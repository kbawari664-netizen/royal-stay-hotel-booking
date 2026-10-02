<?php

/*
|--------------------------------------------------------------------------
| Royal Stay - Search Hotels
|--------------------------------------------------------------------------
*/

session_start();

require_once "config/database.php";


/*
|--------------------------------------------------------------------------
| Search Value
|--------------------------------------------------------------------------
*/

$search = trim($_GET['search'] ?? '');

$hotels = [];

$error = "";


/*
|--------------------------------------------------------------------------
| Search Hotels
|--------------------------------------------------------------------------
*/

try {

    if ($search !== '') {

        $stmt = $pdo->prepare("
            SELECT *
            FROM hotels
            WHERE name LIKE ?
               OR location LIKE ?
               OR description LIKE ?
            ORDER BY id DESC
        ");

        $keyword = "%" . $search . "%";

        $stmt->execute([
            $keyword,
            $keyword,
            $keyword
        ]);

        $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {

        $stmt = $pdo->query("
            SELECT *
            FROM hotels
            ORDER BY id DESC
        ");

        $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {

    $error = "Unable to load hotels right now.";

    $hotels = [];
}


/*
|--------------------------------------------------------------------------
| Page Title
|--------------------------------------------------------------------------
*/

$page_title = "Search Hotels - Royal Stay";

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
        <?= htmlspecialchars($page_title) ?>
    </title>


    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


<style>

/* =========================================================
   GLOBAL
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
    font-family: "Montserrat", sans-serif;
    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(212,175,55,.035),
            transparent 30%
        ),
        #080808;
    color: #ffffff;
    min-height: 100vh;
    overflow-x: hidden;
}

body::selection {
    background: #d4af37;
    color: #111;
}

a {
    text-decoration: none;
}

button,
input {
    font-family: "Montserrat", sans-serif;
}


/* =========================================================
   HERO
========================================================= */

.search-hero {

    position: relative;

    min-height: 500px;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 100px 20px 90px;

    overflow: hidden;

    background:

        linear-gradient(
            135deg,
            rgba(0,0,0,.72),
            rgba(0,0,0,.90)
        ),

        url("assets/images/hotel.jpg");

    background-size: cover;

    background-position: center;
}


/* GOLD GLOW */

.search-hero::before {

    content: "";

    position: absolute;

    width: 550px;

    height: 550px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    filter: blur(100px);

    top: -280px;

    left: -180px;

    animation:
        heroGlow 7s ease-in-out infinite alternate;
}


.search-hero::after {

    content: "";

    position: absolute;

    width: 450px;

    height: 450px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.07);

    filter: blur(100px);

    right: -200px;

    bottom: -230px;

    animation:
        heroGlow 6s ease-in-out infinite alternate-reverse;
}


@keyframes heroGlow {

    from {
        transform: translate(0,0) scale(1);
    }

    to {
        transform: translate(50px,30px) scale(1.15);
    }
}


.hero-content {

    position: relative;

    z-index: 5;

    width: 100%;

    max-width: 950px;
}


/* =========================================================
   HERO ICON
========================================================= */

.hero-icon {

    width: 75px;

    height: 75px;

    margin: 0 auto 22px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    border:
        1px solid
        rgba(212,175,55,.45);

    background:
        rgba(212,175,55,.07);

    box-shadow:
        0 0 40px
        rgba(212,175,55,.12),

        inset 0 0 25px
        rgba(212,175,55,.05);

    color: #d4af37;

    font-size: 28px;

    animation:
        floatIcon 3s ease-in-out infinite;
}


@keyframes floatIcon {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-8px);
    }
}


/* =========================================================
   HERO TITLE
========================================================= */

.hero-content h1 {

    font-family:
        "Playfair Display",
        serif;

    font-size:
        clamp(42px, 6vw, 72px);

    line-height: 1.1;

    color: #ffffff;

    margin-bottom: 18px;

    letter-spacing: -.5px;

    text-shadow:
        0 10px 35px
        rgba(0,0,0,.6);
}


.hero-content h1 span {

    color: #d4af37;

    position: relative;
}


.hero-content h1 span::after {

    content: "";

    position: absolute;

    height: 2px;

    width: 70%;

    left: 15%;

    bottom: -8px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d4af37,
            transparent
        );
}


.hero-content p {

    color: #c5c5c5;

    font-size: 14px;

    line-height: 1.9;

    max-width: 650px;

    margin: 0 auto 35px;
}


/* =========================================================
   SEARCH BOX
========================================================= */

.search-box {

    width: 100%;

    max-width: 800px;

    margin: auto;

    display: flex;

    align-items: center;

    background:
        rgba(255,255,255,.065);

    border:
        1px solid
        rgba(212,175,55,.35);

    border-radius: 60px;

    padding: 8px;

    backdrop-filter: blur(20px);

    -webkit-backdrop-filter: blur(20px);

    box-shadow:
        0 25px 70px
        rgba(0,0,0,.45);

    transition:
        .35s ease;
}


.search-box:hover,
.search-box:focus-within {

    border-color: #d4af37;

    box-shadow:
        0 0 45px
        rgba(212,175,55,.16),

        0 25px 70px
        rgba(0,0,0,.5);

    transform:
        translateY(-3px);
}


.search-box > i {

    margin-left: 22px;

    color: #d4af37;

    font-size: 17px;
}


.search-box input {

    flex: 1;

    min-width: 0;

    border: none;

    outline: none;

    background: transparent;

    color: #ffffff;

    font-size: 13px;

    padding: 17px;
}


.search-box input::placeholder {
    color: #888;
}


.search-btn {

    border: none;

    outline: none;

    cursor: pointer;

    background:
        linear-gradient(
            135deg,
            #e2c35d,
            #d4af37
        );

    color: #111;

    font-size: 12px;

    font-weight: 800;

    padding: 16px 28px;

    border-radius: 45px;

    transition:
        .3s ease;

    white-space: nowrap;

    box-shadow:
        0 7px 25px
        rgba(212,175,55,.18);
}


.search-btn:hover {

    background: #ffffff;

    transform:
        scale(1.04);

    box-shadow:
        0 10px 30px
        rgba(212,175,55,.3);
}


/* =========================================================
   RESULTS SECTION
========================================================= */

.results-section {

    width: 92%;

    max-width: 1400px;

    margin: auto;

    padding: 80px 0 110px;
}


/* =========================================================
   SECTION HEADING
========================================================= */

.results-heading {

    display: flex;

    justify-content: space-between;

    align-items: flex-end;

    gap: 25px;

    margin-bottom: 40px;

    padding-bottom: 25px;

    border-bottom:
        1px solid
        rgba(255,255,255,.07);
}


.results-heading h2 {

    font-family:
        "Playfair Display",
        serif;

    font-size:
        clamp(28px, 4vw, 38px);

    line-height: 1.35;

    color: #ffffff;
}


.results-heading h2 span {
    color: #d4af37;
}


.results-heading p {

    color: #999;

    font-size: 11px;

    font-weight: 600;

    white-space: nowrap;

    padding: 9px 15px;

    border-radius: 30px;

    border:
        1px solid
        rgba(212,175,55,.18);

    background:
        rgba(212,175,55,.04);
}


/* =========================================================
   ERROR
========================================================= */

.error-box {

    padding: 18px 20px;

    margin-bottom: 30px;

    border:
        1px solid
        rgba(255,80,80,.25);

    border-radius: 15px;

    background:
        rgba(255,0,0,.04);

    color: #ff8a8a;

    text-align: center;

    font-size: 13px;
}


/* =========================================================
   HOTEL GRID
========================================================= */

.hotel-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 24px;
}


