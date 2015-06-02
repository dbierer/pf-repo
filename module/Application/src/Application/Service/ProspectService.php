<?php
namespace Application\Service;

// identify classes to use from external namespaces
use Doctrine\Common\Util\Debug;
use Doctrine\ODM\DocumentRepository;
use Doctrine\ORM\Query;
use Application\Entity\Prospects;
use Application\Repository\ProspectsMongoDbRepo;

class ProspectService
{

    const DOCUMENT = 'Application\Documents\Prospects';
    
    public function showProspectHeader()
    {
        $output = '';
        $output .= 'First Name  |   Last Name  |               Email                |            Address            |            City          | St |  Post |      Phone  ' . PHP_EOL;
        $output .= '------------------------------------------------------------------------------------------------------------------------------------------------------' . PHP_EOL;
        return $output;
    }
    
    public function showProspectRows($list)
    {
        $output = '';
        $pattern = "%11s | %12s | %34s | %29s | %24s | %2s | %5s | %12s\n";
        if ($list) {
            foreach ($list as $prospect) {
                $output .= sprintf($pattern,
                    $prospect->getFirstName(),
                    $prospect->getLastName(),
                    $prospect->getEmail(),
                    $prospect->getAddress(),
                    $prospect->getCity(),
                    strtoupper(substr($prospect->getStateProvince(), 0, 2)),
                    $prospect->getPostalCode(),
                    $prospect->getPhone());
            }
        }
        return $output;
    }
    
    public function showProspect(Prospects $prospect = NULL)
    {
        $output = '';
        if ($prospect) {
            $output .= "<hr>\n";
            $output .= "<style>th { text-align:right; font-family:helvetica; margin-right: 50px; }</style>\n";
            $output .= "<table>\n";
            $output .= "<tr><th>First</th><td>&nbsp;&nbsp;</td><td>{$prospect->getFirstName()}</td></tr>\n";
            $output .= "<tr><th>Last</th><td>&nbsp;&nbsp;</td><td>{$prospect->getLastName()}</td></tr>\n";
            $output .= "<tr><th>Email</th><td>&nbsp;&nbsp;</td><td>{$prospect->getEmail()}</td></tr>\n";
            $output .= "<tr><th>Address</th><td>&nbsp;&nbsp;</td><td>{$prospect->getAddress()}</td></tr>\n";
            $output .= "<tr><th>City</th><td>&nbsp;&nbsp;</td><td>{$prospect->getCity()}</td></tr>\n";
            $output .= "<tr><th>State/Prov</th><td>&nbsp;&nbsp;</td><td>{$prospect->getStateProvince()}</td></tr>\n";
            $output .= "<tr><th>Postal Code</th><td>&nbsp;&nbsp;</td><td>{$prospect->getPostalCode()}</td></tr>\n";
            $output .= "<tr><th>Country</th><td>&nbsp;&nbsp;</td><td>{$prospect->getCountry()}</td></tr>\n";
            $output .= "<tr><th>Phone</th><td>&nbsp;&nbsp;</td><td>{$prospect->getPhone()}</td></tr>\n";
            $output .= "</table>\n";
        }
        return $output;
    }

    public function updateProspectForm(Prospects $prospect, $label = 'Update')
    {
        $formRow = "<tr><th>%s</th><td>&nbsp;&nbsp;</td><td><input type='%s' name='%s' value='%s' /></td></tr>\n";
        $output  = '';
        $output .= "<style>th { text-align:right; font-family:helvetica; margin-right: 50px; }</style>\n";
        $output .= "<form method='post'>\n";
        $output .= "<hr>\n";
        $output .= "<table>\n";
        $output .= sprintf($formRow, 'First',      'text',  'firstName',  $prospect->getFirstName());
        $output .= sprintf($formRow, 'Last',       'text',  'lastName',   $prospect->getLastName());
        $output .= sprintf($formRow, 'Email',      'email', 'email',      $prospect->getEmail());
        $output .= sprintf($formRow, 'Address',    'text',  'address',    $prospect->getAddress());
        $output .= sprintf($formRow, 'City',       'text',  'city',       $prospect->getCity());
        $output .= sprintf($formRow, 'State/Prov', 'text',  'stateProv',  $prospect->getStateProvince());
        $output .= sprintf($formRow, 'Postal Code','text',  'postalCode', $prospect->getPostalCode());
        $output .= sprintf($formRow, 'Country',    'text',  'country',    $prospect->getCountry());
        $output .= sprintf($formRow, 'Phone',      'text',  'phone',      $prospect->getPhone());
        $output .= sprintf($formRow, '',           'submit','submit',     $label);
        $output .= "<input type='hidden' name='id' value='{$prospect->getId()}' />\n";
        $output .= "</table>\n";
        $output .= "</form>\n";
        return $output;
    }

