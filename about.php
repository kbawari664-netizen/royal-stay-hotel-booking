
<?php

session_start();
require_once "config/database.php";

$page_title = "About Us - Royal Stay";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($page_title); ?></title>

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
    font-family: "Montserrat", Arial, sans-serif;
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

    border: 4px solid rgba(212,175,55,.2);

    border-top-color: #d4af37;

    border-radius: 50%;

    animation: spin 1s linear infinite;

    margin: 0 auto 18px;
}

.loader-content h2 {

    font-family: "Playfair Display", serif;

    letter-spacing: 4px;

    animation: pulse 1.2s ease-in-out infinite;
}


/* =====================================================
   NAVBAR
===================================================== */

.navbar {

    position: sticky;
    top: 0;

    z-index: 5000;

    background: rgba(17,17,17,.96);

    backdrop-filter: blur(12px);

    padding: 17px 7%;

    display: flex;
    align-items: center;
    justify-content: space-between;

    box-shadow:
        0 5px 25px rgba(0,0,0,.20);

    animation: navDown .8s ease;
}

.logo {

    color: #d4af37;

    font-family: "Playfair Display", serif;

    font-size: 29px;
    font-weight: 700;

    transition: .3s ease;
}

.logo i {
    margin-right: 7px;
}

.logo:hover {

    transform: scale(1.06);

    text-shadow:
        0 0 18px rgba(212,175,55,.6);
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

    transform: translateX(-50%);

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

    padding: 9px 17px;

    border-radius: 25px;
}

.login-btn::after {
    display: none;
}

.login-btn:hover {

    background: white;

    transform: translateY(-2px);
}


/* =====================================================
   HERO
===================================================== */

.hero {

    min-height: 460px;

    position: relative;

    display: flex;

    align-items: center;
    justify-content: center;

    text-align: center;

    padding: 70px 20px;

    background:

        linear-gradient(
            rgba(0,0,0,.72),
            rgba(0,0,0,.76)
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

    top: -150px;
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

    max-width: 850px;

    position: relative;

    z-index: 5;
}

.hero small {

    display: block;

    color: #d4af37;

    font-weight: 700;

    letter-spacing: 5px;

    text-transform: uppercase;

    margin-bottom: 15px;

    animation:
        fadeUp .8s ease both;
}

.hero h1 {

    color: white;

    font-family:
        "Playfair Display",
        serif;

    font-size:
        clamp(42px, 6vw, 68px);

    margin-bottom: 20px;

    animation:
        fadeUp .9s ease .2s both;
}

.hero h1 span {
    color: #d4af37;
}

.hero p {

    color: #ddd;

    font-size: 17px;

    line-height: 1.8;

    animation:
        fadeUp 1s ease .4s both;
}


/* =====================================================
   ABOUT SECTION
===================================================== */

.about {

    max-width: 1200px;

    margin: auto;

    padding: 90px 25px;
}

.about-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 60px;

    align-items: center;
}


/* ABOUT IMAGE */

.about-image {

    height: 430px;

    position: relative;

    border-radius: 20px;

    overflow: hidden;

    background:

        linear-gradient(
            rgba(0,0,0,.25),
            rgba(0,0,0,.45)
        ),

        url("assets/images/hotel.jpg")
        center/cover no-repeat;

    box-shadow:
        0 20px 50px rgba(0,0,0,.18);

    animation:
        imageReveal 1s ease both;
}

.about-image::before {

    content: "";

    position: absolute;

    inset: 15px;

    border: 2px solid
        rgba(212,175,55,.75);

    border-radius: 15px;

    z-index: 2;

    pointer-events: none;
}

.about-image-content {

    position: absolute;

    inset: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    color: white;

    font-size: 75px;

    z-index: 3;

    text-shadow:
        0 5px 20px rgba(0,0,0,.6);

    transition: .4s ease;
}

.about-image:hover
.about-image-content {

    transform:
        scale(1.15)
        rotate(3deg);
}

.about-image:hover {

    box-shadow:
        0 25px 60px rgba(0,0,0,.28);
}


/* ABOUT TEXT */

.about-text {

    animation:
        fadeRight 1s ease .2s both;
}

.about-label {

    color: #b28d1c;

    font-size: 12px;

    font-weight: 800;

    letter-spacing: 4px;

    text-transform: uppercase;
}

