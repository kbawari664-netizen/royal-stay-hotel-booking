
<?php

session_start();

require_once "config/database.php";

$message = "";
$error = "";

/*
|--------------------------------------------------------------------------
| Form Submit
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $user_message = trim($_POST["message"] ?? "");

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if (
        $name === "" ||
        $email === "" ||
        $subject === "" ||
        $user_message === ""
    ) {

        $error = "Please fill all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        try {

            /*
            |--------------------------------------------------------------------------
            | Save Message
            |--------------------------------------------------------------------------
            */

            $stmt = $pdo->prepare("
                INSERT INTO contact_messages
                (name, email, phone, subject, message, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");

            $stmt->execute([
                $name,
                $email,
                $phone,
                $subject,
                $user_message
            ]);

            $message =
                "Thank you! Your message has been sent successfully.";

            /*
            |--------------------------------------------------------------------------
            | Clear Form
            |--------------------------------------------------------------------------
            */

            $name = "";
            $email = "";
            $phone = "";
            $subject = "";
            $user_message = "";

        } catch (PDOException $e) {

            $error =
                "Something went wrong. Please try again.";
        }
    }
}

$page_title = "Contact - Royal Stay";

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo htmlspecialchars($page_title); ?>
    </title>


    <!-- Google Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


<style>

/* =====================================================
   RESET
===================================================== */

* {

    margin: 0;

    padding: 0;

    box-sizing: border-box;
}

html {

    scroll-behavior: smooth;
}

body {

    font-family:
        "Montserrat",
        Arial,
        sans-serif;

    background: #f7f5f0;

    color: #222;

    overflow-x: hidden;
}

a {

    text-decoration: none;
}


/* =====================================================
   LOADER
===================================================== */

#loader {

    position: fixed;

    inset: 0;

    background: #111;

    display: flex;

    align-items: center;

    justify-content: center;

    z-index: 99999;

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

    color: #d4af37;
}

.loader-circle {

    width: 65px;

    height: 65px;

    border:
        4px solid
        rgba(212,175,55,.2);

    border-top-color:
        #d4af37;

    border-radius: 50%;

    animation:
        spin 1s linear infinite;

    margin:
        0 auto 18px;
}

.loader-content h2 {

    font-family:
        "Playfair Display",
        serif;

    letter-spacing: 4px;

    animation:
        pulse 1.2s ease-in-out infinite;
}


/* =====================================================
   NAVBAR
===================================================== */

.navbar {

    position: sticky;

    top: 0;

    z-index: 5000;

    background:
        rgba(17,17,17,.96);

    backdrop-filter:
        blur(12px);

    padding:
        17px 7%;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 5px 25px
        rgba(0,0,0,.20);

    animation:
        navDown .8s ease;
}

.logo {

    color: #d4af37;

    font-family:
        "Playfair Display",
        serif;

    font-size: 29px;

    font-weight: 700;

    transition: .3s ease;
}

.logo i {

    margin-right: 7px;
}

.logo:hover {

    transform:
        scale(1.06);

    text-shadow:
        0 0 18px
        rgba(212,175,55,.6);
}

.nav-links {

    display: flex;

    align-items: center;

    gap: 24px;

    list-style: none;
}

.nav-links a {

    color: white;

    font-size: 14px;

    font-weight: 600;

    position: relative;

    transition: .3s ease;
}

.nav-links a::after {

    content: "";

    position: absolute;

    left: 50%;

    bottom: -7px;

    width: 0;

    height: 2px;

    background: #d4af37;

    transform:
        translateX(-50%);

    transition: .3s ease;
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

.login-btn {

    background: #d4af37;

    color: #111 !important;

    padding:
        9px 17px;

    border-radius: 25px;
}

.login-btn::after {

    display: none;
}

.login-btn:hover {

    background: white;

    transform:
        translateY(-2px);
}


/* =====================================================
   HERO
===================================================== */

.hero {

    min-height: 410px;

    position: relative;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding:
        70px 20px;

    background:

        linear-gradient(
            rgba(0,0,0,.72),
            rgba(0,0,0,.77)
        ),

        url("assets/images/hotel.jpg")
        center/cover no-repeat;

    overflow: hidden;
}

.hero::before {

    content: "";

    position: absolute;

    width: 350px;

    height: 350px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.09);

    top: -160px;

    left: -100px;

    animation:
        floating 6s ease-in-out infinite;
}

