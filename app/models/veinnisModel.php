<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class veinnisModel extends Model
{
    protected $tblProductTypes = "product_types";
    protected $tblCustomers = "customers";


    public function getProductTypes()
    {
        $sql = "SELECT * FROM $this->tblProductTypes ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function info($customerId)
    {
        $sql = "SELECT * FROM $this->tblCustomers kh WHERE id = '$customerId'";
        $result = $this->con->query($sql);
        return $result;
    }
}