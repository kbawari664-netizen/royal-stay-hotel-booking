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


/*
|--------------------------------------------------------------------------
| Get Booking ID
|--------------------------------------------------------------------------
*/

$booking_id = 0;

if (isset($_GET['booking_id'])) {
    $booking_id = (int) $_GET['booking_id'];
} elseif (isset($_GET['id'])) {
    $booking_id = (int) $_GET['id'];
} elseif (isset($_GET['booking'])) {
    $booking_id = (int) $_GET['booking'];
}


/*
|--------------------------------------------------------------------------
| Validate Booking ID
|--------------------------------------------------------------------------
*/

if ($booking_id <= 0) {
    die("
        <!DOCTYPE html>
        <html>
        <head>
            <title>Booking Not Found</title>
            <style>
                body{
                    margin:0;
                    background:#070707;
                    color:#fff;
                    font-family:Arial,sans-serif;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    min-height:100vh;
                }

                .error-box{
                    width:90%;
                    max-width:500px;
                    text-align:center;
                    padding:45px 30px;
                    border:1px solid #d4af37;
                    border-radius:20px;
                    background:#111;
                    box-shadow:0 0 40px rgba(212,175,55,.15);
                }

                h1{
                    color:#d4af37;
                }

                a{
                    display:inline-block;
                    margin-top:20px;
                    padding:12px 25px;
                    background:#d4af37;
                    color:#000;
                    text-decoration:none;
                    border-radius:30px;
                    font-weight:bold;
                }
            </style>
        </head>

        <body>

            <div class='error-box'>
                <h1>Booking Not Found</h1>
                <p>Sorry, your booking could not be found.</p>
                <a href='index.php'>Back to Home</a>
            </div>

        </body>
        </html>
    ");
}


/*
|--------------------------------------------------------------------------
| Get Booking Information
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        bookings.*,

        users.name AS user_name,
        users.email AS user_email,
        users.phone AS user_phone

    FROM bookings

    LEFT JOIN users
        ON bookings.user_id = users.id

    WHERE bookings.id = ?
    AND bookings.user_id = ?

    LIMIT 1
");

$stmt->execute([
    $booking_id,
    $_SESSION['user_id']
]);

$booking = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Booking Not Found
|--------------------------------------------------------------------------
*/

if (!$booking) {

    die("
        <!DOCTYPE html>
        <html>

        <head>

            <title>Booking Not Found</title>

            <style>

                body{
                    margin:0;
                    background:#070707;
                    color:#fff;
                    font-family:Arial,sans-serif;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    min-height:100vh;
                }

                .error-box{
                    width:90%;
                    max-width:500px;
                    text-align:center;
                    padding:45px 30px;
                    border:1px solid #d4af37;
                    border-radius:20px;
                    background:#111;
                    box-shadow:0 0 50px rgba(212,175,55,.18);
                }

                .error-icon{
                    font-size:60px;
                    color:#d4af37;
                    margin-bottom:15px;
                }

                h1{
                    color:#d4af37;
                }

                a{
                    display:inline-block;
                    margin-top:20px;
                    padding:13px 28px;
                    background:#d4af37;
                    color:#000;
                    text-decoration:none;
                    border-radius:30px;
                    font-weight:bold;
                }

            </style>

        </head>

        <body>

            <div class='error-box'>

                <div class='error-icon'>
                    !
                </div>

                <h1>Booking Not Found</h1>

                <p>
                    This booking does not exist or does not belong to your account.
                </p>

                <a href='index.php'>
                    Back to Home
                </a>

            </div>

        </body>

        </html>
    ");

}


/*
|--------------------------------------------------------------------------
| Room Information
|--------------------------------------------------------------------------
*/

$roomTypes = [
    "Superior Room",
    "Grand Deluxe Room",
    "Deluxe Room",
    "Luxury Room",
    "Executive Room",
    "Premium Room",
    "Royal Suite",
    "Presidential Suite"
];

$roomPrices = [
    7500,
    8500,
    10000,
    12000,
    13500,
    15000,
    18000,
    25000
];

$roomImages = [

    "https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1400&q=80",

    "https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1400&q=80"
];


/*
|--------------------------------------------------------------------------
| Get Room ID
|--------------------------------------------------------------------------
*/

$room_id = (int) $booking['room_id'];


/*
|--------------------------------------------------------------------------
| Validate Room
|--------------------------------------------------------------------------
*/

if ($room_id < 135 || $room_id > 178) {

    $roomType = "Hotel Room";
    $roomPrice = (float) $booking['total_price'];
    $roomImage = $roomImages[0];

} else {

    $index = $room_id - 135;

    $typeIndex = $index % count($roomTypes);

    $imageIndex = $index % count($roomImages);

    $roomType = $roomTypes[$typeIndex];

    $roomPrice = $roomPrices[$typeIndex];

    $roomImage = $roomImages[$imageIndex];
}


/*
|--------------------------------------------------------------------------
| Hotel Information
|--------------------------------------------------------------------------
*/

$hotelName = "Royal Grand Hotel";

$hotelLocation = "Karachi, Pakistan";


/*
|--------------------------------------------------------------------------
| Booking Details
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
*/

$totalPrice = (float) $booking['total_price'];


/*
|--------------------------------------------------------------------------
| Confirmation Number
|--------------------------------------------------------------------------
*/

$confirmationNumber =
    "RS-" .
    date("Y") .
    "-" .
    str_pad($booking_id, 6, "0", STR_PAD_LEFT);


/*
|--------------------------------------------------------------------------
| Booking Status
|--------------------------------------------------------------------------
*/

$status = $booking['status'];


/*
|--------------------------------------------------------------------------
| Guest Information
|--------------------------------------------------------------------------
*/

$guestName = htmlspecialchars(
    $booking['guest_name'] ?? $booking['user_name'] ?? 'Guest'
);

$guestEmail = htmlspecialchars(
    $booking['email'] ?? $booking['user_email'] ?? ''
);

$guestPhone = htmlspecialchars(
    $booking['phone'] ?? $booking['user_phone'] ?? ''
);


/*
|--------------------------------------------------------------------------
| Safe Output
|--------------------------------------------------------------------------
*/

$roomTypeSafe = htmlspecialchars($roomType);

$hotelNameSafe = htmlspecialchars($hotelName);

$hotelLocationSafe = htmlspecialchars($hotelLocation);

$statusSafe = htmlspecialchars($status);

$confirmationSafe = htmlspecialchars($confirmationNumber);

$roomNumber = "R-" . $room_id;

$page_title = "Booking Confirmed";

require_once "header.php";

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
    Booking Confirmed - Royal Stay
</title>


<!-- Google Fonts -->

<link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


/* =========================================================
   BODY
========================================================= */

body{

    min-height:100vh;

    font-family:'Montserrat', sans-serif;

    color:#fff;

    background:

        radial-gradient(
            circle at 50% 0%,
            rgba(212,175,55,.14),
            transparent 32%
        ),

        radial-gradient(
            circle at 0% 100%,
            rgba(212,175,55,.08),
            transparent 30%
        ),

        radial-gradient(
            circle at 100% 70%,
            rgba(212,175,55,.06),
            transparent 30%
        ),

        #060606;

    overflow-x:hidden;

}


/* =========================================================
   GOLD FLOATING LIGHT
========================================================= */

body::before{

    content:"";

    position:fixed;

    width:500px;
    height:500px;

    left:-250px;
    top:30%;

    background:rgba(212,175,55,.06);

    border-radius:50%;

    filter:blur(80px);

    pointer-events:none;

    animation:
        floatingLight 8s ease-in-out infinite;

}


body::after{

    content:"";

    position:fixed;

    width:450px;
    height:450px;

    right:-220px;
    bottom:0;

    background:rgba(212,175,55,.05);

    border-radius:50%;

    filter:blur(80px);

    pointer-events:none;

    animation:
        floatingLight2 10s ease-in-out infinite;

}


@keyframes floatingLight{

    0%{
        transform:translateY(0) scale(1);
    }

    50%{
        transform:translateY(-60px) scale(1.1);
    }

    100%{
        transform:translateY(0) scale(1);
    }

}


@keyframes floatingLight2{

    0%{
        transform:translateY(0) scale(1);
    }

    50%{
        transform:translateY(50px) scale(1.12);
    }

    100%{
        transform:translateY(0) scale(1);
    }

}


/* =========================================================
   MAIN WRAPPER
========================================================= */

.confirmation-wrapper{

    width:100%;

    max-width:1150px;

    margin:0 auto;

    padding:70px 20px 90px;

    position:relative;

    z-index:2;

}


/* =========================================================
   PAGE TITLE
========================================================= */

.page-heading{

    text-align:center;

    margin-bottom:45px;

    animation:
        titleEnter 1s ease forwards;

}


.page-heading .crown{

    width:75px;
    height:75px;

    margin:0 auto 18px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:30px;

    color:#d4af37;

    border:1px solid rgba(212,175,55,.45);

    background:
        radial-gradient(
            circle,
            rgba(212,175,55,.15),
            rgba(0,0,0,.8)
        );

    box-shadow:
        0 0 20px rgba(212,175,55,.15),
        inset 0 0 20px rgba(212,175,55,.08);

    animation:
        crownGlow 3s ease-in-out infinite;

}


.page-heading h1{

    font-family:'Playfair Display', serif;

    font-size:48px;

    font-weight:700;

    margin-bottom:12px;

    background:
        linear-gradient(
            90deg,
            #fff,
            #d4af37,
            #fff,
            #d4af37
        );

    background-size:300% auto;

    -webkit-background-clip:text;

    -webkit-text-fill-color:transparent;

    animation:
        goldText 5s linear infinite;

}


.page-heading p{

    color:#aaa;

    font-size:15px;

}


/* =========================================================
   SUCCESS AREA
========================================================= */

.success-area{

    text-align:center;

    margin-bottom:35px;

    animation:
        successPop .8s ease forwards;

}


.success-circle{

    width:105px;
    height:105px;

    margin:0 auto 22px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    position:relative;

    background:

        radial-gradient(
            circle,
            rgba(212,175,55,.18),
            rgba(212,175,55,.03)
        );

    border:2px solid #d4af37;

    box-shadow:

        0 0 25px rgba(212,175,55,.35),

        0 0 70px rgba(212,175,55,.12),

        inset 0 0 25px rgba(212,175,55,.12);

    animation:
        successGlow 2.5s ease-in-out infinite;

}


.success-circle::before{

    content:"";

    position:absolute;

    width:125px;
    height:125px;

    border:1px solid rgba(212,175,55,.35);

    border-radius:50%;

    animation:
        ringPulse 2s ease-out infinite;

}


.success-circle i{

    color:#d4af37;

    font-size:48px;

    animation:
        checkAppear .8s ease .2s forwards;

    opacity:0;

}


.success-area h2{

    font-family:'Playfair Display', serif;

    font-size:32px;

    color:#fff;

    margin-bottom:10px;

}


.success-area p{

    color:#999;

    font-size:14px;

}


/* =========================================================
   MAIN CARD
========================================================= */

.confirmation-card{

    position:relative;

    overflow:hidden;

    background:

        linear-gradient(
            145deg,
            rgba(25,25,25,.96),
            rgba(10,10,10,.98)
        );

    border:1px solid rgba(212,175,55,.28);

    border-radius:25px;

    box-shadow:

        0 25px 80px rgba(0,0,0,.65),

        0 0 40px rgba(212,175,55,.05);

    animation:
        cardEnter 1s ease .2s forwards;

    opacity:0;

}


.confirmation-card::before{

    content:"";

    position:absolute;

    top:0;
    left:-120%;

    width:80%;
    height:100%;

    background:

        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.05),
            transparent
        );

    transform:skewX(-20deg);

    animation:
        cardShine 5s ease-in-out infinite;

    pointer-events:none;

}


