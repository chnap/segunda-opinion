<?php
require_once 'conexion_db.php';

$username = "admin";
$nueva_contrasena = "OncoAdmin2026!"; 
$email_usuario = "admin@onco.com";

$nuevo_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("SELECT id FROM backend_users WHERE email = ? OR username = ?");
    $stmt->execute([$email_usuario, $username]);
    $user = $stmt->fetch();

    if ($user) {
        $update = $pdo->prepare("UPDATE backend_users SET password_hash = ?, username = ? WHERE email = ?");
        $update->execute([$nuevo_hash, $username, $email_usuario]);
        echo "<h3 style='color: green;'>¡Contraseña actualizada con éxito! Usuario: <code>$username</code> / Clave: <code>$nueva_contrasena</code></h3>";
    } else {
        $insert = $pdo->prepare("INSERT INTO backend_users (username, email, password_hash, role) VALUES (?, ?, ?, 'ADMIN')");
        $insert->execute([$username, $email_usuario, $nuevo_hash]);
        echo "<h3 style='color: green;'>¡Usuario creado con éxito! Usuario: <code>$username</code> / Clave: <code>$nueva_contrasena</code></h3>";
    }
    echo "<p><strong>Recuerda eliminar este archivo (cambiar_pass.php) cuando termines por seguridad.</strong></p>";

} catch (Exception $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
}
?>