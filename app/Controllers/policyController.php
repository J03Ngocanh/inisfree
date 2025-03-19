<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

class policyController extends Controller
{
    private $veinnisModel;

    public function __construct()
    {
        $this->veinnisModel = $this->model('veinnisModel');
    }

    private function renderPolicy($viewName)
    {
        $productTypes = $this->veinnisModel->getProductTypes();
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->veinnisModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('policy/' . $viewName);
        $this->view('footer');
    }

    public function muahang()
    {
        $this->renderPolicy('muahang');
    }

    public function trahang()
    {
        $this->renderPolicy('trahang');
    }

    public function giaohang()
    {
        $this->renderPolicy('giaohang');
    }

    public function pttt()
    {
        $this->renderPolicy('pttt');
    }
}
