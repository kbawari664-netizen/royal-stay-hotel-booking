<?php

require_once "config/database.php";

/*
|--------------------------------------------------------------------------
| GET HOTEL ID
|--------------------------------------------------------------------------
*/

$hotelId = isset($_GET["id"])
    ? (int) $_GET["id"]
    : (isset($_GET["hotel_id"]) ? (int) $_GET["hotel_id"] : 0);


/*
|--------------------------------------------------------------------------
| HELPER FUNCTION
|--------------------------------------------------------------------------
*/

function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}


/*
|--------------------------------------------------------------------------
| HOTEL IMAGES
|--------------------------------------------------------------------------
*/

$hotelImages = [

    "https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1601918774946-25832a4be0d6?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1596436889106-be35e843f04b?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1563911302283-d2bc129e7570?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1562790351-d273a961e0e9?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1568084680786-a84f91d5892a?auto=format&fit=crop&w=1200&q=85",

    "https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=85"

];

$fallbackImage = $hotelImages[0];


/*
|--------------------------------------------------------------------------
| DEMO HOTELS
|--------------------------------------------------------------------------
*/

$demoHotels = [

    101 => [
        "id" => 101,
        "name" => "Royal Palace Hotel",
        "location" => "Karachi",
        "description" => "A luxurious hotel with elegant rooms and premium facilities.",
        "phone" => "+92 300 1111111",
        "email" => "royalpalace@example.com"
    ],

    102 => [
        "id" => 102,
        "name" => "Golden Crown Hotel",
        "location" => "Lahore",
        "description" => "Modern rooms, excellent service and a peaceful environment.",
        "phone" => "+92 300 2222222",
        "email" => "goldencrown@example.com"
    ],

    103 => [
        "id" => 103,
        "name" => "Pearl Grand Hotel",
        "location" => "Islamabad",
        "description" => "Enjoy premium comfort with beautiful city views.",
        "phone" => "+92 300 3333333",
        "email" => "pearlgrand@example.com"
    ],

    104 => [
        "id" => 104,
        "name" => "Royal Garden Hotel",
        "location" => "Murree",
        "description" => "A beautiful mountain hotel surrounded by green gardens.",
        "phone" => "+92 300 4444444",
        "email" => "royalgarden@example.com"
    ],

    105 => [
        "id" => 105,
        "name" => "Grand Palace Resort",
        "location" => "Swat",
        "description" => "Relax in luxury while enjoying the natural beauty of Swat.",
        "phone" => "+92 300 5555555",
        "email" => "grandpalace@example.com"
    ],

    106 => [
        "id" => 106,
        "name" => "Luxury Pearl Resort",
        "location" => "Hunza",
        "description" => "Premium rooms with amazing mountain views.",
        "phone" => "+92 300 6666666",
        "email" => "luxurypearl@example.com"
    ],

    107 => [
        "id" => 107,
        "name" => "Diamond Palace",
        "location" => "Peshawar",
        "description" => "Elegant accommodation with modern facilities.",
        "phone" => "+92 300 7777777",
        "email" => "diamondpalace@example.com"
    ],

    108 => [
        "id" => 108,
        "name" => "Royal View Hotel",
        "location" => "Nathia Gali",
        "description" => "A peaceful hotel with breathtaking hill views.",
        "phone" => "+92 300 8888888",
        "email" => "royalview@example.com"
    ],

    109 => [
        "id" => 109,
        "name" => "Emerald Hotel",
        "location" => "Gilgit",
        "description" => "Comfortable rooms and beautiful northern landscapes.",
        "phone" => "+92 300 9999999",
        "email" => "emerald@example.com"
    ],

    110 => [
        "id" => 110,
        "name" => "Royal Mountain Hotel",
        "location" => "Skardu",
        "description" => "Luxury accommodation surrounded by stunning mountains.",
        "phone" => "+92 301 1111111",
        "email" => "royalmountain@example.com"
    ],

    111 => [
        "id" => 111,
        "name" => "Blue Pearl Hotel",
        "location" => "Karachi",
        "description" => "Modern hotel with comfortable rooms and excellent service.",
        "phone" => "+92 301 2222222",
        "email" => "bluepearl@example.com"
    ],

    112 => [
        "id" => 112,
        "name" => "City Crown Hotel",
        "location" => "Lahore",
        "description" => "Perfect for business and family stays in the city.",
        "phone" => "+92 301 3333333",
        "email" => "citycrown@example.com"
    ],

    113 => [
        "id" => 113,
        "name" => "Royal Lake Resort",
        "location" => "Kaghan",
        "description" => "Beautiful resort with peaceful lake and mountain views.",
        "phone" => "+92 301 4444444",
        "email" => "royallake@example.com"
    ],

    114 => [
        "id" => 114,
        "name" => "Grand Royal Hotel",
        "location" => "Rawalpindi",
        "description" => "Premium hotel rooms with modern amenities.",
        "phone" => "+92 301 5555555",
        "email" => "grandroyal@example.com"
    ],

    115 => [
        "id" => 115,
        "name" => "Crystal Palace",
        "location" => "Islamabad",
        "description" => "Elegant rooms and a luxurious atmosphere.",
        "phone" => "+92 301 6666666",
        "email" => "crystalpalace@example.com"
    ],

    116 => [
        "id" => 116,
        "name" => "Sunrise Resort",
        "location" => "Abbottabad",
        "description" => "Enjoy peaceful mornings and comfortable accommodation.",
        "phone" => "+92 301 7777777",
        "email" => "sunrise@example.com"
    ],

    117 => [
        "id" => 117,
        "name" => "Royal Diamond Hotel",
        "location" => "Quetta",
        "description" => "A stylish hotel offering quality rooms and services.",
        "phone" => "+92 301 8888888",
        "email" => "royaldiamond@example.com"
    ],

    118 => [
        "id" => 118,
        "name" => "Golden Pearl Hotel",
        "location" => "Faisalabad",
        "description" => "Comfortable accommodation with modern facilities.",
        "phone" => "+92 301 9999999",
        "email" => "goldenpearl@example.com"
    ],

    119 => [
        "id" => 119,
        "name" => "Royal Grand Resort",
        "location" => "Malam Jabba",
        "description" => "Luxury resort perfect for a peaceful mountain vacation.",
        "phone" => "+92 302 1111111",
        "email" => "royalgrand@example.com"
    ],

    120 => [
        "id" => 120,
        "name" => "Imperial Royal Hotel",
        "location" => "Multan",
        "description" => "Premium rooms with excellent hospitality.",
        "phone" => "+92 302 2222222",
        "email" => "imperialroyal@example.com"
    ],

    121 => [
        "id" => 121,
        "name" => "Royal Pearl Resort",
        "location" => "Nathia Gali",
        "description" => "Luxury resort with peaceful surroundings and mountain views.",
        "phone" => "+92 302 3333333",
        "email" => "royalpearl@example.com"
    ],

    122 => [
        "id" => 122,
        "name" => "Golden Mountain Hotel",
        "location" => "Murree",
        "description" => "Beautiful rooms with a relaxing mountain atmosphere.",
        "phone" => "+92 302 4444444",
        "email" => "goldenmountain@example.com"
    ],

    123 => [
        "id" => 123,
        "name" => "Sapphire Grand Hotel",
        "location" => "Islamabad",
        "description" => "Modern luxury hotel designed for families and travelers.",
        "phone" => "+92 302 5555555",
        "email" => "sapphiregrand@example.com"
    ],

    124 => [
        "id" => 124,
        "name" => "Royal Ocean Hotel",
        "location" => "Karachi",
        "description" => "Elegant city hotel close to beautiful coastal attractions.",
        "phone" => "+92 302 6666666",
        "email" => "royalocean@example.com"
    ],

    125 => [
        "id" => 125,
        "name" => "Imperial Palace Resort",
        "location" => "Lahore",
        "description" => "Premium rooms with excellent dining and hospitality.",
        "phone" => "+92 302 7777777",
        "email" => "imperialpalace@example.com"
    ],

    126 => [
        "id" => 126,
        "name" => "Blue Mountain Resort",
        "location" => "Swat",
        "description" => "A peaceful resort surrounded by beautiful green mountains.",
        "phone" => "+92 302 8888888",
        "email" => "bluemountain@example.com"
    ],

    127 => [
        "id" => 127,
        "name" => "Emerald Crown Hotel",
        "location" => "Peshawar",
        "description" => "Stylish hotel with comfortable rooms and modern services.",
        "phone" => "+92 302 9999999",
        "email" => "emeraldcrown@example.com"
    ],

    128 => [
        "id" => 128,
        "name" => "Crystal Lake Resort",
        "location" => "Kaghan",
        "description" => "Enjoy peaceful lake views and luxury accommodation.",
        "phone" => "+92 303 1111111",
        "email" => "crystallake@example.com"
    ],

    129 => [
        "id" => 129,
        "name" => "Grand Horizon Hotel",
        "location" => "Hunza",
        "description" => "A premium hotel offering amazing views of the mountains.",
        "phone" => "+92 303 2222222",
        "email" => "grandhorizon@example.com"
    ],

    130 => [
        "id" => 130,
        "name" => "Royal Valley Hotel",
        "location" => "Gilgit",
        "description" => "Comfortable rooms surrounded by beautiful northern scenery.",
        "phone" => "+92 303 3333333",
        "email" => "royalvalley@example.com"
    ],

    131 => [
        "id" => 131,
        "name" => "Diamond View Resort",
        "location" => "Skardu",
        "description" => "Luxury resort with breathtaking mountain views.",
        "phone" => "+92 303 4444444",
        "email" => "diamondview@example.com"
    ],

    132 => [
        "id" => 132,
        "name" => "Pearl Garden Hotel",
        "location" => "Rawalpindi",
        "description" => "Modern hotel with peaceful rooms and quality services.",
        "phone" => "+92 303 5555555",
        "email" => "pearlgarden@example.com"
    ],

    133 => [
        "id" => 133,
        "name" => "Golden Hills Resort",
        "location" => "Abbottabad",
        "description" => "Relaxing resort surrounded by beautiful green hills.",
        "phone" => "+92 303 6666666",
        "email" => "goldenhills@example.com"
    ],

    134 => [
        "id" => 134,
        "name" => "Royal Heritage Hotel",
        "location" => "Multan",
        "description" => "Elegant hotel combining traditional style with modern comfort.",
        "phone" => "+92 303 7777777",
        "email" => "royalheritage@example.com"
    ],

    135 => [
        "id" => 135,
        "name" => "Sunrise Palace",
        "location" => "Faisalabad",
        "description" => "Comfortable rooms and excellent services for every guest.",
        "phone" => "+92 303 8888888",
        "email" => "sunrisepalace@example.com"
    ],

    136 => [
        "id" => 136,
        "name" => "Imperial Mountain Resort",
        "location" => "Quetta",
        "description" => "Beautiful mountain resort with modern accommodation.",
        "phone" => "+92 303 9999999",
        "email" => "imperialmountain@example.com"
    ],

    137 => [
        "id" => 137,
        "name" => "Royal Lake Hotel",
        "location" => "Naran",
        "description" => "Peaceful hotel with beautiful lake and valley views.",
        "phone" => "+92 304 1111111",
        "email" => "royallakehotel@example.com"
    ],

    138 => [
        "id" => 138,
        "name" => "Golden Valley Resort",
        "location" => "Kalam",
        "description" => "A luxury resort surrounded by forests and mountains.",
        "phone" => "+92 304 2222222",
        "email" => "goldenvalley@example.com"
    ],

    139 => [
        "id" => 139,
        "name" => "Sapphire Pearl Hotel",
        "location" => "Bahawalpur",
        "description" => "Modern rooms with premium facilities and friendly service.",
        "phone" => "+92 304 3333333",
        "email" => "sapphirepearl@example.com"
    ],

    140 => [
        "id" => 140,
        "name" => "Grand Crown Resort",
        "location" => "Murree",
        "description" => "Luxury mountain resort ideal for families and travelers.",
        "phone" => "+92 304 4444444",
        "email" => "grandcrown@example.com"
    ],

    141 => [
        "id" => 141,
        "name" => "Royal Heights Hotel",
        "location" => "Islamabad",
        "description" => "Premium city hotel with stylish rooms and excellent views.",
        "phone" => "+92 304 5555555",
        "email" => "royalheights@example.com"
    ],

    142 => [
        "id" => 142,
        "name" => "Crystal View Resort",
        "location" => "Swat",
        "description" => "A beautiful resort offering comfort and peaceful views.",
        "phone" => "+92 304 6666666",
        "email" => "crystalview@example.com"
    ],

    143 => [
        "id" => 143,
        "name" => "Royal Paradise Hotel",
        "location" => "Lahore",
        "description" => "Elegant rooms, modern facilities and premium hospitality.",
        "phone" => "+92 304 7777777",
        "email" => "royalparadise@example.com"
    ],

    144 => [
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
| FIND HOTEL
|--------------------------------------------------------------------------
*/

$hotel = null;
$hotelSource = "database";


/*
|--------------------------------------------------------------------------
| DATABASE HOTEL
|--------------------------------------------------------------------------
*/

if ($hotelId > 0) {

    try {

        $stmt = $pdo->prepare(
            "SELECT * FROM hotels WHERE id = ? LIMIT 1"
        );

        $stmt->execute([$hotelId]);

        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        $hotel = null;

    }

}


/*
|--------------------------------------------------------------------------
| DEMO HOTEL
|--------------------------------------------------------------------------
*/

if (!$hotel && isset($demoHotels[$hotelId])) {

    $hotel = $demoHotels[$hotelId];

    $hotelSource = "demo";
}


/*
|--------------------------------------------------------------------------
| HOTEL NOT FOUND
|--------------------------------------------------------------------------
*/

if (!$hotel) {

    http_response_code(404);

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
            Hotel Not Found - Royal Stay
        </title>

        <style>

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {

                min-height: 100vh;

                display: flex;

                align-items: center;

                justify-content: center;

                background: #080808;

                color: #fff;

                font-family: Arial, sans-serif;

                padding: 20px;
            }

            .error-box {

                width: 100%;

                max-width: 500px;

                text-align: center;

                padding: 50px 30px;

                background: #111;

                border: 1px solid #3b3217;

                border-radius: 20px;

                box-shadow:
                    0 20px 60px
                    rgba(0,0,0,.5);
            }

            .error-icon {

                font-size: 60px;

                color: #d4af37;

                margin-bottom: 20px;
            }

            h1 {

                color: #d4af37;

                margin-bottom: 15px;
            }

            p {

                color: #999;

                line-height: 1.7;

                margin-bottom: 25px;
            }

            a {

                display: inline-block;

                padding: 12px 22px;

                border-radius: 8px;

                background:
                    linear-gradient(
                        135deg,
                        #d4af37,
                        #f5d76e
                    );

                color: #080808;

                text-decoration: none;

                font-weight: bold;
            }

        </style>

    </head>

    <body>

        <div class="error-box">

            <div class="error-icon">
                ♛
            </div>

            <h1>
                Hotel Not Found
            </h1>

            <p>
                Sorry, the hotel you are looking for
                does not exist.
            </p>

            <a href="hotels.php">
                ← Back To Hotels
            </a>

        </div>

    </body>

    </html>

    <?php

    exit;
}


/*
|--------------------------------------------------------------------------
| HOTEL INFORMATION
|--------------------------------------------------------------------------
*/

$hotelName = $hotel["name"] ?? "Royal Stay Hotel";

$location =
    $hotel["location"]
    ?? $hotel["city"]
    ?? "Pakistan";

$description =
    $hotel["description"]
    ?? "Experience comfort, luxury and excellent hospitality at Royal Stay.";

$phone =
    $hotel["phone"]
    ?? "+92 300 0000000";

$email =
    $hotel["email"]
    ?? "info@royalstay.com";


/*
|--------------------------------------------------------------------------
| HOTEL IMAGE
|--------------------------------------------------------------------------
*/

$imageIndex =
    abs($hotelId) % count($hotelImages);

$hotelImage =
    $hotelImages[$imageIndex];


/*
|--------------------------------------------------------------------------
| EXTRA INFORMATION
|--------------------------------------------------------------------------
*/

$rating = "4.8";

$roomsText = "Luxury Rooms";

$service = "24/7 Service";

$wifi = "Free WiFi";

$parking = "Free Parking";

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

        <?= e($hotelName) ?>

        - Royal Stay

    </title>


    <!-- GOOGLE FONT -->

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- FONT AWESOME -->

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


body {

    font-family:
        'Montserrat',
        sans-serif;

    background:
        radial-gradient(
            circle at top,
            #1b1b1b 0%,
            #090909 55%,
            #040404 100%
        );

    color: #fff;

    min-height: 100vh;
}


/* =========================================================
   NAVBAR
========================================================= */

nav {

    width: 100%;

    padding: 17px 7%;

    display: flex;

    justify-content: space-between;

    align-items: center;

    background: rgba(8,8,8,.96);

    border-bottom:
        1px solid
        rgba(212,175,55,.20);

    position: sticky;

    top: 0;

    z-index: 1000;

    backdrop-filter: blur(12px);
}


.logo {

    color: #d4af37;

    font-family:
        'Playfair Display',
        serif;

    font-size: 25px;

    font-weight: 700;

    letter-spacing: 2px;

    text-decoration: none;
}


.nav-links {

    display: flex;

    align-items: center;

    gap: 27px;

    list-style: none;
}


.nav-links a {

    color: #ddd;

    text-decoration: none;

    font-size: 12px;

    font-weight: 600;

    transition: .3s;
}


.nav-links a:hover {

    color: #d4af37;
}


/* =========================================================
   HERO
========================================================= */

.hero {

    min-height: 460px;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 60px 7%;

    position: relative;

    overflow: hidden;

    background:

        linear-gradient(
            90deg,
            rgba(0,0,0,.95),
            rgba(0,0,0,.65),
            rgba(0,0,0,.88)
        ),

        url("<?= e($hotelImage) ?>")

        center / cover;
}


.hero::before {

    content: "";

    position: absolute;

    width: 450px;

    height: 450px;

    border-radius: 50%;

    background:
        rgba(212,175,55,.08);

    filter: blur(100px);
}


.hero-content {

    position: relative;

    width: 100%;

    max-width: 1200px;

    display: grid;

    grid-template-columns:
        1.2fr
        .8fr;

    gap: 50px;

    align-items: center;
}


.hero-text {

    animation:
        fadeUp .8s ease both;
}


.badge {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 13px;

    background:
        linear-gradient(
            135deg,
            #d4af37,
            #f5d76e
        );

    color: #090909;

    border-radius: 8px;

    font-size: 9px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 1px;

    margin-bottom: 18px;
}


.hero h1 {

    font-family:
        'Playfair Display',
        serif;

    font-size: clamp(
        38px,
        5vw,
        65px
    );

    line-height: 1.1;

    color: #f5d76e;

    margin-bottom: 18px;
}


.hero-location {

    color: #ddd;

    font-size: 13px;

    margin-bottom: 20px;
}


.hero-location i {

    color: #d4af37;

    margin-right: 7px;
}


.hero-description {

    max-width: 650px;

    color: #bbb;

    font-size: 13px;

    line-height: 1.9;
}


/* =========================================================
   HERO IMAGE
========================================================= */

.hero-image-box {

    height: 330px;

    border-radius: 22px;

    overflow: hidden;

    border:
        1px solid
        rgba(212,175,55,.4);

    box-shadow:

        0 25px 60px
        rgba(0,0,0,.65),

        0 0 35px
        rgba(212,175,55,.08);

    animation:
        fadeUp .9s ease both;
}


.hero-image-box img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    transition:
        transform .7s ease;
}


.hero-image-box:hover img {

    transform:
        scale(1.06);
}


/* =========================================================
   CONTAINER
========================================================= */

.container {

    width: 90%;

    max-width: 1200px;

    margin: auto;

    padding:
        70px 0;
}


/* =========================================================
   INFO
========================================================= */

.info-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 18px;

    margin-bottom: 55px;
}


