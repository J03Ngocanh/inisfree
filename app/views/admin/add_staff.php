<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>

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
        <h2>Add Staff</h2>
        <form action="/inis/admin/processAddStaff" method="POST">
            <div class="form-item">
                <input type="text" name="staff_name" id="staff_name" placeholder="Full name" required>
            </div>
            <div class="form-item">
                <input type="text" name="phone" id="phone" placeholder="Phone number" required>
            </div>
            <div class="form-item">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form-item">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
            </div>
            <div class="form-item">
                <select name="role_id" id="role_id" required>
                    <option value="" disabled selected>Select role</option>
                    <?php while ($row = $role->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn submit-btn">Add Staff</button>
                <a href="/inis/admin/staff" class="btn reset-btn">Cancel</a>
            </div>
        </form>

        <?php if (isset($_SESSION['success_message'])): ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        title: "Success!",
                        text: "<?= addslashes($_SESSION['success_message']) ?>",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                });
            </script>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        title: "Error!",
                        text: "<?= addslashes($_SESSION['error']) ?>",
                        icon: "error",
                        confirmButtonText: "Try again"
                    });
                });
            </script>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>


    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector("form").addEventListener("submit", function (event) {
        event.preventDefault();
        let formData = new FormData(this);

        fetch("/inis/admin/processAddStaff", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Success!",
                        text: data.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error",
                        confirmButtonText: "Try again"
                    });
                }
            })
            .catch(error => console.error("Error:", error));
    });

</script>

</body>
</html>