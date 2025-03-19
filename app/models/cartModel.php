<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class cartModel extends Model
{
    protected $tblProductTypes = "product_types";
    protected $tblProducts = "products";
    protected $tblCart = "cart";
    protected $tblCustomers = "customers";
    protected $tblCartItems = "cart_items";
    protected $tblOrders = "orders";
    protected $tblRank = "rank";
    protected $tblOrderItems = "order_items";


    public function getProductInfo($productCode)
    {
        $sql = "SELECT product_code, name, price, image, quantity AS soluongtonkho
                FROM $this->tblProducts
                WHERE product_code = '$productCode'";
        return $this->con->query($sql);
    }

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

    public function getCart($phone)
    {
        $sql = "SELECT
        ctgh.*,
        sp.name,
        sp.image,
        sp.price,
        ctgh.quantity
    FROM {$this->tblCartItems} AS ctgh
    INNER JOIN {$this->tblCart} AS gh ON ctgh.cart_id = gh.cart_id
    INNER JOIN {$this->tblProducts} AS sp ON ctgh.product_code = sp.product_code
    WHERE gh.phone = '$phone' AND gh.active = 0";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getCartId($phone)
    {
        $sql = "SELECT * FROM $this->tblCart WHERE active=0 AND phone='$phone'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function hasActiveCart($phone)
    {
        $sql = "SELECT * FROM $this->tblCart WHERE phone = '$phone' AND active=0";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getProductForBuyNow($productCode)
    {
        $sql = "SELECT * FROM $this->tblProducts WHERE product_code = '$productCode'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function decreaseProductQuantity($quantity, $productCode)
    {
        $sql = "UPDATE $this->tblProducts SET quantity= (SELECT quantity FROM $this->tblProducts WHERE product_code = '$productCode' )-$quantity
    WHERE product_code='$productCode' ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getCartItems($cartId)
    {
        $sql = "SELECT * FROM $this->tblCartItems WHERE cart_id = $cartId ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getCartProductInfo($cartId)
    {
        $sql = "SELECT $this->tblProducts.image, $this->tblProducts.name, $this->tblProducts.price, $this->tblCartItems.* FROM $this->tblCartItems INNER JOIN $this->tblProducts ON $this->tblCartItems.product_code = $this->tblProducts.product_code WHERE cart_id = $cartId ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function updateOrder($totalAmount, $cartId, $recipientName, $recipientAddress, $paymentMethod, $createdAt)
    {
        $recipientName = $this->con->real_escape_string($recipientName);
        $recipientAddress = $this->con->real_escape_string($recipientAddress);
        $paymentMethod = $this->con->real_escape_string($paymentMethod);

        $sql = "UPDATE $this->tblCart
    SET total_amount= $totalAmount, recipient_name='$recipientName', recipient_address='$recipientAddress',
    payment_method='$paymentMethod', created_at=NOW(), active=1 WHERE cart_id= $cartId";
        $result = $this->con->query($sql);
        return $result;
    }

    public function Getttinchitietdonhang($orderId)
    {
        $sql = "SELECT sp.name, ctdh.quantity, sp.price FROM $this->tblOrderItems ctdh INNER JOIN $this->tblProducts sp ON ctdh.product_code = sp.product_code WHERE order_id = '$orderId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function Getttindonhang($orderId)
    {
        $sql = "SELECT * FROM $this->tblOrders WHERE order_code = '$orderId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function Laymasanpham($cartId)
    {
        $sql = "SELECT cart_id, product_code, quantity FROM $this->tblCartItems
    WHERE cart_id=$cartId";
        $result = $this->con->query($sql);
        return $result;
    }

    public function addOrder($orderId, $customerId, $subtotal, $discount, $totalToPay, $recipientName, $phone, $recipientAddress, $paymentMethod, $createdAt)
    {
        $sql = "INSERT INTO $this->tblOrders (order_code, customer_id, subtotal,discount, total, recipient_name, recipient_phone, recipient_address, payment_method, created_at)
            VALUES ('$orderId','$customerId', '$subtotal', $discount, $totalToPay, '$recipientName','$phone', '$recipientAddress', '$paymentMethod', '$createdAt')";
        if ($this->con->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function getCoupon($customerId)
    {
        $sql = "SELECT discount FROM $this->tblRank r INNER JOIN $this->tblCustomers kh ON r.id = kh.rank_id WHERE kh.id='$customerId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function updateStock($productCode, $quantity)
    {
        $sql = "UPDATE $this->tblProducts
                SET quantity = quantity - $quantity
                WHERE product_code = '$productCode'
                AND quantity >= $quantity";
        return $this->con->query($sql);
    }

    public function checkStock($productCode, $quantity)
    {
        $sql = "SELECT quantity AS soluongtonkho
                FROM $this->tblProducts
                WHERE product_code = '$productCode'";
        $result = $this->con->query($sql);
        if ($row = $result->fetch_assoc()) {
            return $row['soluongtonkho'] >= $quantity;
        }
        return false;
    }

    public function addBuyNowItem($cartId, $productCode, $productName, $quantity, $unitPrice)
    {
        if ($this->checkStock($productCode, $quantity)) {
            $sql = "INSERT INTO $this->tblCartItems (cart_id, product_code, product_name, quantity, unit_price)
                    VALUES ($cartId, '$productCode', '$productName', $quantity, $unitPrice)";
            $result = $this->con->query($sql);
            if ($result) {
                $this->updateStock($productCode, $quantity);
            }
            return $result;
        }
        return false;
    }

    public function addOrderDetail($orderId, $productCode, $quantity, $price)
    {
        if ($this->checkStock($productCode, $quantity)) {
            $sql = "INSERT INTO $this->tblOrderItems (order_id, product_code, quantity, unit_price)
                    VALUES ('$orderId', '$productCode', $quantity, $price)";
            $result = $this->con->query($sql);
            if ($result) {
                $this->updateStock($productCode, $quantity);
            }
            return $result;
        }
        return false;
    }

    public function updateBuyNowQuantity($productCode, $quantity)
    {
        if ($this->checkStock($productCode, $quantity)) {
            $sql = "UPDATE $this->tblProducts
                    SET quantity = quantity - $quantity
                    WHERE product_code = '$productCode'";
            return $this->con->query($sql);
        }
        return false;
    }

    public function createBuyNowOrder($phone, $recipientName, $recipientAddress, $paymentMethod, $totalAmount, $createdAt)
    {
        $recipientName = $this->con->real_escape_string($recipientName);
        $recipientAddress = $this->con->real_escape_string($recipientAddress);
        $paymentMethod = $this->con->real_escape_string($paymentMethod);
        $sql = "INSERT INTO $this->tblCart (phone, recipient_name, recipient_address, payment_method, total_amount, created_at, active) VALUES ('$phone', '$recipientName', '$recipientAddress', '$paymentMethod', $totalAmount, '$createdAt', 0)";
        return $this->con->query($sql);
    }

    public function getLastCartId($phone)
    {
        $sql = "SELECT MAX(cart_id) AS maxid FROM $this->tblCart WHERE phone = '$phone'";
        return $this->con->query($sql);
    }
}
?>
