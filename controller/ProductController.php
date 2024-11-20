<?php
include '../db.php';

class ProductController {
    
    // Fonction pour ajouter un produit
    public function addProduct($nom, $description, $prix, $categorie_id, $materials, $artisan_id, $photo) {
        global $pdo;

        // Requête d'insertion
        $sql = "INSERT INTO produits (nom, description, prix, photo, categorie_id, materials, artisan_id) 
                VALUES (:nom, :description, :prix, :photo, :categorie_id, :materials, :artisan_id)";
        $stmt = $pdo->prepare($sql);
        
        // Exécution de la requête avec les données fournies
        $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':photo' => $photo,
            ':categorie_id' => $categorie_id,
            ':materials' => $materials,
            ':artisan_id' => $artisan_id
        ]);
    }
    
    // Fonction pour modifier un produit
    public function editProduct($id, $nom, $description, $prix, $categorie_id, $materials, $artisan_id, $photo) {
        global $pdo;

        // Requête de mise à jour
        $sql = "UPDATE produits SET nom = :nom, description = :description, prix = :prix, photo = :photo, 
                categorie_id = :categorie_id, materials = :materials, artisan_id = :artisan_id 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        // Exécution de la requête avec les nouvelles données
        $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':description' => $description,
            ':prix' => $prix,
            ':photo' => $photo,
            ':categorie_id' => $categorie_id,
            ':materials' => $materials,
            ':artisan_id' => $artisan_id
        ]);
    }
    
    // Fonction pour récupérer un produit par son ID
    public function getProductById($id) {
        global $pdo;

        // Requête pour récupérer un produit par son ID
        $sql = "SELECT * FROM produits WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch();
    }
    
    // Fonction pour récupérer tous les produits
    public function getAllProducts() {
        global $pdo;

        // Requête pour récupérer tous les produits
        $sql = "SELECT * FROM produits";
        $stmt = $pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    // Fonction pour supprimer un produit
    public function deleteProduct($id) {
        global $pdo;

        // Requête de suppression
        $sql = "DELETE FROM produits WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
?>
