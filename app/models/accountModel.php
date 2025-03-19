<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/model.php';

class accountModel extends Model
{
    protected $tblCustomers = "customers";
    protected $tblStaff = "staff";
    protected $tblProductTypes = 'product_types';

    public function checkStaff($phone)
    {
        $sql = "SELECT * FROM $this->tblStaff WHERE phone = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function checkCustomer($phone)
    {
        $sql = "SELECT * FROM $this->tblCustomers WHERE phone = ? OR email = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $phone, $phone);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function checkStaffByPhone($phone)
    {
        $sql = "SELECT * FROM $this->tblStaff WHERE phone='$phone'";
        $result = $this->con->query($sql);
        return $result;
    }

    public function checkCustomerByPhone($phone)
    {
        $sql = "SELECT * FROM $this->tblCustomers WHERE phone='$phone'";
        $result = $this->con->query($sql);
        return $result;
    }


    public function checkEmailExists($email)
    {
        $sql = "SELECT * FROM $this->tblCustomers WHERE email = '$email'";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    // Save verification code to database
    public function saveVerificationCode($userId, $verificationCode)
    {
        $sql = "UPDATE customers SET verification_code = '$verificationCode' WHERE id = '$userId'";
        return $this->con->query($sql);
    }


    // Check verification code
    public function checkVerificationCode($userId, $verificationCode)
    {
        $sql = "SELECT * FROM customers WHERE id = '$userId' AND verification_code = '$verificationCode'";
        $result = $this->con->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }


    // Update new password
    public function updatePassword($email, $newPassword)
    {
        $sql = "UPDATE customers SET password = '$newPassword' WHERE email = '$email'";
        return $this->con->query($sql);
    }


    public function addAccount($customerName, $email, $phone, $dateOfBirth, $password, $rankId)
    {
        $sql = "INSERT INTO $this->tblCustomers (name, email, phone, date_of_birth, password, rank_id)
        VALUES ('$customerName', '$email', '$phone', '$dateOfBirth', '$password', '$rankId')";
        return $this->con->query($sql);
    }

    public function getProductTypes()
    {
        $sql = "SELECT * FROM $this->tblProductTypes ";
        $result = $this->con->query($sql);
        return $result;
    }

}

?>
