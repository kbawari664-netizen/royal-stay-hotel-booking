<?php

/*
|--------------------------------------------------------------------------
| START SESSION
|--------------------------------------------------------------------------
| The session must start before any HTML/output is sent to the browser.
| This fixes the "Session cannot be started after headers have already
| been sent" warning from header.php.
|--------------------------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/*
|--------------------------------------------------------------------------
| PAGE TITLE
|--------------------------------------------------------------------------
*/
$page_title = "Hotels";


/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/
require_once "config/database.php";

/*
|--------------------------------------------------------------------------
| Get Hotels From Database
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("SELECT * FROM hotels ORDER BY id DESC");
$stmt->execute();

$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Hotel Images
|--------------------------------------------------------------------------
*/

$hotelImages = [

    "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1601918774946-25832a4be0d6?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1596436889106-be35e843f04b?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1563911302283-d2bc129e7570?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1562790351-d273a961e0e9?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1568084680786-a84f91d5892a?auto=format&fit=crop&w=900&q=80",

    "https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=900&q=80"

];


/*
|--------------------------------------------------------------------------
| Fallback Image
|--------------------------------------------------------------------------
*/

$fallbackImage =
    "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=900&q=80";


/*
|--------------------------------------------------------------------------
| 44 Demo Hotels
|--------------------------------------------------------------------------
*/

