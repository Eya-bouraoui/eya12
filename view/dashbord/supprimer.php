<?php
include_once '../../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour supprimer
    $query = "DELETE FROM produit WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
} else {
    echo "ID manquant pour la suppression.";
}
?>

