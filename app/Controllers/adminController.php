<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

// require_once 'app/models/sanpham.php';

class adminController extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = $this->model('adminModel');
    }

    public function overview()
    {
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "2") {
            header("location: /inis/admin/products");
        } else {
            if (isset($_SESSION['staff_name'])){
                $this->view('header');
                $this->view('admin/dashboard');
            }
            else {
                header("location: /inis/account/login");
            }
        }

    }

    public function staff()
    {
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "2") {
            header("location: /inis/admin/products");
        } else {
            if (isset($_SESSION['staff_name'])){
                $staffList = $this->adminModel->getStaffList();
                $role = $this->adminModel->getRoles();
                $this->view('header');
                $this->view('admin/staff_list', ['staffList' => $staffList, 'role' => $role]);
            }
            else {
                header("location: /inis/account/login");
            }
        }
    }

    public function customers()
    {
        if (isset($_SESSION['staff_name'])){
        $customerList = $this->adminModel->getCustomerList();
        $this->view('header');
        $this->view('admin/customer_list', ['customerList' => $customerList]);
    }
    else {
        header("location: /inis/account/login");
    }
    }

    public function orders()
    {
        if (isset($_SESSION['staff_name'])){
        $this->view('header');
        $orderList = $this->adminModel->getOrders();
        $orderDetails = $this->adminModel->getOrderDetails();
        $this->view('admin/order_list', ['orderList' => $orderList, 'orderDetails' => $orderDetails]);
    }
    else {
        header("location: /inis/account/login");
    }
    }

    public function products()
    {
        if (isset($_SESSION['staff_name'])){
        $productList = $this->adminModel->getProductList();
        $categories = $this->adminModel->getCategories();

        $this->view('header');
        $this->view('admin/product_list', ['productList' => $productList, 'categories' => $categories]);
    }
    else {
        header("location: /inis/account/login");
    }
    }

    public function getProductInfo($productCode)
    {
        $result = $this->adminModel->getProduct($productCode);
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function deleteProduct($productCode)
    {
        $this->adminModel->deleteProduct($productCode);
        $_SESSION['success_message'] = "Product deleted: $productCode";
        header("location: /inis/admin/products");
    }


    public function confirmOrder($orderId)
    {
        $this->adminModel->confirmPayment($orderId);
        $result = $this->adminModel->getOrderInfo($orderId);
        if ($row = $result->fetch_assoc()) {
            $customerId = $row['customer_id'];
            $subtotal = $row['subtotal'];
        } else {
            echo 1111;
        }
        $this->adminModel->updatePointsAndRank($customerId, $subtotal);
        header("location: /inis/admin/orders");

    }

    public function dashboard()
    {
        $year = date('Y');
        $month = date('m');
        $revenue = $this->adminModel->getRevenueByYear($year);
        $topProducts = $this->adminModel->getTopProducts($month, $year);
        $lowStockProducts = $this->adminModel->getLowStockProducts();


        $this->view('header');
        $this->view('admin/dashboard', [
            'revenue' => $revenue,
            'topProducts' => $topProducts,
            'lowStockProducts' => $lowStockProducts,
            'currentYear' => $year,
            'currentMonth' => $month
        ]);
    }
    public function getDoanhThuJSON()
    {
        $month = isset($_POST['month']) ? $_POST['month'] : null; // Get the selected month from POST
        $revenue = $this->adminModel->getRevenueByMonth($month);
        echo json_encode($revenue);
    }

    public function editProduct($productCode = '')
    {
        if (empty($productCode)) {
            $_SESSION['error'] = "Product code not found!";
            header("location: /inis/admin/products");
            return;
        }

        // Get product info
        $product = $this->adminModel->getProduct($productCode);
        $categories = $this->adminModel->getCategories();

        if (!$product) {
            $_SESSION['error'] = "Product not found!";
            header("location: /inis/admin/products");
            return;
        }

        $productData = mysqli_fetch_array($product);

        $this->view('header');
        $this->view('admin/edit_product', [
            'product' => $productData,
            'categories' => $categories
        ]);
    }

    public function processUpdateProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request!";
            header("location: /inis/admin/products");
            return;
        }
        $productCode = $_POST['product_code'] ?? '';
        $productName = $_POST['product_name'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($productCode) || empty($productName) || empty($categoryId) || empty($quantity) || empty($price)) {
            $_SESSION['error'] = "Please fill in all required fields!";
            header("location: /inis/admin/editProduct/$productCode");
            return;
        }

        // Get current product info to keep old images if no new upload
        $result = $this->adminModel->getProduct($productCode);
        $row = mysqli_fetch_array($result);
        $image = $row['image'] ?? '';
        $image1 = $row['image1'] ?? '';
        $image2 = $row['image2'] ?? '';
        $image3 = $row['image3'] ?? '';
        $image4 = $row['image4'] ?? '';

        // Process 5 images if new upload
        $imageFields = ['image', 'image1', 'image2', 'image3', 'image4'];
        $postFields = ['image', 'image1', 'image2', 'image3', 'image4'];
        foreach ($imageFields as $i => $field) {
            $f = $postFields[$i];
            if (isset($_FILES[$f]) && $_FILES[$f]['name'] != '') {
                $filename = $_FILES[$f]['name'];
                $file_tmp = $_FILES[$f]['tmp_name'];
                move_uploaded_file($file_tmp, "public/img/" . $filename);
                $$field = $filename;
            }
        }

        // Call update product (model expects old param names)
        $this->adminModel->updateProduct($productCode, $productName, $categoryId, $quantity, $price, $description, $image, $image1, $image2, $image3, $image4);

        $_SESSION['success_message'] = "Product updated: $productCode - $productName";
        header("location: /inis/admin/products");
    }

    public function add()
    {
        $categories = $this->adminModel->getCategories();

        $this->view('header');
        $this->view('admin/add_product', [
            'categories' => $categories
        ]);
    }

    public function processAddProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request!";
            header("location: /inis/admin/products");
            return;
        }

        // Get form data
        $productName = $_POST['product_name'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';

        // Validate required fields
        if (empty($productName) || empty($categoryId) || empty($quantity) || empty($price)) {
            $_SESSION['error'] = "Please fill in all required fields!";
            header("location: /inis/admin/addProduct");
            return;
        }

        // Handle 5 images
        $image = '';
        $image1 = '';
        $image2 = '';
        $image3 = '';
        $image4 = '';

        $imageFields = ['image', 'image1', 'image2', 'image3', 'image4'];
        $imgVars = ['image', 'image1', 'image2', 'image3', 'image4'];
        foreach ($imageFields as $i => $field) {
            if (isset($_FILES[$field]) && $_FILES[$field]['name'] != '') {
                $filename = $_FILES[$field]['name'];
                $file_tmp = $_FILES[$field]['tmp_name'];
                move_uploaded_file($file_tmp, "public/img/" . $filename);
                ${$imgVars[$i]} = $filename;
            }
        }

        // Call add product with 10 params (model param names kept for compatibility)
        $this->adminModel->addProduct($categoryId, $productName, $description, $price, $image, $image1, $image2, $image3, $image4, $quantity);

        $_SESSION['success_message'] = "Product added: $productName";
        header("location: /inis/admin/products");
    }

    public function addStaff()
    {
        $role = $this->adminModel->getRoles();
        //  $this->view('header');
        $this->view('admin/add_staff', ['role' => $role]);
    }

    public function processAddStaff()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["success" => false, "message" => "Invalid request!"]);
            return;
        }

        // Get POST data
        $staffName = trim($_POST['staff_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['mat_khau_2'] ?? '';
        $roleId = $_POST['role_id'] ?? '';

        // Validate input
        if (empty($staffName) || empty($phone) || empty($password) || empty($roleId)) {
            echo json_encode(["success" => false, "message" => "Please fill in all required fields!"]);
            return;
        }

        if ($password !== $passwordConfirm) {
            echo json_encode(["success" => false, "message" => "Passwords do not match!"]);
            return;
        }

        if (!preg_match("/^0[0-9]{9,10}$/", $phone)) {
            echo json_encode(["success" => false, "message" => "Invalid phone number!"]);
            return;
        }

        // Check if phone already exists
        if (mysqli_num_rows($this->adminModel->checkStaffByPhone($phone)) > 0) {
            echo json_encode(["success" => false, "message" => "This phone number is already in use!"]);
            return;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Add account to database
        $this->adminModel->addStaff($staffName, $phone, $hashed_password, $roleId);

        // Clear unnecessary session
        unset($_SESSION['display_staff_name'], $_SESSION['duplicate_phone_msg'], $_SESSION['display_phone'],
            $_SESSION['duplicate_email_msg'], $_SESSION['display_email'], $_SESSION['display_password']);

        // Return JSON for popup
        echo json_encode([
            "success" => true,
            "message" => "Staff added successfully: $staffName",
            "redirect" => "/inis/admin/staff"
        ]);
        exit;
    }


    public function editStaff($staffId = '')
    {
        if (empty($staffId)) {
            $_SESSION['error'] = "Staff code not found!";
            header("location: /inis/admin/staff");
            return;
        }

        $staff = $this->adminModel->getStaff($staffId);
        $role = $this->adminModel->getRoles();

        if (!$staff) {
            $_SESSION['error'] = "Staff not found!";
            header("location: /inis/admin/staff");
            return;
        }

        $staffData = mysqli_fetch_array($staff);
        $this->view('header');
        $this->view('admin/edit_staff', ['staffData' => $staffData, 'role' => $role]);
    }

    public function processUpdateStaff()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request!";
            header("location: /inis/admin/staff");
            return;
        }

        $staffId = $_POST['staff_id'] ?? '';
        $staffName = $_POST['staff_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['mat_khau_2'] ?? '';
        $roleId = $_POST['role_id'] ?? '';

        if (empty($staffId) || empty($staffName) || empty($phone) || empty($roleId)) {
            $_SESSION['error'] = "Please fill in all required fields!";
            header("location: /inis/admin/editStaff/$staffId");
            return;
        }

        if ($password && $password !== $passwordConfirm) {
            $_SESSION['error'] = "Passwords do not match!";
            header("location: /inis/admin/editStaff/$staffId");
            return;
        }

        if (!preg_match("/^0[0-9]{9,10}$/", $phone)) {
            $_SESSION['error'] = "Invalid phone number!";
            header("location: /inis/admin/editStaff/$staffId");
            return;
        }

        $hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : null;
        $this->adminModel->updateStaff($staffId, $staffName, $phone, $hashed_password, $roleId);

        $_SESSION['success_message'] = "Staff updated: $staffName";
        header("location: /inis/admin/staff");
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            return;
        }

        $staffId = $_POST['staff_id'] ?? '';
        $status = $_POST['status'] ?? '';

        if (empty($staffId) || !in_array($status, ['0', '1'])) {
            echo json_encode(['success' => false]);
            return;
        }

        $this->adminModel->updateStatus($staffId, $status);
        echo json_encode(['success' => true]);
    }


    public function getRevenueByYearJSON() {
        // Set header for JSON response
        header('Content-Type: application/json; charset=UTF-8');

        $year = isset($_POST['year']) ? (int)$_POST['year'] : date('Y');
        $revenue = $this->adminModel->getRevenueByYear($year);

        // Return JSON and exit
        echo json_encode(['data' => array_values($revenue)]);
        exit;
    }

    public function getTopProductsJSON() {
        // Set header for JSON response
        header('Content-Type: application/json; charset=UTF-8');

        $month = isset($_POST['month']) ? (int)$_POST['month'] : date('m');
        $year = isset($_POST['year']) ? (int)$_POST['year'] : date('Y');
        $topProducts = $this->adminModel->getTopProducts($month, $year);

        // Return JSON and exit
        echo json_encode($topProducts);
        exit;
    }
public function getLowStockProductsJSON(){
        $lowStockProducts = $this->adminModel->getLowStockProducts();
        // Return JSON and exit
        echo json_encode($lowStockProducts);
        exit;

    }
}