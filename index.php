
<?php

session_start();

$isLoggedIn = isset($_SESSION["user_id"]);

$userName = $isLoggedIn && isset($_SESSION["user_name"])
    ? $_SESSION["user_name"]
    : "";

$page_title = "Royal Stay - Luxury Hotel Booking";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?php echo htmlspecialchars($page_title); ?></title>


    <!-- =========================
         GOOGLE FONTS
    ========================= -->

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- =========================
         FONT AWESOME
    ========================= -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


<style>

/* =====================================================
   GLOBAL
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
    font-family: 'Montserrat', sans-serif;
    background: #f8f8f8;
    color: #222;
    line-height: 1.6;
    overflow-x: hidden;
}

:root {
    --gold: #c9a227;
    --gold-dark: #a78316;
    --dark: #111;
    --light: #fff;
    --gray: #777;
    --bg: #f8f8f8;
}

a {
    text-decoration: none;
}

img {
    width: 100%;
    display: block;
}

button,
input {
    font-family: inherit;
}


/* =====================================================
   LOADER
===================================================== */

#loader {
    position: fixed;
    inset: 0;
    background: #111;
    z-index: 99999;

    display: flex;
    align-items: center;
    justify-content: center;

    transition: opacity 0.6s ease;
}

.loader-content {
    text-align: center;
    color: white;

    animation: loaderContent 1s ease;
}

.loader-circle {
    width: 60px;
    height: 60px;

    border: 4px solid rgba(255,255,255,0.15);
    border-top: 4px solid var(--gold);

    border-radius: 50%;

    animation: spin 1s linear infinite;

    margin: auto auto 20px;
}

.loader-content h2 {
    font-family: 'Playfair Display', serif;

    letter-spacing: 4px;

    color: var(--gold);

    animation: loaderText 1.5s ease-in-out infinite alternate;
}

@keyframes spin {

    to {
        transform: rotate(360deg);
    }

}

@keyframes loaderContent {

    from {
        opacity: 0;
        transform: scale(0.7);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }

}

@keyframes loaderText {

    from {
        opacity: 0.5;
    }

    to {
        opacity: 1;
    }

}


/* =====================================================
   NAVBAR
===================================================== */

.navbar {
    position: fixed;

    top: 0;
    left: 0;

    width: 100%;

    z-index: 9999;

    background: rgba(0,0,0,0.92);

    padding: 18px 7%;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 3px 15px rgba(0,0,0,0.15);

    transition:
        padding 0.4s ease,
        background 0.4s ease;
}

.logo {
    color: white;

    font-size: 25px;

    font-weight: 700;

    letter-spacing: 2px;

    font-family: 'Playfair Display', serif;

    transition: 0.3s ease;
}

.logo:hover {
    transform: scale(1.04);
}

.logo span {
    color: var(--gold);
}

.nav-links {
    display: flex;

    align-items: center;

    gap: 28px;
}

.nav-links a {
    color: white;

    font-size: 14px;

    font-weight: 500;

    position: relative;

    transition: 0.3s;
}

.nav-links a::after {
    content: "";

    position: absolute;

    left: 0;
    bottom: -7px;

    width: 0;
    height: 2px;

    background: var(--gold);

    transition: 0.3s ease;
}

.nav-links a:hover {
    color: var(--gold);
}

.nav-links a:hover::after {
    width: 100%;
}

.login-btn {
    border: 1px solid var(--gold);

    padding: 10px 20px;

    border-radius: 30px;

    color: var(--gold) !important;
}

.login-btn::after {
    display: none;
}

.login-btn:hover {
    background: var(--gold);

    color: white !important;
}


/* =====================================================
   HERO
===================================================== */

.hero {
    min-height: 100vh;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    position: relative;

    overflow: hidden;

    background:
        linear-gradient(
            rgba(0,0,0,0.62),
            rgba(0,0,0,0.62)
        ),
        url("https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85");

    background-size: cover;

    background-position: center;

    animation:
        heroZoom 14s ease-in-out infinite alternate;
}

@keyframes heroZoom {

    0% {
        background-size: 100%;
    }

    100% {
        background-size: 110%;
    }

}

.hero::after {
    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            180deg,
            rgba(0,0,0,0.05),
            rgba(0,0,0,0.25)
        );

    pointer-events: none;
}

.hero-content {
    max-width: 900px;

    padding: 30px;

    color: white;

    position: relative;

    z-index: 2;

    animation:
        heroContent 1.2s ease forwards;
}

