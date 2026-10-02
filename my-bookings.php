<?php

session_start();

require_once "config/database.php";


/*
|--------------------------------------------------------------------------
| Check Login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}


$user_id = (int) $_SESSION['user_id'];


/*
|--------------------------------------------------------------------------
| Get User Bookings
|--------------------------------------------------------------------------
*/

try {

    $stmt = $pdo->prepare("
        SELECT
            bookings.*,
            rooms.room_number,
            rooms.room_type,
            rooms.price,
            hotels.name AS hotel_name,
            hotels.location AS hotel_location

        FROM bookings

        LEFT JOIN rooms
            ON bookings.room_id = rooms.id

        LEFT JOIN hotels
            ON rooms.hotel_id = hotels.id

        WHERE bookings.user_id = ?

        ORDER BY bookings.id DESC
    ");

    $stmt->execute([$user_id]);

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $bookings = [];

}


/*
|--------------------------------------------------------------------------
| Page Title
|--------------------------------------------------------------------------
*/

$page_title = "My Bookings";

require_once "header.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>My Bookings - Royal Stay</title>


<!-- Google Fonts -->

<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
      rel="stylesheet">


<!-- Font Awesome -->

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>

/* =========================================================
   GLOBAL
========================================================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


body {

    font-family: "Montserrat", sans-serif;

    background:
        radial-gradient(
            circle at top left,
            rgba(212,175,55,0.10),
            transparent 35%
        ),
        radial-gradient(
            circle at bottom right,
            rgba(212,175,55,0.08),
            transparent 35%
        ),
        #080808;

    color: #ffffff;

    min-height: 100vh;

    overflow-x: hidden;
}


/* =========================================================
   GOLD
========================================================= */

:root {

    --gold: #d4af37;

    --gold-light: #f5d76e;

    --gold-dark: #9e7c18;

    --black: #080808;

    --card: #111111;

    --border: rgba(212,175,55,0.25);

}


/* =========================================================
   PAGE
========================================================= */

.my-bookings-page {

    width: 100%;

    min-height: 100vh;

    padding-bottom: 80px;

}


/* =========================================================
   HERO
========================================================= */

.bookings-hero {

    position: relative;

    min-height: 300px;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 60px 20px;

    overflow: hidden;

    background:

        linear-gradient(
            rgba(0,0,0,0.75),
            rgba(0,0,0,0.90)
        ),

        url("assets/images/hotel.jpg");

    background-size: cover;

    background-position: center;

}


/* Golden overlay */

.bookings-hero::before {

    content: "";

    position: absolute;

    inset: 0;

    background:
        radial-gradient(
            circle,
            rgba(212,175,55,0.18),
            transparent 55%
        );

    animation: heroGlow 5s ease-in-out infinite;

}


@keyframes heroGlow {

    0%,100% {
        opacity: .4;
        transform: scale(1);
    }

    50% {
        opacity: .9;
        transform: scale(1.08);
    }

}


.hero-content {

    position: relative;

    z-index: 2;

}


.hero-icon {

    width: 75px;

    height: 75px;

    margin: 0 auto 20px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    color: var(--gold);

    border: 1px solid var(--gold);

    background: rgba(0,0,0,.55);

    box-shadow:

        0 0 15px rgba(212,175,55,.35),

        inset 0 0 15px rgba(212,175,55,.08);

    animation: iconFloat 3s ease-in-out infinite;

}


@keyframes iconFloat {

    0%,100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-8px);
    }

}


.hero-title {

    font-family: "Playfair Display", serif;

    font-size: clamp(38px, 6vw, 65px);

    color: #fff;

    margin-bottom: 12px;

    text-shadow:
        0 0 15px rgba(212,175,55,.25);

}


.hero-title span {

    color: var(--gold);

}


.hero-subtitle {

    color: #cfcfcf;

    font-size: 15px;

    letter-spacing: 1px;

}


/* =========================================================
   CONTAINER
========================================================= */

.bookings-container {

    width: min(1200px, 92%);

    margin: 55px auto 0;

}


/* =========================================================
   TOP BAR
========================================================= */

