<?php

session_start();

require_once "config/database.php";

$error = "";

/*
|--------------------------------------------------------------------------
| Login Form Submit
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($email === "" || $password === "") {

        $error = "Please enter email and password.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->prepare("
            SELECT
                id,
                name,
                email,
                password,
                role
            FROM users
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | Check Password
        |--------------------------------------------------------------------------
        */

        if ($user && password_verify($password, $user["password"])) {

            /*
            |--------------------------------------------------------------------------
            | Regenerate Session ID
            |--------------------------------------------------------------------------
            */

            session_regenerate_id(true);

            /*
            |--------------------------------------------------------------------------
            | Login Success
            |--------------------------------------------------------------------------
            */

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_role"] = $user["role"];

            /*
            |--------------------------------------------------------------------------
            | Admin Redirect
            |--------------------------------------------------------------------------
            */

            if ($user["role"] === "admin") {

                header("Location: admin.php");
                exit;

            }

            /*
            |--------------------------------------------------------------------------
            | Normal User Redirect
            |--------------------------------------------------------------------------
            */

            header("Location: index.php");
            exit;

        } else {

            $error = "Invalid email or password.";

        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | Royal Stay</title>

    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        /* =========================================================
           RESET
        ========================================================= */

        * {

            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }


        html {

            scroll-behavior: smooth;

        }


        body {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px;

            overflow: hidden;

            font-family: "Montserrat", sans-serif;

            background:
                radial-gradient(
                    circle at 20% 20%,
                    rgba(212,175,55,0.13),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 80% 80%,
                    rgba(212,175,55,0.10),
                    transparent 30%
                ),
                #070707;

            color: #fff;

        }


        /* =========================================================
           BACKGROUND
        ========================================================= */

        .background {

            position: fixed;

            inset: 0;

            overflow: hidden;

            pointer-events: none;

            z-index: 0;

        }


        .glow {

            position: absolute;

            width: 350px;

            height: 350px;

            border-radius: 50%;

            background: rgba(212,175,55,0.08);

            filter: blur(80px);

            animation: floatingGlow 8s ease-in-out infinite;

        }


        .glow.one {

            top: -120px;

            left: -100px;

        }


        .glow.two {

            right: -100px;

            bottom: -120px;

            animation-delay: 2s;

        }


        @keyframes floatingGlow {

            0%,
            100% {

                transform: translate(0, 0) scale(1);

            }

            50% {

                transform: translate(30px, -20px) scale(1.15);

            }

        }


        /* =========================================================
           DECORATIVE CIRCLES
        ========================================================= */

        .circle {

            position: absolute;

            border: 1px solid rgba(212,175,55,0.10);

            border-radius: 50%;

            animation: rotateCircle 20s linear infinite;

        }


        .circle.one {

            width: 500px;

            height: 500px;

            top: -250px;

            right: -150px;

        }


        .circle.two {

            width: 350px;

            height: 350px;

            bottom: -180px;

            left: -120px;

            animation-direction: reverse;

            animation-duration: 15s;

        }


        @keyframes rotateCircle {

            from {

                transform: rotate(0deg);

            }

            to {

                transform: rotate(360deg);

            }

        }


        /* =========================================================
           LOADER
        ========================================================= */

        #loader {

            position: fixed;

            inset: 0;

            background: #050505;

            display: flex;

            align-items: center;

            justify-content: center;

            z-index: 99999;

            transition:
                opacity 0.25s ease,
                visibility 0.25s ease;

        }


        #loader.hide {

            opacity: 0;

            visibility: hidden;

        }


        .loader-content {

            text-align: center;

        }


        .loader-circle {

            width: 55px;

            height: 55px;

            border-radius: 50%;

            border: 4px solid rgba(212,175,55,0.18);

            border-top-color: #d4af37;

            animation: spin 0.8s linear infinite;

            margin: auto auto 18px;

        }


        .loader-content h2 {

            font-family: "Playfair Display", serif;

            color: #d4af37;

            letter-spacing: 5px;

            font-size: 20px;

        }


        @keyframes spin {

            to {

                transform: rotate(360deg);

            }

        }


        /* =========================================================
           LOGIN CARD
        ========================================================= */

        .login-container {

            position: relative;

            z-index: 5;

            width: 100%;

            max-width: 450px;

            padding: 45px 40px;

            border-radius: 24px;

            background:
                linear-gradient(
                    145deg,
                    rgba(30,30,30,0.96),
                    rgba(10,10,10,0.96)
                );

            border: 1px solid rgba(212,175,55,0.55);

            box-shadow:
                0 25px 70px rgba(0,0,0,0.65),
                0 0 50px rgba(212,175,55,0.06);

            backdrop-filter: blur(15px);

            animation: cardEnter 0.8s ease forwards;

        }


        @keyframes cardEnter {

            from {

                opacity: 0;

                transform:
                    translateY(30px)
                    scale(0.96);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);

            }

        }


        /* =========================================================
           TOP GOLD LINE
        ========================================================= */

        .login-container::before {

            content: "";

            position: absolute;

            top: 0;

            left: 50%;

            transform: translateX(-50%);

            width: 100px;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #d4af37,
                    transparent
                );

            border-radius: 10px;

        }


        /* =========================================================
           LOGO
        ========================================================= */

        .logo {

            text-align: center;

            margin-bottom: 8px;

            font-family: "Playfair Display", serif;

            font-size: 42px;

            font-weight: 700;

            color: #d4af37;

            letter-spacing: 1px;

            text-shadow:
                0 0 20px rgba(212,175,55,0.20);

        }


        .logo-icon {

            display: block;

            font-size: 30px;

            margin-bottom: 8px;

            animation: crownFloat 2.5s ease-in-out infinite;

        }


        @keyframes crownFloat {

            0%,
            100% {

                transform: translateY(0);

            }

            50% {

                transform: translateY(-5px);

            }

        }


        .subtitle {

            text-align: center;

            color: #aaa;

            font-size: 13px;

            line-height: 1.7;

            margin-bottom: 32px;

        }


        /* =========================================================
           ERROR
        ========================================================= */

        .error {

            display: flex;

            align-items: center;

            gap: 10px;

            background: rgba(220,38,38,0.12);

            border: 1px solid rgba(239,68,68,0.35);

            border-left: 4px solid #ef4444;

            color: #ff9b9b;

            padding: 13px 15px;

            border-radius: 10px;

            margin-bottom: 22px;

            font-size: 13px;

            animation: shake 0.35s ease;

        }


        @keyframes shake {

            0%,
            100% {

                transform: translateX(0);

            }

            25% {

                transform: translateX(-6px);

            }

            75% {

                transform: translateX(6px);

            }

        }


        /* =========================================================
           FORM
        ========================================================= */

        .form-group {

            margin-bottom: 21px;

        }


        label {

            display: block;

            color: #ddd;

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 9px;

        }


        label i {

            color: #d4af37;

            margin-right: 6px;

        }


        .input-wrapper {

            position: relative;

        }


        .input-wrapper > i {

            position: absolute;

            left: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #9d8228;

            font-size: 14px;

            pointer-events: none;

            transition: 0.3s;

        }


        input {

            width: 100%;

            height: 52px;

            padding: 0 45px 0 45px;

            border-radius: 11px;

            border: 1px solid #303030;

            outline: none;

            background: #151515;

            color: #fff;

            font-family: "Montserrat", sans-serif;

            font-size: 14px;

            transition:
                border-color 0.3s,
                box-shadow 0.3s,
                background 0.3s;

        }


        input::placeholder {

            color: #666;

        }


        input:focus {

            border-color: #d4af37;

            background: #191919;

            box-shadow:
                0 0 0 3px
                rgba(212,175,55,0.09),
                0 0 20px
                rgba(212,175,55,0.05);

        }


        .input-wrapper:focus-within > i {

            color: #d4af37;

        }


        /* =========================================================
           PASSWORD
        ========================================================= */

        .password-wrapper input {

            padding-right: 50px;

        }


        .toggle-password {

            position: absolute;

            right: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #777;

            cursor: pointer;

            transition: 0.3s;

            font-size: 15px;

        }


        .toggle-password:hover {

            color: #d4af37;

            transform:
                translateY(-50%)
                scale(1.1);

        }


        /* =========================================================
           LOGIN BUTTON
        ========================================================= */

        .login-btn {

            position: relative;

            width: 100%;

            height: 54px;

            border: none;

            border-radius: 11px;

            margin-top: 5px;

            overflow: hidden;

            background:
                linear-gradient(
                    100deg,
                    #9f7410,
                    #d4af37,
                    #f0d264,
                    #b8860b
                );

            background-size: 250% 100%;

            color: #090909;

            font-family: "Montserrat", sans-serif;

            font-size: 15px;

            font-weight: 700;

            cursor: pointer;

            transition:
                transform 0.3s,
                box-shadow 0.3s;

            animation: goldMove 4s ease infinite;

        }


        @keyframes goldMove {

            0% {

                background-position: 0% 50%;

            }

            50% {

                background-position: 100% 50%;

            }

            100% {

                background-position: 0% 50%;

            }

        }


        .login-btn:hover {

            transform: translateY(-3px);

            box-shadow:
                0 12px 30px
                rgba(212,175,55,0.25);

        }


        .login-btn:active {

            transform: translateY(-1px);

        }


        .login-btn i {

            margin-right: 8px;

        }


        /* =========================================================
           DIVIDER
        ========================================================= */

        .divider {

            display: flex;

            align-items: center;

            gap: 12px;

            margin: 25px 0;

            color: #555;

            font-size: 11px;

        }


        .divider::before,
        .divider::after {

            content: "";

            height: 1px;

            flex: 1;

            background: #292929;

        }


        /* =========================================================
           REGISTER
        ========================================================= */

        .register {

            text-align: center;

            color: #888;

            font-size: 13px;

        }


        .register a {

            color: #d4af37;

            font-weight: 700;

            text-decoration: none;

            margin-left: 5px;

            transition: 0.3s;

        }


        .register a:hover {

            color: #f0d264;

            text-decoration: underline;

        }


        /* =========================================================
           BACK HOME
        ========================================================= */

        .back-home {

            display: block;

            text-align: center;

            margin-top: 22px;

            color: #666;

            text-decoration: none;

            font-size: 12px;

            transition: 0.3s;

        }


        .back-home i {

            margin-right: 5px;

        }


        .back-home:hover {

            color: #d4af37;

        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 500px) {

            body {

                padding: 18px;

                overflow-y: auto;

            }


            .login-container {

                padding: 38px 24px;

                border-radius: 20px;

            }


            .logo {

                font-size: 35px;

            }


            .logo-icon {

                font-size: 25px;

            }


            .subtitle {

                font-size: 12px;

            }

        }


        @media (max-width: 350px) {

            .login-container {

                padding: 30px 18px;

            }


            .logo {

                font-size: 31px;

            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     LOADER
========================================================= -->

<div id="loader">

    <div class="loader-content">

        <div class="loader-circle"></div>

        <h2>ROYAL STAY</h2>

    </div>

</div>


<!-- =========================================================
     BACKGROUND
========================================================= -->

<div class="background">

    <div class="glow one"></div>

    <div class="glow two"></div>

    <div class="circle one"></div>

    <div class="circle two"></div>

</div>


<!-- =========================================================
     LOGIN CONTAINER
========================================================= -->

<div class="login-container">


    <!-- Logo -->

    <div class="logo">

        <span class="logo-icon">
            <i class="fa-solid fa-crown"></i>
        </span>

        Royal Stay

    </div>


    <div class="subtitle">

        Welcome back!<br>

        Please login to continue your luxury stay.

    </div>


    <!-- Error -->

    <?php if ($error !== ""): ?>

        <div class="error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <span>
                <?php echo htmlspecialchars($error); ?>
            </span>

        </div>

    <?php endif; ?>


    <!-- Login Form -->

    <form method="POST" action="">


        <!-- Email -->

        <div class="form-group">

            <label for="email">

                <i class="fa-solid fa-envelope"></i>

                Email Address

            </label>


            <div class="input-wrapper">

                <i class="fa-solid fa-envelope"></i>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    value="<?php
                        echo htmlspecialchars(
                            $_POST["email"] ?? ""
                        );
                    ?>"
                    autocomplete="email"
                    required
                >

            </div>

        </div>


        <!-- Password -->

        <div class="form-group">

            <label for="password">

                <i class="fa-solid fa-lock"></i>

                Password

            </label>


            <div class="input-wrapper password-wrapper">

                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >


                <span
                    class="toggle-password"
                    onclick="togglePassword()"
                    title="Show / Hide Password"
                >

                    <i
                        id="eyeIcon"
                        class="fa-solid fa-eye"
                    ></i>

                </span>

            </div>

        </div>


        <!-- Login Button -->

        <button
            type="submit"
            class="login-btn"
        >

            <i class="fa-solid fa-right-to-bracket"></i>

            Login to Royal Stay

        </button>


    </form>


    <!-- Divider -->

    <div class="divider">

        OR

    </div>


    <!-- Register -->

    <div class="register">

        Don't have an account?

        <a href="register.php">

            Create Account

        </a>

    </div>


    <!-- Home -->

    <a
        href="index.php"
        class="back-home"
    >

        <i class="fa-solid fa-arrow-left"></i>

        Back to Royal Stay

    </a>


</div>


<script>

/* =========================================================
   PASSWORD SHOW / HIDE
========================================================= */

function togglePassword() {

    const password =
        document.getElementById("password");

    const eyeIcon =
        document.getElementById("eyeIcon");


    if (password.type === "password") {

        password.type = "text";

        eyeIcon.classList.remove("fa-eye");

        eyeIcon.classList.add("fa-eye-slash");

    } else {

        password.type = "password";

        eyeIcon.classList.remove("fa-eye-slash");

        eyeIcon.classList.add("fa-eye");

    }

}


/* =========================================================
   LOADER
========================================================= */

window.addEventListener("load", function () {

    const loader =
        document.getElementById("loader");


    setTimeout(function () {

        loader.classList.add("hide");

    }, 500);

});

</script>


</body>

</html>