@keyframes cardShine{

    0%{
        left:-120%;
    }

    35%{
        left:130%;
    }

    100%{
        left:130%;
    }

}


/* =========================================================
   HOTEL SECTION
========================================================= */

.hotel-section{

    display:grid;

    grid-template-columns:
        1.05fr
        1fr;

    min-height:350px;

}


.hotel-image{

    position:relative;

    min-height:350px;

    overflow:hidden;

}


.hotel-image img{

    width:100%;
    height:100%;

    object-fit:cover;

    display:block;

    transform:scale(1.04);

    animation:
        imageReveal 1.5s ease forwards;

}


.hotel-image::after{

    content:"";

    position:absolute;

    inset:0;

    background:

        linear-gradient(
            90deg,
            transparent 30%,
            rgba(0,0,0,.15),
            #0b0b0b
        );

}


.hotel-image::before{

    content:"";

    position:absolute;

    z-index:2;

    top:0;
    left:-100%;

    width:50%;
    height:100%;

    background:

        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.16),
            transparent
        );

    transform:skewX(-20deg);

    animation:
        imageLight 5s ease-in-out infinite;

}


@keyframes imageLight{

    0%{
        left:-100%;
    }

    40%{
        left:150%;
    }

    100%{
        left:150%;
    }

}


.hotel-info{

    padding:40px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    animation:
        detailsEnter 1s ease .5s forwards;

    opacity:0;

}