.bookings-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 30px;

    padding: 22px 25px;

    border: 1px solid var(--border);

    border-radius: 18px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.04),
            rgba(255,255,255,.015)
        );

    backdrop-filter: blur(15px);

    box-shadow:
        0 15px 45px rgba(0,0,0,.35);

}


.booking-count {

    display: flex;

    align-items: center;

    gap: 13px;

}


.booking-count-icon {

    width: 48px;

    height: 48px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    color: var(--gold);

    border: 1px solid var(--border);

    background: rgba(212,175,55,.07);

}


.booking-count strong {

    display: block;

    font-size: 21px;

    color: #fff;

}


.booking-count small {

    color: #999;

}


.gold-text {

    color: var(--gold);

}


/* =========================================================
   BOOKING GRID
========================================================= */

.booking-list {

    display: grid;

    gap: 25px;

}


/* =========================================================
   BOOKING CARD
========================================================= */

.booking-card {

    position: relative;

    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            #151515,
            #0c0c0c
        );

    border: 1px solid rgba(212,175,55,.20);

    border-radius: 22px;

    padding: 28px;

    box-shadow:
        0 20px 55px rgba(0,0,0,.40);

    opacity: 0;

    transform: translateY(35px);

    animation: cardAppear .8s ease forwards;

    animation-delay: var(--delay);

    transition:
        transform .4s ease,
        border-color .4s ease,
        box-shadow .4s ease;

}


@keyframes cardAppear {

    to {

        opacity: 1;

        transform: translateY(0);

    }

}


.booking-card:hover {

    transform: translateY(-7px);

    border-color: rgba(212,175,55,.65);

    box-shadow:
        0 25px 70px rgba(0,0,0,.55),
        0 0 35px rgba(212,175,55,.08);

}


/* shine */

.booking-card::before {

    content: "";

    position: absolute;

    top: 0;

    left: -120%;

    width: 70%;

    height: 100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.06),
            transparent
        );

    transform: skewX(-20deg);

    transition: .8s;

}


.booking-card:hover::before {

    left: 140%;

}


/* =========================================================
   CARD HEADER
========================================================= */

.booking-header {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 20px;

    padding-bottom: 22px;

    border-bottom: 1px solid rgba(255,255,255,.08);

}


.hotel-info {

    display: flex;

    align-items: center;

    gap: 15px;

}


.hotel-icon {

    width: 58px;

    height: 58px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 15px;

    color: var(--gold);

    font-size: 23px;

    background:
        linear-gradient(
            145deg,
            rgba(212,175,55,.18),
            rgba(212,175,55,.04)
        );

    border: 1px solid rgba(212,175,55,.30);

}


.hotel-name {

    font-family: "Playfair Display", serif;

    font-size: 22px;

    color: #fff;

    margin-bottom: 5px;

}


.hotel-location {

    color: #999;

    font-size: 13px;

}


.hotel-location i {

    color: var(--gold);

    margin-right: 5px;

}


/* =========================================================
   STATUS
========================================================= */

.status {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 9px 15px;

    border-radius: 50px;

    font-size: 12px;

    font-weight: 700;

    letter-spacing: .5px;

    text-transform: uppercase;

}


.status-confirmed {

    color: #9ff5b1;

    background: rgba(46,204,113,.10);

    border: 1px solid rgba(46,204,113,.30);

}


.status-pending {

    color: #ffd76a;

    background: rgba(212,175,55,.10);

    border: 1px solid rgba(212,175,55,.30);

    animation: pendingPulse 2s infinite;

}


.status-cancelled {

    color: #ff8b8b;

    background: rgba(231,76,60,.10);

    border: 1px solid rgba(231,76,60,.30);

}


@keyframes pendingPulse {

    0%,100% {
        box-shadow: 0 0 0 rgba(212,175,55,0);
    }

    50% {
        box-shadow: 0 0 18px rgba(212,175,55,.18);
    }

}


/* =========================================================
   BOOKING BODY
========================================================= */

.booking-body {

    padding: 25px 0;

}


.booking-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 15px;

}


.booking-item {

    padding: 17px;

    border-radius: 14px;

    background: rgba(255,255,255,.025);

    border: 1px solid rgba(255,255,255,.06);

    transition: .3s ease;

}


