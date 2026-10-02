<?php

session_start();

require_once "config/database.php";


/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];


/*
|--------------------------------------------------------------------------
| ROOM DATA
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| GET ROOM ID
|--------------------------------------------------------------------------
*/

$roomId = isset($_GET["room_id"])
    ? (int)$_GET["room_id"]
    : 0;


/*
|--------------------------------------------------------------------------
| VALIDATE ROOM
|--------------------------------------------------------------------------
*/

if ($roomId < 135 || $roomId > 178) {

    header("Location: room.php");
    exit;
}


$index = $roomId - 135;

$typeIndex = $index % count($roomTypes);
$imageIndex = $index % count($roomImages);

$roomType = $roomTypes[$typeIndex][0];
$pricePerNight = $roomTypes[$typeIndex][1];
$roomImage = $roomImages[$imageIndex];

$roomNumber = "R-" . $roomId;


/*
|--------------------------------------------------------------------------
| VARIABLES
|--------------------------------------------------------------------------
*/

$error = "";

$guestName = "";
$email = "";
$phone = "";
$checkIn = "";
$checkOut = "";
$guests = 1;


/*
|--------------------------------------------------------------------------
| BOOKING SUBMIT
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $guestName = trim($_POST["guest_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    $checkIn = $_POST["check_in"] ?? "";
    $checkOut = $_POST["check_out"] ?? "";

    $guests = (int)($_POST["guests"] ?? 1);


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($guestName === "") {

        $error = "Please enter guest name.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif ($phone === "") {

        $error = "Please enter phone number.";

    } elseif ($checkIn === "" || $checkOut === "") {

        $error = "Please select check-in and check-out dates.";

    } elseif ($guests < 1 || $guests > 10) {

        $error = "Guests must be between 1 and 10.";

    } else {

        try {

            $today = new DateTime();
            $inDate = new DateTime($checkIn);
            $outDate = new DateTime($checkOut);

            /*
            |--------------------------------------------------------------------------
            | DATE VALIDATION
            |--------------------------------------------------------------------------
            */

            if ($inDate < $today->setTime(0, 0, 0)) {

                $error = "Check-in date cannot be in the past.";

            } elseif ($outDate <= $inDate) {

                $error = "Check-out date must be after check-in date.";

            } else {

                $nights = $inDate->diff($outDate)->days;

                $totalPrice = $nights * $pricePerNight;


                /*
                |--------------------------------------------------------------------------
                | CHECK ROOM AVAILABILITY
                |--------------------------------------------------------------------------
                */

                $availabilitySql = "
                    SELECT COUNT(*)
                    FROM bookings
                    WHERE room_id = ?
                    AND status IN ('Pending', 'Confirmed')
                    AND check_in < ?
                    AND check_out > ?
                ";

                $availabilityStmt = $pdo->prepare($availabilitySql);

                $availabilityStmt->execute([
                    $roomId,
                    $checkOut,
                    $checkIn
                ]);

                $alreadyBooked = (int)$availabilityStmt->fetchColumn();


                if ($alreadyBooked > 0) {

                    $error = "Sorry, this room is already booked for the selected dates.";

                } else {


                    /*
                    |--------------------------------------------------------------------------
                    | INSERT BOOKING
                    |--------------------------------------------------------------------------
                    */

                    $sql = "
                        INSERT INTO bookings
                        (
                            user_id,
                            room_id,
                            guest_name,
                            email,
                            phone,
                            check_in,
                            check_out,
                            guests,
                            total_price,
                            status,
                            created_at
                        )
                        VALUES
                        (
                            :user_id,
                            :room_id,
                            :guest_name,
                            :email,
                            :phone,
                            :check_in,
                            :check_out,
                            :guests,
                            :total_price,
                            :status,
                            NOW()
                        )
                    ";

                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([

                        ":user_id" => $userId,

                        ":room_id" => $roomId,

                        ":guest_name" => $guestName,

                        ":email" => $email,

                        ":phone" => $phone,

                        ":check_in" => $checkIn,

                        ":check_out" => $checkOut,

                        ":guests" => $guests,

                        ":total_price" => $totalPrice,

                        ":status" => "Pending"
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | GET BOOKING ID
                    |--------------------------------------------------------------------------
                    */

                    $bookingId = (int)$pdo->lastInsertId();


                    /*
                    |--------------------------------------------------------------------------
                    | SESSION BACKUP
                    |--------------------------------------------------------------------------
                    */

                    $_SESSION["booking"] = [

                        "booking_id" => $bookingId,

                        "room_id" => $roomId,

                        "guest_name" => $guestName,

                        "email" => $email,

                        "phone" => $phone,

                        "check_in" => $checkIn,

                        "check_out" => $checkOut,

                        "guests" => $guests,

                        "nights" => $nights,

                        "total_price" => $totalPrice
                    ];


                    /*
                    |--------------------------------------------------------------------------
                    | REDIRECT
                    |--------------------------------------------------------------------------
                    */

                    header(
                        "Location: booking-confirmation.php?booking_id=" . $bookingId
                    );

                    exit;
                }
            }

        } catch (Exception $e) {

            $error = "Booking error: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Book Room - Royal Stay</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
rel="stylesheet">

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

    min-height:100vh;
}

.navbar{

    height:75px;

    background:#050505;

    border-bottom:1px solid rgba(212,175,55,.3);

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:0 7%;
}

.logo{

    color:#d4af37;

    font-family:'Playfair Display',serif;

    font-size:28px;

    font-weight:bold;

    text-decoration:none;
}

.nav-links{

    display:flex;

    gap:25px;
}

.nav-links a{

    color:#ddd;

    text-decoration:none;

    font-size:14px;

    transition:.3s;
}

.nav-links a:hover{

    color:#d4af37;
}

.container{

    width:90%;

    max-width:1100px;

    margin:60px auto;
}

.booking-box{

    display:grid;

    grid-template-columns:40% 60%;

    background:#111;

    border:1px solid rgba(212,175,55,.3);

    border-radius:18px;

    overflow:hidden;

    box-shadow:0 20px 60px rgba(0,0,0,.5);
}

.room-preview{

    background:#0b0b0b;

    padding:30px;
}

.room-preview img{

    width:100%;

    height:280px;

    object-fit:cover;

    border-radius:12px;

    margin-bottom:25px;
}

.room-preview h2{

    color:#d4af37;

    font-family:'Playfair Display',serif;

    margin-bottom:12px;
}

.room-preview p{

    color:#aaa;

    margin:10px 0;
}

.room-price{

    color:#d4af37;

    font-size:25px;

    font-weight:bold;

    margin-top:20px;
}

.room-price span{

    font-size:12px;

    color:#777;
}

.form-area{

    padding:40px;
}

.form-area h1{

    color:#d4af37;

    font-family:'Playfair Display',serif;

    font-size:38px;

    margin-bottom:30px;
}

.error{

    background:#351111;

    color:#ff8f8f;

    border:1px solid #7d3030;

    padding:14px;

    border-radius:7px;

    margin-bottom:20px;
}

.form-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:18px;
}

