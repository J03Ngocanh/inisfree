<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Same style as add staff */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .main-content {
            max-width: 650px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .form-item {
            margin-bottom: 15px;
        }

        .form-item input, .form-item select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-item input:focus, .form-item select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .form-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .submit-btn:hover {
            background-color: #388E3C;
        }

        .reset-btn {
            background-color: #f44336;
            color: white;
            text-decoration: none; 
        }

        .reset-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
<div class="detail">
    <div class="main-content">
        <h2>Edit Staff</h2>
        <form action="/inis/admin/processUpdateStaff" method="POST" onsubmit="return validateForm()">
            <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staffData['staff_id']) ?>">
            <div class="form-item">
                <input type="text" name="staff_name" id="staff_name"
                       value="<?= htmlspecialchars($staffData['name']) ?>" required>
            </div>
            <div class="form-item">
                <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($staffData['phone']) ?>"
                       onkeypress="return isNumberKey(event)" required>
            </div>
            <div class="form-item">
                <input type="password" name="password" id="password"
                       placeholder="New password (leave blank to keep)">
            </div>
            <div class="form-item">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password">
            </div>
            <div class="form-item">
                <select name="role_id" id="role_id" required>
                    <?php while ($row = $role->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= $row['id'] == $staffData['role_id'] ? 'selected' : '' ?>>
                            <?= $row['name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn submit-btn">Save Changes</button>
                <a href="/inis/admin/staff" class="btn reset-btn">Cancel</a>
            </div>
        </form>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<script>alert('" . addslashes($_SESSION['success_message']) . "');</script>";
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error'])) {
            echo "<script>alert('" . addslashes($_SESSION['error']) . "');</script>";
            unset($_SESSION['error']);
        }
        ?>
    </div>
</div>
<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var sdt = document.getElementById("sdt").value;

        if (password && confirmPassword !== password) {
            alert("Passwords do not match.");
            return false;
        }
        if (!/^0[0-9]{9,10}$/.test(sdt)) {
            alert("Invalid phone number.");
            return false;
        }
        return true;
    }

    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
</script>
</body>
</html>