.hero::after {

    content: "";

    position: absolute;

    width: 300px;

    height: 300px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    right: -100px;

    bottom: -150px;

    animation:
        floating 5s ease-in-out infinite reverse;
}

.hero-content {

    position: relative;

    z-index: 5;
}

.hero small {

    color: #d4af37;

    letter-spacing: 5px;

    font-weight: 700;

    text-transform: uppercase;

    animation:
        fadeUp .8s ease both;
}

.hero h1 {

    color: white;

    font-family:
        "Playfair Display",
        serif;

    font-size:
        clamp(42px, 6vw, 65px);

    margin:
        12px 0 15px;

    animation:
        fadeUp .9s ease .2s both;
}

.hero h1 span {

    color: #d4af37;
}

.hero p {

    color: #ddd;

    font-size: 16px;

    line-height: 1.7;

    animation:
        fadeUp 1s ease .4s both;
}


/* =====================================================
   MAIN CONTAINER
===================================================== */

.container {

    width: 90%;

    max-width: 1200px;

    margin:
        70px auto 90px;
}

.contact-grid {

    display: grid;

    grid-template-columns:
        .85fr 1.4fr;

    gap: 30px;

    align-items: stretch;
}


/* =====================================================
   CONTACT INFO
===================================================== */

.contact-info {

    background: white;

    padding: 35px;

    border-radius: 18px;

    box-shadow:
        0 10px 35px
        rgba(0,0,0,.08);

    animation:
        fadeLeft .9s ease both;

    position: relative;

    overflow: hidden;
}

.contact-info::before {

    content: "";

    position: absolute;

    width: 180px;

    height: 180px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    top: -90px;

    right: -80px;
}

.contact-label {

    color: #b28d1c;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 4px;

    text-transform: uppercase;
}

.contact-info h2 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 34px;

    color: #111;

    margin:
        10px 0 15px;

    position: relative;
}

.gold-line {

    width: 65px;

    height: 4px;

    background: #d4af37;

    border-radius: 5px;

    margin-bottom: 23px;
}

.contact-info > p {

    color: #666;

    line-height: 1.8;

    font-size: 13px;

    margin-bottom: 25px;
}


/* INFO BOX */

.info-box {

    background:
        linear-gradient(
            135deg,
            #fffdf6,
            #faf7ed
        );

    padding: 17px;

    border-radius: 10px;

    margin-bottom: 13px;

    border:
        1px solid
        rgba(212,175,55,.15);

    transition:
        .35s ease;

    position: relative;

    z-index: 2;
}

.info-box:hover {

    transform:
        translateX(7px);

    border-color:
        #d4af37;

    box-shadow:
        0 8px 20px
        rgba(0,0,0,.06);
}

.info-icon {

    width: 42px;

    height: 42px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.15);

    color: #b28d1c;

    display: flex;

    align-items: center;

    justify-content: center;

    float: left;

    margin-right: 12px;

    transition: .3s;
}

.info-box:hover .info-icon {

    background: #d4af37;

    color: #111;

    transform:
        rotate(10deg);
}

.info-box strong {

    display: block;

    color: #b28d1c;

    font-size: 12px;

    margin-bottom: 4px;

    padding-top: 3px;
}

.info-box span {

    color: #555;

    font-size: 12px;

    line-height: 1.5;
}


/* =====================================================
   CONTACT FORM
===================================================== */

.contact-form {

    background: white;

    padding: 38px;

    border-radius: 18px;

    box-shadow:
        0 10px 35px
        rgba(0,0,0,.08);

    animation:
        fadeRight .9s ease .15s both;
}

.contact-form h2 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 34px;

    color: #111;

    margin-bottom: 8px;
}

.form-subtitle {

    color: #777;

    font-size: 13px;

    margin-bottom: 20px;
}


/* =====================================================
   ALERTS
===================================================== */

.success,
.error {

    padding: 14px 16px;

    border-radius: 9px;

    margin-bottom: 20px;

    display: flex;

    align-items: center;

    gap: 10px;

    font-size: 13px;

    animation:
        fadeUp .5s ease;
}

.success {

    background: #dcfce7;

    color: #166534;

    border-left:
        4px solid
        #22c55e;
}

