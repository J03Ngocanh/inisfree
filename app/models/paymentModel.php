<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class paymentModel extends Model
{
    protected $tblProductTypes = "product_types";
    protected $tblProducts = "products";


    public function getProductInfo($productCode)
    {
        $sql = "SELECT * FROM $this->tblProducts WHERE product_code = '$productCode'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getProductTypes()
    {
        $sql = "SELECT * FROM $this->tblProductTypes ";
        $result = $this->con->query($sql);
        return $result;
    }
}
?>
