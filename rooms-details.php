<?php
session_start();
require_once "config/database.php";

$roomTypes = [
    ["Superior Room", 7500],
    ["Grand Deluxe Room", 8500],
    ["Deluxe Room", 10000],
    ["Luxury Room", 12000],
    ["Executive Room", 13500],
    ["Premium Room", 15000],
    ["Royal Suite", 18000],
    ["Presidential Suite", 25000]
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

$roomId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($roomId < 135 || $roomId > 178){
    header("Location: room.php");
    exit;
}

$index = $roomId - 135;

$typeIndex = $index % count($roomTypes);
$imageIndex = $index % count($roomImages);

$roomType = $roomTypes[$typeIndex][0];
$price = $roomTypes[$typeIndex][1];
$image = $roomImages[$imageIndex];

$roomNumber = "R-" . $roomId;

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($roomType) ?> - Royal Stay</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#080808;
    color:#fff;
    font-family:'Montserrat',sans-serif;
}

.navbar{
    height:75px;
    background:#050505;
    border-bottom:1px solid rgba(212,175,55,.3);
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 7%;
}

.logo{
    color:#d4af37;
    text-decoration:none;
    font-family:'Playfair Display',serif;
    font-size:28px;
    font-weight:bold;
}

.nav-links{
    display:flex;
    gap:25px;
}

.nav-links a{
    color:#ddd;
    text-decoration:none;
}

.nav-links a:hover{
    color:#d4af37;
}

.container{
    width:86%;
    max-width:1250px;
    margin:70px auto;
}

.room-details{
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:45px;
    background:#111;
    border:1px solid rgba(212,175,55,.25);
    border-radius:18px;
    overflow:hidden;
}

.room-image{
    min-height:600px;
}

.room-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.content{
    padding:50px 40px;
}

.badge{
    display:inline-block;
    color:#000;
    background:#d4af37;
    padding:7px 15px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
    margin-bottom:20px;
}

h1{
    font-family:'Playfair Display',serif;
    color:#d4af37;
    font-size:44px;
    margin-bottom:15px;
}

.description{
    color:#aaa;
    line-height:1.8;
    margin-bottom:30px;
}

.price{
    color:#d4af37;
    font-size:30px;
    font-weight:bold;
    margin-bottom:30px;
}

.price span{
    color:#777;
    font-size:14px;
    font-weight:normal;
}

.features{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
    margin-bottom:35px;
}

.feature{
    background:#181818;
    padding:15px;
    border-radius:8px;
    color:#ddd;
}

.feature i{
    color:#d4af37;
    margin-right:8px;
}

.btn{
    display:inline-block;
    padding:14px 25px;
    text-decoration:none;
    border-radius:7px;
    transition:.3s;
    margin-right:10px;
}

.book{
    background:#d4af37;
    color:#000;
    font-weight:bold;
}

.book:hover{
    background:#fff;
}

.back{
    border:1px solid #555;
    color:#ddd;
}

.back:hover{
    border-color:#d4af37;
    color:#d4af37;
}

@media(max-width:850px){

    .room-details{
        grid-template-columns:1fr;
    }

    .room-image{
        min-height:350px;
    }

    .content{
        padding:35px 25px;
    }

    h1{
        font-size:34px;
    }

    .nav-links{
        display:none;
    }
}

</style>
</head>

<body>




<div class="container">

<div class="room-details">

<div class="room-image">
<img src="<?= htmlspecialchars($image) ?>"
alt="<?= htmlspecialchars($roomType) ?>">
</div>

<div class="content">

<div class="badge">
AVAILABLE
</div>

<h1><?= htmlspecialchars($roomType) ?></h1>

<p class="description">
Enjoy a premium stay at Royal Grand Hotel with elegant
interior, comfortable furniture and modern facilities.
Perfect for families, couples and business travelers.
</p>

<div class="price">
PKR <?= number_format($price) ?>
<span>/ night</span>
</div>

<div class="features">

<div class="feature">
<i class="fa-solid fa-bed"></i>
King Size Bed
</div>

<div class="feature">
<i class="fa-solid fa-wifi"></i>
Free Wi-Fi
</div>

<div class="feature">
<i class="fa-solid fa-snowflake"></i>
Air Conditioning
</div>

<div class="feature">
<i class="fa-solid fa-tv"></i>
Smart TV
</div>

<div class="feature">
<i class="fa-solid fa-bath"></i>
Private Bathroom
</div>

<div class="feature">
<i class="fa-solid fa-mug-hot"></i>
Breakfast
</div>

<div class="feature">
<i class="fa-solid fa-door-open"></i>
<?= htmlspecialchars($roomNumber) ?>
</div>

<div class="feature">
<i class="fa-solid fa-users"></i>
Up to 10 Guests
</div>

</div>

<a href="booking.php?room_id=<?= $roomId ?>"
class="btn book">
<i class="fa-solid fa-calendar-check"></i>
Book Now
</a>

<a href="room.php" class="btn back">
Back to Rooms
</a>

</div>

</div>

</div>

</body>
</html>