<?php
$host = 'localhost';      // Hôte de la base de données
$dbname = 'artisans';     // Nom de la base de données
$username = 'root';       // Nom d'utilisateur MySQL
$password = '';           // Mot de passe (vide pour XAMPP par défaut)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Réglez le mode d'erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion: " . $e->getMessage();
}
?>
