<!DOCTYPE html>
<html lang="vi-VN" data-nhanh.vn-template="T0299">
<head>
    <meta name="robots" content="index, follow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login</title>
    <meta name="DC.language" content="scheme&#x3D;utf-8&#x20;content&#x3D;vi">
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="google-site-verification" content="">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/fontAwesome/font-awesome-4.7.0.min.css?v=2"
          type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/bootstrap/bootstrap.4.3.1.min.css?v=2" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/css/appLib.css" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0299/css/plugin.css?v=10" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0299/css/animate.css?v=10" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0299/css/define.css?v=10" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0299/css/style.css?v=10" type="text/css">
    <link rel="stylesheet" href="https://web.nvnstatic.net/tp/T0299/css/responsive.css?v=10" type="text/css">
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.min.js?v=17"></script>
    <script defer type="text/javascript"
            src="https://web.nvnstatic.net/js/bootstrap/boostrap.popper.min.js?v=17"></script>
    <script defer type="text/javascript"
            src="https://web.nvnstatic.net/js/bootstrap/bootstrap.4.3.1.min.js?v=17"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/lib.js?v=17"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.cookie.js?v=17"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/tp/T0299/js/plugin.js?v=3"></script>
    <script defer type="text/javascript" src="https://web.nvnstatic.net/tp/T0299/js/mains.js?v=3"></script>
    <style type="text/css"></style>
    <style type="text/css">img {
            max-width: 100%;
        }

        img.lazyload {
            opacity: 0.001;
            object-fit: scale-down !important;
        }

        .fb-customerchat > span > iframe.fb_customer_chat_bounce_out_v2 {
            max-height: 0 !important;
        }

        .fb-customerchat > span > iframe.fb_customer_chat_bounce_in_v2 {
            max-height: calc(100% - 80px) !important;
        }</style>
    <script src="https://pos.nvnstatic.net/cache/location.vn.js?v=241115_150026" defer></script>
    <script src="https://web.nvnstatic.net/js/lazyLoad/lazysizes.min.js" async></script>
    <style>figure.image {
            clear: both;
            display: table;
            margin: .9em auto;
            min-width: 50px;
            text-align: center;
            width: auto !important;
        }

        figure.image img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            min-width: 100%;
        }

        figure.image > figcaption {
            background-color: #f7f7f7;
            caption-side: bottom;
            color: #333;
            display: block;
            font-size: .75em;
            outline-offset: -1px;
            padding: .6em;
            word-break: break-word;
        }

        figure.image img, img.image_resized {
            height: auto !important;
            aspect-ratio: auto !important;
        }</style>
    <script src="https://web.nvnstatic.net/js/translate/vi-vn.js" defer></script>
    <script>
    </script>
</head>
<?php
if (isset($_SESSION['signup_success'])) {
    ?>
    <div id="popupSuccess" class="popup">
        <div class="popup-content">
            <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Success Icon" class="icon-success">
            <h2>Sign up successful
                <h2>
                    <div class="message-box">Congratulations! You have received your first 50 points.</div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("popupSuccess").style.display = "flex";
            setTimeout(function () {
                window.location.href = "<?php echo WEBROOT . 'account/login'; ?>";
            }, 2000); // Redirect after 2 seconds
        });
    </script>

    <style>
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 520px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .icon-success {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .message-box {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 15px;
        }

        /* Login error display */
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #ffe5e5;
            border: 1px solid red;
            border-radius: 5px;
        }

        /* Phone input */
        #phone {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        /* On input focus */
        #phone:focus {
            border-color: #79c66e;
            box-shadow: 0 0 5px rgba(121, 198, 110, 0.5);
        }

        /* Phone validation error */
        .input-error {
            border: 2px solid red !important;
            background-color: #ffe5e5;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
    <?php
    unset($_SESSION['signup_success']); // Clear session after showing popup
}
?>

<body>

<script defer type="text/javascript" src="https://web.nvnstatic.net/js/jquery/jquery.validationEngine.js?v=19"></script>
<script defer type="text/javascript"
        src="https://web.nvnstatic.net/js/jquery/jquery.validationEngine-vi.js?v=19"></script>