@keyframes heroContent {

    from {
        opacity: 0;
        transform: translateY(50px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}

.hero-content .small-title {
    color: var(--gold);

    font-size: 15px;

    letter-spacing: 4px;

    text-transform: uppercase;

    margin-bottom: 15px;

    animation:
        fadeDown 1s ease 0.2s both;
}

.hero-content h1 {
    font-family: 'Playfair Display', serif;

    font-size: 65px;

    line-height: 1.1;

    margin-bottom: 20px;

    animation:
        titleReveal 1.2s ease 0.4s both;
}

@keyframes titleReveal {

    from {
        opacity: 0;
        transform: scale(0.85);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }

}

.hero-content p {
    max-width: 650px;

    margin: auto;

    color: #eee;

    font-size: 16px;

    animation:
        fadeUp 1s ease 0.7s both;
}

.hero-buttons {
    margin-top: 30px;

    display: flex;

    justify-content: center;

    gap: 15px;

    flex-wrap: wrap;

    animation:
        fadeUp 1s ease 0.9s both;
}

@keyframes fadeDown {

    from {
        opacity: 0;
        transform: translateY(-25px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}

@keyframes fadeUp {

    from {
        opacity: 0;
        transform: translateY(25px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


/* =====================================================
   BUTTONS
===================================================== */

.btn {
    display: inline-block;

    padding: 13px 25px;

    border-radius: 30px;

    font-size: 14px;

    font-weight: 600;

    transition:
        transform 0.3s ease,
        background 0.3s ease;

    position: relative;

    overflow: hidden;
}

.btn::before {
    content: "";

    position: absolute;

    top: 0;
    left: -120%;

    width: 70%;
    height: 100%;

    background: rgba(255,255,255,0.28);

    transform: skewX(-25deg);

    transition: 0.6s ease;
}

.btn:hover::before {
    left: 130%;
}

.btn-gold {
    background: var(--gold);

    color: white;
}

.btn-gold:hover {
    background: var(--gold-dark);

    transform: translateY(-4px);

    box-shadow:
        0 10px 25px rgba(201,162,39,0.3);
}

.btn-outline {
    border: 1px solid white;

    color: white;
}

.btn-outline:hover {
    background: white;

    color: #111;

    transform: translateY(-4px);
}


/* =====================================================
   SEARCH BOX
===================================================== */

.search-box {
    width: 90%;

    max-width: 1100px;

    margin: -55px auto 70px;

    background: white;

    padding: 25px;

    border-radius: 12px;

    box-shadow:
        0 10px 35px rgba(0,0,0,0.12);

    position: relative;

    z-index: 10;

    animation:
        searchFloat 1s ease 0.3s both;
}

@keyframes searchFloat {

    from {
        opacity: 0;
        transform: translateY(40px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}

.search-form {
    display: grid;

    grid-template-columns:
        1.5fr 1fr 1fr 1fr auto;

    gap: 12px;
}

.input-group {
    position: relative;
}

.input-group i {
    position: absolute;

    left: 15px;

    top: 50%;

    transform: translateY(-50%);

    color: var(--gold);
}

.input-group input {
    width: 100%;

    padding:
        14px
        15px
        14px
        43px;

    border: 1px solid #ddd;

    border-radius: 8px;

    outline: none;

    transition: 0.3s ease;
}

.input-group input:focus {
    border-color: var(--gold);

    box-shadow:
        0 0 0 3px rgba(201,162,39,0.08);
}

.search-btn {
    border: none;

    background: var(--gold);

    color: white;

    padding: 0 25px;

    border-radius: 8px;

    cursor: pointer;

    font-weight: 600;

    transition: 0.3s ease;
}

.search-btn:hover {
    background: var(--gold-dark);

    transform: translateY(-3px);

    box-shadow:
        0 8px 20px rgba(201,162,39,0.3);
}


/* =====================================================
   SECTION
===================================================== */

.section {
    padding: 80px 7%;
}

.section-title {
    text-align: center;

    margin-bottom: 45px;
}

.section-title span {
    color: var(--gold);

    font-size: 14px;

    letter-spacing: 3px;

    text-transform: uppercase;

    font-weight: 600;
}

.section-title h2 {
    font-family: 'Playfair Display', serif;

    font-size: 42px;

    margin-top: 8px;
}

.section-title p {
    max-width: 650px;

    margin: 10px auto 0;

    color: var(--gray);
}


/* =====================================================
   REVEAL
===================================================== */

.reveal {
    opacity: 0;

    transform:
        translateY(60px)
        scale(0.97);

    transition:
        opacity 0.9s ease,
        transform 0.9s cubic-bezier(.2,.8,.2,1);
}

.reveal.active {
    opacity: 1;

    transform:
        translateY(0)
        scale(1);
}


/* =====================================================
   FEATURES
===================================================== */

.features {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 25px;
}

.feature-card {
    background: white;

    padding: 35px 25px;

    text-align: center;

    border-radius: 12px;

    box-shadow:
        0 5px 25px rgba(0,0,0,0.07);

    transition:
        transform 0.45s ease,
        box-shadow 0.45s ease;

    position: relative;

    overflow: hidden;
}

.feature-card::before {
    content: "";

    position: absolute;

    width: 100px;
    height: 100px;

    border-radius: 50%;

    background:
        rgba(201,162,39,0.08);

    top: -50px;
    right: -50px;

    transition: 0.5s ease;
}

.feature-card:hover::before {
    transform: scale(3);
}

.feature-card:hover {
    transform: translateY(-12px);

    box-shadow:
        0 18px 40px rgba(0,0,0,0.12);
}

.feature-icon {
    width: 70px;

    height: 70px;

    margin:
        auto auto 20px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        rgba(201,162,39,0.12);

    color: var(--gold);

    font-size: 27px;

    transition: 0.6s ease;

    position: relative;

    z-index: 2;
}

.feature-card:hover .feature-icon {
    transform:
        rotateY(360deg)
        scale(1.08);
}

.feature-card h3 {
    margin-bottom: 10px;

    font-family:
        'Playfair Display', serif;

    position: relative;

    z-index: 2;
}

.feature-card p {
    color: var(--gray);

    font-size: 14px;

    position: relative;

    z-index: 2;
}


/* =====================================================
   HOTEL CARDS
===================================================== */

.hotel-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 25px;
}

.hotel-card {
    background: white;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 5px 25px rgba(0,0,0,0.08);

    transition:
        transform 0.45s ease,
        box-shadow 0.45s ease;
}

.hotel-card:hover {
    transform:
        translateY(-12px)
        scale(1.015);

    box-shadow:
        0 18px 40px rgba(0,0,0,0.15);
}

.hotel-image {
    height: 240px;

    overflow: hidden;

    position: relative;
}

.hotel-image img {
    height: 100%;

    object-fit: cover;

    transition:
        transform 0.8s cubic-bezier(.2,.8,.2,1),
        filter 0.5s ease;
}

.hotel-card:hover .hotel-image img {
    transform: scale(1.12);

    filter: brightness(1.08);
}

.hotel-image::after {
    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,0.35),
            transparent 60%
        );

    opacity: 0;

    transition: 0.5s ease;

    pointer-events: none;
}

.hotel-card:hover .hotel-image::after {
    opacity: 1;
}

.hotel-info {
    padding: 22px;
}

.hotel-info h3 {
    font-family:
        'Playfair Display', serif;

    font-size: 23px;

    margin-bottom: 8px;
}

.hotel-location {
    color: var(--gray);

    font-size: 13px;

    margin-bottom: 15px;
}

.hotel-location i {
    color: var(--gold);

    margin-right: 5px;
}

.hotel-bottom {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 10px;
}

.price {
    color: var(--gold-dark);

    font-weight: 700;

    font-size: 18px;

    transition: 0.3s ease;
}

.hotel-card:hover .price,
.room-card:hover .price {
    transform: translateX(5px);

    color: var(--gold);
}

.price small {
    color: var(--gray);

    font-size: 11px;

    font-weight: 400;
}


/* =====================================================
   STATS
===================================================== */

.stats {
    background: #111;

    color: white;

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    text-align: center;

    padding: 60px 7%;
}

.stat {
    transition: 0.4s ease;
}

.stat:hover {
    transform: translateY(-8px);
}

.stat h2 {
    color: var(--gold);

    font-size: 38px;

    font-family:
        'Playfair Display', serif;

    transition: 0.4s ease;
}

.stat:hover h2 {
    transform: scale(1.1);
}

.stat p {
    color: #ccc;

    font-size: 14px;
}


/* =====================================================
   ROOMS
===================================================== */

.room-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 25px;
}

.room-card {
    background: white;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 5px 25px rgba(0,0,0,0.08);

    transition:
        transform 0.45s ease,
        box-shadow 0.45s ease;
}

.room-card:hover {
    transform:
        translateY(-12px)
        scale(1.015);

    box-shadow:
        0 18px 40px rgba(0,0,0,0.15);
}

.room-image {
    height: 240px;

    overflow: hidden;

    position: relative;
}

.room-image img {
    height: 100%;

    object-fit: cover;

    transition:
        transform 0.8s cubic-bezier(.2,.8,.2,1),
        filter 0.5s ease;
}

.room-card:hover .room-image img {
    transform: scale(1.12);

    filter: brightness(1.08);
}

.room-image::after {
    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,0.35),
            transparent 60%
        );

    opacity: 0;

    transition: 0.5s ease;
}

.room-card:hover .room-image::after {
    opacity: 1;
}

.room-info {
    padding: 22px;
}

.room-info h3 {
    font-family:
        'Playfair Display', serif;

    font-size: 23px;

    margin-bottom: 12px;
}

.room-features {
    display: flex;

    gap: 15px;

    flex-wrap: wrap;

    color: var(--gray);

    font-size: 12px;

    margin-bottom: 18px;
}

.room-features i {
    color: var(--gold);

    margin-right: 4px;
}

.room-bottom {
    display: flex;

    align-items: center;

    justify-content: space-between;
}


/* =====================================================
   OFFER
===================================================== */

.offer {
    margin: 30px 7%;

    padding: 90px 30px;

    text-align: center;

    color: white;

    border-radius: 15px;

    background:
        linear-gradient(
            rgba(0,0,0,0.65),
            rgba(0,0,0,0.65)
        ),
        url("https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1800&q=85");

    background-size: cover;

    background-position: center;

    transition: 0.5s ease;
}

.offer:hover {
    transform: scale(1.01);
}

.offer span {
    color: var(--gold);

    letter-spacing: 3px;

    font-size: 14px;
}

.offer h2 {
    font-family:
        'Playfair Display', serif;

    font-size: 45px;

    margin: 12px 0;
}

.offer p {
    max-width: 650px;

    margin:
        auto auto 25px;

    color: #eee;
}


/* =====================================================
   REVIEWS
===================================================== */

.reviews {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 25px;
}

.review-card {
    background: white;

    padding: 30px;

    border-radius: 12px;

    box-shadow:
        0 5px 25px rgba(0,0,0,0.06);

    transition:
        transform 0.4s ease,
        box-shadow 0.4s ease;
}

.review-card:hover {
    transform: translateY(-10px);

    box-shadow:
        0 15px 35px rgba(0,0,0,0.12);
}

.stars {
    color: var(--gold);

    margin-bottom: 15px;
}

.stars i {
    display: inline-block;

    transition: 0.3s ease;
}

.review-card:hover .stars i {
    animation:
        starBounce 0.6s ease;
}

.review-card:hover .stars i:nth-child(2) {
    animation-delay: 0.05s;
}

.review-card:hover .stars i:nth-child(3) {
    animation-delay: 0.1s;
}

.review-card:hover .stars i:nth-child(4) {
    animation-delay: 0.15s;
}

.review-card:hover .stars i:nth-child(5) {
    animation-delay: 0.2s;
}

@keyframes starBounce {

    50% {
        transform:
            translateY(-6px)
            scale(1.15);
    }

}

.review-card p {
    color: var(--gray);

    font-size: 14px;

    margin-bottom: 20px;
}

.review-user {
    display: flex;

    align-items: center;

    gap: 12px;
}

.review-avatar {
    width: 45px;

    height: 45px;

    border-radius: 50%;

    background: var(--gold);

    color: white;

    display: flex;

    align-items: center;

    justify-content: center;

    font-weight: 700;

    transition: 0.4s ease;
}

.review-card:hover .review-avatar {
    transform:
        rotate(10deg)
        scale(1.08);
}

.review-user h4 {
    font-size: 14px;
}

.review-user span {
    color: var(--gray);

    font-size: 12px;
}


/* =====================================================
   CTA
===================================================== */

.cta {
    text-align: center;

    background: #111;

    color: white;

    padding: 80px 7%;
}

.cta h2 {
    font-family:
        'Playfair Display', serif;

    font-size: 42px;

    margin-bottom: 15px;
}

.cta p {
    color: #ccc;

    max-width: 650px;

    margin:
        auto auto 25px;
}


/* =====================================================
   CONTACT BUTTON
===================================================== */

.contact-btn {
    position: fixed;

    right: 25px;

    bottom: 25px;

    width: 55px;

    height: 55px;

    background: var(--gold);

    color: white;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 21px;

    box-shadow:
        0 5px 20px rgba(0,0,0,0.25);

    z-index: 1000;

    transition: 0.3s;

    animation:
        contactPulse 2.5s infinite;
}

.contact-btn:hover {
    transform: scale(1.12);

    background: var(--gold-dark);
}

@keyframes contactPulse {

    0% {
        box-shadow:
            0 5px 20px rgba(0,0,0,0.25);
    }

    50% {
        box-shadow:
            0 5px 25px rgba(201,162,39,0.45),
            0 0 0 10px rgba(201,162,39,0.08);
    }

    100% {
        box-shadow:
            0 5px 20px rgba(0,0,0,0.25);
    }

}


/* =====================================================
   BACK TO TOP
===================================================== */

#backToTop {
    position: fixed;

    right: 25px;

    bottom: 90px;

    width: 45px;

    height: 45px;

    border: none;

    border-radius: 50%;

    background: #111;

    color: white;

    cursor: pointer;

    display: none;

    align-items: center;

    justify-content: center;

    z-index: 999;

    transition: 0.3s;
}

#backToTop:hover {
    background: var(--gold);

    transform: translateY(-4px);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1000px) {

    .search-form {
        grid-template-columns: 1fr 1fr;
    }

    .search-btn {
        padding: 14px;
    }

    .features,
    .hotel-grid,
    .room-grid,
    .reviews {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .stats {
        grid-template-columns:
            repeat(2, 1fr);

        gap: 35px;
    }

}


@media (max-width: 768px) {

    .navbar {
        padding: 15px 5%;
    }

    .nav-links {
        display: none;
    }

    .hero {
        animation: none;
    }

    .hero-content h1 {
        font-size: 45px;
    }

    .hero-content p {
        font-size: 14px;
    }

    .section {
        padding: 60px 5%;
    }

    .section-title h2 {
        font-size: 34px;
    }

    .search-box {
        margin-top: -30px;
    }

    .search-form {
        grid-template-columns: 1fr;
    }

    .features,
    .hotel-grid,
    .room-grid,
    .reviews {
        grid-template-columns: 1fr;
    }

    .stats {
        grid-template-columns:
            1fr 1fr;

        padding: 50px 5%;
    }

    .offer {
        margin: 20px 5%;
    }

    .offer h2 {
        font-size: 34px;
    }

    .cta h2 {
        font-size: 34px;
    }

}


@media (max-width: 480px) {

    .hero-content h1 {
        font-size: 36px;
    }

    .hero-content {
        padding: 20px;
    }

    .stats {
        grid-template-columns: 1fr;
    }

    .hero-buttons {
        flex-direction: column;
    }

    .hero-buttons .btn {
        width: 100%;
    }

    .contact-btn {
        right: 18px;
        bottom: 18px;
    }

    #backToTop {
        right: 18px;
        bottom: 82px;
    }

}


/* =====================================================
   REDUCED MOTION
===================================================== */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;

        animation-iteration-count: 1 !important;

        transition-duration: 0.01ms !important;

        scroll-behavior: auto !important;
    }

}