/* =========================================================
   HOTEL CARD
========================================================= */

.hotel-card {

    position: relative;

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            #171717,
            #0d0d0d
        );

    border:
        1px solid
        rgba(212,175,55,.13);

    border-radius: 22px;

    box-shadow:
        0 15px 45px
        rgba(0,0,0,.35);

    transition:
        transform .45s ease,
        border-color .45s ease,
        box-shadow .45s ease;

    animation:
        cardShow .65s ease both;
}


.hotel-card:hover {

    transform:
        translateY(-12px);

    border-color:
        rgba(212,175,55,.55);

    box-shadow:
        0 28px 75px
        rgba(0,0,0,.6),

        0 0 25px
        rgba(212,175,55,.06);
}


/* GOLD LINE */

.hotel-card::after {

    content: "";

    position: absolute;

    left: 10%;

    right: 10%;

    bottom: 0;

    height: 2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d4af37,
            transparent
        );

    transform:
        scaleX(0);

    transition:
        transform .45s ease;
}


.hotel-card:hover::after {

    transform:
        scaleX(1);
}


@keyframes cardShow {

    from {

        opacity: 0;

        transform:
            translateY(25px);
    }

    to {

        opacity: 1;

        transform:
            translateY(0);
    }
}


/* =========================================================
   HOTEL IMAGE
========================================================= */

