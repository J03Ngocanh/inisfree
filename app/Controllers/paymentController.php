<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

class paymentController extends Controller
{
    private $paymentModel;

    public function __construct()
    {
        $this->paymentModel = $this->model('paymentModel');
    }

    public function checkout()
    {
        $productTypes = $this->paymentModel->getProductTypes();
        $checkoutItems = $_SESSION['cart'] ?? [];
        $this->view('menu', ['productTypes' => $productTypes]);
        $this->view('payment/checkout', ['checkoutItems' => $checkoutItems]);
    }
}
?>