</style>

</head>


<body>


<!-- =====================================================
     LOADER
===================================================== -->

<div id="loader">

    <div class="loader-content">

        <div class="loader-circle"></div>

        <h2>ROYAL STAY</h2>

    </div>

</div>


<?php

$page_title = "Home";

require_once "header.php";

?>


<!-- =====================================================
     HERO
===================================================== -->

<section class="hero">

    <div class="hero-content">

        <div class="small-title">
            Luxury • Comfort • Experience
        </div>

        <h1>
            Welcome to Royal Stay
        </h1>

        <p>
            Discover beautiful hotels, comfortable rooms,
            secure booking and unforgettable experiences.
        </p>

        <div class="hero-buttons">

            <a
                href="hotels.php"
                class="btn btn-gold"
            >
                <i class="fa-solid fa-hotel"></i>
                Explore Hotels
            </a>

            <a
                href="room.php"
                class="btn btn-outline"
            >
                <i class="fa-solid fa-bed"></i>
                View Rooms
            </a>

        </div>

    </div>

</section>


<!-- =====================================================
     SEARCH
===================================================== -->

<div class="search-box">

    <form
        action="search.php"
        method="GET"
        class="search-form"
        id="searchForm"
    >

        <div class="input-group">

            <i class="fa-solid fa-location-dot"></i>

            <input
                type="text"
                name="location"
                placeholder="Where are you going?"
                required
            >

        </div>


        <div class="input-group">

            <i class="fa-solid fa-calendar-days"></i>

            <input
                type="date"
                name="check_in"
                id="check_in"
                required
            >

        </div>


        <div class="input-group">

            <i class="fa-solid fa-calendar-check"></i>

            <input
                type="date"
                name="check_out"
                id="check_out"
                required
            >

        </div>


        <div class="input-group">

            <i class="fa-solid fa-users"></i>

            <input
                type="number"
                name="guests"
                min="1"
                value="1"
                placeholder="Guests"
                required
            >

        </div>


        <button
            type="submit"
            class="search-btn"
        >

            <i class="fa-solid fa-search"></i>

            Search

        </button>

    </form>

