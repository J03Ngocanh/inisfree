<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

class cartController extends Controller
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = $this->model('cartModel');
    }

    public function createorder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $this->genUUIDv4();
            $phone = $_POST['phone'] ?? '';
            $recipientName = $_POST['recipient_name'] ?? '';
            $recipientAddress = $_POST['recipient_address'] ?? '';
            $paymentMethod = $_POST['payment_method'] ?? '';
            $subtotal = $_POST['subtotal'];
            $discount = $_POST['discount'];
            $totalToPay = $_POST['total_to_pay'];
            $createdAt = date('Y-m-d H:i:s');

            $customerId = $_SESSION['customer_id'] ?? 'KH0000';

            $result = $this->cartModel->addOrder($orderId, $customerId, $subtotal, $discount, $totalToPay, $recipientName, $phone, $recipientAddress, $paymentMethod, $createdAt);

            if ($result) {
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $product_code => $item) {
                        $quantity = $item['quantity'];
                        $price = $item['price'];
                        $this->cartModel->addOrderDetail($orderId, $product_code, $quantity, $price);
                    }
                }
                echo json_encode(["orderId" => $orderId]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Could not create order. Please try again."]);
            }
        }
    }

    public function index()
    {
        $productTypes = $this->cartModel->getProductTypes();
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->cartModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        if (isset($_SESSION['phone'])) {
            $data['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            $this->view('cart/index', ['cart' => $data['cart']]);
        } else {
            $this->view('account/login');
        }
    }

    public function removeItem()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_code'])) {
            $productCode = $_POST['product_code'];
            if (isset($_SESSION['cart'][$productCode])) {
                unset($_SESSION['cart'][$productCode]);
            }
        }
        header('Location: /inis/cart/index');
        exit();
    }

    public function checkout()
    {
        $thanhtoan = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $customerId = $_SESSION['customer_id'];
        $coupon = $this->cartModel->getCoupon($customerId);
        $productTypes = $this->cartModel->getProductTypes();
        $info = $this->cartModel->info($customerId);
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('payment/checkout', ['checkoutItems' => $thanhtoan, 'coupon' => $coupon]);
    }

    public function muangay($productCode)
    {
        if (isset($_SESSION['phone'])) {
            $productTypes = $this->cartModel->getProductTypes();
            $quantity = $_POST['quantity'];
            $_SESSION['buy_now_quantity'] = $quantity;
            $buyNowProduct = $this->cartModel->getProductForBuyNow($productCode);
            if (!$buyNowProduct) {
                die("Product not found: $productCode");
            }
            $customerId = $_SESSION['customer_id'];
            $coupon = $this->cartModel->getCoupon($customerId);
            $info = $this->cartModel->info($customerId);
            $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
            $this->view('payment/buy_now', ['buyNowProduct' => $buyNowProduct, 'quantity' => $quantity, 'productCode' => $productCode, 'coupon' => $coupon]);
            $this->view('footer');
        } else {
            header('Location: ' . WEBROOT . 'account/login');
            exit();
        }
    }


    public function processBuyNow($masp)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $phone = $_POST['phone'];
            $recipientName = $_POST['recipient_name'];
            $recipientAddress = $_POST['recipient_address'];
            $paymentMethod = $_POST['payment_method'];
            $quantity = $_POST['quantity'];
            $totalAmount = $_POST['subtotal'];
            $createdAt = date('Y-m-d H:i:s');
            $this->cartModel->createBuyNowOrder($phone, $recipientName, $recipientAddress, $paymentMethod, $totalAmount, $createdAt);

            $lastCartResult = $this->cartModel->getLastCartId($phone);
            $cartRow = mysqli_fetch_array($lastCartResult);
            $cartId = $cartRow['maxid'];
            $data = $this->cartModel->getProductInfo($masp);
            $row = mysqli_fetch_array($data);
            $unitPrice = $row['price'];

            $productName = $row['name'];
            $this->cartModel->addBuyNowItem($cartId, $masp, $productName, $quantity, $unitPrice);
            $this->cartModel->updateBuyNowQuantity($masp, $quantity);

            if ($paymentMethod == 'bank_transfer') {
            } else if ($paymentMethod == 'cash') {
                echo "<script>alert('Order will be delivered and paid on delivery.');</script>";
            }
            header("location: /inis/cart/orderComplete/$cartId");
        }
    }

    public function processCheckout()
    {
        $orderId = $this->genUUIDv4();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $phone = $_POST['phone'] ?? '';
            $recipientName = $_POST['recipient_name'] ?? '';
            $recipientAddress = $_POST['recipient_address'] ?? '';
            $paymentMethod = $_POST['payment_method'] ?? '';
            $subtotal = $_POST['subtotal'];
            $discount = $_POST['discount'];
            $totalToPay = $_POST['total_to_pay'];
            $createdAt = date('Y-m-d H:i:s');

            $customerId = $_SESSION['customer_id'] ?? 'KH0000';

            $result = $this->cartModel->addOrder($orderId, $customerId, $subtotal, $discount, $totalToPay, $recipientName, $phone, $recipientAddress, $paymentMethod, $createdAt);

            if ($result) {
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $product_code => $item) {
                        $quantity = $item['quantity'];
                        $price = $item['price'];
                        $this->cartModel->addOrderDetail($orderId, $product_code, $quantity, $price);
                        unset($_SESSION['cart']);
                    }
                    if (isset($_POST['payment_method']) && $_POST['payment_method'] === 'vnpay_qr') {
                        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                        $vnp_Returnurl = "https://inis-hvnh.site/inis/vnpay/return";
                        $vnp_TmnCode = "Z0O9T9AJ";
                        $vnp_HashSecret = "NBWOGA7BHPKQ4IF59MXMPRJOFX1W9QQ5";
                        $vnp_TxnRef = $orderId;
                        $vnp_OrderInfo = $vnp_TxnRef;
                        $vnp_Amount = $_POST['total_to_pay'] * 100;
                        $vnp_Locale = 'vn';
                        $vnp_BankCode = '';
                        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                        $inputData = array(
                            "vnp_Version" => "2.1.0",
                            "vnp_TmnCode" => $vnp_TmnCode,
                            "vnp_Amount" => $vnp_Amount,
                            "vnp_Command" => "pay",
                            "vnp_CreateDate" => date('YmdHis'),
                            "vnp_CurrCode" => "VND",
                            "vnp_IpAddr" => $vnp_IpAddr,
                            "vnp_Locale" => $vnp_Locale,
                            "vnp_OrderInfo" => $vnp_OrderInfo,
                            "vnp_OrderType" => "other",
                            "vnp_ReturnUrl" => $vnp_Returnurl,
                            "vnp_TxnRef" => $vnp_TxnRef
                        );

                        ksort($inputData);
                        $query = "";
                        $i = 0;
                        $hashdata = "";
                        foreach ($inputData as $key => $value) {
                            if ($i == 1) {
                                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                            } else {
                                $hashdata .= urlencode($key) . "=" . urlencode($value);
                                $i = 1;
                            }
                            $query .= urlencode($key) . "=" . urlencode($value) . '&';
                        }

                        $vnp_Url .= "?" . $query;
                        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

                        header('Location: ' . $vnp_Url);
                        exit();
                    }
                }

                header("Location: " . WEBROOT . "cart/orderComplete/$orderId");
                exit();
            } else {
                die("Error: Could not create order.");
            }
        } else {
            die("Error: Invalid request.");
        }
    }

    public function orderComplete($orderId)
    {
        $productTypes = $this->cartModel->getProductTypes();
        $customerId = $_SESSION['customer_id'];
        $info = $this->cartModel->info($customerId);
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $orderItemsInfo = $this->cartModel->Getttinchitietdonhang($orderId);
        $orderInfo = $this->cartModel->Getttindonhang($orderId);
        $this->view('cart/order_detail', ['orderItemsInfo' => $orderItemsInfo, 'orderInfo' => $orderInfo]);
        $this->view('footer');
    }

    public function getCartCount()
    {
        $cartCount = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $cartCount += $item['quantity'];
            }
        }
        echo $cartCount;
        exit;
    }

    public function updateQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productCode = $_POST['product_code'];
            $quantity = (int)$_POST['quantity'];

            $productResult = $this->cartModel->getProductInfo($productCode);
            if ($row = mysqli_fetch_assoc($productResult)) {
                $stockQty = $row['soluongtonkho'];

                if ($quantity <= $stockQty) {
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as &$item) {
                            if ($item['product_code'] === $productCode) {
                                $item['quantity'] = $quantity;
                                break;
                            }
                        }
                    }
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Quantity exceeds stock',
                        'available' => $stockQty
                    ]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Product not found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
        exit;
    }

    public function checkQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productCode = $_POST['product_code'];
            $quantity = (int)$_POST['quantity'];

            $productResult = $this->cartModel->getProductInfo($productCode);
            if ($row = mysqli_fetch_assoc($productResult)) {
                $stockQty = $row['soluongtonkho'];

                if ($quantity <= $stockQty) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'available' => $stockQty
                    ]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Product not found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
        exit;
    }

    public function addItem($productCode)
    {
        $productResult = $this->cartModel->getProductInfo($productCode);
        if ($row = mysqli_fetch_assoc($productResult)) {
            $stockQty = $row['soluongtonkho'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            $currentQty = isset($_SESSION['cart'][$productCode]) ? $_SESSION['cart'][$productCode]['quantity'] : 0;
            $newQty = $currentQty + $quantity;

            if ($newQty <= $stockQty) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $name = $row['name'];
                $price = $row['price'];
                $image = $row['image'];

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productCode])) {
                    $_SESSION['cart'][$productCode]['quantity'] = $newQty;
                } else {
                    $_SESSION['cart'][$productCode] = [
                        'product_code' => $productCode,
                        'name' => $name,
                        'price' => $price,
                        'image' => $image,
                        'quantity' => $quantity,
                    ];
                }
                $_SESSION['flash_message'] = "Product added to cart.";
                $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : WEBROOT . 'home/home';
                header("Location: $redirectUrl");
            } else {
                $_SESSION['flash_message'] = "Quantity exceeds stock. Available: $stockQty.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
            exit();
        }
        header("Location: " . WEBROOT . "home/home");
        exit();
    }

    function genUUIDv4() {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