.hotel-image {

    position: relative;

    height: 235px;

    overflow: hidden;
}


.hotel-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    display: block;

    transition:
        transform .8s ease,
        filter .5s ease;
}


.hotel-card:hover
.hotel-image img {

    transform:
        scale(1.1);

    filter:
        brightness(1.08);
}


/* IMAGE DARK GRADIENT */

.hotel-image::after {

    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.85),
            rgba(0,0,0,.05) 65%
        );

    pointer-events: none;
}


/* =========================================================
   BADGE
========================================================= */

.hotel-badge {

    position: absolute;

    top: 14px;

    left: 14px;

    z-index: 5;

    display: inline-flex;

    align-items: center;

    gap: 6px;

    background:
        rgba(212,175,55,.95);

    color: #111;

    padding: 7px 11px;

    border-radius: 30px;

    font-size: 8px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .8px;

    box-shadow:
        0 7px 20px
        rgba(0,0,0,.3);
}


/* =========================================================
   IMAGE CENTER ICON
========================================================= */

.hotel-image-icon {

    position: absolute;

    right: 15px;

    top: 15px;

    z-index: 5;

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    color: #ffffff;

    background:
        rgba(0,0,0,.45);

    border:
        1px solid
        rgba(255,255,255,.18);

    backdrop-filter:
        blur(10px);

    opacity: 0;

    transform:
        translateY(-8px);

    transition:
        .35s ease;
}


.hotel-card:hover
.hotel-image-icon {

    opacity: 1;

    transform:
        translateY(0);
}


/* =========================================================
   CONTENT
========================================================= */

.hotel-content {

    position: relative;

    padding: 21px;
}


/* HOTEL TITLE */

.hotel-content h3 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 22px;

    color: #ffffff;

    margin-bottom: 9px;

    line-height: 1.3;

    transition:
        color .3s ease;
}


.hotel-card:hover
.hotel-content h3 {

    color: #d4af37;
}


/* LOCATION */

.hotel-location {

    display: flex;

    align-items: center;

    gap: 7px;

    color: #d4af37;

    font-size: 10px;

    font-weight: 600;

    margin-bottom: 13px;
}


.hotel-location i {

    font-size: 11px;
}


/* DESCRIPTION */

.hotel-description {

    color: #929292;

    font-size: 11px;

    line-height: 1.75;

    min-height: 40px;

    display:
        -webkit-box;

    -webkit-line-clamp: 2;

    -webkit-box-orient: vertical;

    overflow: hidden;

    margin-bottom: 18px;
}


/* =========================================================
   HOTEL INFO
========================================================= */

.hotel-info {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 7px;

    margin-bottom: 18px;
}


.info-item {

    text-align: center;

    padding: 9px 4px;

    border-radius: 10px;

    background:
        rgba(255,255,255,.025);

    border:
        1px solid
        rgba(255,255,255,.06);

    transition:
        .3s ease;
}


.hotel-card:hover
.info-item {

    border-color:
        rgba(212,175,55,.14);

    background:
        rgba(212,175,55,.035);
}


.info-item i {

    display: block;

    color: #d4af37;

    font-size: 11px;

    margin-bottom: 5px;
}


.info-item span {

    color: #777;

    font-size: 8px;

    text-transform: uppercase;

    letter-spacing: .5px;
}


/* =========================================================
   BOTTOM
========================================================= */

.hotel-bottom {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 10px;

    padding-top: 15px;

    border-top:
        1px solid
        rgba(255,255,255,.07);
}


.hotel-price {

    color: #777;

    font-size: 8px;

    line-height: 1.5;

    text-transform: uppercase;

    letter-spacing: .5px;
}


