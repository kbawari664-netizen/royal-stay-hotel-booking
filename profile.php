<?php

session_start();

require_once "config/database.php";

/* =========================
   CHECK LOGIN
========================= */

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;

}

$user_id = $_SESSION['user_id'];

$message = "";
$error = "";


/* =========================
   GET USER
========================= */

$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$stmt->execute([$user_id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$user) {

    die("User not found.");

}


/* =========================
   UPDATE PROFILE
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");


    /* Validation */

    if ($name === "") {

        $error = "Name is required.";

    } elseif ($email === "") {

        $error = "Email is required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        try {

            /* Check if email already belongs to another user */

            $checkEmail = $pdo->prepare("
                SELECT id
                FROM users
                WHERE email = ?
                AND id != ?
            ");

            $checkEmail->execute([
                $email,
                $user_id
            ]);


            if ($checkEmail->fetch()) {

                $error = "This email address is already in use.";

            } else {

                /* Update profile */

                $stmt = $pdo->prepare("
                    UPDATE users
                    SET name = ?, email = ?, phone = ?
                    WHERE id = ?
                ");

                $stmt->execute([
                    $name,
                    $email,
                    $phone,
                    $user_id
                ]);


                /* Update session name */

                $_SESSION["user_name"] = $name;


                /* If login system uses session email */

                $_SESSION["user_email"] = $email;


                $message = "Profile updated successfully.";


                /* Get updated user */

                $stmt = $pdo->prepare("
                    SELECT *
                    FROM users
                    WHERE id = ?
                ");

                $stmt->execute([$user_id]);

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

            }

        } catch (PDOException $e) {

            $error = "Something went wrong while updating your profile.";

        }

    }

}


/* =========================
   USER DATA
========================= */

$name = $user['name'] ?? '';

$email = $user['email'] ?? '';

$phone = $user['phone'] ?? '';

$created_at = $user['created_at'] ?? 'Not available';

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Profile - Royal Stay</title>


    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            font-family: 'Montserrat', sans-serif;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(212,175,55,.10),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom left,
                    rgba(212,175,55,.06),
                    transparent 35%
                ),
                #080808;

            color: #fff;

            min-height: 100vh;

            overflow-x: hidden;
        }


        /* =========================
           LOADER
        ========================= */

        #loader {

            position: fixed;

            inset: 0;

            width: 100%;
            height: 100vh;

            background: #050505;

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

            width: 55px;

            height: 55px;

            border: 4px solid
                rgba(212,175,55,.20);

            border-top: 4px solid #d4af37;

            border-radius: 50%;

            animation:
                loaderSpin 1s linear infinite;

            margin:
                0 auto 18px;
        }


        .loader-content h2 {

            color: #d4af37;

            font-family:
                'Playfair Display', serif;

            letter-spacing: 4px;

            font-size: 22px;
        }


        @keyframes loaderSpin {

            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }

        }


        /* =========================
           NAVBAR
        ========================= */

        .navbar {

            position: sticky;

            top: 0;

            z-index: 1000;

            background:
                rgba(5,5,5,.96);

            backdrop-filter:
                blur(12px);

            padding:
                18px 6%;

            display: flex;

            justify-content:
                space-between;

            align-items: center;

            border-bottom:
                1px solid
                rgba(212,175,55,.20);

            box-shadow:
                0 5px 25px
                rgba(0,0,0,.5);
        }


        .logo {

            color: #d4af37;

            font-family:
                'Playfair Display', serif;

            font-size: 25px;

            font-weight: 700;

            text-decoration: none;

            letter-spacing: 1px;
        }


        .logo i {

            margin-right: 7px;
        }


        .nav-links {

            display: flex;

            align-items: center;

            gap: 22px;

            flex-wrap: wrap;
        }


        .nav-links a {

            color: #ddd;

            text-decoration: none;

            font-size: 12px;

            transition: .3s;

            position: relative;
        }


        .nav-links a::after {

            content: "";

            position: absolute;

            left: 0;

            bottom: -7px;

            width: 0;

            height: 2px;

            background: #d4af37;

            transition: .3s;
        }


        .nav-links a:hover {

            color: #d4af37;
        }


        .nav-links a:hover::after {

            width: 100%;
        }


        .nav-links .active {

            color: #d4af37;
        }


        .nav-links .active::after {

            width: 100%;
        }


        /* =========================
           HERO
        ========================= */

        .profile-hero {

            position: relative;

            min-height: 280px;

            display: flex;

            align-items: center;

            justify-content: center;

            text-align: center;

            overflow: hidden;

            background:

                linear-gradient(
                    rgba(0,0,0,.80),
                    rgba(0,0,0,.92)
                ),

                url("assets/images/hotel.jpg");

            background-size: cover;

            background-position: center;
        }


        .profile-hero::before {

            content: "";

            position: absolute;

            width: 350px;

            height: 350px;

            background:
                rgba(212,175,55,.12);

            border-radius: 50%;

            filter: blur(80px);

            animation:
                heroGlow 4s infinite alternate;
        }


        @keyframes heroGlow {

            from {

                transform:
                    scale(.8);

                opacity: .3;
            }

            to {

                transform:
                    scale(1.2);

                opacity: .8;
            }

        }


        .hero-content {

            position: relative;

            z-index: 2;

            animation:
                heroUp .8s ease;
        }


        @keyframes heroUp {

            from {

                opacity: 0;

                transform:
                    translateY(30px);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .hero-icon {

            width: 75px;

            height: 75px;

            margin:
                0 auto 15px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(212,175,55,.12);

            border:
                1px solid
                rgba(212,175,55,.5);

            color: #d4af37;

            font-size: 30px;

            box-shadow:
                0 0 30px
                rgba(212,175,55,.12);
        }


        .hero-content h1 {

            font-family:
                'Playfair Display', serif;

            color: #d4af37;

            font-size:
                clamp(38px, 6vw, 58px);

            margin-bottom: 10px;
        }


        .hero-content p {

            color: #ccc;

            font-size: 14px;
        }


        .gold-line {

            width: 65px;

            height: 3px;

            background: #d4af37;

            margin: 15px auto;
        }


        /* =========================
           CONTAINER
        ========================= */

        .container {

            width: 90%;

            max-width: 650px;

            margin:
                60px auto;
        }


        /* =========================
           PROFILE CARD
        ========================= */

        .profile-card {

            background:
                linear-gradient(
                    145deg,
                    #191919,
                    #0e0e0e
                );

            border:
                1px solid
                rgba(212,175,55,.20);

            border-radius: 20px;

            padding: 35px;

            box-shadow:
                0 20px 50px
                rgba(0,0,0,.55);

            animation:
                cardShow .8s ease;
        }


        @keyframes cardShow {

            from {

                opacity: 0;

                transform:
                    translateY(35px);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        .profile-title {

            text-align: center;

            margin-bottom: 30px;
        }


        .profile-title h2 {

            font-family:
                'Playfair Display', serif;

            color: #d4af37;

            font-size: 30px;

            margin-bottom: 8px;
        }


        .profile-title p {

            color: #888;

            font-size: 13px;
        }


        /* =========================
           ALERTS
        ========================= */

        .success {

            background:
                rgba(34,197,94,.10);

            border:
                1px solid
                rgba(34,197,94,.35);

            color: #86efac;

            padding: 13px;

            border-radius: 10px;

            text-align: center;

            margin-bottom: 20px;

            font-size: 13px;
        }


        .success i {

            margin-right: 7px;
        }


        .error {

            background:
                rgba(239,68,68,.10);

            border:
                1px solid
                rgba(239,68,68,.35);

            color: #fca5a5;

            padding: 13px;

            border-radius: 10px;

            text-align: center;

            margin-bottom: 20px;

            font-size: 13px;
        }


        .error i {

            margin-right: 7px;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {

            margin-bottom: 20px;
        }


        label {

            display: block;

            color: #ddd;

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 8px;
        }


        label i {

            color: #d4af37;

            margin-right: 7px;

            width: 18px;
        }


        .input-box {

            position: relative;
        }


        .input-box i {

            position: absolute;

            left: 15px;

            top: 50%;

            transform:
                translateY(-50%);

            color: #d4af37;

            pointer-events: none;
        }


        input {

            width: 100%;

            padding:
                14px 15px 14px 45px;

            border:
                1px solid
                rgba(255,255,255,.12);

            border-radius: 10px;

            background: #111;

            color: #fff;

            font-family:
                'Montserrat', sans-serif;

            font-size: 14px;

            outline: none;

            transition: .3s;
        }


        input:focus {

            border-color: #d4af37;

            box-shadow:
                0 0 15px
                rgba(212,175,55,.10);
        }


        /* Account Created stays disabled */

        input.created-input {

            background: #0b0b0b;

            color: #777;

            cursor: not-allowed;

            border-color:
                rgba(255,255,255,.06);
        }


        /* =========================
           BUTTON
        ========================= */

        .btn {

            width: 100%;

            margin-top: 8px;

            padding: 14px;

            border: none;

            border-radius: 10px;

            background: #d4af37;

            color: #111;

            font-family:
                'Montserrat', sans-serif;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition: .3s;

            position: relative;

            overflow: hidden;
        }


        .btn::before {

            content: "";

            position: absolute;

            top: 0;

            left: -100%;

            width: 100%;

            height: 100%;

            background:
                rgba(255,255,255,.25);

            transform:
                skewX(-25deg);

            transition: .5s;
        }


        .btn:hover::before {

            left: 100%;
        }


        .btn:hover {

            background: #f0ca4f;

            transform:
                translateY(-2px);

            box-shadow:
                0 8px 25px
                rgba(212,175,55,.20);
        }


        .btn i {

            margin-right: 8px;
        }


        /* =========================
           BACK LINK
        ========================= */

        .back {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            margin-top: 22px;

            color: #d4af37;

            text-decoration: none;

            font-size: 13px;

            transition: .3s;
        }


        .back:hover {

            color: #f0ca4f;

            transform:
                translateX(-3px);
        }


        /* =========================
           FOOTER
        ========================= */

        footer {

            background: #050505;

            border-top:
                1px solid
                rgba(212,175,55,.20);

            text-align: center;

            padding: 35px 20px;

            margin-top: 80px;
        }


        footer h3 {

            color: #d4af37;

            font-family:
                'Playfair Display', serif;

            margin-bottom: 10px;
        }


        footer p {

            color: #777;

            font-size: 13px;
        }


        /* =========================
           TOP BUTTON
        ========================= */

        #topBtn {

            position: fixed;

            right: 25px;

            bottom: 25px;

            width: 45px;

            height: 45px;

            border: none;

            border-radius: 50%;

            background: #d4af37;

            color: #111;

            cursor: pointer;

            display: none;

            align-items: center;

            justify-content: center;

            z-index: 999;

            transition: .3s;
        }


        #topBtn:hover {

            background: #f0ca4f;

            transform:
                translateY(-5px);
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 850px) {

            .navbar {

                padding:
                    16px 20px;

            }


            .nav-links {

                gap: 12px;

            }


            .nav-links a {

                font-size: 11px;

            }

        }


        @media (max-width: 650px) {

            .navbar {

                flex-direction:
                    column;

                gap: 15px;

            }


            .nav-links {

                justify-content:
                    center;

            }


            .profile-card {

                padding:
                    25px 20px;

            }


            .profile-hero {

                min-height: 300px;

            }


            .hero-content h1 {

                font-size: 40px;

            }

        }

    </style>

</head>


<body>


<!-- =========================
     LOADER
========================= -->

<div id="loader">

    <div class="loader-content">

        <div class="loader-circle"></div>

        <h2>ROYAL STAY</h2>

    </div>

</div>
<?php

$page_title = "Profile";

require_once "header.php";

?>



<!-- =========================
     HERO
========================= -->

<section class="profile-hero">


    <div class="hero-content">


        <div class="hero-icon">

            <i class="fa-solid fa-user"></i>

        </div>


        <h1>My Profile</h1>


        <div class="gold-line"></div>


        <p>
            Manage your Royal Stay account information
        </p>


    </div>

</section>


<!-- =========================
     PROFILE
========================= -->

<div class="container">


    <div class="profile-card">


        <div class="profile-title">

            <h2>Account Information</h2>

            <p>
                Update your personal information below.
            </p>

        </div>


        <!-- SUCCESS MESSAGE -->

        <?php if ($message !== ""): ?>

            <div class="success">

                <i class="fa-solid fa-circle-check"></i>

                <?= htmlspecialchars($message) ?>

            </div>

        <?php endif; ?>


        <!-- ERROR MESSAGE -->

        <?php if ($error !== ""): ?>

            <div class="error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <!-- FORM -->

        <form method="POST">


            <!-- NAME -->

            <div class="form-group">

                <label for="name">

                    <i class="fa-solid fa-user"></i>

                    Full Name

                </label>


                <div class="input-box">

                    <i class="fa-solid fa-user"></i>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= htmlspecialchars($name) ?>"
                        placeholder="Enter your full name"
                        required
                    >

                </div>

            </div>


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">

                    <i class="fa-solid fa-envelope"></i>

                    Email Address

                </label>


                <div class="input-box">

                    <i class="fa-solid fa-envelope"></i>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($email) ?>"
                        placeholder="Enter your email address"
                        required
                    >

                </div>

            </div>


            <!-- PHONE -->

            <div class="form-group">

                <label for="phone">

                    <i class="fa-solid fa-phone"></i>

                    Phone Number

                </label>


                <div class="input-box">

                    <i class="fa-solid fa-phone"></i>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="<?= htmlspecialchars($phone) ?>"
                        placeholder="Enter your phone number"
                    >

                </div>

            </div>


            <!-- ACCOUNT CREATED -->

            <div class="form-group">

                <label for="created_at">

                    <i class="fa-solid fa-calendar"></i>

                    Account Created

                </label>


                <div class="input-box">

                    <i class="fa-solid fa-calendar"></i>

                    <input
                        type="text"
                        id="created_at"
                        class="created-input"
                        value="<?= htmlspecialchars($created_at) ?>"
                        disabled
                    >

                </div>

            </div>


            <!-- UPDATE BUTTON -->

            <button
                type="submit"
                class="btn"
            >

                <i class="fa-solid fa-floppy-disk"></i>

                Update Profile

            </button>


        </form>


        <!-- BACK TO BOOKINGS -->

        <a
            href="my-bookings.php"
            class="back"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Back to My Bookings

        </a>


    </div>

</div>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <h3>ROYAL STAY</h3>

    <p>
        Luxury stays. Beautiful memories.
    </p>

    <p style="margin-top:10px;">

        &copy; <?= date("Y") ?>

        Royal Stay.

        All Rights Reserved.

    </p>

</footer>


<!-- =========================
     BACK TO TOP
========================= -->

<button id="topBtn">

    <i class="fa-solid fa-arrow-up"></i>

</button>


<!-- =========================
     JAVASCRIPT
========================= -->

<script>


/* =========================
   LOADER
========================= */

window.addEventListener("load", function () {

    const loader =
        document.getElementById("loader");

    setTimeout(function () {

        loader.classList.add("hide");

    }, 500);

});


/* =========================
   BACK TO TOP
========================= */

const topBtn =
    document.getElementById("topBtn");


window.addEventListener("scroll", function () {

    if (window.scrollY > 300) {

        topBtn.style.display = "flex";

    } else {

        topBtn.style.display = "none";

    }

});


topBtn.addEventListener("click", function () {

    window.scrollTo({

        top: 0,

        behavior: "smooth"

    });

});

</script>


</body>

</html>