<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class homeModel extends Model
{
    protected $tblProductTypes = 'product_types';
    protected $tblProducts = 'products';
    protected $tblCustomers = 'customers';
    protected $tblRank = 'rank';
    protected $tblOrderItems = 'order_items';
    protected $tblOrders = 'orders';

    public function getProductTypes()
    {
        $sql = "SELECT * FROM $this->tblProductTypes ";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getBestSellers()
    {
        $sql = "SELECT sp.product_code,sp.name, sp.image, sp.price,SUM(cthd.quantity) AS total_sold FROM {$this->tblOrderItems} AS cthd
            INNER JOIN {$this->tblOrders} AS hd ON cthd.order_id = hd.order_code
            INNER JOIN {$this->tblProducts} AS sp ON cthd.product_code = sp.product_code
            GROUP BY sp.product_code
            ORDER BY total_sold DESC LIMIT 4";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getNewItems()
    {
        $sql = "SELECT sp.product_code, sp.name, sp.image, sp.price FROM {$this->tblProducts} AS sp
    ORDER BY sp.created_at DESC LIMIT 4";
        $result = $this->con->query($sql);
        return $result;
    }

    public function info($customerId)
    {
        $sql = "SELECT * FROM $this->tblCustomers kh INNER JOIN $this->tblRank r ON kh.rank_id = r.id WHERE id = '$customerId'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function getOrderHistory($customerId)
    {
        $sql = "SELECT hd.order_code, hd.created_at, hd.total, hd.status, sp.name, cthd.quantity FROM $this->tblOrders hd
            JOIN $this->tblOrderItems cthd ON hd.order_code = cthd.order_id
            JOIN $this->tblProducts sp ON cthd.product_code = sp.product_code WHERE hd.customer_id = '$customerId'
            ORDER BY hd.created_at DESC";
        $result = $this->con->query($sql);

        $history = [];
        while ($row = $result->fetch_assoc()) {
            $orderId = $row['order_code'];
            if (!isset($history[$orderId])) {
                $history[$orderId] = [
                    'created_at' => $row['created_at'],
                    'total' => $row['total'],
                    'status' => $row['status'],
                    'items' => []
                ];
            }
            $history[$orderId]['items'][] = [
                'name' => $row['name'],
                'quantity' => $row['quantity']
            ];
        }
        return $history;
    }
}


?>