.hotel-price strong {

    display: inline-block;

    color: #d4af37;

    font-size: 14px;

    font-weight: 800;

    margin-bottom: 2px;
}


/* =========================================================
   DETAILS BUTTON
========================================================= */

.details-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    background:
        rgba(212,175,55,.04);

    color: #d4af37;

    border:
        1px solid
        rgba(212,175,55,.42);

    padding: 10px 13px;

    border-radius: 30px;

    font-size: 9px;

    font-weight: 800;

    transition:
        .3s ease;

    white-space: nowrap;
}


.details-btn i {

    transition:
        transform .3s ease;
}


.details-btn:hover {

    background:
        #d4af37;

    color: #111;

    transform:
        translateY(-2px);

    box-shadow:
        0 8px 25px
        rgba(212,175,55,.2);
}


.details-btn:hover i {

    transform:
        translateX(4px);
}


/* =========================================================
   NO RESULTS
========================================================= */

.no-results {

    text-align: center;

    padding: 90px 25px;

    border:
        1px solid
        rgba(212,175,55,.15);

    border-radius: 25px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.015)
        );

    box-shadow:
        0 25px 60px
        rgba(0,0,0,.3);
}


.no-results i {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: 85px;

    height: 85px;

    border-radius: 50%;

    color: #d4af37;

    font-size: 36px;

    border:
        1px solid
        rgba(212,175,55,.25);

    background:
        rgba(212,175,55,.05);

    margin-bottom: 22px;

    animation:
        floatIcon 3s ease-in-out infinite;
}


.no-results h3 {

    font-family:
        "Playfair Display",
        serif;

    font-size: 30px;

    margin-bottom: 12px;
}


.no-results p {

    color: #999;

    font-size: 12px;

    line-height: 1.8;

    max-width: 550px;

    margin:
        0 auto 27px;
}


.no-results strong {

    color: #d4af37;
}


.all-hotels-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background:
        linear-gradient(
            135deg,
            #e2c35d,
            #d4af37
        );

    color: #111;

    padding: 13px 23px;

    border-radius: 30px;

    font-size: 10px;

    font-weight: 800;

    transition:
        .3s ease;
}


.all-hotels-btn:hover {

    background: #ffffff;

    transform:
        translateY(-3px);

    box-shadow:
        0 10px 30px
        rgba(212,175,55,.2);
}


/* =========================================================
   BACK TO TOP
========================================================= */

#topBtn {

    position: fixed;

    right: 25px;

    bottom: 25px;

    width: 48px;

    height: 48px;

    border:
        1px solid
        rgba(212,175,55,.5);

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #e2c35d,
            #d4af37
        );

    color: #111;

    cursor: pointer;

    display: none;

    align-items: center;

    justify-content: center;

    z-index: 5000;

    transition:
        .3s ease;

    box-shadow:
        0 10px 30px
        rgba(0,0,0,.4);
}


#topBtn:hover {

    background: #ffffff;

    transform:
        translateY(-5px);
}


/* =========================================================
   RESPONSIVE 1200
========================================================= */

@media (max-width: 1200px) {

    .hotel-grid {

        grid-template-columns:
            repeat(3, 1fr);
    }
}


/* =========================================================
   RESPONSIVE 900
========================================================= */

@media (max-width: 900px) {

    .hotel-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }

    .search-hero {

        min-height: 450px;
    }
}


/* =========================================================
   RESPONSIVE 700
========================================================= */

@media (max-width: 700px) {

    .search-hero {

        min-height: 440px;

        padding:
            70px 15px;
    }


    .hero-content h1 {

        font-size: 42px;
    }


    .hero-content p {

        font-size: 11px;

        max-width: 500px;
    }


    .search-box {

        border-radius: 22px;

        flex-wrap: wrap;

        padding: 8px;
    }


    .search-box > i {

        margin-left: 12px;
    }


    .search-box input {

        width:
            calc(100% - 50px);

        padding:
            14px 10px;
    }


    .search-btn {

        width: 100%;

        margin-top: 6px;
    }


    .results-section {

        width: 92%;

        padding:
            60px 0 80px;
    }


    .results-heading {

        flex-direction: column;

        align-items: flex-start;

        margin-bottom: 30px;
    }


    .results-heading p {

        white-space: normal;
    }


    .hotel-grid {

        grid-template-columns: 1fr;

        gap: 22px;
    }


    .hotel-image {

        height: 245px;
    }
}