.error {

    background: #fee2e2;

    color: #991b1b;

    border-left:
        4px solid
        #ef4444;
}


/* =====================================================
   FORM
===================================================== */

.form-row {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 17px;
}

.form-group {

    margin-bottom: 3px;
}

label {

    display: block;

    margin-top: 15px;

    margin-bottom: 8px;

    color: #333;

    font-size: 12px;

    font-weight: 700;
}

.required {

    color: #d4af37;
}

.input-box {

    position: relative;
}

.input-box i {

    position: absolute;

    left: 14px;

    top: 50%;

    transform:
        translateY(-50%);

    color: #b28d1c;

    font-size: 14px;

    transition: .3s;
}

textarea + i {

    top: 20px;

    transform: none;
}

input,
textarea {

    width: 100%;

    border:
        1px solid #ddd;

    border-radius: 9px;

    background: #fafafa;

    padding:
        13px 14px 13px 42px;

    font-family:
        "Montserrat",
        sans-serif;

    font-size: 13px;

    outline: none;

    transition:
        .3s ease;
}

textarea {

    min-height: 155px;

    resize: vertical;

    line-height: 1.6;
}

input:hover,
textarea:hover {

    border-color:
        #d4af37;
}

input:focus,
textarea:focus {

    background: white;

    border-color:
        #d4af37;

    box-shadow:
        0 0 0 3px
        rgba(212,175,55,.12);
}

.input-box:focus-within i {

    color: #d4af37;

    transform:
        translateY(-50%)
        scale(1.1);
}

textarea.input-box {

    padding-left: 42px;
}


/* =====================================================
   BUTTON
===================================================== */

.btn {

    width: 100%;

    margin-top: 23px;

    padding: 14px;

    border: none;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #d4af37,
            #b28d1c
        );

    color: #111;

    font-family:
        "Montserrat",
        sans-serif;

    font-size: 14px;

    font-weight: 800;

    cursor: pointer;

    position: relative;

    overflow: hidden;

    transition:
        .35s ease;
}

.btn::before {

    content: "";

    position: absolute;

    width: 0;

    height: 100%;

    top: 0;

    left: -20%;

    background:
        rgba(255,255,255,.25);

    transform:
        skewX(-20deg);

    transition:
        .5s ease;
}

.btn:hover::before {

    width: 140%;
}

.btn:hover {

    transform:
        translateY(-3px);

    box-shadow:
        0 12px 25px
        rgba(212,175,55,.30);
}

.btn i {

    margin-right: 7px;
}


/* =====================================================
   FOOTER
===================================================== */

footer {

    background: #111;

    color: #999;

    padding:
        50px 7% 22px;
}

.footer-grid {

    max-width: 1200px;

    margin: auto;

    display: grid;

    grid-template-columns:
        2fr 1fr 1fr 1fr;

    gap: 40px;

    margin-bottom: 35px;
}

.footer-logo {

    color: #d4af37;

    font-family:
        "Playfair Display",
        serif;

    font-size: 27px;

    margin-bottom: 15px;
}

.footer-col p {

    font-size: 12px;

    line-height: 1.8;

    margin-bottom: 7px;
}

.footer-col h3 {

    color: white;

    font-size: 15px;

    margin-bottom: 17px;
}

.footer-col ul {

    list-style: none;
}

.footer-col li {

    margin-bottom: 10px;
}

.footer-col a {

    color: #999;

    font-size: 12px;

    transition: .3s;
}

.footer-col a:hover {

    color: #d4af37;

    padding-left: 5px;
}

.social {

    display: flex;

    gap: 9px;

    margin-top: 18px;
}

.social a {

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #222;

    color: #aaa;

    border-radius: 50%;

    transition: .3s;
}

.social a:hover {

    background: #d4af37;

    color: #111;

    transform:
        translateY(-4px);
}

.footer-bottom {

    max-width: 1200px;

    margin: auto;

    border-top:
        1px solid #292929;

    padding-top: 20px;

    text-align: center;

    font-size: 11px;
}

.footer-bottom span {

    color: #d4af37;
}


/* =====================================================
   BACK TO TOP
===================================================== */