</div>


<!-- =====================================================
     FEATURES
===================================================== -->

<section class="section reveal">

    <div class="section-title">

        <span>Why Choose Us</span>

        <h2>Everything You Need</h2>

        <p>
            Royal Stay provides everything you need
            for a comfortable and enjoyable stay.
        </p>

    </div>


    <div class="features">


        <div class="feature-card">

            <div class="feature-icon">

                <i class="fa-solid fa-hotel"></i>

            </div>

            <h3>
                Luxury Hotels
            </h3>

            <p>
                Discover premium hotels with
                beautiful locations and excellent services.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">

                <i class="fa-solid fa-bed"></i>

            </div>

            <h3>
                Comfortable Rooms
            </h3>

            <p>
                Choose from a wide range of rooms
                designed for your comfort.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">

                <i class="fa-solid fa-shield-halved"></i>

            </div>

            <h3>
                Secure Booking
            </h3>

            <p>
                Your booking information is protected
                with a secure and easy booking system.
            </p>

        </div>


    </div>

</section>


<!-- =====================================================
     FEATURED HOTELS
===================================================== -->

<section class="section reveal">

    <div class="section-title">

        <span>
            Featured Hotels
        </span>

        <h2>
            Popular Hotels
        </h2>

        <p>
            Explore some of our most popular hotels
            available for your next trip.
        </p>

    </div>


    <div class="hotel-grid">


        <!-- HOTEL 1 -->

        <div class="hotel-card">

            <div class="hotel-image">

                <img
                    src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1000&q=85"
                    alt="Royal Grand Hotel"
                    loading="lazy"
                >

            </div>

            <div class="hotel-info">

                <h3>
                    Royal Grand Hotel
                </h3>

                <div class="hotel-location">

                    <i class="fa-solid fa-location-dot"></i>

                    Karachi, Pakistan

                </div>

                <div class="hotel-bottom">

                    <div class="price">

                        $80

                        <small>
                            / night
                        </small>

                    </div>

                    <a
                        href="hotels.php"
                        class="btn btn-gold"
                    >
                        View Hotel
                    </a>

                </div>

            </div>

        </div>


        <!-- HOTEL 2 -->

        <div class="hotel-card">

            <div class="hotel-image">

                <img
                    src="https://images.unsplash.com/photo-1601918774946-25832a4be0d6?auto=format&fit=crop&w=1000&q=85"
                    alt="Royal Palace Hotel"
                    loading="lazy"
                >

            </div>

            <div class="hotel-info">

                <h3>
                    Royal Palace
                </h3>

                <div class="hotel-location">

                    <i class="fa-solid fa-location-dot"></i>

                    Islamabad, Pakistan

                </div>

                <div class="hotel-bottom">

                    <div class="price">

                        $95

                        <small>
                            / night
                        </small>

                    </div>

                    <a
                        href="hotels.php"
                        class="btn btn-gold"
                    >
                        View Hotel
                    </a>

                </div>

            </div>

        </div>


        <!-- HOTEL 3 -->

        <div class="hotel-card">

            <div class="hotel-image">

                <img
                    src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1000&q=85"
                    alt="Royal Luxury Hotel"
                    loading="lazy"
                >

            </div>

            <div class="hotel-info">

                <h3>
                    Royal Luxury
                </h3>

                <div class="hotel-location">

                    <i class="fa-solid fa-location-dot"></i>

                    Lahore, Pakistan

                </div>

                <div class="hotel-bottom">

                    <div class="price">

                        $120

                        <small>
                            / night
                        </small>

                    </div>

                    <a
                        href="hotels.php"
                        class="btn btn-gold"
                    >
                        View Hotel
                    </a>

                </div>

            </div>

        </div>


    </div>