$demoHotels = [

    [
        "id" => 101,
        "name" => "Royal Palace Hotel",
        "location" => "Karachi",
        "description" => "A luxurious hotel with elegant rooms and premium facilities.",
        "phone" => "+92 300 1111111",
        "email" => "royalpalace@example.com"
    ],

    [
        "id" => 102,
        "name" => "Golden Crown Hotel",
        "location" => "Lahore",
        "description" => "Modern rooms, excellent service and a peaceful environment.",
        "phone" => "+92 300 2222222",
        "email" => "goldencrown@example.com"
    ],

    [
        "id" => 103,
        "name" => "Pearl Grand Hotel",
        "location" => "Islamabad",
        "description" => "Enjoy premium comfort with beautiful city views.",
        "phone" => "+92 300 3333333",
        "email" => "pearlgrand@example.com"
    ],

    [
        "id" => 104,
        "name" => "Royal Garden Hotel",
        "location" => "Murree",
        "description" => "A beautiful mountain hotel surrounded by green gardens.",
        "phone" => "+92 300 4444444",
        "email" => "royalgarden@example.com"
    ],

    [
        "id" => 105,
        "name" => "Grand Palace Resort",
        "location" => "Swat",
        "description" => "Relax in luxury while enjoying the natural beauty of Swat.",
        "phone" => "+92 300 5555555",
        "email" => "grandpalace@example.com"
    ],

    [
        "id" => 106,
        "name" => "Luxury Pearl Resort",
        "location" => "Hunza",
        "description" => "Premium rooms with amazing mountain views.",
        "phone" => "+92 300 6666666",
        "email" => "luxurypearl@example.com"
    ],

    [
        "id" => 107,
        "name" => "Diamond Palace",
        "location" => "Peshawar",
        "description" => "Elegant accommodation with modern facilities.",
        "phone" => "+92 300 7777777",
        "email" => "diamondpalace@example.com"
    ],

    [
        "id" => 108,
        "name" => "Royal View Hotel",
        "location" => "Nathia Gali",
        "description" => "A peaceful hotel with breathtaking hill views.",
        "phone" => "+92 300 8888888",
        "email" => "royalview@example.com"
    ],

    [
        "id" => 109,
        "name" => "Emerald Hotel",
        "location" => "Gilgit",
        "description" => "Comfortable rooms and beautiful northern landscapes.",
        "phone" => "+92 300 9999999",
        "email" => "emerald@example.com"
    ],

    [
        "id" => 110,
        "name" => "Royal Mountain Hotel",
        "location" => "Skardu",
        "description" => "Luxury accommodation surrounded by stunning mountains.",
        "phone" => "+92 301 1111111",
        "email" => "royalmountain@example.com"
    ],

    [
        "id" => 111,
        "name" => "Blue Pearl Hotel",
        "location" => "Karachi",
        "description" => "Modern hotel with comfortable rooms and excellent service.",
        "phone" => "+92 301 2222222",
        "email" => "bluepearl@example.com"
    ],

    [
        "id" => 112,
        "name" => "City Crown Hotel",
        "location" => "Lahore",
        "description" => "Perfect for business and family stays in the city.",
        "phone" => "+92 301 3333333",
        "email" => "citycrown@example.com"
    ],

    [
        "id" => 113,
        "name" => "Royal Lake Resort",
        "location" => "Kaghan",
        "description" => "Beautiful resort with peaceful lake and mountain views.",
        "phone" => "+92 301 4444444",
        "email" => "royallake@example.com"
    ],

    [
        "id" => 114,
        "name" => "Grand Royal Hotel",
        "location" => "Rawalpindi",
        "description" => "Premium hotel rooms with modern amenities.",
        "phone" => "+92 301 5555555",
        "email" => "grandroyal@example.com"
    ],

    [
        "id" => 115,
        "name" => "Crystal Palace",
        "location" => "Islamabad",
        "description" => "Elegant rooms and a luxurious atmosphere.",
        "phone" => "+92 301 6666666",
        "email" => "crystalpalace@example.com"
    ],

    [
        "id" => 116,
        "name" => "Sunrise Resort",
        "location" => "Abbottabad",
        "description" => "Enjoy peaceful mornings and comfortable accommodation.",
        "phone" => "+92 301 7777777",
        "email" => "sunrise@example.com"
    ],

    [
        "id" => 117,
        "name" => "Royal Diamond Hotel",
        "location" => "Quetta",
        "description" => "A stylish hotel offering quality rooms and services.",
        "phone" => "+92 301 8888888",
        "email" => "royaldiamond@example.com"
    ],

    [
        "id" => 118,
        "name" => "Golden Pearl Hotel",
        "location" => "Faisalabad",
        "description" => "Comfortable accommodation with modern facilities.",
        "phone" => "+92 301 9999999",
        "email" => "goldenpearl@example.com"
    ],

    [
        "id" => 119,
        "name" => "Royal Grand Resort",
        "location" => "Malam Jabba",
        "description" => "Luxury resort perfect for a peaceful mountain vacation.",
        "phone" => "+92 302 1111111",
        "email" => "royalgrand@example.com"
    ],

    [
        "id" => 120,
        "name" => "Imperial Royal Hotel",
        "location" => "Multan",
        "description" => "Premium rooms with excellent hospitality.",
        "phone" => "+92 302 2222222",
        "email" => "imperialroyal@example.com"
    ],

    [
        "id" => 121,
        "name" => "Royal Pearl Resort",
        "location" => "Nathia Gali",
        "description" => "Luxury resort with peaceful surroundings and mountain views.",
        "phone" => "+92 302 3333333",
        "email" => "royalpearl@example.com"
    ],

    [
        "id" => 122,
        "name" => "Golden Mountain Hotel",
        "location" => "Murree",
        "description" => "Beautiful rooms with a relaxing mountain atmosphere.",
        "phone" => "+92 302 4444444",
        "email" => "goldenmountain@example.com"
    ],

    [
        "id" => 123,
        "name" => "Sapphire Grand Hotel",
        "location" => "Islamabad",
        "description" => "Modern luxury hotel designed for families and travelers.",
        "phone" => "+92 302 5555555",
        "email" => "sapphiregrand@example.com"
    ],

    [
        "id" => 124,
        "name" => "Royal Ocean Hotel",
        "location" => "Karachi",
        "description" => "Elegant city hotel close to beautiful coastal attractions.",
        "phone" => "+92 302 6666666",
        "email" => "royalocean@example.com"
    ],

    [
        "id" => 125,
        "name" => "Imperial Palace Resort",
        "location" => "Lahore",
        "description" => "Premium rooms with excellent dining and hospitality.",
        "phone" => "+92 302 7777777",
        "email" => "imperialpalace@example.com"
    ],

    [
        "id" => 126,
        "name" => "Blue Mountain Resort",
        "location" => "Swat",
        "description" => "A peaceful resort surrounded by beautiful green mountains.",
        "phone" => "+92 302 8888888",
        "email" => "bluemountain@example.com"
    ],

    [
        "id" => 127,
        "name" => "Emerald Crown Hotel",
        "location" => "Peshawar",
        "description" => "Stylish hotel with comfortable rooms and modern services.",
        "phone" => "+92 302 9999999",
        "email" => "emeraldcrown@example.com"
    ],

    [
        "id" => 128,
        "name" => "Crystal Lake Resort",
        "location" => "Kaghan",
        "description" => "Enjoy peaceful lake views and luxury accommodation.",
        "phone" => "+92 303 1111111",
        "email" => "crystallake@example.com"
    ],

    [
        "id" => 129,
        "name" => "Grand Horizon Hotel",
        "location" => "Hunza",
        "description" => "A premium hotel offering amazing views of the mountains.",
        "phone" => "+92 303 2222222",
        "email" => "grandhorizon@example.com"
    ],

    [
        "id" => 130,
        "name" => "Royal Valley Hotel",
        "location" => "Gilgit",
        "description" => "Comfortable rooms surrounded by beautiful northern scenery.",
        "phone" => "+92 303 3333333",
        "email" => "royalvalley@example.com"
    ],

    [
        "id" => 131,
        "name" => "Diamond View Resort",
        "location" => "Skardu",
        "description" => "Luxury resort with breathtaking mountain views.",
        "phone" => "+92 303 4444444",
        "email" => "diamondview@example.com"
    ],

    [
        "id" => 132,
        "name" => "Pearl Garden Hotel",
        "location" => "Rawalpindi",
        "description" => "Modern hotel with peaceful rooms and quality services.",
        "phone" => "+92 303 5555555",
        "email" => "pearlgarden@example.com"
    ],

    [
        "id" => 133,
        "name" => "Golden Hills Resort",
        "location" => "Abbottabad",
        "description" => "Relaxing resort surrounded by beautiful green hills.",
        "phone" => "+92 303 6666666",
        "email" => "goldenhills@example.com"
    ],

    [
        "id" => 134,
        "name" => "Royal Heritage Hotel",
        "location" => "Multan",
        "description" => "Elegant hotel combining traditional style with modern comfort.",
        "phone" => "+92 303 7777777",
        "email" => "royalheritage@example.com"
    ],

    [
        "id" => 135,
        "name" => "Sunrise Palace",
        "location" => "Faisalabad",
        "description" => "Comfortable rooms and excellent services for every guest.",
        "phone" => "+92 303 8888888",
        "email" => "sunrisepalace@example.com"
    ],

    [
        "id" => 136,
        "name" => "Imperial Mountain Resort",
        "location" => "Quetta",
        "description" => "Beautiful mountain resort with modern accommodation.",
        "phone" => "+92 303 9999999",
        "email" => "imperialmountain@example.com"
    ],

    [
        "id" => 137,
        "name" => "Royal Lake Hotel",
        "location" => "Naran",
        "description" => "Peaceful hotel with beautiful lake and valley views.",
        "phone" => "+92 304 1111111",
        "email" => "royallakehotel@example.com"
    ],

    [
        "id" => 138,
        "name" => "Golden Valley Resort",
        "location" => "Kalam",
        "description" => "A luxury resort surrounded by forests and mountains.",
        "phone" => "+92 304 2222222",
        "email" => "goldenvalley@example.com"
    ],

    [
        "id" => 139,
        "name" => "Sapphire Pearl Hotel",
        "location" => "Bahawalpur",
        "description" => "Modern rooms with premium facilities and friendly service.",
        "phone" => "+92 304 3333333",
        "email" => "sapphirepearl@example.com"
    ],

    [
        "id" => 140,
        "name" => "Grand Crown Resort",
        "location" => "Murree",
        "description" => "Luxury mountain resort ideal for families and travelers.",
        "phone" => "+92 304 4444444",
        "email" => "grandcrown@example.com"
    ],

    [
        "id" => 141,
        "name" => "Royal Heights Hotel",
        "location" => "Islamabad",
        "description" => "Premium city hotel with stylish rooms and excellent views.",
        "phone" => "+92 304 5555555",
        "email" => "royalheights@example.com"
    ],

    [
        "id" => 142,
        "name" => "Crystal View Resort",
        "location" => "Swat",
        "description" => "A beautiful resort offering comfort and peaceful views.",
        "phone" => "+92 304 6666666",
        "email" => "crystalview@example.com"
    ],

    [
        "id" => 143,
        "name" => "Royal Paradise Hotel",
        "location" => "Lahore",
        "description" => "Elegant rooms, modern facilities and premium hospitality.",
        "phone" => "+92 304 7777777",
        "email" => "royalparadise@example.com"
    ],

    [
        "id" => 144,
        "name" => "Royal Star Hotel",
        "location" => "Karachi",
        "description" => "A modern luxury hotel offering comfortable rooms and premium service.",
        "phone" => "+92 305 1111111",
        "email" => "royalstar@example.com"
    ]

];