#topBtn {

    position: fixed;

    right: 25px;

    bottom: 25px;

    width: 45px;

    height: 45px;

    border: none;

    border-radius: 50%;

    background: #111;

    color: #d4af37;

    display: none;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    z-index: 5000;

    transition: .3s;
}

#topBtn:hover {

    background: #d4af37;

    color: #111;

    transform:
        translateY(-5px);
}


/* =====================================================
   ANIMATIONS
===================================================== */

@keyframes spin {

    to {
        transform:
            rotate(360deg);
    }

}

@keyframes pulse {

    0%, 100% {
        opacity: .7;
    }

    50% {
        opacity: 1;
    }

}

@keyframes navDown {

    from {
        opacity: 0;

        transform:
            translateY(-40px);
    }

    to {
        opacity: 1;

        transform:
            translateY(0);
    }

}

@keyframes fadeUp {

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

@keyframes fadeLeft {

    from {
        opacity: 0;

        transform:
            translateX(-45px);
    }

    to {
        opacity: 1;

        transform:
            translateX(0);
    }

}

@keyframes fadeRight {

    from {
        opacity: 0;

        transform:
            translateX(45px);
    }

    to {
        opacity: 1;

        transform:
            translateX(0);
    }

}

@keyframes floating {

    0%, 100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(25px);
    }

}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 1000px) {

    .footer-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }

}

@media (max-width: 800px) {

    .contact-grid {

        grid-template-columns:
            1fr;
    }

    .form-row {

        grid-template-columns:
            1fr;
    }

}

@media (max-width: 700px) {

    .navbar {

        flex-direction: column;

        gap: 15px;

        padding:
            16px 5%;
    }

    .nav-links {

        flex-wrap: wrap;

        justify-content: center;

        gap: 13px;
    }

    .hero {

        min-height: 370px;

        padding:
            60px 15px;
    }

    .hero h1 {

        font-size: 40px;
    }

    .container {

        width: 92%;

        margin-top:
            50px;
    }

    .contact-info,
    .contact-form {

        padding: 25px;
    }

    .contact-info h2,
    .contact-form h2 {

        font-size: 30px;
    }

    .footer-grid {

        grid-template-columns:
            1fr;
    }

}

@media (max-width: 450px) {

    .logo {

        font-size: 24px;
    }

    .nav-links {

        gap: 9px;
    }

    .nav-links a {

        font-size: 12px;
    }

    .hero h1 {

        font-size: 35px;
    }

    .hero p {

        font-size: 14px;
    }

}

</style>
<?php

$page_title = "Contact US";

require_once "header.php";

?>
</head>


<body>


<!-- =====================================================
     LOADER
===================================================== -->

<div id="loader">

    <div class="loader-content">

        <div class="loader-circle"></div>

        <h2>
            ROYAL STAY
        </h2>

    </div>

</div>




<!-- =====================================================
     HERO
===================================================== -->

<section class="hero">

    <div class="hero-content">

        <small>
            Royal Stay Support
        </small>

        <h1>

            Contact
            <span>Us</span>

        </h1>

        <p>
            Have a question? We would love to hear from you.
        </p>

    </div>

</section>


<!-- =====================================================
     MAIN
===================================================== -->