</section>


<!-- =====================================================
     STATS
===================================================== -->

<section class="stats reveal">

    <div class="stat">

        <h2>
            50+
        </h2>

        <p>
            Hotels
        </p>

    </div>


    <div class="stat">

        <h2>
            500+
        </h2>

        <p>
            Rooms
        </p>

    </div>


    <div class="stat">

        <h2>
            1000+
        </h2>

        <p>
            Happy Guests
        </p>

    </div>


    <div class="stat">

        <h2>
            2000+
        </h2>

        <p>
            Bookings
        </p>

    </div>

</section>


<!-- =====================================================
     POPULAR ROOMS
===================================================== -->

<section class="section reveal">

    <div class="section-title">

        <span>
            Our Rooms
        </span>

        <h2>
            Popular Rooms
        </h2>

        <p>
            Find the perfect room for your stay.
        </p>

    </div>


    <div class="room-grid">


        <!-- ROOM 1 -->

        <div class="room-card">

            <div class="room-image">

                <img
                    src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1000&q=85"
                    alt="Deluxe Room"
                    loading="lazy"
                >

            </div>

            <div class="room-info">

                <h3>
                    Deluxe Room
                </h3>

                <div class="room-features">

                    <span>

                        <i class="fa-solid fa-user-group"></i>

                        2 Guests

                    </span>

                    <span>

                        <i class="fa-solid fa-wifi"></i>

                        WiFi

                    </span>

                    <span>

                        <i class="fa-solid fa-tv"></i>

                        TV

                    </span>

                </div>

                <div class="room-bottom">

                    <div class="price">

                        $70

                        <small>
                            / night
                        </small>

                    </div>

                    <a
                        href="room.php"
                        class="btn btn-gold"
                    >
                        Book Now
                    </a>

                </div>

            </div>

        </div>


        <!-- ROOM 2 -->

        <div class="room-card">

            <div class="room-image">

                <img
                    src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1000&q=85"
                    alt="Executive Room"
                    loading="lazy"
                >

            </div>

            <div class="room-info">

                <h3>
                    Executive Room
                </h3>

                <div class="room-features">

                    <span>

                        <i class="fa-solid fa-user-group"></i>

                        3 Guests

                    </span>

                    <span>

                        <i class="fa-solid fa-wifi"></i>

                        WiFi

                    </span>

                    <span>

                        <i class="fa-solid fa-mug-hot"></i>

                        Coffee

                    </span>

                </div>

                <div class="room-bottom">

                    <div class="price">

                        $95

                        <small>
                            / night
                        </small>

                    </div>

                    <a
                        href="room.php"
                        class="btn btn-gold"
                    >
                        Book Now
                    </a>

                </div>

            </div>

        </div>


        <!-- ROOM 3 -->

        <div class="room-card">

            <div class="room-image">

                <img
                    src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=85"
                    alt="Royal Suite"
                    loading="lazy"
                >

            </div>

            <div class="room-info">

                <h3>
                    Royal Suite
                </h3>

                <div class="room-features">

                    <span>

                        <i class="fa-solid fa-user-group"></i>

                        4 Guests

                    </span>

                    <span>

                        <i class="fa-solid fa-wifi"></i>

                        WiFi

                    </span>

                    <span>

                        <i class="fa-solid fa-bath"></i>

                        Bath

                    </span>

                </div>

                <div class="room-bottom">

                    <div class="price">

                        $150

                        <small>
                            / night
                        </small>

                    </div>

                    <a
                        href="room.php"
                        class="btn btn-gold"
                    >
                        Book Now
                    </a>

                </div>

            </div>

        </div>


    </div>