.hotel-label{

    color:#d4af37;

    text-transform:uppercase;

    font-size:11px;

    letter-spacing:3px;

    margin-bottom:10px;

}


.hotel-info h3{

    font-family:'Playfair Display', serif;

    font-size:32px;

    margin-bottom:8px;

}


.hotel-location{

    color:#999;

    margin-bottom:25px;

}


.hotel-location i{

    color:#d4af37;

    margin-right:7px;

}


/* =========================================================
   ROOM DETAILS
========================================================= */

.room-badge{

    display:inline-flex;

    align-items:center;

    width:max-content;

    padding:8px 15px;

    border:1px solid rgba(212,175,55,.35);

    border-radius:30px;

    color:#d4af37;

    font-size:12px;

    margin-bottom:22px;

    background:rgba(212,175,55,.05);

}


.room-badge i{

    margin-right:7px;

}


.room-title{

    font-family:'Playfair Display', serif;

    font-size:25px;

    margin-bottom:15px;

}


.room-number{

    color:#888;

    font-size:13px;

}


/* =========================================================
   INFO GRID
========================================================= */

.info-grid{

    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:15px;

    padding:35px;

    border-top:1px solid rgba(255,255,255,.07);

}


.info-box{

    position:relative;

    padding:22px;

    border-radius:16px;

    background:rgba(255,255,255,.025);

    border:1px solid rgba(255,255,255,.06);

    transition:
        transform .3s ease,
        border-color .3s ease,
        box-shadow .3s ease;

}


