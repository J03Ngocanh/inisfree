<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Nunito", sans-serif;
        }

        .toto {
            display: flex;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .detail {
            margin-left: 250px;
            margin-top: 80px;

        }

        .header {
            display: flex;

            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 60px;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .icon-menu {
            display: flex;
            gap: 3%;
        }

        .logo img {
            width: 200px;
            height: auto;
        }

        .sidebar {
            width: 250px;
            background-color: rgb(68, 184, 88);
            color: #fff;
            padding-top: 80px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar .menu {
            list-style: none;
        }

        .sidebar .menu a {
            display: block;
            padding: 15px 25px;
            font-size: 18px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .sidebar .menu a i {
            margin-right: 10px;
        }

        .sidebar .menu a:hover,
        .sidebar .menu a.active {
            background-color: rgb(21, 100, 12);
            color: white;
        }

        /* Main menu active color */
        .sidebar .menu a.open {
            background-color: rgb(30, 130, 20);
        }

        .sidebar .submenu {
            list-style: none;
            padding-left: 30px;
            display: none;
        }

        .sidebar .submenu a {
            padding: 10px 25px;
            font-size: 16px;
            color: white;
            text-decoration: none;
        }

        .sidebar .submenu a:hover {
            background-color: rgb(194, 224, 204);
            color: rgb(5, 27, 11);
        }

        .content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="to">
    <header class="header">
        <div class="logo">
            <a href="<?php echo WEBROOT; ?>admin/overview">
                <img src="<?php echo WEBROOT; ?>public/img/innis.png" alt="Logo">
            </a>
        </div>
        <div class="icon-menu">
            <?php if (isset($_SESSION['staff_name'])): ?>
                Hello, <strong><?= htmlspecialchars($_SESSION['staff_name']); ?></strong>
                <a href="<?php echo WEBROOT; ?>account/logout" style="text-decoration:none; color:black">| Log
                    out</a>
            <?php else: ?>
                <a href="<?php echo WEBROOT; ?>account/login" class="icon"><i class="fas fa-user"></i></a>
            <?php endif; ?>
        </div>
    </header>
</div>
<div class="sidebar">
    <ul class="menu">
        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "1") { ?>
            <li><a href="<?php echo WEBROOT . 'admin/overview' ?>"><i class="fas fa-house"></i>Overview</a></li>
            <li><a href="<?php echo WEBROOT . 'admin/staff' ?>"><i class="fas fa-building"></i>Staff</a></li>
        <?php } ?>
        <li><a href="<?php echo WEBROOT . 'admin/customers' ?>"><i class="fa-solid fa-boxes-stacked"></i>Customers</a>
        </li>
        <li><a href="<?php echo WEBROOT . 'admin/products' ?>"><i class="fa-brands fa-product-hunt"></i>Products</a></li>
        <li><a href="<?php echo WEBROOT . 'admin/orders' ?>"><i class="fa-solid fa-file-import"></i>Orders</a></li>


    </ul>
</div>

<script>
    // Current URL
    const currentUrl = window.location.href;

    // Menu and submenu links
    const menuItems = document.querySelectorAll('.sidebar .menu a');

    // Remove active/open from all items
    function removeActiveStates() {
        menuItems.forEach(item => {
            item.classList.remove('active', 'open');
        });

        // Close all submenus
        const allSubmenus = document.querySelectorAll('.submenu');
        allSubmenus.forEach(submenu => {
            submenu.style.display = 'none';
        });
    }

    // Set active for current URL
    menuItems.forEach(item => {
        if (item.href === currentUrl) {
            removeActiveStates();
            item.classList.add('active');
            const parentMenu = item.closest('.submenu')?.previousElementSibling;
            if (parentMenu) {
                parentMenu.classList.add('active');
                parentMenu.nextElementSibling.style.display = 'block';
            }
        }
    });

    // Toggle submenu
    const reportMenu = document.querySelector('.report-menu');
    const submenu = document.querySelector('.submenu');

    reportMenu.addEventListener('click', function () {
        const isVisible = submenu.style.display === 'block';

        // Clear other items
        removeActiveStates();

        // Show/hide submenu
        submenu.style.display = isVisible ? 'none' : 'block';

        // Add 'open' for submenu
        if (!isVisible) {
            reportMenu.classList.add('open');
        }
    });
</script>

</body>
</html>