</section>


<!-- =====================================================
     SPECIAL OFFER
===================================================== -->

<section class="offer reveal">

    <span>
        SPECIAL OFFER
    </span>

    <h2>
        Stay Longer, Save More
    </h2>

    <p>
        Enjoy amazing hotel experiences with
        special offers and comfortable rooms.
    </p>

    <a
        href="hotels.php"
        class="btn btn-gold"
    >
        Explore Offers
    </a>

</section>


<!-- =====================================================
     REVIEWS
===================================================== -->

<section class="section reveal">

    <div class="section-title">

        <span>
            Guest Reviews
        </span>

        <h2>
            What Our Guests Say
        </h2>

    </div>


    <div class="reviews">


        <!-- REVIEW 1 -->

        <div class="review-card">

            <div class="stars">

                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>

            </div>

            <p>
                "Royal Stay made my trip very comfortable.
                The room was clean and the booking process
                was very easy."
            </p>

            <div class="review-user">

                <div class="review-avatar">
                    A
                </div>

                <div>

                    <h4>
                        Ahmed Khan
                    </h4>

                    <span>
                        Guest
                    </span>

                </div>

            </div>

        </div>


        <!-- REVIEW 2 -->

        <div class="review-card">

            <div class="stars">

                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>

            </div>

            <p>
                "Beautiful hotel and excellent service.
                I really enjoyed my stay at Royal Stay."
            </p>

            <div class="review-user">

                <div class="review-avatar">
                    S
                </div>

                <div>

                    <h4>
                        Sara Ali
                    </h4>

                    <span>
                        Guest
                    </span>

                </div>

            </div>

        </div>


        <!-- REVIEW 3 -->

        <div class="review-card">

            <div class="stars">

                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>

            </div>

            <p>
                "The website is simple and easy to use.
                Booking a room was quick and secure."
            </p>

            <div class="review-user">

                <div class="review-avatar">
                    M
                </div>

                <div>

                    <h4>
                        Muhammad
                    </h4>

                    <span>
                        Guest
                    </span>

                </div>

            </div>

        </div>


    </div>