.info-box:hover{

    transform:translateY(-6px);

    border-color:rgba(212,175,55,.45);

    box-shadow:
        0 10px 30px rgba(0,0,0,.3),
        0 0 20px rgba(212,175,55,.06);

}


.info-box i{

    color:#d4af37;

    font-size:18px;

    margin-bottom:10px;

}


.info-box span{

    display:block;

    color:#777;

    font-size:11px;

    text-transform:uppercase;

    letter-spacing:1px;

    margin-bottom:6px;

}


.info-box strong{

    color:#eee;

    font-size:14px;

    word-break:break-word;

}


/* =========================================================
   CONFIRMATION NUMBER
========================================================= */

.confirmation-number{

    margin:0 35px 25px;

    padding:20px;

    text-align:center;

    border-radius:15px;

    border:1px dashed rgba(212,175,55,.45);

    background:rgba(212,175,55,.035);

}


.confirmation-number span{

    display:block;

    color:#777;

    text-transform:uppercase;

    letter-spacing:2px;

    font-size:10px;

    margin-bottom:8px;

}


.confirmation-number strong{

    font-size:22px;

    letter-spacing:2px;

    color:#d4af37;

    display:inline-block;

    animation:
        numberShine 3s ease-in-out infinite;

}


@keyframes numberShine{

    0%,100%{
        text-shadow:
            0 0 0 rgba(212,175,55,0);
    }

    50%{
        text-shadow:
            0 0 18px rgba(212,175,55,.6);
    }

}


/* =========================================================
   STATUS
========================================================= */

.status{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 15px;

    border-radius:30px;

    background:rgba(212,175,55,.08);

    color:#d4af37;

    border:1px solid rgba(212,175,55,.25);

    font-size:11px;

    text-transform:uppercase;

    letter-spacing:1px;

    animation:
        statusGlow 2s ease-in-out infinite;

}


