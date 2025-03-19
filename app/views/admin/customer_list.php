<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        /* Table */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        td {
            color: #333;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* Overlay when active */
        #overlay.active {
            opacity: 1;
        }

        /* Popup styles */
        #orderDetailsPopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: none;
            opacity: 0;
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }


        #orderDetailsPopup.active {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }


        /* Close button */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            color: #888;
            cursor: pointer;
        }

        .close:hover {
            color: #4CAF50;
        }

        /* Input and select styling */
        #orderDetailsPopup .form-item input,
        #orderDetailsPopup .form-item select {
            width: 100%;
            padding: 12px 14px; /* Tăng khoảng cách trong */
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        #orderDetailsPopup .form-item input:focus,
        #orderDetailsPopup .form-item select:focus {
            border-color: #4CAF50;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 6px rgba(76, 175, 80, 0.5); /* Ánh sáng xung quanh ô */
        }

        #editPopup .form-item input,
        #editPopup .form-item select {
            width: 100%;
            padding: 12px 14px; /* Tăng khoảng cách trong */
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        #editPopup .form-item input:focus,
        #editPopup .form-item select:focus {
            border-color: #4CAF50;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 6px rgba(76, 175, 80, 0.5); /* Ánh sáng xung quanh ô */
        }

        /* Button Styling */
        button.btn_ne {
            padding: 12px 20px;
            background-color: #4CAF50; /* Green background for the submit button */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
            width: 100%;
            text-align: center;
        }

        button.btn_ne button:hover {
            background-color: #388E3C; /* Darker green on hover */
            transform: scale(1.05);
        }

        /* Cancel button styling */
        #orderDetailsPopup .btn-cancel {
            background-color: #f44336; /* Red background for the cancel button */
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #orderDetailsPopup .btn-cancel:hover {
            background-color: #d32f2f; /* Darker red on hover */
            transform: scale(1.05);
        }

        #editPopup .btn-cancel {
            background-color: #f44336; /* Red background for the cancel button */
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #editPopup .btn-cancel:hover {
            background-color: #d32f2f; /* Darker red on hover */
            transform: scale(1.05);
        }


        /* Button */
        .btn-add {
            background-color: #4CAF50;             color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 8px 10px 10px 10px; /* Thêm khoảng cách trong nút */
            position: fixed;             top: 70px;             right: 20px;             border-radius: 10px; /* Bo tròn góc nút */
            border: solid white;
            z-index: 1000; /* Đảm bảo nút hiển thị trên các phần tử khác */
            cursor: pointer;
        }

        button:hover {
            background-color: #388E3C;
        }

        .btn-cancel {
            background-color: #f44336;
        }

        .btn-cancel:hover {
            background-color: #d32f2f;
        }

        /* Edit account form */
        #editPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            max-width: 650px;
            width: 90%;
        }

        #editPopup.active {
            display: block; /* Chỉ khi có class 'active' thì popup mới hiển thị */
        }

        .btn-edit i {

            color: #4CAF50;             margin-right: 5px;
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        #overlay {
            z-index: 9999 !important;
        }

        #orderDetailsPopup {
            z-index: 10000 !important;
        }


    </style>
</head>
<body>

<div class="detail">
    <h2>Customer List</h2>

    <table>
        <thead>
        <tr>
            <th>Customer code</th>
            <th>Customer name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Date of birth</th>
            <th>Rank</th>
            <th>Points</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_array($customerList)) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['phone']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['date_of_birth']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['point']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>


</div>
<script>


    // Validate add account form
    function validateForm() {

        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var phone = document.getElementById("phone").value;


        if (confirmPassword !== password) {
            alert("Passwords do not match.");
            return false;
        }
        if (!/^0[0-9]{9,10}$/.test(phone)) {
            alert("Invalid phone number.");
            return false;
        }
        return true;
    }

    // Validate edit account form
    function validateEditForm() {

        var password = document.getElementById("editPassword").value;
        var confirmPassword = document.getElementById("edit_confirm_password").value;
        var phone = document.getElementById("edit_phone").value;


        if (confirmPassword !== password) {
            alert("Passwords do not match.");
            return false;
        }
        if (!/^0[0-9]{9,10}$/.test(phone)) {
            alert("Invalid phone number.");
            return false;
        }
        return true;
    }


</script>
</body>
</html>