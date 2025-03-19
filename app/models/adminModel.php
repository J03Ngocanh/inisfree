<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class adminModel extends Model
{
    protected $tblproducts = "products";
    protected $tblstaff = "staff";
    protected $tblcustomers = "customers";
    protected $tblrole = "role";
    protected $tblrank = "rank";
    protected $tblcategories = "categories";
    protected $tblproduct_types = 'product_types';
    protected $tblorders = "orders";
    protected $tblorder_items = "order_items";
    protected $tblCart = "cart";


    public function getProductList()
    {
        $sql = "SELECT * FROM $this->tblproducts ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getStaffList()
    {
        $sql = "SELECT nv.*, r.name FROM staff nv 
                LEFT JOIN role r ON nv.role_id = r.id";
        return $this->con->query($sql);
    }

    public function checkStaffByPhone($phone)
    {
        $sql = "SELECT * FROM $this->tblstaff WHERE phone='$phone'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM role";
        return $this->con->query($sql);
    }

    public function getProduct($productCode)
    {
        $sql = "SELECT * FROM $this->tblproducts WHERE product_code='$productCode' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getCustomerList()
    {
        $sql = "SELECT * FROM $this->tblcustomers INNER JOIN $this->tblrank ON $this->tblcustomers.rank_id = $this->tblrank.id";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM $this->tblcategories  ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function updateProduct($productCode, $productName, $categoryId, $quantity, $price, $description, $image, $image1, $image2, $image3, $image4)
    {
        $sql = "UPDATE products SET 
            name = '$productName', 
            category_id = '$categoryId', 
            quantity = '$quantity', 
            price = '$price', 
            description = '$description', 
            image = '$image', 
            image1 = '$image1', 
            image2 = '$image2', 
            image3 = '$image3', 
            image4 = '$image4' 
            WHERE product_code = '$productCode'";

        $result = $this->con->query($sql);
        return $result;
    }

    public function addProduct($categoryId, $productName, $description, $price, $image, $image1, $image2, $image3, $image4, $quantity)
    {
        $createdAt = date('Y-m-d H:i:s');
        $sql = "INSERT INTO products (category_id, name, description, price, image, image1, image2, image3, image4, quantity, created_at) 
            VALUES ('$categoryId', '$productName', '$description', '$price', '$image', '$image1', '$image2', '$image3', '$image4', '$quantity', '$createdAt')";
        $result = $this->con->query($sql);
        return $result;
    }

    public function checkProductCode($productCode)
    {
        $sql = "SELECT * FROM $this->tblproducts WHERE product_code='$productCode' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function deleteProduct($productCode)
    {
        $sql = "DELETE FROM $this->tblproducts  WHERE product_code='$productCode' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getOrders()
    {
        $sql = "SELECT * FROM $this->tblorders";
        $result = $this->con->query($sql);
        return $result;
    }

    public function confirmPayment($orderId) {
        $paymentTime = date('Y-m-d H:i:s');
        $sql = "UPDATE $this->tblorders SET status='Paid', payment_time = '$paymentTime' WHERE order_code = '$orderId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getOrderInfo($orderId)
    {
        $sql = "SELECT customer_id, subtotal FROM $this->tblorders WHERE order_code = '$orderId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function updatePointsAndRank($customerId, $subtotal)
    {
        // Get current customer points
        $sql = "SELECT point, rank_id FROM customers WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        $stmt->close();

        if ($customer) {
            $old_rank = $customer['rank_id'];
            $newPoints = $customer['point'] + floor($subtotal / 1000);

            if ($newPoints >= 7500) {
                $new_rank = 4; // Diamond
            } elseif ($newPoints >= 4000) {
                $new_rank = 3; // Gold
            } elseif ($newPoints >= 2000) {
                $new_rank = 2; // Silver
            } else {
                $new_rank = 1; // Member
            }

            $sqlUpdate = "UPDATE customers SET point = ?, rank_id = ? WHERE id = ?";
            $stmtUpdate = $this->con->prepare($sqlUpdate);
            $stmtUpdate->bind_param("iis", $newPoints, $new_rank, $customerId);
            $stmtUpdate->execute();
            $stmtUpdate->close();

            // If rank changed, store session for popup
            if ($new_rank > $old_rank) {
                $_SESSION['rank_up'] = $new_rank;
            }
        }
    }


    public function getOrderDetails()
    {
        $sql = "SELECT $this->tblorder_items.*, $this->tblproducts.image, $this->tblproducts.name FROM $this->tblorder_items INNER JOIN $this->tblproducts
   ON $this->tblorder_items.product_code = $this->tblproducts.product_code";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getStaff($staffId)
    {
        $sql = "SELECT nv.*, r.name FROM staff nv 
                LEFT JOIN role r ON nv.role_id = r.id 
                WHERE nv.staff_id = '$staffId'";
        return $this->con->query($sql);
    }


    public function addStaff($staffName, $phone, $password, $roleId)
    {
        $sql = "INSERT INTO staff (name, phone, password, role_id, status) 
                VALUES ('$staffName', '$phone', '$password', '$roleId', 1)";
        return $this->con->query($sql);

    }


    public function updateStaff($staffId, $staffName, $phone, $password, $roleId)
    {
        $sql = "UPDATE staff SET 
                name = '$staffName', 
                phone = '$phone', 
                role_id = '$roleId'";
        if ($password) {
            $sql .= ", password = '$password'";
        }
        $sql .= " WHERE staff_id = '$staffId'";
        return $this->con->query($sql);
    }

    public function updateStatus($staffId, $status)
    {
        $sql = "UPDATE staff SET status = '$status' WHERE staff_id = '$staffId'";
        return $this->con->query($sql);
    }

// SELECT 
//                 DATE(ngaydat) AS ngay,
//                 SUM(tongtien) AS doanhthu
//             FROM $this->tabledondathang
//             WHERE active = 1";

//     if ($month) {
//         $sql .= " AND DATE_FORMAT(ngaydat, '%Y-%m') = ?"; // Filter by month
//     }

//     $sql .= " GROUP BY DATE(ngaydat)
//               ORDER BY ngay ASC";

//     $stmt = $this->con->prepare($sql);
//     if ($month) {
//         $stmt->bind_param("s", $month);
//     }
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $data = [];
//     while ($row = $result->fetch_assoc()) {
//         $data[] = $row;
//     }

//     return $data;

    // Get revenue by month/year
    public function getRevenueByMonth($month = null)
    {
        $sql = "SELECT 
            DATE(created_at) AS date, 
            SUM(total_amount) AS revenue 
        FROM $this->tblCart 
        WHERE ((payment_method = 'bank_transfer' AND status = 'Paid')
               OR (payment_method = 'cash' AND status = 'Processing'))
          AND payment_method IS NOT NULL";
        if ($month) {
            $sql .= " AND DATE_FORMAT(created_at, '%Y-%m') = ?";
        }

        $sql .= " GROUP BY DATE(created_at) 
            ORDER BY date ASC";

        $stmt = $this->con->prepare($sql);
        if ($month) {
            $stmt->bind_param("s", $month);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;

    }


    public function getRevenueByYear($year) {
        $query = "SELECT MONTH(created_at) AS month, SUM(total) AS revenue 
              FROM orders 
              WHERE YEAR(created_at) = ? AND status = 'Paid'
              GROUP BY MONTH(created_at)
              ORDER BY month ASC";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array_fill(1, 12, 0);
        while ($row = $result->fetch_assoc()) {
            $data[$row['month']] = (float)$row['revenue'];
        }
        return $data;
    }

    public function getTopProducts($month, $year) {
        $query = "SELECT sp.name, SUM(ct.quantity) AS total_quantity
              FROM order_items ct
              JOIN products sp ON ct.product_code = sp.product_code
              JOIN orders dh ON ct.order_id = dh.order_code
              WHERE MONTH(dh.created_at) = ? AND YEAR(dh.created_at) = ? AND (dh.status = 'Paid')
              GROUP BY ct.product_code, sp.name
              ORDER BY total_quantity DESC
              LIMIT 5";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $labels = [];
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['name'];
            $data[] = (int)$row['total_quantity'];
        }
        return ['labels' => $labels, 'data' => $data];
    }

        public function getLowStockProducts() {
            $query = "SELECT product_code, name, quantity 
                      FROM $this->tblproducts 
                      WHERE quantity < 20";
        
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $labels = [];
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $labels[] = $row['name'];
                $data[] = $row['quantity'];
            }
        
            return ['labels' => $labels, 'data' => $data];
        }


}


?>