/* =========================================================
   RESPONSIVE 450
========================================================= */

@media (max-width: 450px) {

    .hero-content h1 {

        font-size: 35px;
    }


    .hero-icon {

        width: 65px;

        height: 65px;

        font-size: 24px;
    }


    .hero-content p {

        font-size: 10px;
    }


    .hotel-content h3 {

        font-size: 21px;
    }


    .hotel-bottom {

        align-items: flex-end;
    }


    #topBtn {

        right: 15px;

        bottom: 15px;

        width: 44px;

        height: 44px;
    }
}

</style>

</head>


<body>


<!-- =========================================================
     HEADER
========================================================= -->

<?php

$page_title = "Search";

require_once "header.php";

?>


<!-- =========================================================
     HERO
========================================================= -->

<section class="search-hero">

    <div class="hero-content">


        <div class="hero-icon">

            <i class="fa-solid fa-magnifying-glass"></i>

        </div>


        <h1>

            Find Your

            <span>
                Perfect Stay
            </span>

        </h1>


        <p>

            Search luxury hotels, discover beautiful
            destinations and find your next unforgettable
            experience with Royal Stay.

        </p>


        <!-- SEARCH FORM -->

        <form
            method="GET"
            action="search.php"
            class="search-box"
            id="searchForm"
        >

            <i class="fa-solid fa-location-dot"></i>


            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Search hotel, city or location..."
                autocomplete="off"
            >


            <button
                type="submit"
                class="search-btn"
            >

                <i class="fa-solid fa-search"></i>

                Search

            </button>

        </form>

    </div>

</section>


<!-- =========================================================
     RESULTS
========================================================= -->

