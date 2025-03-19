<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';
require_once dirname(dirname(dirname(__FILE__))) . '/app/models/mailer.php';

class accountController extends Controller
{
    private $accountModel;

    public function __construct()
    {
        $this->accountModel = $this->model('accountModel');
    }

    public function forgot()
    {
        $this->view('account/forgot_password');
    }

    public function login()
    {
        if(isset($_SESSION['customer_name'])){
            header('Location: /inis/home/home');
            return;
        }
        elseif(isset($_SESSION['staff_name'])){
            header('Location: /inis/admin/dashboard');
            return;
        }
        $this->view('account/login');
    }

    // Handle when user clicks "Send verification code"
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $user = $this->accountModel->checkEmailExists($email);

            if ($user) {
                $verificationCode = rand(100000, 999999);
                if ($this->accountModel->saveVerificationCode($user['id'], $verificationCode)) {
                    $mailer = new Mailer();
                    if ($mailer->sendVerificationCode($email, $verificationCode)) {
                        $_SESSION['email'] = $email;
                        $_SESSION['message'] = "Verification code has been sent to your email.";
                        $_SESSION['message_type'] = "success";
                        $this->view('account/verify_code');
                        exit;
                    } else {
                        $_SESSION['message'] = "Could not send email. Please try again.";
                        $_SESSION['message_type'] = "error";
                        $this->view('account/forgot_password');
                        exit;
                    }
                }
            } else {
                $_SESSION['message'] = "Email not found in the system.";
                $_SESSION['message_type'] = "error";
                $this->view('account/forgot_password');
                exit;
            }
        }
    }

    public function verifyCode()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $verificationCode = $_POST['verification_code'];
            $email = $_SESSION['email'];

            $user = $this->accountModel->checkEmailExists($email);

            if ($user) {
                if ($this->accountModel->checkVerificationCode($user['id'], $verificationCode)) {
                    $_SESSION['message'] = "Code verified. You can change your password.";
                    $_SESSION['message_type'] = "success";
                    $this->view('account/reset_password');
                } else {
                    $_SESSION['message'] = "Invalid verification code.";
                    $_SESSION['message_type'] = "error";
                    $this->view('account/verify_code');
                }
            } else {
                $_SESSION['message'] = "Email not found in the system.";
                $_SESSION['message_type'] = "error";
                $this->view('account/verify_code');
            }
        }
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['email'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword === $confirmPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $user = $this->accountModel->updatePassword($email, $hashedPassword);

                if ($user) {
                    $_SESSION['message'] = "Password changed successfully!";
                    $_SESSION['message_type'] = "success";
                    unset($_SESSION['email']);
                    header("Location: /inis/account/login");
                    exit;
                } else {
                    $_SESSION['message'] = "An error occurred. Please try again.";
                    $_SESSION['message_type'] = "error";
                    $this->view('account/reset_password');
                    exit;
                }
            } else {
                $_SESSION['message'] = "Password and confirmation do not match.";
                $_SESSION['message_type'] = "error";
                $this->view('account/reset_password');
                exit;
            }
        }
    }


    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['login_error'] = "Invalid request.";
            $this->view('account/login');
            return;
        }

        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        if (empty($phone) || empty($password)) {
            $_SESSION['login_error'] = "Please enter phone or email and password.";
            $this->view('account/login');
            return;
        }
        $checkCustomer = $this->accountModel->checkCustomer($phone);
        if ($checkCustomer && $row = mysqli_fetch_assoc($checkCustomer)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['customer_name'] = $row['tenkhachhang'];
                $_SESSION['sdt'] = $row['sdt'];
                $_SESSION['customer_id'] = $row['id'];

                if (!empty($_POST['rememberMe'])) {
                    setcookie('login_sdt', $phone, time() + (7 * 24 * 60 * 60), "/");
                    setcookie('login_password', $password, time() + (7 * 24 * 60 * 60), "/");
                }

                unset($_SESSION['login_error']);
                header('Location: /inis/home/home');
                exit();
            } else {
                $_SESSION['login_error'] = "Incorrect password.";
            }
        } else {
            $checkStaff = $this->accountModel->checkStaff($phone);
            if ($checkStaff && $row = mysqli_fetch_assoc($checkStaff)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['staff_name'] = $row['name'];
                    $_SESSION['sdt'] = $row['phone'];
                    $_SESSION['staff_id'] = $row['staff_id'];
                    $_SESSION['role'] = $row['role_id'];

                    if (!empty($_POST['rememberMe'])) {
                        setcookie('login_sdt', $phone, time() + (7 * 24 * 60 * 60), "/");
                        setcookie('login_password', $password, time() + (7 * 24 * 60 * 60), "/");
                    }

                    unset($_SESSION['login_error']);
                    header('Location: /inis/admin/products');
                    exit();
                } else {
                    $_SESSION['login_error'] = "Incorrect password.";
                }
            } else {
                $_SESSION['login_error'] = "No account with this phone number.";
            }
        }
        $this->view('account/login');
    }

    public function signup()
    {
        $this->view('account/signup1');
    }


    public function processSignup()
    {
        $customerName = $_POST['customer_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $email = $_POST['email'] ?? '';
        $dateOfBirth = $_POST['date_of_birth'] ?? '';
        $rankId = 1;
        $checkCustomerByPhone = $this->accountModel->checkCustomerByPhone($phone);
        $checkemail = $this->accountModel->checkEmailExists($email);
        $i = 0;
        if (mysqli_num_rows($checkCustomerByPhone) > 0) {
            $_SESSION['duplicate_phone_msg'] = "This phone number is already in use.";
            $i++;
        } else {
            unset($_SESSION['duplicate_phone_msg']);
            $_SESSION['display_phone'] = $phone;
        }

        if ($checkemail) {
            $_SESSION['duplicate_email_msg'] = "This email is already registered.";
            $i++;
        } else {
            unset($_SESSION['duplicate_email_msg']);
            $_SESSION['display_email'] = $email;
        }

        if ($i == 0) {
            $this->accountModel->addAccount($customerName, $email, $phone, $dateOfBirth, $password_hash, $rankId);
            $_SESSION['signup_success'] = true;

            unset($_SESSION['display_customer_name'], $_SESSION['duplicate_phone_msg'], $_SESSION['display_phone'],
                $_SESSION['duplicate_email_msg'], $_SESSION['display_email'], $_SESSION['display_password']);

            header('Location: /inis/account/login');
            exit();
        } else {
            $_SESSION['display_customer_name'] = $customerName;
            $_SESSION['display_password'] = $password;
            header('Location: /inis/account/signup');
            exit();
        }
    }

    public function processAddStaff()
    {
        $staffName = $_POST['staff_name'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $roleId = $_POST['role_id'];

        $checkStaffByPhone = $this->accountModel->checkStaffByPhone($phone);
        $i = 0;
        if (mysqli_num_rows($checkStaffByPhone) > 0) {
            $_SESSION['duplicate_phone_msg'] = "This phone number is already in use.";
            $i++;
        } else {
            unset($_SESSION['duplicate_phone_msg']);
            $_SESSION['display_phone'] = $phone;
        }
        if ($i == 0) {
            $adminModel = $this->model('adminModel');
            $adminModel->addStaff($staffName, $phone, $password_hash, $roleId);

            unset($_SESSION['display_staff_name'], $_SESSION['duplicate_phone_msg'], $_SESSION['display_phone'],
                $_SESSION['duplicate_email_msg'], $_SESSION['display_email'], $_SESSION['display_password']);
        } else {
            $_SESSION['display_staff_name'] = $staffName;
            $_SESSION['display_password'] = $password;
        }
    }


    public function logout()
    {
        if (isset($_SESSION['sdt'])) {
            session_destroy();
        }
        header('Location: /inis/account/login/');
    }


}

?>