/*
|--------------------------------------------------------------------------
| Make Exactly 44 Cards
|--------------------------------------------------------------------------
*/

if (count($hotels) < 44) {

    $needed = 44 - count($hotels);

    $hotels = array_merge(
        $hotels,
        array_slice($demoHotels, 0, $needed)
    );
}

$hotels = array_slice($hotels, 0, 44);


/*
|--------------------------------------------------------------------------
| Assign Image To Every Card
|--------------------------------------------------------------------------
|
| IMPORTANT:
| We assign an image to every card.
| This also fixes missing/empty images from database.
|
|--------------------------------------------------------------------------
*/

foreach ($hotels as $key => &$hotel) {

    $hotel["image"] =
        $hotelImages[
            $key % count($hotelImages)
        ];

}

unset($hotel);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Hotels - Royal Stay</title>


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


/* =========================================================
   BODY
========================================================= */

body {

    font-family:
        'Montserrat',
        sans-serif;

    background:
        radial-gradient(
            circle at top,
            #191919 0%,
            #080808 55%,
            #050505 100%
        );

    color: #fff;

    min-height: 100vh;

}


/* =========================================================
   LOADER
========================================================= */

#loader {

    position: fixed;

    inset: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    background:
        radial-gradient(
            circle at center,
            #252525 0%,
            #101010 45%,
            #030303 100%
        );

    z-index: 999999;

    opacity: 1;

    visibility: visible;

    pointer-events: all;

    transition:
        opacity .7s ease,
        visibility .7s ease;

}