.info-card {

    background:
        linear-gradient(
            145deg,
            #191919,
            #0c0c0c
        );

    border:
        1px solid
        rgba(212,175,55,.18);

    border-radius: 15px;

    padding: 25px 18px;

    text-align: center;

    transition: .3s;
}


.info-card:hover {

    transform:
        translateY(-6px);

    border-color:
        rgba(212,175,55,.55);
}


.info-card i {

    color: #d4af37;

    font-size: 25px;

    margin-bottom: 13px;
}


.info-card h3 {

    font-size: 12px;

    color: #eee;

    margin-bottom: 7px;
}


.info-card p {

    font-size: 9px;

    color: #888;
}


/* =========================================================
   DETAILS
========================================================= */

.details-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 30px;
}


.details-box {

    background:
        linear-gradient(
            145deg,
            #191919,
            #0a0a0a
        );

    border:
        1px solid
        rgba(212,175,55,.18);

    border-radius: 20px;

    padding: 30px;
}


.details-box h2 {

    color: #d4af37;

    font-family:
        'Playfair Display',
        serif;

    font-size: 28px;

    margin-bottom: 20px;
}


.details-box p {

    color: #aaa;

    font-size: 12px;

    line-height: 1.9;
}


/* =========================================================
   FEATURES
========================================================= */