.form-group{

    display:flex;

    flex-direction:column;
}

.form-group.full{

    grid-column:1/-1;
}

label{

    color:#ccc;

    margin-bottom:8px;

    font-size:13px;
}

input,
select{

    width:100%;

    background:#181818;

    color:#fff;

    border:1px solid #333;

    padding:13px;

    border-radius:7px;

    outline:none;

    font-family:'Montserrat',sans-serif;
}

input:focus,
select:focus{

    border-color:#d4af37;

    box-shadow:0 0 10px rgba(212,175,55,.1);
}

.summary{

    margin-top:25px;

    padding:20px;

    background:#181818;

    border-radius:10px;

    border:1px solid #282828;
}

.summary-row{

    display:flex;

    justify-content:space-between;

    padding:8px 0;

    color:#aaa;
}

.summary-row strong{

    color:#fff;
}

.total{

    border-top:1px solid #333;

    margin-top:10px;

    padding-top:15px;

    color:#d4af37;

    font-size:22px;

    font-weight:bold;
}

.submit-btn{

    width:100%;

    margin-top:25px;

    padding:15px;

    border:none;

    border-radius:8px;

    background:#d4af37;

    color:#000;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;
}

.submit-btn:hover{

    background:#fff;

    transform:translateY(-2px);
}

@media(max-width:850px){

    .booking-box{

        grid-template-columns:1fr;
    }

    .form-grid{

        grid-template-columns:1fr;
    }

    .form-group.full{

        grid-column:auto;
    }

    .nav-links{

        display:none;
    }
}

