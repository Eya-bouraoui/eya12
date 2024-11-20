<?php
include_once '../../db.php'; // Connexion à la base de données

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
    <title>Liste des produits</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
         /* Style du bouton */
         button {
            background-color: #4CAF50; /* Couleur de fond */
            color: white; /* Texte en blanc */
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease; /* Transition pour l'effet hover */
            margin-top: 20px; /* Espacement au-dessus du bouton */
        }

        /* Effet hover sur le bouton */
        button:hover {
            background-color: #45a049; /* Couleur de fond au survol */
        }

        /* Message de statut */
        .status-message {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        < </div>
        <ul class="menu">
            <li><a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <!-- Autres éléments du menu -->
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
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
            </div>
        </div>
    </div>
</body>
</html>