.status::before{

    content:"";

    width:7px;
    height:7px;

    margin-right:8px;

    border-radius:50%;

    background:#d4af37;

    box-shadow:
        0 0 10px #d4af37;

}


@keyframes statusGlow{

    0%,100%{
        box-shadow:
            0 0 0 rgba(212,175,55,0);
    }

    50%{
        box-shadow:
            0 0 18px rgba(212,175,55,.15);
    }

}


/* =========================================================
   PRICE SECTION
========================================================= */

.price-section{

    margin:0 35px 30px;

    padding:25px;

    border-radius:18px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    background:

        linear-gradient(
            135deg,
            rgba(212,175,55,.08),
            rgba(212,175,55,.02)
        );

    border:1px solid rgba(212,175,55,.18);

}


.price-label{

    color:#aaa;

    font-size:13px;

}


.price-label small{

    display:block;

    color:#666;

    margin-top:5px;

}


.price-value{

    text-align:right;

}


.price-value span{

    display:block;

    color:#777;

    font-size:10px;

    text-transform:uppercase;

    letter-spacing:1px;

}


.price-value strong{

    color:#d4af37;

    font-size:30px;

    font-weight:700;

    animation:
        priceGlow 2.5s ease-in-out infinite;

}


@keyframes priceGlow{

    0%,100%{
        text-shadow:
            0 0 0 rgba(212,175,55,0);
    }

    50%{
        text-shadow:
            0 0 20px rgba(212,175,55,.45);
    }

}


/* =========================================================
   BUTTONS
========================================================= */

.action-buttons{

    display:flex;

    gap:15px;

    padding:0 35px 35px;

    animation:
        bottomEnter 1s ease .8s forwards;

    opacity:0;

}


.btn{

    position:relative;

    overflow:hidden;

    flex:1;

    padding:15px 20px;

    border-radius:12px;

    text-decoration:none;

    text-align:center;

    font-weight:600;

    font-size:13px;

    transition:
        transform .3s ease,
        box-shadow .3s ease;

}


.btn:hover{

    transform:translateY(-4px);

}


.btn::before{

    content:"";

    position:absolute;

    top:0;
    left:-120%;

    width:70%;
    height:100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.3),
            transparent
        );

    transform:skewX(-20deg);

    transition:.6s;

}


.btn:hover::before{

    left:140%;

}


.btn-primary{

    background:#d4af37;

    color:#080808;

    box-shadow:
        0 8px 25px rgba(212,175,55,.15);

}


.btn-primary:hover{

    box-shadow:
        0 12px 35px rgba(212,175,55,.35);

}


.btn-secondary{

    background:#171717;

    color:#ddd;

    border:1px solid rgba(255,255,255,.1);

}


.btn-secondary:hover{

    border-color:rgba(212,175,55,.5);

    color:#d4af37;

}


/* =========================================================
   FLOATING STARS
========================================================= */

.star{

    position:fixed;

    width:3px;
    height:3px;

    background:#d4af37;

    border-radius:50%;

    opacity:.4;

    pointer-events:none;

    z-index:1;

}


.star-1{

    top:20%;
    left:8%;

    animation:
        starMove 5s ease-in-out infinite;

}


.star-2{

    top:70%;
    left:15%;

    animation:
        starMove 7s ease-in-out infinite 1s;

}


.star-3{

    top:35%;
    right:10%;

    animation:
        starMove 6s ease-in-out infinite 2s;

}


.star-4{

    top:80%;
    right:18%;

    animation:
        starMove 8s ease-in-out infinite 1.5s;

}


@keyframes starMove{

    0%,100%{

        transform:
            translateY(0)
            scale(1);

        opacity:.2;

    }

    50%{

        transform:
            translateY(-25px)
            scale(1.8);

        opacity:.8;

    }

}


/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes titleEnter{

    from{

        opacity:0;

        transform:
            translateY(-25px);

    }

    to{

        opacity:1;

        transform:
            translateY(0);

    }

}


