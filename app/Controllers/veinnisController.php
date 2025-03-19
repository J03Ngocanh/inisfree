<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

//require_once 'app/models/giohangModel.php';
class veinnisController extends Controller
{
    private $veinnisModel;

    public function __construct()
    {
        $this->veinnisModel = $this->model('veinnisModel');
    }

    public function veinnis()
    {
        $info = null; // Khởi tạo mặc định
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->veinnisModel->info($customerId);
        }
        $productTypes = $this->veinnisModel->getProductTypes();
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('veinnis/veinnis');
        $this->view('footer');
    }

    public function blog1()
    {
        $productTypes = $this->veinnisModel->getProductTypes();
        $info = null; // Khởi tạo mặc định
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->veinnisModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('veinnis/blog1');
        $this->view('footer');
    }

    public function blog2()
    {
        $productTypes = $this->veinnisModel->getProductTypes();
        $info = null; // Khởi tạo mặc định
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->veinnisModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('veinnis/blog2');

        $this->view('footer');
    }
}