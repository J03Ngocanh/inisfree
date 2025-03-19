<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class productModel extends Model
{
    protected $tblProducts = "products";
    protected $tblCategories = "categories";
    protected $tblProductTypes = 'product_types';
    protected $tblCustomers = 'customers';


    public function getProductTypes()
    {
        $sql = "SELECT * FROM $this->tblProductTypes ";
        $result = $this->con->query($sql);
        return $result;
    }

    // Get all categories
    public function getCategories()
    {
        $sql = "SELECT * FROM $this->tblCategories ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function info($customerId)
    {
        $sql = "SELECT * FROM $this->tblCustomers kh WHERE id = '$customerId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM $this->tblProducts ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getProductDetail($id)
    {
        $sql = "SELECT * FROM $this->tblProducts WHERE product_code = '$id' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getProductsByCategory($id)
    {
        $sql = "SELECT * FROM $this->tblProducts WHERE category_id = $id  ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getAll_loai($id)
    {
        $id = (int) $id;
        $stmt = $this->con->prepare("SELECT p.* FROM {$this->tblProducts} p INNER JOIN {$this->tblCategories} c ON p.category_id = c.id WHERE c.product_type_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTypeName($id)
    {
        $id = (int) $id;
        $stmt = $this->con->prepare("SELECT * FROM {$this->tblProductTypes} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getCategoryTypeName($id)
    {
        $sql = "SELECT $this->tblCategories.id, $this->tblCategories.name AS category_name, $this->tblProductTypes.name AS type_name FROM $this->tblCategories INNER JOIN $this->tblProductTypes ON $this->tblCategories.product_type_id= $this->tblProductTypes.id
        WHERE $this->tblCategories.id= $id ;
         ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function searchProducts($nd)
    {
        $sql = "SELECT * FROM $this->tblProducts WHERE name LIKE '%$nd%' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getProductNamesBySearch($nd)
    {
        $sql = "SELECT  product_code,name, image FROM $this->tblProducts WHERE name LIKE '%$nd%' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getByCategory($categoryId)
    {
        $stmt = $this->con->prepare("SELECT * FROM $this->tblProducts WHERE category_id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