.booking-item:hover {

    border-color: rgba(212,175,55,.25);

    background: rgba(212,175,55,.04);

}


.booking-item i {

    display: block;

    color: var(--gold);

    font-size: 18px;

    margin-bottom: 9px;

}


.booking-item span {

    display: block;

    color: #777;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 5px;

}


.booking-item strong {

    display: block;

    color: #eee;

    font-size: 14px;

}


/* =========================================================
   PRICE
========================================================= */

.price-box {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding-top: 22px;

    border-top: 1px solid rgba(255,255,255,.08);

}


.price-label {

    color: #999;

    font-size: 13px;

}


.price-label i {

    color: var(--gold);

    margin-right: 5px;

}


.price {

    font-size: 27px;

    font-weight: 800;

    color: var(--gold);

    text-shadow:
        0 0 15px rgba(212,175,55,.20);

}


.price small {

    font-size: 12px;

    color: #888;

    font-weight: 400;

}


/* =========================================================
   CARD FOOTER
========================================================= */

.booking-footer {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding-top: 22px;

}


.booking-id {

    color: #777;

    font-size: 12px;

}


.booking-id strong {

    color: #bbb;

}


.btn {

    position: relative;

    overflow: hidden;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 9px;

    min-width: 165px;

    padding: 13px 22px;

    border-radius: 50px;

    text-decoration: none;

    color: #090909;

    background:
        linear-gradient(
            135deg,
            var(--gold-light),
            var(--gold)
        );

    font-size: 13px;

    font-weight: 800;

    border: none;

    box-shadow:
        0 8px 25px rgba(212,175,55,.18);

    transition: .35s ease;

}


.btn:hover {

    color: #000;

    transform: translateY(-3px);

    box-shadow:
        0 12px 35px rgba(212,175,55,.35);

}


.btn::before {

    content: "";

    position: absolute;

    top: 0;

    left: -100%;

    width: 60%;

    height: 100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.55),
            transparent
        );

    transform: skewX(-20deg);

}


.btn:hover::before {

    left: 150%;

    transition: .7s;

}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {

    text-align: center;

    padding: 75px 25px;

    border: 1px solid var(--border);

    border-radius: 22px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.04),
            rgba(255,255,255,.01)
        );

}


.empty-icon {

    width: 85px;

    height: 85px;

    margin: 0 auto 22px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 32px;

    color: var(--gold);

    border: 1px solid var(--border);

    background: rgba(212,175,55,.06);

}


.empty-state h2 {

    font-family: "Playfair Display", serif;

    font-size: 30px;

    margin-bottom: 10px;

}


.empty-state p {

    color: #888;

    margin-bottom: 25px;

}


.empty-state .btn {

    display: inline-flex;

}


/* =========================================================
   BACK TO TOP
========================================================= */

#backToTop {

    position: fixed;

    right: 25px;

    bottom: 25px;

    width: 45px;

    height: 45px;

    border-radius: 50%;

    border: 1px solid var(--gold);

    background: #111;

    color: var(--gold);

    cursor: pointer;

    display: none;

    align-items: center;

    justify-content: center;

    z-index: 999;

    transition: .3s ease;

}


#backToTop:hover {

    background: var(--gold);

    color: #000;

    transform: translateY(-4px);

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .booking-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media (max-width: 650px) {

    .bookings-top {

        flex-direction: column;

        align-items: flex-start;

    }


    .booking-header {

        flex-direction: column;

    }


    .booking-grid {

        grid-template-columns: 1fr;

    }


    .booking-footer {

        flex-direction: column;

        align-items: stretch;

    }


    .btn {

        width: 100%;

    }


    .price-box {

        align-items: flex-start;

        gap: 10px;

        flex-direction: column;

    }


    .booking-card {

        padding: 20px;

    }


    .hero-title {

        font-size: 40px;

    }

}

</style>

</head>


<body>