#loader.hide {

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

}


/* =========================================================
   LOADER CONTENT
========================================================= */

.loader-content {

    text-align: center;

    animation:
        loaderEnter .8s
        cubic-bezier(.22,1,.36,1);

}


/* =========================================================
   LOADER CIRCLE
========================================================= */

.loader-circle {

    width: 82px;

    height: 82px;

    margin:
        0 auto 22px;

    border-radius: 50%;

    border:
        3px solid
        rgba(212,175,55,.12);

    border-top-color:
        #d4af37;

    border-right-color:
        #f5d76e;

    animation:
        loaderSpin .9s
        linear infinite;

    box-shadow:

        0 0 15px
        rgba(212,175,55,.20),

        0 0 35px
        rgba(212,175,55,.10);

    position: relative;

}


/* Inner Circle */

.loader-circle::before {

    content: "";

    position: absolute;

    inset: 9px;

    border-radius: 50%;

    border:
        2px solid
        rgba(245,215,110,.18);

    border-bottom-color:
        #d4af37;

    animation:
        loaderSpinReverse 1.4s
        linear infinite;

}


/* Crown */

.loader-circle::after {

    content: "♛";

    position: absolute;

    inset: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #d4af37;

    font-size: 22px;

    text-shadow:
        0 0 15px
        rgba(212,175,55,.6);

}


/* =========================================================
   LOADER TITLE
========================================================= */

.loader-content h2 {

    color: #d4af37;

    font-family:
        'Playfair Display',
        serif;

    font-size: 27px;

    font-weight: 700;

    letter-spacing: 6px;

    text-shadow:

        0 0 12px
        rgba(212,175,55,.30),

        0 0 30px
        rgba(212,175,55,.12);

}


/* =========================================================
   LOADER TEXT
========================================================= */

.loader-content p {

    margin-top: 10px;

    color: #999;

    font-size: 9px;

    letter-spacing: 4px;

    text-transform: uppercase;

}


/* =========================================================
   LOADING DOTS
========================================================= */

.loading-dots {

    display: flex;

    justify-content: center;

    gap: 6px;

    margin-top: 15px;

}


.loading-dots span {

    width: 6px;

    height: 6px;

    background: #d4af37;

    border-radius: 50%;

    animation:
        loadingDot 1s
        infinite ease-in-out;

}


.loading-dots span:nth-child(2) {

    animation-delay: .15s;

}


.loading-dots span:nth-child(3) {

    animation-delay: .30s;

}


/* =========================================================
   LOADER ANIMATION
========================================================= */

@keyframes loaderSpin {

    from {

        transform:
            rotate(0deg);

    }

    to {

        transform:
            rotate(360deg);

    }

}


@keyframes loaderSpinReverse {

    from {

        transform:
            rotate(360deg);

    }

    to {

        transform:
            rotate(0deg);

    }

}