.features {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 12px;

    margin-top: 20px;
}


.feature {

    display: flex;

    align-items: center;

    gap: 9px;

    color: #aaa;

    font-size: 10px;
}


.feature i {

    color: #d4af37;
}


/* =========================================================
   CONTACT
========================================================= */

.contact-list {

    display: flex;

    flex-direction: column;

    gap: 16px;
}


.contact-item {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 13px;

    background:
        rgba(255,255,255,.03);

    border-radius: 10px;
}


.contact-item i {

    color: #d4af37;

    width: 20px;

    text-align: center;
}


.contact-item span {

    color: #bbb;

    font-size: 11px;

    word-break: break-word;
}


/* =========================================================
   BUTTONS
========================================================= */

.buttons {

    display: flex;

    flex-wrap: wrap;

    gap: 12px;

    margin-top: 25px;
}


.btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    padding:
        13px 20px;

    border-radius: 9px;

    text-decoration: none;

    font-size: 10px;

    font-weight: 700;

    transition: .3s;
}


.btn-gold {

    background:
        linear-gradient(
            135deg,
            #d4af37,
            #f5d76e
        );

    color: #080808;
}


.btn-dark {

    background:
        rgba(255,255,255,.05);

    color: #ddd;

    border:
        1px solid
        rgba(212,175,55,.25);
}


