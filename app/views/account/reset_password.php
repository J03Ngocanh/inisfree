<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
        flex-direction: column;
        font-family: "Nunito", sans-serif;

    }

    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }


    form input, form button {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    form input {
        font-size: 14px;
    }

    form button {
        background-color: white;
        color: #16a032;
        border: 2px solid #16a032;
        font-size: 16px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #16a032;
        color: white;
    }

    /* Message */
    .alert {
        font-size: 13px;
        background-color: #d4edda;         color: #155724;
        padding: 15px;
        margin-bottom: 10px;         border-radius: 5px;
        border: 1px solid #c3e6cb;
        text-align: center;
        width: 300px;
        margin-bottom: 20px;     }

</style>
<body>
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert <?php echo $_SESSION['message_type']; ?>">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']);
    unset($_SESSION['message_type']); ?>
<?php endif; ?>

<form method="POST" action="<?php echo WEBROOT . 'account/resetPassword' ?>">
    <label for="new_password">New password:</label>
    <input type="password" name="new_password" required>

    <label for="confirm_password">Confirm password:</label>
    <input type="password" name="confirm_password" required>

    <button type="submit">Reset password</button>
</form>
</body>
</html>