.about-text h2 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 42px;

    color: #111;

    margin: 12px 0 18px;
}

.gold-line {

    width: 70px;
    height: 4px;

    background: #d4af37;

    margin-bottom: 25px;

    border-radius: 5px;

    position: relative;
}

.gold-line::after {

    content: "";

    position: absolute;

    width: 25px;
    height: 4px;

    background: #111;

    left: 0;

    animation:
        lineMove 2s ease-in-out infinite;
}

.about-text p {

    color: #555;

    line-height: 1.85;

    margin-bottom: 18px;

    font-size: 15px;
}


/* =====================================================
   FEATURES
===================================================== */

.features {

    background: #111;

    padding: 90px 25px;

    position: relative;

    overflow: hidden;
}

.features::before {

    content: "";

    position: absolute;

    width: 350px;
    height: 350px;

    border-radius: 50%;

    border: 1px solid
        rgba(212,175,55,.15);

    top: -180px;
    right: -100px;
}

.section-title {

    text-align: center;

    margin-bottom: 50px;

    position: relative;

    z-index: 2;
}

.section-title small {

    color: #d4af37;

    letter-spacing: 4px;

    font-weight: 700;
}

.section-title h2 {

    color: white;

    font-family:
        "Playfair Display",
        serif;

    font-size: 40px;

    margin: 12px 0;
}

.section-title p {

    color: #aaa;

    font-size: 14px;
}

.feature-grid {

    max-width: 1150px;

    margin: auto;

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 28px;

    position: relative;

    z-index: 2;
}

.feature-card {

    background:
        linear-gradient(
            145deg,
            #202020,
            #151515
        );

    padding: 40px 28px;

    text-align: center;

    border-radius: 18px;

    border: 1px solid #333;

    transition:
        .4s ease;

    position: relative;

    overflow: hidden;
}

.feature-card::before {

    content: "";

    position: absolute;

    width: 0;
    height: 0;

    background:
        rgba(212,175,55,.08);

    border-radius: 50%;

    top: 50%;
    left: 50%;

    transform:
        translate(-50%,-50%);

    transition: .5s ease;
}

.feature-card:hover::before {

    width: 450px;
    height: 450px;
}

.feature-card:hover {

    transform:
        translateY(-12px);

    border-color:
        #d4af37;

    box-shadow:
        0 20px 45px
        rgba(0,0,0,.35);
}

.feature-icon {

    width: 75px;
    height: 75px;

    margin:
        0 auto 22px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        rgba(212,175,55,.12);

    color: #d4af37;

    font-size: 30px;

    position: relative;
    z-index: 2;

    transition: .4s ease;
}

.feature-card:hover
.feature-icon {

    background: #d4af37;

    color: #111;

    transform:
        rotateY(360deg);
}

.feature-card h3 {

    color: #d4af37;

    margin-bottom: 14px;

    font-size: 19px;

    position: relative;
    z-index: 2;
}

.feature-card p {

    color: #aaa;

    line-height: 1.7;

    font-size: 13px;

    position: relative;
    z-index: 2;
}


/* =====================================================
   MISSION
===================================================== */

.mission {

    max-width: 900px;

    margin: auto;

    padding: 90px 25px;

    text-align: center;
}

.mission small {

    color: #b28d1c;

    font-weight: 800;

    letter-spacing: 4px;
}

.mission h2 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 42px;

    margin:
        12px 0 20px;
}

.mission p {

    color: #555;

    font-size: 16px;

    line-height: 1.9;
}

.quote {

    margin-top: 30px;

    color: #b28d1c;

    font-size: 22px;

    font-family:
        "Playfair Display",
        serif;

    font-weight: 700;

    animation:
        pulse 2s ease-in-out infinite;
}


/* =====================================================
   FOOTER
===================================================== */