<section class="results-section">


    <?php if ($error !== ''): ?>

        <div class="error-box">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars($error) ?>

        </div>

    <?php endif; ?>


    <!-- RESULTS HEADER -->

    <div class="results-heading">

        <div>

            <h2>

                <?php if ($search !== ''): ?>

                    Search Results for

                    <span>
                        "<?= htmlspecialchars($search) ?>"
                    </span>

                <?php else: ?>

                    Explore Our

                    <span>
                        Luxury Hotels
                    </span>

                <?php endif; ?>

            </h2>

        </div>


        <p>

            <i class="fa-solid fa-hotel"></i>

            <?= count($hotels) ?>

            hotel<?= count($hotels) != 1 ? 's' : '' ?>

            found

        </p>

    </div>


    <?php if (!empty($hotels)): ?>


        <!-- =================================================
             HOTEL GRID
        ================================================== -->

        <div class="hotel-grid">


            <?php foreach ($hotels as $index => $hotel): ?>


                <?php

                $hotelImage =
                    !empty($hotel['image'])
                    ? $hotel['image']
                    : 'assets/images/hotel.jpg';


                $hotelName =
                    $hotel['name']
                    ?? 'Royal Stay Hotel';


                $hotelLocation =
                    $hotel['location']
                    ?? 'Pakistan';


                $hotelDescription =
                    !empty($hotel['description'])
                    ? $hotel['description']
                    : 'Experience comfort, luxury and unforgettable hospitality at Royal Stay.';

                ?>


                <!-- HOTEL CARD -->

                <article
                    class="hotel-card"
                    style="
                        animation-delay:
                        <?= $index * 0.08 ?>s;
                    "
                >


                    <!-- IMAGE -->

                    <div class="hotel-image">


                        <span class="hotel-badge">

                            <i class="fa-solid fa-crown"></i>

                            Luxury

                        </span>


                        <div class="hotel-image-icon">

                            <i class="fa-solid fa-heart"></i>

                        </div>


                        <img
                            src="<?= htmlspecialchars($hotelImage) ?>"
                            alt="<?= htmlspecialchars($hotelName) ?>"
                            loading="lazy"
                            onerror="
                                this.onerror=null;
                                this.src='assets/images/hotel.jpg';
                            "
                        >

                    </div>


                    <!-- CONTENT -->

                    <div class="hotel-content">


                        <!-- NAME -->

                        <h3>

                            <?= htmlspecialchars($hotelName) ?>

                        </h3>


                        <!-- LOCATION -->

                        <div class="hotel-location">

                            <i class="fa-solid fa-location-dot"></i>

                            <?= htmlspecialchars($hotelLocation) ?>

                        </div>


                        <!-- DESCRIPTION -->

                        <p class="hotel-description">

                            <?= htmlspecialchars($hotelDescription) ?>

                        </p>


                        <!-- EXTRA INFO -->

                        <div class="hotel-info">


                            <div class="info-item">

                                <i class="fa-solid fa-wifi"></i>

                                <span>
                                    Free WiFi
                                </span>

                            </div>


                            <div class="info-item">

                                <i class="fa-solid fa-bed"></i>

                                <span>
                                    Luxury Room
                                </span>

                            </div>


                            <div class="info-item">

                                <i class="fa-solid fa-star"></i>

                                <span>
                                    Premium
                                </span>

                            </div>


                        </div>


                        <!-- BOTTOM -->

                        <div class="hotel-bottom">


                            <div class="hotel-price">

                                <strong>
                                    Royal Stay
                                </strong>

                                <br>

                                Luxury Experience

                            </div>


                            <a
                                href="hotel-details.php?id=<?= urlencode($hotel['id']) ?>"
                                class="details-btn"
                            >

                                View Details

                                <i class="fa-solid fa-arrow-right"></i>

                            </a>


                        </div>


                    </div>


                </article>


            <?php endforeach; ?>


        </div>


    <?php else: ?>


        <!-- =================================================
             NO RESULTS
        ================================================== -->

        <div class="no-results">


            <i class="fa-solid fa-hotel"></i>


            <h3>

                No Hotels Found

            </h3>


            <p>

                <?php if ($search !== ''): ?>

                    We couldn't find any hotel matching

                    <strong>
                        "<?= htmlspecialchars($search) ?>"
                    </strong>.

                    Try another hotel name, city or location.

                <?php else: ?>

                    There are currently no hotels available.

                    Please check again later.

                <?php endif; ?>

            </p>


            <a
                href="hotels.php"
                class="all-hotels-btn"
            >

                <i class="fa-solid fa-hotel"></i>

                View All Hotels

            </a>


        </div>


    <?php endif; ?>


</section>


<!-- =========================================================
     BACK TO TOP
========================================================= -->

<button
    id="topBtn"
    type="button"
    aria-label="Back to top"
>

    <i class="fa-solid fa-arrow-up"></i>

</button>


<!-- =========================================================
     FOOTER
========================================================= -->

<?php
require_once "footer.php";
?>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /*
        |--------------------------------------------------------------------------
        | BACK TO TOP
        |--------------------------------------------------------------------------
        */

        const topBtn =
            document.getElementById("topBtn");


        window.addEventListener(
            "scroll",
            function () {

                if (!topBtn) {
                    return;
                }


                if (window.scrollY > 250) {

                    topBtn.style.display =
                        "flex";

                } else {

                    topBtn.style.display =
                        "none";

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | BACK TO TOP CLICK
        |--------------------------------------------------------------------------
        */

        if (topBtn) {

            topBtn.addEventListener(
                "click",
                function () {

                    window.scrollTo({

                        top: 0,

                        behavior: "smooth"

                    });

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH INPUT EFFECT
        |--------------------------------------------------------------------------
        */

        const searchInput =
            document.querySelector(
                ".search-box input"
            );


        if (searchInput) {


            searchInput.addEventListener(
                "focus",
                function () {

                    this.parentElement.classList.add(
                        "active"
                    );

                }
            );


            searchInput.addEventListener(
                "blur",
                function () {

                    this.parentElement.classList.remove(
                        "active"
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE FALLBACK
        |--------------------------------------------------------------------------
        */

        const images =
            document.querySelectorAll(
                ".hotel-image img"
            );


        images.forEach(
            function (image) {

                image.addEventListener(
                    "error",
                    function () {

                        this.src =
                            "assets/images/hotel.jpg";

                    }
                );

            }
        );

    }
);

</script>


</body>

</html>