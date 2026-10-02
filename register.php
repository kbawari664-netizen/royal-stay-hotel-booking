<?php

require_once "config/database.php";

$message = "";
$messageType = "";

$name = "";
$email = "";
$phone = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || $email === "" || $phone === "" || $password === "") {

        $message = "Please fill all fields.";
        $messageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "error";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
        $messageType = "error";

    } else {

        $check = $pdo->prepare(
            "SELECT id FROM users WHERE email = ? LIMIT 1"
        );

        $check->execute([$email]);

        if ($check->fetch()) {

            $message = "Email already exists.";
            $messageType = "error";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            try {

                $stmt = $pdo->prepare("
                    INSERT INTO users
                    (name, email, password, phone)
                    VALUES (?, ?, ?, ?)
                ");

                $stmt->execute([
                    $name,
                    $email,
                    $hashedPassword,
                    $phone
                ]);

                $message = "Registration successful! You can now login.";
                $messageType = "success";

                $name = "";
                $email = "";
                $phone = "";

            } catch (PDOException $e) {

                $message = "Something went wrong. Please try again.";
                $messageType = "error";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - Royal Stay</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #080808;
            color: #fff;
            overflow-x: hidden;
        }


        /* =========================
           LOADER
        ========================== */

        #loader {
            position: fixed;
            inset: 0;
            background: #080808;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;

            opacity: 1;
            visibility: visible;

            transition:
                opacity .5s ease,
                visibility .5s ease;
        }

        #loader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader-content {
            text-align: center;
        }

        .loader-circle {
            width: 48px;
            height: 48px;

            border: 3px solid rgba(212, 175, 55, .20);
            border-top: 3px solid #d4af37;

            border-radius: 50%;

            animation: spin 1s linear infinite;

            margin: 0 auto 14px;
        }

        .loader-content h2 {
            color: #d4af37;

            font-family: 'Playfair Display', serif;

            font-size: 18px;

            letter-spacing: 4px;
        }

        @keyframes spin {

            to {
                transform: rotate(360deg);
            }

        }


        /* =========================
           BACKGROUND
        ========================== */

        .page {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 25px 15px;

            position: relative;

            overflow: hidden;
        }

        .background {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    rgba(0,0,0,.78),
                    rgba(0,0,0,.88)
                ),
                url("images/hotel.jpg");

            background-size: cover;
            background-position: center;

            animation: backgroundZoom 15s ease-in-out infinite alternate;

            z-index: -3;
        }

        @keyframes backgroundZoom {

            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.08);
            }

        }


        /* =========================
           GOLD GLOW
        ========================== */

        .glow {
            position: absolute;

            width: 250px;
            height: 250px;

            border-radius: 50%;

            background: rgba(212,175,55,.08);

            filter: blur(70px);

            z-index: -2;

            animation: floatGlow 6s ease-in-out infinite alternate;
        }

        .glow-one {
            top: -80px;
            left: -80px;
        }

        .glow-two {
            right: -80px;
            bottom: -80px;

            animation-delay: 2s;
        }

        @keyframes floatGlow {

            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(25px, -20px);
            }

        }


        /* =========================
           REGISTER CONTAINER
        ========================== */

        .register-container {

            width: 100%;
            max-width: 400px;

            padding: 30px 28px;

            background:
                linear-gradient(
                    145deg,
                    rgba(25,25,25,.96),
                    rgba(8,8,8,.97)
                );

            border: 1px solid rgba(212,175,55,.35);

            border-radius: 20px;

            box-shadow:
                0 25px 60px rgba(0,0,0,.65),
                0 0 35px rgba(212,175,55,.08);

            backdrop-filter: blur(12px);

            position: relative;

            animation: cardAppear .8s ease forwards;
        }

        @keyframes cardAppear {

            from {
                opacity: 0;
                transform: translateY(35px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

        }


        /* =========================
           TOP GOLD LINE
        ========================== */

        .register-container::before {

            content: "";

            position: absolute;

            top: 0;
            left: 15%;

            width: 70%;
            height: 2px;

            background: linear-gradient(
                90deg,
                transparent,
                #d4af37,
                transparent
            );
        }


        /* =========================
           LOGO
        ========================== */

        .logo-area {
            text-align: center;

            margin-bottom: 20px;
        }

        .logo-icon {

            color: #d4af37;

            font-size: 22px;

            margin-bottom: 5px;

            animation: crownFloat 2.5s ease-in-out infinite;
        }

        @keyframes crownFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }

        }

        .logo {

            font-family: 'Playfair Display', serif;

            font-size: 32px;

            font-weight: 700;

            letter-spacing: 2px;

            color: #d4af37;
        }

        .subtitle {

            margin-top: 4px;

            color: #aaa;

            font-size: 11px;

            letter-spacing: 1px;
        }


        /* =========================
           MESSAGE
        ========================== */

        .message {

            padding: 10px 12px;

            border-radius: 8px;

            margin-bottom: 15px;

            font-size: 11px;

            line-height: 1.5;

            text-align: center;

            animation: messageShow .4s ease;
        }

        @keyframes messageShow {

            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        .message.success {

            color: #d4af37;

            background: rgba(212,175,55,.08);

            border: 1px solid rgba(212,175,55,.3);
        }

        .message.error {

            color: #ff8c8c;

            background: rgba(255,60,60,.08);

            border: 1px solid rgba(255,60,60,.25);
        }


        /* =========================
           FORM
        ========================== */

        .form-group {

            margin-bottom: 13px;

            position: relative;
        }

        .form-group label {

            display: block;

            color: #ddd;

            font-size: 11px;

            font-weight: 500;

            margin-bottom: 6px;
        }

        .input-box {
            position: relative;
        }

        input {

            width: 100%;

            height: 40px;

            padding:
                0
                38px
                0
                38px;

            background: rgba(255,255,255,.04);

            border: 1px solid rgba(255,255,255,.12);

            border-radius: 8px;

            outline: none;

            color: #fff;

            font-family: 'Montserrat', sans-serif;

            font-size: 12px;

            transition: .3s;
        }

        input::placeholder {
            color: #777;
        }

        input:focus {

            border-color: #d4af37;

            background: rgba(212,175,55,.04);

            box-shadow:
                0 0 0 3px rgba(212,175,55,.07);
        }

        .input-icon {

            position: absolute;

            left: 13px;

            top: 50%;

            transform: translateY(-50%);

            color: #d4af37;

            font-size: 11px;

            pointer-events: none;
        }


        /* =========================
           PASSWORD SHOW
        ========================== */

        .show-password {

            position: absolute;

            right: 13px;

            top: 50%;

            transform: translateY(-50%);

            color: #888;

            font-size: 12px;

            cursor: pointer;

            transition: .3s;
        }

        .show-password:hover {
            color: #d4af37;
        }


        /* =========================
           REGISTER BUTTON
        ========================== */

        .register-btn {

            width: 100%;

            height: 43px;

            margin-top: 4px;

            border: none;

            border-radius: 8px;

            background: linear-gradient(
                135deg,
                #d4af37,
                #f1d477
            );

            color: #111;

            font-family: 'Montserrat', sans-serif;

            font-size: 12px;

            font-weight: 700;

            letter-spacing: .8px;

            cursor: pointer;

            position: relative;

            overflow: hidden;

            transition: .3s;
        }

        .register-btn::before {

            content: "";

            position: absolute;

            top: 0;
            left: -100%;

            width: 100%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.45),
                    transparent
                );

            transition: .5s;
        }

        .register-btn:hover::before {
            left: 100%;
        }

        .register-btn:hover {

            transform: translateY(-2px);

            box-shadow:
                0 10px 25px rgba(212,175,55,.25);
        }

        .register-btn:active {
            transform: translateY(0);
        }


        /* =========================
           LOGIN LINK
        ========================== */

        .login-link {

            text-align: center;

            margin-top: 16px;

            color: #999;

            font-size: 11px;
        }

        .login-link a {

            color: #d4af37;

            text-decoration: none;

            font-weight: 600;

            transition: .3s;
        }

        .login-link a:hover {
            color: #fff;
        }


        /* =========================
           HOME LINK
        ========================== */

        .home-link {

            display: block;

            text-align: center;

            margin-top: 12px;

            color: #777;

            text-decoration: none;

            font-size: 10px;

            transition: .3s;
        }

        .home-link i {
            margin-right: 4px;
        }

        .home-link:hover {
            color: #d4af37;
        }


        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 480px) {

            .page {
                padding: 20px 12px;
            }

            .register-container {

                max-width: 370px;

                padding: 26px 22px;

                border-radius: 17px;
            }

            .logo {
                font-size: 28px;
            }

            .logo-icon {
                font-size: 20px;
            }

            .subtitle {
                font-size: 10px;
            }

            input {
                height: 39px;
                font-size: 11px;
            }

            .register-btn {
                height: 42px;
            }
        }

    </style>

