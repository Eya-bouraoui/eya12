<?php
include_once '../../db.php';  // Connexion à la base de données

// Requête pour récupérer les produits avec les informations de l'artisan et de la catégorie
$query = "SELECT produit.*, artisan.nom AS artisan_name, categorie.nom AS categorie_name
          FROM produit
          LEFT JOIN artisan ON produit.artisan_id = artisan.id
          LEFT JOIN categorie ON produit.categorie_id = categorie.id";

$stmt = $conn->prepare($query); // Prépare la requête pour exécution
$stmt->execute(); // Exécute la requête
$results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les résultats en tant que tableau associatif
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="sidebar">
        <div class="logo">
            <ul class="menu">
                <li class="active">
                    <a href="index.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>TunisieAuthentique</span>
                    </a>
                </li>
               
                
                <li class="logout">
                    <a href="#">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <span>Primary</span>
                <h2>Dashboard</h2>
            </div>
        </div>

        <div class="tabular--wrapper">
            <h3 class="main--title">Products</h3>
            
            <!-- Button to add new product -->
            <a href="ajouter.php" class="btn btn-primary">Add New Product</a>

            <div class="table-container">
            <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Photo</th>
            <th>Category</th>
            <th>Materials</th>
            <th>Artisan Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['prix']; ?></td>
                <td><img src="uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['nom']; ?>" width="50"></td>
                <td><?php echo isset($row['categorie_name']) ? $row['categorie_name'] : 'Non renseigné'; ?></td>
                <td><?php echo $row['materials']; ?></td>
                <td><?php echo isset($row['artisan_name']) ? $row['artisan_name'] : 'Non renseigné'; ?></td>
                <td>
                    <a href="modifier.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="supprimer.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
            </div>
        </div>
    </div>
</body>
</html>