    public function areYouSure($id)
    {
        $output  = '';
        $output .= "<style>th { text-align:right; font-family:helvetica; margin-right: 50px; }</style>\n";
        $output .= "<form method='get'>\n";
        $output .= "<table>\n";
        $output .= "<tr><td><input type='radio' value='Y' name='sure'></td><td>Y</td></tr>\n";
        $output .= "<tr><td><input type='radio' value='N' name='sure'></td><td>N</td></tr>\n";
        $output .= "</table>\n";
        $output .= "<br /><input type='submit' name='submit' value='Continue' />\n";
        $output .= "<input type='hidden' name='id' value='{$id}' />\n";
        $output .= "</form>\n";
        return $output;
    }

    public function selectForm($list, $code = 0)
    {
        $output = "<form>\n";
        $output .= $this->selectProspect($list, $code);
        $output .= "<br><input type='submit' name='submit' value='Choose' />\n";
        $output .= "</form>\n";
        return $output;
    }

    public function selectProspect($list, $code)
    {
        $output = "Select Prospect \n";
        if ($list) {
            $output .= "<select name='id'>\n";
            $output .= "<option value=\"0\">Choose</option>\n";
            foreach ($list as $prospect) {
                Debug::dump($prospect);
                $id = $prospect->getId();
                $checked = ($id == $code) ? ' selected' : '';
                $output .= "<option value=\"{$id}\" {$checked}>{$prospect->getFullName()}</option>\n";
            }
            $output .= "</select>\n";
        }
        return $output;
    }
    
    public function selectEmailForm($list, $email = '')
    {
        $output = "<form>\n";
        $output .= $this->selectEmailProspect($list, $email);
        $output .= "<br><input type='submit' name='submit' value='Choose' />\n";
        $output .= "</form>\n";
        return $output;
    }

    public function selectEmailProspect($list, $email)
    {
        $output = "Select Prospects By Email\n";
        if ($list) {
            $output .= "<select name='id'>\n";
            $output .= "<option value=\"0\">Choose</option>\n";
            foreach ($list as $prospect) {
                $id = $prospect->getEmail();
                $checked = ($email == $id) ? ' selected' : '';
                $output .= "<option value=\"{$id}\" {$checked}>{$prospect->getEmail()}</option>\n";
            }
            $output .= "</select>\n";
        }
        return $output;
    }

    public function selectHydration()
    {
        $output  = '';
        $output .= "<style>th { text-align:right; font-family:helvetica; margin-right: 50px; }</style>\n";
        $output .= "<table>\n";
        $output .= "<tr><td><input type='radio' value='" . Query::HYDRATE_OBJECT        . "' name='mode'></td><td>Object</td></tr>\n";
        $output .= "<tr><td><input type='radio' value='" . Query::HYDRATE_ARRAY         . "' name='mode'></td><td>Array</td></tr>\n";
        $output .= "<tr><td><input type='radio' value='" . Query::HYDRATE_SCALAR        . "' name='mode'></td><td>Scalar</td></tr>\n";
        $output .= "<tr><td><input type='radio' value='" . Query::HYDRATE_SINGLE_SCALAR . "' name='mode'></td><td>Single Scalar</td></tr>\n";
        $output .= "</table>\n";
        return $output;
    }
}
    