<div class="my-bookings-page">


    <!-- HERO -->

    <section class="bookings-hero">

        <div class="hero-content">

            <div class="hero-icon">

                <i class="fa-solid fa-calendar-check"></i>

            </div>

            <h1 class="hero-title">

                My <span>Bookings</span>

            </h1>

            <p class="hero-subtitle">

                Manage and view all your Royal Stay reservations

            </p>

        </div>

    </section>



    <!-- CONTENT -->

    <div class="bookings-container">


        <!-- TOP -->

        <div class="bookings-top">

            <div class="booking-count">

                <div class="booking-count-icon">

                    <i class="fa-solid fa-ticket"></i>

                </div>

                <div>

                    <strong>

                        <?= count($bookings) ?>

                        <span class="gold-text">

                            Booking<?= count($bookings) != 1 ? 's' : '' ?>

                        </span>

                    </strong>

                    <small>

                        Your reservation history

                    </small>

                </div>

            </div>

        </div>



        <?php if (!empty($bookings)): ?>


            <div class="booking-list">


                <?php foreach ($bookings as $index => $booking): ?>


                    <?php

                    /*
                    |--------------------------------------------------------------------------
                    | Dates
                    |--------------------------------------------------------------------------
                    */

                    $checkIn = new DateTime($booking['check_in']);

                    $checkOut = new DateTime($booking['check_out']);

                    $nights = $checkIn->diff($checkOut)->days;


                    if ($nights < 1) {
                        $nights = 1;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Total Price
                    |--------------------------------------------------------------------------
                    | IMPORTANT:
                    | Use the total saved during booking.
                    */

                    $total_price = (float) $booking['total_price'];


                    /*
                    |--------------------------------------------------------------------------
                    | Status
                    |--------------------------------------------------------------------------
                    */

                    $status = strtolower(
                        trim($booking['status'] ?? 'pending')
                    );


                    if ($status === 'confirmed') {

                        $statusClass = 'status-confirmed';

                        $statusIcon = 'fa-circle-check';

                    }

                    elseif ($status === 'cancelled') {

                        $statusClass = 'status-cancelled';

                        $statusIcon = 'fa-circle-xmark';

                    }

                    else {

                        $statusClass = 'status-pending';

                        $statusIcon = 'fa-clock';

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Confirmation Number
                    |--------------------------------------------------------------------------
                    */

                    $confirmationNumber =
                        "RS-" .
                        date(
                            "Y",
                            strtotime($booking['created_at'])
                        ) .
                        "-" .
                        str_pad(
                            $booking['id'],
                            6,
                            "0",
                            STR_PAD_LEFT
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Hotel / Room Fallback
                    |--------------------------------------------------------------------------
                    */

                    $hotelName =
                        !empty($booking['hotel_name'])
                        ? $booking['hotel_name']
                        : 'Royal Grand Hotel';


                    $hotelLocation =
                        !empty($booking['hotel_location'])
                        ? $booking['hotel_location']
                        : 'Karachi, Pakistan';


                    $roomType =
                        !empty($booking['room_type'])
                        ? $booking['room_type']
                        : 'Hotel Room';


                    $roomNumber =
                        !empty($booking['room_number'])
                        ? $booking['room_number']
                        : 'R-' . $booking['room_id'];

                    ?>


                    <!-- BOOKING CARD -->

                    <div
                        class="booking-card"
                        style="--delay: <?= $index * 0.12 ?>s;"
                    >


                        <!-- HEADER -->

                        <div class="booking-header">


                            <div class="hotel-info">


                                <div class="hotel-icon">

                                    <i class="fa-solid fa-hotel"></i>

                                </div>


                                <div>

                                    <div class="hotel-name">

                                        <?= htmlspecialchars($hotelName) ?>

                                    </div>


                                    <div class="hotel-location">

                                        <i class="fa-solid fa-location-dot"></i>

                                        <?= htmlspecialchars($hotelLocation) ?>

                                    </div>

                                </div>


                            </div>



                            <div class="status <?= $statusClass ?>">

                                <i class="fa-solid <?= $statusIcon ?>"></i>

                                <?= htmlspecialchars(
                                    ucfirst($status)
                                ) ?>

                            </div>


                        </div>



                        <!-- BODY -->

                        <div class="booking-body">


                            <div class="booking-grid">


                                <!-- Room -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-bed"></i>

                                    <span>Room Type</span>

                                    <strong>

                                        <?= htmlspecialchars($roomType) ?>

                                    </strong>

                                </div>


                                <!-- Room Number -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-door-open"></i>

                                    <span>Room Number</span>

                                    <strong>

                                        <?= htmlspecialchars($roomNumber) ?>

                                    </strong>

                                </div>


                                <!-- Check In -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-calendar-plus"></i>

                                    <span>Check In</span>

                                    <strong>

                                        <?= $checkIn->format("d M Y") ?>

                                    </strong>

                                </div>


                                <!-- Check Out -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-calendar-minus"></i>

                                    <span>Check Out</span>

                                    <strong>

                                        <?= $checkOut->format("d M Y") ?>

                                    </strong>

                                </div>


                                <!-- Guests -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-users"></i>

                                    <span>Guests</span>

                                    <strong>

                                        <?= (int) $booking['guests'] ?>

                                        Guest<?= $booking['guests'] != 1 ? 's' : '' ?>

                                    </strong>

                                </div>


                                <!-- Nights -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-moon"></i>

                                    <span>Nights</span>

                                    <strong>

                                        <?= $nights ?>

                                        Night<?= $nights != 1 ? 's' : '' ?>

                                    </strong>

                                </div>


                                <!-- Booking Date -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-clock-rotate-left"></i>

                                    <span>Booked On</span>

                                    <strong>

                                        <?= date(
                                            "d M Y",
                                            strtotime($booking['created_at'])
                                        ) ?>

                                    </strong>

                                </div>


                                <!-- Confirmation -->

                                <div class="booking-item">

                                    <i class="fa-solid fa-hashtag"></i>

                                    <span>Confirmation</span>

                                    <strong>

                                        <?= htmlspecialchars($confirmationNumber) ?>

                                    </strong>

                                </div>


                            </div>


                        </div>



                        <!-- PRICE -->

                        <div class="price-box">


                            <div class="price-label">

                                <i class="fa-solid fa-crown"></i>

                                Total Booking Amount

                            </div>


                            <div class="price">

                                Rs.

                                <?= number_format(
                                    $total_price,
                                    2
                                ) ?>

                                <small>

                                    / total

                                </small>

                            </div>


                        </div>



                        <!-- FOOTER -->

                        <div class="booking-footer">


                            <div class="booking-id">

                                Booking ID:

                                <strong>

                                    #<?= (int) $booking['id'] ?>

                                </strong>

                            </div>


                            <a
                                class="btn"
                                href="booking-confirmation.php?id=<?= urlencode($booking['id']) ?>"
                            >

                                <i class="fa-solid fa-eye"></i>

                                View Booking

                            </a>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- EMPTY -->

            <div class="empty-state">


                <div class="empty-icon">

                    <i class="fa-solid fa-calendar-xmark"></i>

                </div>


                <h2>

                    No Bookings Yet

                </h2>


                <p>

                    You don't have any hotel reservations yet.

                    Start your Royal Stay experience today.

                </p>


                <a
                    href="hotels.php"
                    class="btn"
                >

                    <i class="fa-solid fa-hotel"></i>

                    Browse Hotels

                </a>


            </div>


        <?php endif; ?>


    </div>

</div>



<!-- BACK TO TOP -->

<button id="backToTop">

    <i class="fa-solid fa-arrow-up"></i>

</button>



<script>

/*
|--------------------------------------------------------------------------
| Loader
|--------------------------------------------------------------------------
*/

window.addEventListener("load", function () {

    const loader =
        document.getElementById("loader");

    if (loader) {

        loader.style.opacity = "0";

        loader.style.visibility = "hidden";

        setTimeout(function () {

            loader.remove();

        }, 600);

    }

});


/*
|--------------------------------------------------------------------------
| Back To Top
|--------------------------------------------------------------------------
*/

const backToTop =
    document.getElementById("backToTop");


window.addEventListener("scroll", function () {

    if (window.scrollY > 350) {

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

</script>


<?php
require_once "footer.php";
?>

</body>

</html>