@keyframes crownGlow{

    0%,100%{

        box-shadow:
            0 0 20px rgba(212,175,55,.15),
            inset 0 0 20px rgba(212,175,55,.08);

    }

    50%{

        box-shadow:
            0 0 35px rgba(212,175,55,.4),
            inset 0 0 30px rgba(212,175,55,.15);

    }

}


@keyframes successPop{

    0%{

        opacity:0;

        transform:
            scale(.8)
            translateY(20px);

    }

    100%{

        opacity:1;

        transform:
            scale(1)
            translateY(0);

    }

}


@keyframes checkAppear{

    0%{

        opacity:0;

        transform:
            scale(.2)
            rotate(-30deg);

    }

    70%{

        opacity:1;

        transform:
            scale(1.2)
            rotate(5deg);

    }

    100%{

        opacity:1;

        transform:
            scale(1)
            rotate(0);

    }

}


@keyframes successGlow{

    0%,100%{

        box-shadow:
            0 0 25px rgba(212,175,55,.25),
            0 0 60px rgba(212,175,55,.08);

    }

    50%{

        box-shadow:
            0 0 40px rgba(212,175,55,.55),
            0 0 90px rgba(212,175,55,.18);

    }

}


@keyframes ringPulse{

    0%{

        opacity:.8;

        transform:
            scale(.85);

    }

    100%{

        opacity:0;

        transform:
            scale(1.45);

    }

}


@keyframes goldText{

    0%{

        background-position:0% center;

    }

    100%{

        background-position:300% center;

    }

}


@keyframes cardEnter{

    from{

        opacity:0;

        transform:
            translateY(40px)
            scale(.97);

    }

    to{

        opacity:1;

        transform:
            translateY(0)
            scale(1);

    }

}


@keyframes imageReveal{

    from{

        opacity:0;

        transform:scale(1.15);

    }

    to{

        opacity:1;

        transform:scale(1.04);

    }

}


@keyframes detailsEnter{

    from{

        opacity:0;

        transform:
            translateX(30px);

    }

    to{

        opacity:1;

        transform:
            translateX(0);

    }

}


