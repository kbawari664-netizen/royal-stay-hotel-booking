<?php

require_once "config/database.php";

$name = "Noor";
$email = "noorxp660@gmail.com";
$password = "112233";

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE email = ?
");

$stmt->execute([$email]);

$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {

    $stmt = $pdo->prepare("
        UPDATE users
        SET
            name = ?,
            password = ?,
            role = 'admin'
        WHERE email = ?
    ");

    $stmt->execute([
        $name,
        $hash,
        $email
    ]);

    echo "<h2>Admin updated successfully.</h2>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
    echo "<p>Password: 112233</p>";
    echo "<p>Role: admin</p>";

} else {

    $stmt = $pdo->prepare("
        INSERT INTO users
        (
            name,
            email,
            password,
            role
        )
        VALUES
        (
            ?,
            ?,
            ?,
            'admin'
        )
    ");

    $stmt->execute([
        $name,
        $email,
        $hash
    ]);

    echo "<h2>Admin created successfully.</h2>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
    echo "<p>Password: 112233</p>";
    echo "<p>Role: admin</p>";
}