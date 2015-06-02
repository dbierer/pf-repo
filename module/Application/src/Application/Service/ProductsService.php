<?php
namespace Application\Service;

use Application\Entity\Products;

class ProductsService
{
    const DEFAULT_PHOTO_DIR     = '/public/images';
    const DEFAULT_PRODUCT_IMAGE = 'tw2113_Box.png';
    const DEFAULT_WIDTH         = 400;
    const DEFAULT_HEIGHT        = 200;
    const SMALL_WIDTH           = '100px';
    const SMALL_HEIGHT          = '50px';
    
    /**
     * Displays product info
     * @param array(Application\Entity\Products $product)
     * @return string $output HTML
     */
    public function showAllProdInfo($productList)
    {
        $output = '';
        $output .= '<hr>';
        $output .= "<style>\n";
        $output .= "td { width: 100px; border: thin solid gray; }\n";
        $output .= "</style>\n";
        $output .= "<table>\n";
        $output .= "<tr><th>&nbsp;</th><th>SKU</th><th>Special</th><th>Title</th><th>Description</th></tr>\n";
        foreach ($productList as $product) {
            $output .= $this->showProductInfo($product);
        }
        $output .= "</table>\n";
        return $output;
    }
    
    /**
     * Displays product info
     * @param Application\Entity\Customer $product
     * @return string $output HTML
     */
    public function showProductInfo(Products $product)
    {
        if ($product->getLink()) {
            $photo   = self::DEFAULT_PHOTO_DIR . '/' . $product->getLink() . '.scale_10.JPG';
        } else {
            $photo   = self::DEFAULT_PHOTO_DIR . '/' . self::DEFAULT_PRODUCT_IMAGE;
        }
        $output = '';
        $output .= "<tr>\n";
        $output .= "<td style='text-align:center;'><img src='$photo' width='" . self::SMALL_WIDTH . "' height='" . self::SMALL_HEIGHT . "'></td>";
        $output .= "<td>{$product->getSku()}</td>";
        $output .= "<td>{$product->getSpecial()}</td>";
        $output .= "<td>{$product->getTitle()}</td>";
        $output .= "<td style='width: 635px;'>{$product->getDescription()}</td>";
        $output .= "</tr>\n";
        return $output;
    }

    /**
     * Update product info
     * @param Application\Entity\Customer $product
     * @return string $output HTML FORM
     */
    public function updateProdInfo(Products $product)
    {
        $checked = ($product->getSpecial()) ? ' checked' : '';
        $output = '';
        $output .= "<style>\n";
        $output .= "td { width: " . self::DEFAULT_WIDTH . "px; border: thin solid gray; }\n";
        $output .= "</style>\n";
        $output .= "<table>\n";
        $output .= "<tr><td>SKU</td><td><input type='text' name='sku' value='{$product->getSku()}' /></td></tr>\n";
        $output .= "<tr><td>Title</td><td><input type='text' name='title' value='{$product->getTitle()}' /></td></tr>\n";
        $output .= "<tr><td>Price</td><td><input type='text' name='price' value='" . number_format($product->getPrice(),2) . "' /></td></tr>\n";
        $output .= "<tr><td>Special</td><td><input type='checkbox' name='special' value='{$product->getSpecial()}' $checked/></td></tr>\n";
        $output .= "<tr><td>Link</td><td><input type='text' name='link' value='{$product->getLink()}' /></td></tr>\n";
        $output .= "<tr><td>Description</td><td><input type='textarea' rows=4 cols=80 name='description' value='{$product->getDescription()}' /></td></tr>\n";
        $output .= "<tr><td>&nbsp;</td><td><input type='submit' name='update' value='Update Product' ></tr>\n";
        $output .= "</table>\n";
        $output .= "<input type='hidden' name='prodId' value='{$product->getId()}' />\n";
        return $output;
    }

    /**
     * Returns <form> which allows for customer and product selection
     * 
     * @param string $custSelect HTML SELECT element
     * @param string $prodSelect HTML SELECT element
     * @param string $extraInput HTML
     * @param bool $header == TRUE = show links
     * @return string HTML FORM
     */
    public function selectForm($custSelect, $prodSelect, $file, $extraInput = '', $header = TRUE)
    {
        $extraInput = (isset($extraInput)) ? $extraInput : '';
        $output  = '<h1>' . $file . '</h1>';
        if ($header) {
            $output .= '<br><a href="#">RESET</a>';
            $output .= ' | <a href="many_to_many_read.php">READ</a>';
            $output .= ' | <a href="many_to_many_create.php">CREATE</a>';
            $output .= ' | <a href="many_to_many_update.php">UPDATE</a>';
            $output .= ' | <a href="many_to_many_delete.php">DELETE</a>';
        }
        $output .= '<form id="init" method="post">' . PHP_EOL;
        $output .= '<table>' . PHP_EOL;
        $output .= '<tr><td style="width: 200px; border: none;">Please select customer</td>';
        $output .= '<td style="width: 200px; border: none;">' . $custSelect  . '</td></tr>' . PHP_EOL;
        $output .= '<tr><td style="width: 200px; border: none;">Please select product</td>';
        $output .= '<td style="width: 200px; border: none;">' . $prodSelect  . '</td></tr>' . PHP_EOL;
        $output .= $extraInput;
        $output .= '<tr><td style="width: 200px; border: none;">&nbsp;</td>';
        $output .= '<td style="width: 200px; border: none;"><input type="submit" name="init" value="Choose" /></td></tr>' . PHP_EOL;
        $output .= '</table>' . PHP_EOL;
        $output .= '</form>' . PHP_EOL;
        return $output;
    }
        
    /**
     * Returns an HTML SELECT element
     * @param array (Application\Entity\Product $productList)
     * @param int $prodId
     * @return string HTML
     */
    public function selectProduct($productList, $prodId = 0)
    {
        $output = '<select name="prodId" style="width:200px;">' . PHP_EOL;
        $output .= '<option value="0">Choose</option>' . PHP_EOL;
        foreach ($productList as $product) {
            if ($prodId == $product->getId()) {
                $selected = ' selected';
            } else {
                $selected = '';
            }
            $output .= '<option value="' . $product->getId() . '"' . $selected . '>' 
                     . $product->getTitle() 
                     . '</option>' 
                     . PHP_EOL;
        }
        $output .= '</select>' . PHP_EOL;
        return $output;
    }
}