@keyframes bottomEnter{

    from{

        opacity:0;

        transform:
            translateY(20px);

    }

    to{

        opacity:1;

        transform:
            translateY(0);

    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:850px){

    .hotel-section{

        grid-template-columns:1fr;

    }


    .hotel-image{

        min-height:280px;

    }


    .hotel-info{

        padding:30px;

    }

}


@media(max-width:600px){

    .confirmation-wrapper{

        padding:
            45px
            12px
            60px;

    }


    .page-heading h1{

        font-size:35px;

    }


    .success-circle{

        width:90px;
        height:90px;

    }


    .success-circle i{

        font-size:38px;

    }


    .hotel-image{

        min-height:230px;

    }


    .hotel-info{

        padding:25px;

    }


    .hotel-info h3{

        font-size:26px;

    }


    .info-grid{

        grid-template-columns:1fr;

        padding:25px;

    }


    .confirmation-number{

        margin:
            0 25px 20px;

    }


    .price-section{

        margin:
            0 25px 25px;

        flex-direction:column;

        align-items:flex-start;

        gap:15px;

    }


    .price-value{

        text-align:left;

    }


    .action-buttons{

        flex-direction:column;

        padding:
            0 25px 25px;

    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){

    *,
    *::before,
    *::after{

        animation-duration:.01ms !important;

        animation-iteration-count:1 !important;

        transition-duration:.01ms !important;

    }

}

</style>

</head>


<body>


<!-- Floating Stars -->

<div class="star star-1"></div>

<div class="star star-2"></div>

<div class="star star-3"></div>

<div class="star star-4"></div>


<!-- =====================================================
     MAIN
===================================================== -->

<main class="confirmation-wrapper">


    <!-- PAGE HEADING -->

    <div class="page-heading">

        <div class="crown">

            <i class="fa-solid fa-crown"></i>

        </div>

        <h1>Booking Confirmation</h1>

        <p>
            Your Royal Stay reservation has been received successfully.
        </p>

    </div>


    <!-- SUCCESS -->

    <div class="success-area">

        <div class="success-circle">

            <i class="fa-solid fa-check"></i>

        </div>

        <h2>Booking Successful!</h2>

        <p>
            Thank you for choosing Royal Stay.
        </p>

    </div>


    <!-- CONFIRMATION CARD -->

    <section class="confirmation-card">


        <!-- HOTEL -->

        <div class="hotel-section">


            <!-- IMAGE -->

            <div class="hotel-image">

                <img
                    src="<?= htmlspecialchars($roomImage) ?>"
                    alt="Royal Stay Hotel Room"
                >

            </div>


            <!-- HOTEL INFO -->

            <div class="hotel-info">


                <div class="hotel-label">
                    Your Stay
                </div>


                <h3>
                    <?= $hotelNameSafe ?>
                </h3>


                <div class="hotel-location">

                    <i class="fa-solid fa-location-dot"></i>

                    <?= $hotelLocationSafe ?>

                </div>


                <div class="room-badge">

                    <i class="fa-solid fa-bed"></i>

                    <?= $roomTypeSafe ?>

                </div>


                <div class="room-title">

                    <?= $roomTypeSafe ?>

                </div>


                <div class="room-number">

                    Room Number:
                    <strong>
                        <?= htmlspecialchars($roomNumber) ?>
                    </strong>

                </div>


            </div>

        </div>


        <!-- INFO GRID -->

        <div class="info-grid">


            <!-- Guest -->

            <div class="info-box">

                <i class="fa-solid fa-user"></i>

                <span>
                    Guest Name
                </span>

                <strong>
                    <?= $guestName ?>
                </strong>

            </div>


            <!-- Email -->

            <div class="info-box">

                <i class="fa-solid fa-envelope"></i>

                <span>
                    Email
                </span>

                <strong>
                    <?= $guestEmail ?>
                </strong>

            </div>


            <!-- Phone -->

            <div class="info-box">

                <i class="fa-solid fa-phone"></i>

                <span>
                    Phone
                </span>

                <strong>
                    <?= $guestPhone ?>
                </strong>

            </div>


            <!-- Guests -->

            <div class="info-box">

                <i class="fa-solid fa-users"></i>

                <span>
                    Guests
                </span>

                <strong>
                    <?= (int)$booking['guests'] ?>
                    Guest(s)
                </strong>

            </div>


            <!-- Check In -->

            <div class="info-box">

                <i class="fa-solid fa-calendar-check"></i>

                <span>
                    Check-In
                </span>

                <strong>
                    <?= $checkIn->format("d M Y") ?>
                </strong>

            </div>


            <!-- Check Out -->

            <div class="info-box">

                <i class="fa-solid fa-calendar-xmark"></i>

                <span>
                    Check-Out
                </span>

                <strong>
                    <?= $checkOut->format("d M Y") ?>
                </strong>

            </div>


            <!-- Nights -->

            <div class="info-box">

                <i class="fa-solid fa-moon"></i>

                <span>
                    Stay Duration
                </span>

                <strong>
                    <?= $nights ?>
                    Night(s)
                </strong>

            </div>


            <!-- Status -->

            <div class="info-box">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    Booking Status
                </span>

                <strong>

                    <span class="status">

                        <?= $statusSafe ?>

                    </span>

                </strong>

            </div>


        </div>


        <!-- CONFIRMATION NUMBER -->

        <div class="confirmation-number">

            <span>
                Confirmation Number
            </span>

            <strong>
                <?= $confirmationSafe ?>
            </strong>

        </div>


        <!-- PRICE -->

        <div class="price-section">


            <div class="price-label">

                Total Booking Amount

                <small>
                    <?= $nights ?> night(s) stay
                </small>

            </div>


            <div class="price-value">

                <span>
                    Total Price
                </span>

                <strong>

                    Rs.
                    <?= number_format($totalPrice, 2) ?>

                </strong>

            </div>


        </div>


        <!-- BUTTONS -->

        <div class="action-buttons">


            <a
                href="index.php"
                class="btn btn-primary"
            >

                <i class="fa-solid fa-house"></i>

                Back to Home

            </a>


            <a
                href="room.php"
                class="btn btn-secondary"
            >

                <i class="fa-solid fa-bed"></i>

                View More Rooms

            </a>


        </div>


    </section>


</main>


</body>

</html>