<div class="container">

    <div class="contact-grid">


        <!-- =================================================
             CONTACT INFORMATION
        ================================================== -->

        <div class="contact-info">

            <span class="contact-label">
                Get In Touch
            </span>

            <h2>
                Contact Information
            </h2>

            <div class="gold-line"></div>

            <p>
                If you have any questions about our hotels,
                rooms or bookings, feel free to contact us.
                Our team is ready to help you.
            </p>


            <!-- ADDRESS -->

            <div class="info-box">

                <div class="info-icon">

                    <i class="fa-solid fa-location-dot"></i>

                </div>

                <strong>
                    Address
                </strong>

                <span>
                    Royal Stay Hotel Booking Office
                </span>

                <div style="clear: both;"></div>

            </div>


            <!-- PHONE -->

            <div class="info-box">

                <div class="info-icon">

                    <i class="fa-solid fa-phone"></i>

                </div>

                <strong>
                    Phone
                </strong>

                <span>
                    +92 300 1234567
                </span>

                <div style="clear: both;"></div>

            </div>


            <!-- EMAIL -->

            <div class="info-box">

                <div class="info-icon">

                    <i class="fa-solid fa-envelope"></i>

                </div>

                <strong>
                    Email
                </strong>

                <span>
                    support@royalstay.com
                </span>

                <div style="clear: both;"></div>

            </div>


            <!-- WORKING HOURS -->

            <div class="info-box">

                <div class="info-icon">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <strong>
                    Working Hours
                </strong>

                <span>
                    Monday - Sunday
                    <br>
                    9:00 AM - 10:00 PM
                </span>

                <div style="clear: both;"></div>

            </div>

        </div>


        <!-- =================================================
             CONTACT FORM
        ================================================== -->

        <div class="contact-form">

            <h2>
                Send Us a Message
            </h2>

            <p class="form-subtitle">
                Fill in the form below and our team will get
                back to you.
            </p>


            <!-- SUCCESS -->

            <?php if ($message !== ""): ?>

                <div class="success">

                    <i class="fa-solid fa-circle-check"></i>

                    <?php
                    echo htmlspecialchars($message);
                    ?>

                </div>

            <?php endif; ?>


            <!-- ERROR -->

            <?php if ($error !== ""): ?>

                <div class="error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <?php
                    echo htmlspecialchars($error);
                    ?>

                </div>

            <?php endif; ?>


            <form
                method="POST"
                action="contact.php"
            >


                <!-- NAME + EMAIL -->

                <div class="form-row">


                    <!-- NAME -->

                    <div class="form-group">

                        <label for="name">

                            Name
                            <span class="required">*</span>

                        </label>

                        <div class="input-box">

                            <i class="fa-solid fa-user"></i>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Enter your name"
                                value="<?php
                                    echo htmlspecialchars(
                                        $name ?? ''
                                    );
                                ?>"
                                required
                            >

                        </div>

                    </div>


                    <!-- EMAIL -->

                    <div class="form-group">

                        <label for="email">

                            Email
                            <span class="required">*</span>

                        </label>

                        <div class="input-box">

                            <i class="fa-solid fa-envelope"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                value="<?php
                                    echo htmlspecialchars(
                                        $email ?? ''
                                    );
                                ?>"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- PHONE -->

                <div class="form-group">

                    <label for="phone">
                        Phone Number
                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-phone"></i>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            placeholder="Enter your phone number"
                            value="<?php
                                echo htmlspecialchars(
                                    $phone ?? ''
                                );
                            ?>"
                        >

                    </div>

                </div>


                <!-- SUBJECT -->

                <div class="form-group">

                    <label for="subject">

                        Subject
                        <span class="required">*</span>

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-heading"></i>

                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            placeholder="Enter message subject"
                            value="<?php
                                echo htmlspecialchars(
                                    $subject ?? ''
                                );
                            ?>"
                            required
                        >

                    </div>

                </div>


                <!-- MESSAGE -->

                <div class="form-group">

                    <label for="message">

                        Message
                        <span class="required">*</span>

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-message"></i>

                        <textarea
                            id="message"
                            name="message"
                            placeholder="Write your message here..."
                            required
                        ><?php
                            echo htmlspecialchars(
                                $user_message ?? ''
                            );
                        ?></textarea>

                    </div>

                </div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="btn"
                >

                    <i class="fa-solid fa-paper-plane"></i>

                    Send Message

                </button>


            </form>

        </div>

    </div>

</div>


<?php
require_once "footer.php";
?>

<!-- =====================================================
     BACK TO TOP
===================================================== -->

<button
    id="topBtn"
    title="Back to top"
>

    <i class="fa-solid fa-arrow-up"></i>

</button>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

/* =========================================
   LOADER - 0.5 SECOND
========================================= */

window.addEventListener(
    "DOMContentLoaded",
    function() {

        const loader =
            document.getElementById("loader");

        setTimeout(function() {

            loader.classList.add("hide");

        }, 500);

    }
);


/* =========================================
   BACK TO TOP
========================================= */

const topBtn =
    document.getElementById("topBtn");


window.addEventListener(
    "scroll",
    function() {

        if (window.scrollY > 350) {

            topBtn.style.display = "flex";

        } else {

            topBtn.style.display = "none";

        }

    }
);


topBtn.addEventListener(
    "click",
    function() {

        window.scrollTo({

            top: 0,

            behavior: "smooth"

        });

    }
);

</script>


</body>

</html>