.btn:hover {

    transform:
        translateY(-3px);
}


.btn-gold:hover {

    box-shadow:
        0 10px 25px
        rgba(212,175,55,.25);
}


/* =========================================================
   FOOTER
========================================================= */

footer {

    background: #050505;

    border-top:
        1px solid
        rgba(212,175,55,.15);

    padding:
        40px 7%;

    text-align: center;
}


.footer-logo {

    color: #d4af37;

    font-family:
        'Playfair Display',
        serif;

    font-size: 23px;

    margin-bottom: 10px;
}


footer p {

    color: #777;

    font-size: 10px;
}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes fadeUp {

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
   RESPONSIVE
========================================================= */

@media (max-width: 850px) {

    nav {

        flex-direction: column;

        gap: 15px;
    }


    .nav-links {

        gap: 14px;

        flex-wrap: wrap;

        justify-content: center;
    }


    .hero {

        padding:
            50px 5%;
    }


    .hero-content {

        grid-template-columns:
            1fr;
    }


    .hero-image-box {

        height: 280px;
    }


    .info-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }


    .details-grid {

        grid-template-columns:
            1fr;
    }
}


@media (max-width: 500px) {

    .info-grid {

        grid-template-columns:
            1fr;
    }


    .container {

        width: 92%;

        padding:
            45px 0;
    }


    .hero h1 {

        font-size: 38px;
    }


    .hero-image-box {

        height: 230px;
    }


    .details-box {

        padding: 22px;
    }
}