@keyframes loaderEnter {

    from {

        opacity: 0;

        transform:
            scale(.75)
            translateY(20px);

    }

    to {

        opacity: 1;

        transform:
            scale(1)
            translateY(0);

    }

}


@keyframes loadingDot {

    0%,
    100% {

        opacity: .25;

        transform:
            translateY(0);

    }

    50% {

        opacity: 1;

        transform:
            translateY(-5px);

    }

}


/* =========================================================
   NAVBAR
========================================================= */



/* =========================================================
   HERO
========================================================= */

.hero {

    min-height: 300px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 50px 20px;

    background:

        linear-gradient(
            rgba(0,0,0,.72),
            rgba(0,0,0,.88)
        ),

        url(
            "<?= htmlspecialchars($hotelImages[0]) ?>"
        )

        center / cover;

    position: relative;

    overflow: hidden;

}


.hero::before {

    content: "";

    position: absolute;

    width: 350px;

    height: 350px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    filter:
        blur(80px);

}


.hero h1 {

    position: relative;

    font-family:
        'Playfair Display',
        serif;

    font-size: 45px;

    color: #d4af37;

    margin-bottom: 12px;

    text-shadow:
        0 0 25px
        rgba(212,175,55,.20);

}


.gold-line {

    position: relative;

    width: 70px;

    height: 3px;

    background:
        linear-gradient(
            90deg,
            #d4af37,
            #f5d76e,
            #d4af37
        );

    margin-bottom: 15px;

    border-radius: 20px;

    box-shadow:
        0 0 12px
        rgba(212,175,55,.35);

}


.hero p {

    position: relative;

    max-width: 650px;

    color: #ccc;

    font-size: 13px;

    line-height: 1.8;

}


/* =========================================================
   MAIN
========================================================= */

.container {

    width: 90%;

    max-width: 1400px;

    margin: auto;

    padding:
        55px 0 75px;

}


/* =========================================================
   SECTION TITLE
========================================================= */

.section-title {

    text-align: center;

    margin-bottom: 38px;

}


.section-title h2 {

    font-family:
        'Playfair Display',
        serif;

    font-size: 30px;

    color: #d4af37;

}


.section-title p {

    color: #999;

    font-size: 11px;

    margin-top: 8px;

}


/* =========================================================
   HOTEL GRID
========================================================= */

.hotel-grid {

    display: grid;

    grid-template-columns:
        repeat(
            auto-fit,
            minmax(245px, 1fr)
        );

    gap: 22px;

}


/* =========================================================
   HOTEL CARD
========================================================= */

.hotel-card {

    background:
        linear-gradient(
            145deg,
            #1b1b1b,
            #0b0b0b
        );

    border:
        1px solid
        rgba(212,175,55,.18);

    border-radius: 18px;

    overflow: hidden;

    min-height: 425px;

    display: flex;

    flex-direction: column;

    position: relative;

    box-shadow:
        0 12px 35px
        rgba(0,0,0,.35);

    transition:
        transform .4s ease,
        box-shadow .4s ease,
        border-color .4s ease;

    animation:
        cardShow .7s ease both;

}


.hotel-card::before {

    content: "";

    position: absolute;

    top: 0;

    left: 0;

    width: 100%;

    height: 2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d4af37,
            #f5d76e,
            #d4af37,
            transparent
        );

    opacity: 0;

    transition: .4s;

    z-index: 5;

}


.hotel-card:hover::before {

    opacity: 1;

}


.hotel-card:hover {

    transform:
        translateY(-10px);

    border-color:
        rgba(212,175,55,.65);

    box-shadow:

        0 20px 50px
        rgba(0,0,0,.55),

        0 0 25px
        rgba(212,175,55,.08);

}


/* =========================================================
   CARD ANIMATION
========================================================= */

@keyframes cardShow {

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


/* =========================================================
   IMAGE
========================================================= */

.hotel-image {

    height: 180px;

    position: relative;

    overflow: hidden;

    background: #111;

}


.hotel-image img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    object-position: center;

    display: block;

    transition:
        transform .7s ease,
        filter .5s ease;

}


.hotel-card:hover
.hotel-image img {

    transform:
        scale(1.10);

    filter:
        brightness(1.08);

}


/* Image Overlay */

.image-overlay {

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.82),
            rgba(0,0,0,.05) 70%
        );

    pointer-events: none;

}


/* =========================================================
   BADGE
========================================================= */