<script defer type="text/javascript" src="https://web.nvnstatic.net/tp/T0299/js/user.js?v=2"></script>
<link rel="stylesheet" href="https://web.nvnstatic.net/css/validationEngine.jquery.css?v=3" type="text/css">
<link rel="stylesheet" href="https://web.nvnstatic.net/css/appLib.css" type="text/css">
<input type="hidden" id="redirect" value="">
<main class="main-site main-childs">
    <div class="user-wrapper">
        <div class="user-nav anonymous-awe">
            <a href="<?php echo WEBROOT . 'account/login' ?>" class="active" rel="nofollow">Login</a>
            <a href="<?php echo WEBROOT . 'account/signup' ?>" rel="nofollow">Sign up</a>

        </div>
        <form accept-charset="UTF-8" id="loginForm" class="validate" onsubmit="return validateForm()"
              action="<?php echo WEBROOT . 'account/processLogin' ?>" method="post">
            <div class="form-group">
                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
                }
                ?>
                <input type="text" name="phone" id="phone"
                       class="validate[required] <?php echo isset($_SESSION['login_error']) ? 'input-error' : ''; ?>"
                       value="<?php
                       if (isset($_SESSION['display_phone'])) {
                           echo $_SESSION['display_phone'];
                       }
                       if (isset($_COOKIE['login_sdt'])) {
                           echo $_COOKIE['login_sdt'];
                       }
                       ?>"
                       placeholder="Phone or email">
            </div>
            <div id="suggestions" class="suggestions"></div>

            <div class="form-group">
                <input type="password" name="password" id="password" class="validate[required]"
                       value="<?php if (isset($_COOKIE['login_password'])) {
                           echo $_COOKIE['login_password'];
                       } ?>"
                       placeholder="Password">
                <div class="input-group-append">
                    <span id="togglePassword" class="input-group-text" style="cursor: pointer;">
                        <i id="eyeIcon" class="fas fa-eye"></i>  <!-- Eye icon -->
                    </span>
                </div>
            </div>

            <div class="user-foot ">
                <button style="background-color:#79c66e; border-color:#79c66e" type="submit" id="btnsignin"
                        class="btn btn-pink full text-uppercase">
                    Login
                </button>
                <div class="userfoot">
                    <label for="rememberMe"><input style="  padding-left:4px;" type="checkbox" id="rememberMe"
                                                   name="rememberMe"> Remember password</label>

                    <a href="<?php echo WEBROOT . 'account/forgot' ?>" class="clearfix1" rel="nofollow">
                        Forgot password?
                    </a>
                </div>


            </div>
        </form>
    </div>
    <script>
        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');


        // On mouse down
        togglePasswordButton.addEventListener('mousedown', function () {
            passwordField.type = "text"; // Show password
            eyeIcon.classList.remove('fa-eye'); // Show open eye icon
            eyeIcon.classList.add('fa-eye-slash');
        });

        // On mouse up
        togglePasswordButton.addEventListener('mouseup', function () {
            passwordField.type = "password"; // Hide password
            eyeIcon.classList.remove('fa-eye-slash'); // Show closed eye icon
            eyeIcon.classList.add('fa-eye');
        });

        // Handle mouseleave
        togglePasswordButton.addEventListener('mouseleave', function () {
            passwordField.type = "password"; // Hide password
            eyeIcon.classList.remove('fa-eye-slash'); // Show closed eye icon
            eyeIcon.classList.add('fa-eye');
        });


    </script>
</main>

<?php
if (isset($_SESSION['message'])) {
    // Use json_encode for valid JS string
    echo "<script>alert(" . json_encode($_SESSION['message']) . ");</script>";

    // Clear message from session after display
    unset($_SESSION['message']);
}
?>

<style>
    /* Overall */
    body, html {
        margin: 0;
        padding: 0;

        background-color: #f9f9f9;
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f9f9f9;
    }

    .user-wrapper {
        max-width: 500px;
        width: 100%;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .user-nav {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }

    .user-nav a {
        text-transform: uppercase;
        font-size: 16px;
        padding: 10px;
        color: #79c66e;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .user-nav a.active,
    .user-nav a:hover {
        border-bottom: 2px solid #79c66e;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    input:focus {
        outline: none;
        border-color: #79c66e;
        box-shadow: 0 0 5px rgba(121, 198, 110, 0.5);
    }

    #togglePassword {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
        color: #aaa;
    }

    #togglePassword:hover {
        color: #79c66e;
    }

    /* Login button */
    button {
        width: 100%;
        padding: 10px;
        background-color: #79c66e;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #67af5c;
    }

    /* Form footer */
    .userfoot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    /* Checkbox and label alignment */
    .userfoot label {
        display: flex;
        align-items: center;
        font-size: 14px;
        gap: 5px;         cursor: pointer;
    }

    .userfoot input[type="checkbox"] {
        width: 18px;         height: 18px;
        accent-color: #79c66e;         height: 18px;

    }


    .userfoot a:hover {
        color: #79c66e;
    }

    /* Username hint */
    .suggestions {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        width: 100%;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        z-index: 10;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .suggestions div {
        padding: 10px;
        cursor: pointer;
        font-size: 14px;
        color: #333;
    }

    .suggestions div:hover {
        background-color: #f5f5f5;
    }

    /* Social login */
    .loginFb, .loginGg {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border-radius: 4px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    .loginFb {
        background-color: #2e4b88;
    }

    .loginFb:hover {
        background-color: #233b6d;
    }

    .loginGg {
        background-color: #ea4235;
    }

    .loginGg:hover {
        background-color: #cc372c;
    }

    .loginFb span,
    .loginGg span {
        margin-right: 10px;
        font-size: 18px;
    }

    /* Login error feedback */
    .error-message {
        color: red;
        font-size: 14px;
        margin-bottom: 10px;
        text-align: center;
    }

</style>
</body>
</html>