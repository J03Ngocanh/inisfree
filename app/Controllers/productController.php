<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

class productController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
    }

    public function index()
    {
        $productTypes = $this->productModel->getProductTypes();
        $productTypes2 = $this->productModel->getProductTypes();
        $categories = $this->productModel->getCategories();
        $products = $this->productModel->getAll();
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->productModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('product/list', ['productTypes' => $productTypes2, 'categories' => $categories, 'products' => $products]);
        $this->view('footer');
    }


    public function byCategory($id)
    {
        $productTypes = $this->productModel->getProductTypes();
        $productTypes2 = $this->productModel->getProductTypes();
        $categories = $this->productModel->getCategories();
        $products = $this->productModel->getProductsByCategory($id);
        $categoryTypeName = $this->productModel->getCategoryTypeName($id);
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->productModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('product/list', ['productTypes' => $productTypes2, 'categories' => $categories, 'products' => $products, 'categoryTypeName' => $categoryTypeName]);
    }

    public function detail($id)
    {
        $productTypes = $this->productModel->getProductTypes();
        $product = $this->productModel->getProductDetail($id);
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->productModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('product/detail', ['product' => $product]);
        $this->view('footer');
    }

    public function byType($id)
    {
        $id = isset($id) ? (int) $id : 0;
        if ($id < 1) {
            header('Location: ' . (defined('WEBROOT') ? WEBROOT : '/') . 'product/index');
            exit;
        }
        $productTypes = $this->productModel->getProductTypes();
        $productTypes2 = $this->productModel->getProductTypes();
        $categories = $this->productModel->getCategories();
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->productModel->info($customerId);
        }
        $tenloai = $this->productModel->getTypeName($id);
        $products = $this->productModel->getAll_loai($id);

        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('product/list', ['productTypes' => $productTypes2, 'categories' => $categories, 'products' => $products, 'typeName' => $tenloai]);
    }

    public function processSearch()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['q'])) {
            $query = $_POST['q'];
            $query = urldecode($query);
            $query = trim($query);
            $query = filter_var($query, FILTER_SANITIZE_STRING);
            $encodedQuery = urlencode($query);
            header("location: /inis/product/search/$encodedQuery ");
            exit;
        }
    }

    public function search($query)
    {
        $query = urldecode($query);
        $query = trim($query);
        $query = filter_var($query, FILTER_SANITIZE_STRING);
        $productTypes = $this->productModel->getProductTypes();
        $productTypes2 = $this->productModel->getProductTypes();
        $categories = $this->productModel->getCategories();
        $products = $this->productModel->searchProducts($query);
        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->productModel->info($customerId);
        }
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('product/list', ['productTypes' => $productTypes2, 'categories' => $categories, 'products' => $products]);
        $this->view('footer');
    }

    public function searchSuggest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['q'])) {
            $query = $_POST['q'];
            $result = $this->productModel->getProductNamesBySearch($query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<a href="/inis/product/detail/' . $row['product_code'] . '" style="text-decoration: none; color: inherit;">
                    <div style="display: flex; align-items: center; padding: 10px 12px; font-size: 14px; color: #333; cursor: pointer; transition: background-color 0.2s;">
                        <img style="width: 30px; height: auto; margin-right: 10px; border-radius: 4px;" src="' . WEBROOT . 'public/img/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                        ' . htmlspecialchars($row['name']) . '
                    </div>
                </a>';
                }
            } else {
                echo "<div>Product not found</div>";
            }
        } else {
            echo "<div>Invalid data</div>";
        }
    }
}
?>