.luxury-badge {

    position: absolute;

    top: 12px;

    left: 12px;

    background:
        linear-gradient(
            135deg,
            #d4af37,
            #f5d76e
        );

    color: #080808;

    padding:
        7px 11px;

    border-radius: 7px;

    font-size: 8px;

    font-weight: 700;

    letter-spacing: .8px;

    text-transform: uppercase;

    box-shadow:
        0 5px 15px
        rgba(0,0,0,.35);

    transition: .3s;

}


.hotel-card:hover
.luxury-badge {

    transform:
        translateY(-2px);

    box-shadow:
        0 7px 20px
        rgba(212,175,55,.25);

}


/* =========================================================
   CONTENT
========================================================= */

.hotel-content {

    padding: 18px;

    display: flex;

    flex-direction: column;

    flex: 1;

}


.hotel-content h2 {

    color: #f5d76e;

    font-family:
        'Playfair Display',
        serif;

    font-size: 20px;

    line-height: 1.3;

    margin-bottom: 8px;

    transition: .3s;

}


.hotel-card:hover
.hotel-content h2 {

    color: #fff;

}


/* Location */

.location {

    color: #aaa;

    font-size: 10px;

    margin-bottom: 11px;

}


.location i {

    color: #d4af37;

    margin-right: 5px;

}


/* Description */

.description {

    color: #aaa;

    font-size: 10.5px;

    line-height: 1.7;

    min-height: 54px;

    margin-bottom: 14px;

}


/* =========================================================
   HOTEL INFO
========================================================= */

.hotel-info {

    border-top:
        1px solid
        rgba(255,255,255,.08);

    padding-top: 12px;

    display: flex;

    flex-direction: column;

    gap: 8px;

    margin-bottom: 15px;

}


.hotel-info p {

    color: #999;

    font-size: 9.5px;

    display: flex;

    align-items: center;

    gap: 8px;

    overflow: hidden;

    white-space: nowrap;

    text-overflow: ellipsis;

}


.hotel-info i {

    color: #d4af37;

    width: 13px;

}


/* =========================================================
   BUTTON
========================================================= */

.btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    text-decoration: none;

    background:
        linear-gradient(
            135deg,
            #d4af37,
            #f5d76e
        );

    color: #090909;

    font-size: 10px;

    font-weight: 700;

    padding:
        11px 15px;

    border-radius: 8px;

    margin-top: auto;

    transition:
        transform .3s ease,
        box-shadow .3s ease;

}


.btn:hover {

    transform:
        translateY(-3px);

    box-shadow:
        0 8px 22px
        rgba(212,175,55,.30);

}



/* =========================================================
   BACK TO TOP
========================================================= */

#topBtn {

    position: fixed;

    right: 20px;

    bottom: 20px;

    width: 40px;

    height: 40px;

    border: none;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #d4af37,
            #f5d76e
        );

    color: #080808;

    cursor: pointer;

    display: none;

    align-items: center;

    justify-content: center;

    z-index: 500;

    box-shadow:
        0 5px 20px
        rgba(0,0,0,.4);

    transition: .3s;

}


#topBtn:hover {

    transform:
        translateY(-4px);

    box-shadow:
        0 8px 25px
        rgba(212,175,55,.25);

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 800px) {

    nav {

        padding:
            15px 5%;

        flex-direction:
            column;

        gap: 13px;

    }


    .nav-links {

        gap: 15px;

        flex-wrap: wrap;

        justify-content: center;

    }


    .hero h1 {

        font-size: 35px;

    }


    .hotel-grid {

        grid-template-columns:
            repeat(
                auto-fit,
                minmax(220px, 1fr)
            );

    }

}