</style>

</head>


<body>


<!-- =========================================================
     NAVBAR
========================================================= -->

<nav>

    <a
        href="index.php"
        class="logo"
    >

        ROYAL STAY

    </a>


    <ul class="nav-links">

        <li>
            <a href="index.php">
                Home
            </a>
        </li>

        <li>
            <a href="hotels.php">
                Hotels
            </a>
        </li>

        <li>
            <a href="room.php?hotel_id=<?= (int)$hotelId ?>">
                Rooms
            </a>
        </li>

        <li>
            <a href="about.php">
                About
            </a>
        </li>

        <li>
            <a href="contact.php">
                Contact
            </a>
        </li>

        <li>
            <a href="login.php">
                Login
            </a>
        </li>

    </ul>

</nav>



<!-- =========================================================
     HERO
========================================================= -->

<section class="hero">

    <div class="hero-content">


        <div class="hero-text">


            <div class="badge">

                <i class="fa-solid fa-crown"></i>

                Luxury Stay

            </div>


            <h1>

                <?= e($hotelName) ?>

            </h1>


            <div class="hero-location">

                <i class="fa-solid fa-location-dot"></i>

                <?= e($location) ?>

            </div>


            <p class="hero-description">

                <?= e($description) ?>

            </p>


            <div class="buttons">


                <!-- VIEW ROOMS -->

                <a
                    href="room.php?hotel_id=<?= (int)$hotelId ?>"
                    class="btn btn-gold"
                >

                    <i class="fa-solid fa-bed"></i>

                    View Rooms

                </a>


                <!-- BACK -->

                <a
                    href="hotels.php"
                    class="btn btn-dark"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    Back To Hotels

                </a>


            </div>


        </div>



        <!-- IMAGE -->

        <div class="hero-image-box">

            <img
                src="<?= e($hotelImage) ?>"
                alt="<?= e($hotelName) ?>"
                onerror="
                    this.onerror=null;
                    this.src='<?= e($fallbackImage) ?>';
                "
            >

        </div>


    </div>

