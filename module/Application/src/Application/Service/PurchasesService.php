<?php
namespace Application\Service;

use Application\Entity\Customer;
use Application\Entity\Purchases;

class PurchasesService
{
    
    const DEFAULT_PHOTO_DIR = '/public/images';
    const SMALL_WIDTH       = '100px';
    const SMALL_HEIGHT      = '50px';
    
    /**
     * Displays purchase + profile info
     * @param array(Application\Entity\Customer $purchase)
     * @return string $output HTML
     */
    public function showAllPurchInfo($purchaseList)
    {
        $output = '';
        $output .= '<hr>';
        $output .= "<style>\n";
        $output .= "td { width: 100px; border: thin solid gray; }\n";
        $output .= "</style>\n";
        $output .= "<table>\n";
        $output .= "<tr><th>&nbsp;</th><th>Transaction</th><th>SKU</th><th>Item</th><th>Quantity</th><th>Price</th><th>Total</th></tr>\n";
        foreach ($purchaseList as $purchase) {
            $output .= $this->showPurchInfo($purchase);
        }
        $output .= "</table>\n";
        return $output;
    }
    
    /**
     * Displays purchase + profile info
     * @param Application\Entity\Customer $purchase
     * @return string $output HTML
     */
    public function showPurchInfo(Purchases $purchase)
    {
        $product = $purchase->getProduct();
        $photo   = self::DEFAULT_PHOTO_DIR . '/' . $product->getLink() . '.scale_10.JPG';
        $output = '';
        $output .= "<tr>\n";
        $output .= "<td style='text-align:center;'><img src='$photo' width='" . self::SMALL_WIDTH . "' height='" . self::SMALL_HEIGHT . "'></td>";
        $output .= "<td>{$purchase->getTransaction()}</td>";
        $output .= "<td>{$product->getSku()}</td>";
        $output .= "<td>{$product->getTitle()}</td>";
        $output .= "<td>{$purchase->getQuantity()}</td>";
        $output .= "<td>" . number_format($purchase->getSalePrice(), 2) . "</td>";
        $output .= "<td>" . number_format($purchase->getTotal(), 2)     . "</td>";
        $output .= "</tr>\n";
        return $output;
    }

    /**
     * Returns an HTML SELECT element
     * @param array (Application\Entity\Purchases $purchaseList)
     * @param int $purchId
     * @return string HTML
     */
    public function selectPurchases($purchaseList, $purchId)
    {
        $output = '';
        if ($purchaseList) {
            $output = '<select name="purchId">' . PHP_EOL;
            foreach ($purchaseList as $purchase) {
                if ($purchase->getId() == $purchId) {
                    $selected = ' selected';
                } else {
                    $selected = '';
                }
                $output .= '<option value="' . $purchase->getId() . '"' . $selected . '>' 
                         . $purchase->getDate()->format('Y-m-d') 
                         . ' [' . $purchase->getTransaction() . '] '
                         . number_format($purchase->getTotal(), 2)
                         . '</option>' 
                         . PHP_EOL;
            }
            $output .= '</select>' . PHP_EOL;
        }
        return $output;
    }
}