@media (max-width: 500px) {

    .container {

        width: 92%;

        padding-top: 35px;

    }


    .hero {

        min-height: 240px;

    }


    .hero h1 {

        font-size: 31px;

    }


    .hotel-grid {

        grid-template-columns: 1fr;

        gap: 17px;

    }


    .hotel-image {

        height: 185px;

    }


    .loader-content h2 {

        font-size: 22px;

        letter-spacing: 4px;

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

        <p>Loading Luxury Experience</p>

        <div class="loading-dots">

            <span></span>
            <span></span>
            <span></span>

        </div>

    </div>

</div>


<?php

require_once "header.php";

?>
<!-- =========================================================
     HERO
========================================================= -->

<section class="hero">

    <h1>
        Our Hotels
    </h1>

    <div class="gold-line"></div>

    <p>

        Discover elegant hotels and luxury resorts
        across Pakistan. Choose your perfect stay
        with Royal Stay.

    </p>

</section>


<!-- =========================================================
     HOTELS
========================================================= -->

<main class="container">


    <div class="section-title">

        <h2>
            Luxury Hotels
        </h2>

        <p>

            <?= count($hotels) ?>
            premium hotels available

        </p>

    </div>


    <div class="hotel-grid">


        <?php foreach ($hotels as $index => $hotel): ?>


            <?php

            $hotelId =
                $hotel["id"]
                ?? 0;


            $hotelName =
                $hotel["name"]
                ?? "Royal Stay Hotel";


            $location =
                $hotel["location"]
                ?? $hotel["city"]
                ?? "Pakistan";


            $description =
                $hotel["description"]
                ??
                "Experience comfort, luxury and excellent hospitality at Royal Stay.";


            $phone =
                $hotel["phone"]
                ??
                "+92 300 0000000";


            $email =
                $hotel["email"]
                ??
                "info@royalstay.com";


            /*
            |--------------------------------------------------------------------------
            | ALWAYS GET IMAGE
            |--------------------------------------------------------------------------
            */

            $image =
                $hotelImages[
                    $index %
                    count($hotelImages)
                ];

            ?>


            <div
                class="hotel-card"
                style="
                    animation-delay:
                    <?= ($index % 12) * 0.06 ?>s;
                "
            >


                <!-- IMAGE -->

                <div class="hotel-image">


                    <img
                        src="<?= htmlspecialchars($image) ?>"
                        alt="<?= htmlspecialchars($hotelName) ?>"
                        loading="<?= $index < 8 ? 'eager' : 'lazy' ?>"
                        onerror="
                            this.onerror=null;
                            this.src='<?= htmlspecialchars($fallbackImage) ?>';
                        "
                    >


                    <div
                        class="image-overlay"
                    ></div>


                    <span
                        class="luxury-badge"
                    >

                        <i
                            class="fa-solid fa-crown"
                        ></i>

                        Luxury Stay

                    </span>


                </div>


                <!-- CONTENT -->

                <div class="hotel-content">


                    <h2>

                        <?= htmlspecialchars($hotelName) ?>

                    </h2>


                    <div class="location">

                        <i
                            class="fa-solid fa-location-dot"
                        ></i>

                        <?= htmlspecialchars($location) ?>

                    </div>


                    <p class="description">

                        <?= htmlspecialchars($description) ?>

                    </p>


                    <div class="hotel-info">


                        <p>

                            <i
                                class="fa-solid fa-phone"
                            ></i>

                            <?= htmlspecialchars($phone) ?>

                        </p>


                        <p>

                            <i
                                class="fa-solid fa-envelope"
                            ></i>

                            <?= htmlspecialchars($email) ?>

                        </p>


                    </div>


                    <a
                        href="hotel-details.php?id=<?= urlencode($hotelId) ?>"
                        class="btn"
                    >

                        View Hotel

                        <i
                            class="fa-solid fa-arrow-right"
                        ></i>

                    </a>


                </div>

            </div>


        <?php endforeach; ?>


    </div>

</main>

<?php
require_once "footer.php";
?>


<!-- =========================================================
     BACK TO TOP
========================================================= -->

<button id="topBtn">

    <i
        class="fa-solid fa-arrow-up"
    ></i>

</button>



<script>

/* =========================================================
   PAGE LOADER
========================================================= */

/*
|--------------------------------------------------------------------------
| IMPORTANT
|--------------------------------------------------------------------------
| We use DOMContentLoaded instead of window.load.
| This means the loader will NOT wait for all 44 images.
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const loader =
            document.getElementById(
                "loader"
            );


        setTimeout(
            function () {

                loader.classList.add(
                    "hide"
                );

            },
            800
        );

    }
);


/* =========================================================
   BACK TO TOP
========================================================= */

const topBtn =
    document.getElementById(
        "topBtn"
    );


window.addEventListener(
    "scroll",
    function () {

        if (
            window.scrollY > 300
        ) {

            topBtn.style.display =
                "flex";

        } else {

            topBtn.style.display =
                "none";

        }

    }
);


topBtn.addEventListener(
    "click",
    function () {

        window.scrollTo({

            top: 0,

            behavior: "smooth"

        });

    }
);

</script>


</body>

</html>