</style>

</head>

<body>


<?php

$page_title = "";

require_once "header.php";

?>


<div class="container">

<div class="booking-box">


<div class="room-preview">

<img src="<?= htmlspecialchars($roomImage) ?>"
alt="<?= htmlspecialchars($roomType) ?>">

<h2>
<?= htmlspecialchars($roomType) ?>
</h2>

<p>
<i class="fa-solid fa-hotel"></i>
Royal Grand Hotel
</p>

<p>
<i class="fa-solid fa-location-dot"></i>
Karachi, Pakistan
</p>

<p>
<i class="fa-solid fa-door-open"></i>
Room <?= htmlspecialchars($roomNumber) ?>
</p>

<p>
<i class="fa-solid fa-wifi"></i>
Free Wi-Fi
</p>

<p>
<i class="fa-solid fa-users"></i>
Maximum 10 Guests
</p>

<div class="room-price">

PKR <?= number_format($pricePerNight) ?>

<span>/ night</span>

</div>

</div>


<div class="form-area">

<h1>
Book Your Room
</h1>


<?php if($error !== ""): ?>

<div class="error">

<i class="fa-solid fa-circle-exclamation"></i>

<?= htmlspecialchars($error) ?>

</div>

<?php endif; ?>


<form method="POST">


<div class="form-grid">


<div class="form-group">

<label>
Guest Name
</label>

<input
type="text"
name="guest_name"
placeholder="Enter guest name"
value="<?= htmlspecialchars($guestName) ?>"
required>

</div>


<div class="form-group">

<label>
Email
</label>

<input
type="email"
name="email"
placeholder="Enter email"
value="<?= htmlspecialchars($email) ?>"
required>

</div>


<div class="form-group">

<label>
Phone
</label>

<input
type="text"
name="phone"
placeholder="03XXXXXXXXX"
value="<?= htmlspecialchars($phone) ?>"
required>

</div>


<div class="form-group">

<label>
Guests
</label>

<select name="guests" id="guests">

<?php for($i=1;$i<=10;$i++): ?>

<option
value="<?= $i ?>"
<?= $guests == $i ? "selected" : "" ?>>

<?= $i ?> Guest<?= $i > 1 ? "s" : "" ?>

</option>

<?php endfor; ?>

</select>

</div>


<div class="form-group">

<label>
Check In
</label>

<input
type="date"
name="check_in"
id="check_in"
value="<?= htmlspecialchars($checkIn) ?>"
required>

</div>


<div class="form-group">

<label>
Check Out
</label>

<input
type="date"
name="check_out"
id="check_out"
value="<?= htmlspecialchars($checkOut) ?>"
required>

</div>


</div>


<div class="summary">

<div class="summary-row">

<span>Price per night</span>

<strong>
PKR <?= number_format($pricePerNight) ?>
</strong>

</div>


<div class="summary-row">

<span>Nights</span>

<strong id="nights">
0
</strong>

</div>


<div class="summary-row total">

<span>Total Price</span>

<strong id="total">
PKR 0
</strong>

</div>

</div>


<button type="submit"
class="submit-btn">

<i class="fa-solid fa-calendar-check"></i>

Confirm Booking

</button>


</form>

</div>

</div>

</div>


<script>

const checkIn =
document.getElementById("check_in");

const checkOut =
document.getElementById("check_out");

const nights =
document.getElementById("nights");

const total =
document.getElementById("total");

const price =
<?= (int)$pricePerNight ?>;


function calculateTotal(){

    if(!checkIn.value || !checkOut.value){

        nights.textContent = "0";

        total.textContent = "PKR 0";

        return;
    }

    const start =
    new Date(checkIn.value);

    const end =
    new Date(checkOut.value);

    const difference =
    end - start;

    const numberOfNights =
    Math.ceil(
        difference / (1000 * 60 * 60 * 24)
    );

    if(numberOfNights > 0){

        nights.textContent =
        numberOfNights;

        total.textContent =
        "PKR " +
        (numberOfNights * price)
        .toLocaleString();

    }else{

        nights.textContent = "0";

        total.textContent = "PKR 0";
    }
}


checkIn.addEventListener(
    "change",
    calculateTotal
);

checkOut.addEventListener(
    "change",
    calculateTotal
);


calculateTotal();

</script>

</body>

</html>