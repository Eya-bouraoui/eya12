<?php

class Produit {
    // Définition des propriétés
    private $id;
    private $nom;
    private $description;
    private $prix;
    private $photo;
    private $categorie_id;
    private $materials;
    private $artisan_id;

    // Base de données et connexion PDO
    private $conn;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour ajouter un produit
    public function ajouter() {
        $query = "INSERT INTO produit (nom, description, prix, photo, categorie_id, materials, artisan_id)
                  VALUES (:nom, :description, :prix, :photo, :categorie_id, :materials, :artisan_id)";

        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':categorie_id', $this->categorie_id);
        $stmt->bindParam(':materials', $this->materials);
        $stmt->bindParam(':artisan_id', $this->artisan_id);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour modifier un produit
    public function modifier() {
        $query = "UPDATE produit
                  SET nom = :nom, description = :description, prix = :prix, photo = :photo, 
                      categorie_id = :categorie_id, materials = :materials, artisan_id = :artisan_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':categorie_id', $this->categorie_id);
        $stmt->bindParam(':materials', $this->materials);
        $stmt->bindParam(':artisan_id', $this->artisan_id);
        $stmt->bindParam(':id', $this->id);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour supprimer un produit
    public function supprimer() {
        $query = "DELETE FROM produit WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison du paramètre
        $stmt->bindParam(':id', $this->id);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour récupérer tous les produits
    public function getProduits() {
        $query = "SELECT produit.*, artisan.nom AS artisan_name, categorie.nom AS categorie_name
                  FROM produit
                  LEFT JOIN artisan ON produit.artisan_id = artisan.id
                  LEFT JOIN categorie ON produit.categorie_id = categorie.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Méthode pour récupérer un produit par son ID
    public function getProduitParId() {
        $query = "SELECT produit.*, artisan.nom AS artisan_name, categorie.nom AS categorie_name
                  FROM produit
                  LEFT JOIN artisan ON produit.artisan_id = artisan.id
                  LEFT JOIN categorie ON produit.categorie_id = categorie.id
                  WHERE produit.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

    // Getters et Setters pour chaque propriété
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function getCategorieId() {
        return $this->categorie_id;
    }

    public function setCategorieId($categorie_id) {
        $this->categorie_id = $categorie_id;
    }

    public function getMaterials() {
        return $this->materials;
    }

    public function setMaterials($materials) {
        $this->materials = $materials;
    }

    public function getArtisanId() {
        return $this->artisan_id;
    }

    public function setArtisanId($artisan_id) {
        $this->artisan_id = $artisan_id;
    }
}
?>