</head>

<body>


    <!-- =========================
         LOADER
    ========================== -->

    <div id="loader">

        <div class="loader-content">

            <div class="loader-circle"></div>

            <h2>ROYAL STAY</h2>

        </div>

    </div>


    <!-- =========================
         PAGE
    ========================== -->

    <div class="page">

        <div class="background"></div>

        <div class="glow glow-one"></div>

        <div class="glow glow-two"></div>


        <!-- REGISTER CARD -->

        <div class="register-container">


            <!-- LOGO -->

            <div class="logo-area">

                <div class="logo-icon">
                    <i class="fa-solid fa-crown"></i>
                </div>

                <div class="logo">
                    ROYAL STAY
                </div>

                <div class="subtitle">
                    CREATE YOUR LUXURY ACCOUNT
                </div>

            </div>


            <!-- MESSAGE -->

            <?php if ($message !== ""): ?>

                <div class="message <?php echo $messageType; ?>">

                    <?php if ($messageType === "success"): ?>

                        <i class="fa-solid fa-circle-check"></i>

                    <?php else: ?>

                        <i class="fa-solid fa-circle-exclamation"></i>

                    <?php endif; ?>

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>


            <!-- FORM -->

            <form method="POST"
                  action="">


                <!-- NAME -->

                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-user input-icon"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter your name"
                            value="<?php echo htmlspecialchars($name); ?>"
                            autocomplete="name"
                            required
                        >

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-envelope input-icon"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            value="<?php echo htmlspecialchars($email); ?>"
                            autocomplete="email"
                            required
                        >

                    </div>

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-phone input-icon"></i>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Enter your phone"
                            value="<?php echo htmlspecialchars($phone); ?>"
                            autocomplete="tel"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-lock input-icon"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Create password"
                            minlength="6"
                            autocomplete="new-password"
                            required
                        >

                        <span
                            class="show-password"
                            onclick="togglePassword()"
                            title="Show password"
                        >
                            <i
                                class="fa-solid fa-eye"
                                id="eyeIcon"
                            ></i>
                        </span>

                    </div>

                </div>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="register-btn"
                >

                    <i class="fa-solid fa-user-plus"></i>

                    CREATE ACCOUNT

                </button>

            </form>


            <!-- LOGIN -->

            <div class="login-link">

                Already have an account?

                <a href="login.php">
                    Login
                </a>

            </div>


            <!-- HOME -->

            <a
                href="index.php"
                class="home-link"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Back to Royal Stay

            </a>

        </div>

    </div>


    <!-- =========================
         JAVASCRIPT
    ========================== -->

    <script>


        /* =========================
           LOADER - 0.5 SECOND
        ========================== */

        window.addEventListener("load", function () {

            const loader =
                document.getElementById("loader");

            setTimeout(function () {

                loader.classList.add("hide");

            }, 500);

        });


        /* =========================
           SHOW / HIDE PASSWORD
        ========================== */

        function togglePassword() {

            const password =
                document.getElementById("password");

            const eyeIcon =
                document.getElementById("eyeIcon");


            if (password.type === "password") {

                password.type = "text";

                eyeIcon.classList.remove(
                    "fa-eye"
                );

                eyeIcon.classList.add(
                    "fa-eye-slash"
                );

            } else {

                password.type = "password";

                eyeIcon.classList.remove(
                    "fa-eye-slash"
                );

                eyeIcon.classList.add(
                    "fa-eye"
                );

            }

        }

    </script>

</body>

</html>