footer {

    background: #111;

    color: #999;

    padding: 55px 7% 22px;
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
        transform: rotate(360deg);
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

@keyframes fadeRight {

    from {
        opacity: 0;
        transform:
            translateX(50px);
    }

    to {
        opacity: 1;
        transform:
            translateX(0);
    }

}

@keyframes imageReveal {

    from {
        opacity: 0;
        transform:
            translateX(-50px)
            scale(.95);
    }

    to {
        opacity: 1;
        transform:
            translateX(0)
            scale(1);
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

@keyframes lineMove {

    0%, 100% {
        left: 0;
    }

    50% {
        left: 45px;
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

    .about-grid {

        grid-template-columns:
            1fr;
    }

    .feature-grid {

        grid-template-columns:
            1fr;
    }

    .about-image {

        height: 350px;
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

        min-height: 410px;

        padding:
            60px 15px;
    }

    .hero h1 {

        font-size: 40px;
    }

    .about {

        padding:
            65px 20px;
    }

    .about-text h2 {

        font-size: 34px;
    }

    .mission {

        padding:
            65px 20px;
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


</head>


<body>

<?php

$page_title = "About Us";

require_once "header.php";

?>

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
            Welcome To Royal Stay
        </small>

        <h1>
            About
            <span>Royal Stay</span>
        </h1>

        <p>
            Experience comfort, elegance and exceptional
            hospitality with Royal Stay.
        </p>

    </div>

</section>


<!-- =====================================================
     ABOUT
===================================================== -->

<section class="about">

    <div class="about-grid">


        <div class="about-image">

            <div class="about-image-content">

                <i class="fa-solid fa-hotel"></i>

            </div>

        </div>


        <div class="about-text">

            <span class="about-label">
                About Our Hotel
            </span>

            <h2>
                Welcome to Royal Stay
            </h2>

            <div class="gold-line"></div>

            <p>
                Royal Stay is designed to make your hotel
                experience comfortable, simple and memorable.
                We provide carefully selected rooms and
                convenient booking services for our guests.
            </p>

            <p>
                Whether you are travelling for business,
                enjoying a family vacation or planning a
                relaxing getaway, Royal Stay is committed to
                providing a pleasant stay from booking to
                checkout.
            </p>

            <p>
                Our goal is to combine modern comfort,
                elegant surroundings and friendly service
                in one place.
            </p>

        </div>

    </div>

</section>


<!-- =====================================================
     FEATURES
===================================================== -->

<section class="features">

    <div class="section-title">

        <small>
            Royal Experience
        </small>

        <h2>
            Why Choose Royal Stay?
        </h2>

        <p>
            Everything you need for a comfortable stay.
        </p>

    </div>


    <div class="feature-grid">


        <div class="feature-card">

            <div class="feature-icon">

                <i class="fa-solid fa-bed"></i>

            </div>

            <h3>
                Comfortable Rooms
            </h3>

            <p>
                Enjoy clean, comfortable and well-maintained
                rooms designed for relaxation.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">

                <i class="fa-solid fa-star"></i>

            </div>

            <h3>
                Quality Service
            </h3>

            <p>
                We focus on providing a smooth and welcoming
                experience for every guest.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">

                <i class="fa-solid fa-lock"></i>

            </div>

            <h3>
                Easy Booking
            </h3>

            <p>
                Find your room and manage your booking through
                our simple online system.
            </p>

        </div>


    </div>

</section>


<!-- =====================================================
     MISSION
===================================================== -->

<section class="mission">

    <small>
        Our Purpose
    </small>

    <h2>
        Our Mission
    </h2>

    <div
        class="gold-line"
        style="margin: 0 auto 25px;"
    ></div>

    <p>
        Our mission is to make every stay convenient,
        comfortable and enjoyable. We aim to provide
        guests with a reliable hotel booking experience
        while maintaining the quality and elegance that
        defines Royal Stay.
    </p>

    <div class="quote">
        “Your comfort is our priority.”
    </div>

</section>


<?php
require_once "footer.php";
?>

<!-- =====================================================
     BACK TO TOP
===================================================== -->

<button id="topBtn" title="Back to top">

    <i class="fa-solid fa-arrow-up"></i>

</button>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

/* =========================================
   LOADER - 0.5 SECOND
========================================= */

window.addEventListener("DOMContentLoaded", function() {

    const loader =
        document.getElementById("loader");

    setTimeout(function() {

        loader.classList.add("hide");

    }, 500);

});


/* =========================================
   BACK TO TOP
========================================= */

const topBtn =
    document.getElementById("topBtn");


window.addEventListener("scroll", function() {

    if (window.scrollY > 350) {

        topBtn.style.display = "flex";

    } else {

        topBtn.style.display = "none";

    }

});


topBtn.addEventListener("click", function() {

    window.scrollTo({

        top: 0,

        behavior: "smooth"

    });

});

</script>


</body>

</html>