</section>


<!-- =====================================================
     CTA
===================================================== -->

<section class="cta reveal">

<?php if ($isLoggedIn): ?>

    <h2>
        Welcome Back,
        <?php echo htmlspecialchars($userName); ?>!
    </h2>

    <p>
        Find your perfect hotel and book your
        next comfortable stay today.
    </p>

    <a
        href="hotels.php"
        class="btn btn-gold"
    >
        Explore Hotels
    </a>

<?php else: ?>

    <h2>
        Ready For Your Next Stay?
    </h2>

    <p>
        Create your account and start booking
        beautiful hotels and comfortable rooms.
    </p>

    <a
        href="register.php"
        class="btn btn-gold"
    >
        Create Account
    </a>

<?php endif; ?>

</section>


<!-- =====================================================
     CONTACT BUTTON
===================================================== -->

<a
    href="contact.php"
    class="contact-btn"
    title="Contact Us"
    aria-label="Contact Us"
>

    <i class="fa-solid fa-comments"></i>

</a>


<!-- =====================================================
     BACK TO TOP
===================================================== -->

<button
    id="backToTop"
    title="Back to Top"
    aria-label="Back to Top"
>

    <i class="fa-solid fa-arrow-up"></i>

</button>


<!-- =====================================================
     FOOTER