</section>



<!-- =========================================================
     MAIN
========================================================= -->

<main class="container">


    <!-- INFO CARDS -->

    <div class="info-grid">


        <div class="info-card">

            <i class="fa-solid fa-star"></i>

            <h3>
                Guest Rating
            </h3>

            <p>
                <?= e($rating) ?> / 5.0
            </p>

        </div>



        <div class="info-card">

            <i class="fa-solid fa-bed"></i>

            <h3>
                Accommodation
            </h3>

            <p>
                <?= e($roomsText) ?>
            </p>

        </div>



        <div class="info-card">

            <i class="fa-solid fa-clock"></i>

            <h3>
                Service
            </h3>

            <p>
                <?= e($service) ?>
            </p>

        </div>



        <div class="info-card">

            <i class="fa-solid fa-wifi"></i>

            <h3>
                Internet
            </h3>

            <p>
                <?= e($wifi) ?>
            </p>

        </div>


    </div>



    <!-- DETAILS -->

    <div class="details-grid">


        <!-- ABOUT -->

        <div class="details-box">

            <h2>
                About This Hotel
            </h2>


            <p>

                <?= e($description) ?>

                Enjoy a comfortable and memorable
                stay with Royal Stay. Our hotel is
                designed to provide guests with
                premium comfort, elegant rooms and
                excellent hospitality.

            </p>


            <div class="features">


                <div class="feature">

                    <i class="fa-solid fa-check"></i>

                    Luxury Accommodation

                </div>


                <div class="feature">

                    <i class="fa-solid fa-check"></i>

                    <?= e($wifi) ?>

                </div>


                <div class="feature">

                    <i class="fa-solid fa-check"></i>

                    <?= e($parking) ?>

                </div>


                <div class="feature">

                    <i class="fa-solid fa-check"></i>

                    24/7 Guest Support

                </div>


                <div class="feature">

                    <i class="fa-solid fa-check"></i>

                    Premium Service

                </div>


                <div class="feature">

                    <i class="fa-solid fa-check"></i>

                    Family Friendly

                </div>


            </div>


        </div>



        <!-- CONTACT -->

        <div class="details-box">

            <h2>
                Contact Hotel
            </h2>


            <div class="contact-list">


                <div class="contact-item">

                    <i class="fa-solid fa-location-dot"></i>

                    <span>

                        <?= e($location) ?>

                    </span>

                </div>


                <div class="contact-item">

                    <i class="fa-solid fa-phone"></i>

                    <span>

                        <?= e($phone) ?>

                    </span>

                </div>


                <div class="contact-item">

                    <i class="fa-solid fa-envelope"></i>

                    <span>

                        <?= e($email) ?>

                    </span>

                </div>


                <div class="contact-item">

                    <i class="fa-solid fa-clock"></i>

                    <span>

                        Open 24 Hours

                    </span>

                </div>


            </div>


            <div class="buttons">


                <a
                    href="tel:<?= e($phone) ?>"
                    class="btn btn-gold"
                >

                    <i class="fa-solid fa-phone"></i>

                    Call Hotel

                </a>


                <a
                    href="mailto:<?= e($email) ?>"
                    class="btn btn-dark"
                >

                    <i class="fa-solid fa-envelope"></i>

                    Email Hotel

                </a>


            </div>


        </div>


    </div>


</main>



<!-- =========================================================
     FOOTER
========================================================= -->

<footer>

    <div class="footer-logo">

        ROYAL STAY

    </div>


    <p>

        © <?= date("Y") ?>

        Royal Stay.

        All Rights Reserved.

    </p>

</footer>


</body>

</html>