===================================================== -->

<?php

if (file_exists("footer.php")) {

    require_once "footer.php";

}

?>


<script>

/* =====================================================
   LOADER
===================================================== */

window.addEventListener("load", function () {

    const loader =
        document.getElementById("loader");

    setTimeout(function () {

        loader.style.opacity = "0";

        setTimeout(function () {

            loader.style.display = "none";

        }, 600);

    }, 600);

});


/* =====================================================
   BACK TO TOP
===================================================== */

const backToTop =
    document.getElementById("backToTop");


window.addEventListener("scroll", function () {

    if (window.scrollY > 400) {

        backToTop.style.display = "flex";

    } else {

        backToTop.style.display = "none";

    }

});


backToTop.addEventListener("click", function () {

    window.scrollTo({

        top: 0,

        behavior: "smooth"

    });

});


/* =====================================================
   SCROLL REVEAL
===================================================== */

const reveals =
    document.querySelectorAll(".reveal");


function revealOnScroll() {

    reveals.forEach(function (element) {

        const windowHeight =
            window.innerHeight;

        const elementTop =
            element.getBoundingClientRect().top;

        if (
            elementTop <
            windowHeight - 100
        ) {

            element.classList.add("active");

        }

    });

}


window.addEventListener(
    "scroll",
    revealOnScroll
);


window.addEventListener(
    "load",
    function () {

        setTimeout(
            revealOnScroll,
            200
        );

    }
);


/* =====================================================
   SEARCH DATE VALIDATION
===================================================== */

const checkIn =
    document.getElementById("check_in");

const checkOut =
    document.getElementById("check_out");


const today =
    new Date()
        .toISOString()
        .split("T")[0];


if (checkIn) {

    checkIn.min = today;

}


if (checkOut) {

    checkOut.min = today;

}


if (checkIn && checkOut) {

    checkIn.addEventListener(
        "change",
        function () {

            checkOut.min = this.value;

            if (
                checkOut.value &&
                checkOut.value <= this.value
            ) {

                checkOut.value = "";

            }

        }
    );

}


/* =====================================================
   SEARCH FORM VALIDATION
===================================================== */

const searchForm =
    document.getElementById("searchForm");


if (searchForm) {

    searchForm.addEventListener(
        "submit",
        function (e) {

            const inDate =
                checkIn.value;

            const outDate =
                checkOut.value;


            if (
                !inDate ||
                !outDate
            ) {

                return;

            }


            if (outDate <= inDate) {

                e.preventDefault();

                alert(
                    "Check-out date must be after check-in date."
                );

            }

        }
    );

}


/* =====================================================
   NAVBAR SCROLL EFFECT
===================================================== */

const navbar =
    document.querySelector(".navbar");


window.addEventListener(
    "scroll",
    function () {

        if (!navbar) {
            return;
        }

        if (window.scrollY > 50) {

            navbar.style.padding =
                "12px 7%";

            navbar.style.background =
                "rgba(0,0,0,0.97)";

        } else {

            navbar.style.padding =
                "18px 7%";

            navbar.style.background =
                "rgba(0,0,0,0.92)";

        }

    }
);


/* =====================================================
   BUTTON CLICK EFFECT
===================================================== */

document
    .querySelectorAll(".btn")
    .forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                this.style.transform =
                    "scale(0.96)";

                setTimeout(
                    () => {

                        this.style.transform =
                            "";

                    },
                    150
                );

            }
        );

    });


/* =====================================================
   PREVENT OLD DATE
===================================================== */

if (checkIn) {

    checkIn.addEventListener(
        "change",
        function () {

            if (this.value < today) {

                this.value = today;

            }

        }
    );

}


if (checkOut) {

    checkOut.addEventListener(
        "change",
        function () {

            if (this.value < today) {

                this.value = "";

                alert(
                    "Please select a valid check-out date."
                );

            }

        }
    );

}

</script>


</body>

</html>
