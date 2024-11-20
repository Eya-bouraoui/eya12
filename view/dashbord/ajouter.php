<?php
include_once '../../db.php'; // Connexion à la base de données

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $materials = $_POST['materials'];
    $categorie_id = $_POST['categorie_id'];
    $artisan_id = $_POST['artisan_id'];

    // Gestion de l'upload de la photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        $filename = str_replace(' ', '_', $_FILES['photo']['name']);
        $destination = $uploadDir . $filename;

        // Vérification que le dossier existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Crée le dossier si nécessaire
        }

        // Déplacer le fichier dans le dossier de destination
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            try {
                // Insérer les données dans la base de données
                $query = "INSERT INTO produit (nom, description, prix, materials, photo, categorie_id, artisan_id) 
                          VALUES (:nom, :description, :prix, :materials, :photo, :categorie_id, :artisan_id)";
                $stmt = $conn->prepare($query);

                // Liaison des paramètres
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':prix', $prix);
                $stmt->bindParam(':materials', $materials);
                $stmt->bindParam(':photo', $filename);
                $stmt->bindParam(':categorie_id', $categorie_id);
                $stmt->bindParam(':artisan_id', $artisan_id);

                // Exécution de la requête
                if ($stmt->execute()) {
                    $message = "Produit ajouté avec succès !";
                    $messageClass = "success";
                } else {
                    $message = "Erreur lors de l'ajout du produit.";
                    $messageClass = "error";
                }
            } catch (PDOException $e) {
                $message = "Erreur : " . $e->getMessage();
                $messageClass = "error";
            }
        } else {
            $message = "Erreur lors du déplacement du fichier.";
            $messageClass = "error";
        }
    } else {
        $message = "Erreur lors de l'upload de la photo.";
        $messageClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style général du formulaire */
        form {
            display: flex;
            flex-direction: column; /* Aligner les éléments les uns sous les autres */
            max-width: 500px;
            margin: 0 auto;
        }

        /* Style des labels et des champs de saisie */
        label {
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

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

        .status-message.success {
            background-color: green;
        }

        .status-message.error {
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <!-- Ajouter ici le logo si nécessaire -->
        </div>
        <ul class="menu">
            <li><a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <!-- Autres éléments du menu -->
        </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h2>Ajouter un nouveau produit</h2>
            </div>
        </div>
        
        <form action="ajouter.php" method="POST" enctype="multipart/form-data">
            <label for="nom">Nom du produit :</label>
            <input type="text" name="nom" id="nom" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description" required></textarea>

            <label for="prix">Prix :</label>
            <input type="number" name="prix" id="prix" required>

            <label for="materials">Matériaux :</label>
            <input type="text" name="materials" id="materials" required>

            <label for="categorie_id">Catégorie :</label>
            <select name="categorie_id" id="categorie_id" required>
                <?php
                $categories = $conn->query("SELECT id, nom FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $categorie) {
                    echo "<option value='{$categorie['id']}'>{$categorie['nom']}</option>";
                }
                ?>
            </select>

            <label for="artisan_id">Artisan :</label>
            <select name="artisan_id" id="artisan_id" required>
                <?php
                $artisans = $conn->query("SELECT id, nom FROM artisan")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($artisans as $artisan) {
                    echo "<option value='{$artisan['id']}'>{$artisan['nom']}</option>";
                }
                ?>
            </select>

            <label for="photo">Photo :</label>
            <input type="file" name="photo" id="photo" required>

            <button type="submit">Ajouter</button>
        </form>
    </div>

    <!-- Affichage du message -->
    <?php if (!empty($message)): ?>
        <div class="status-message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <script>
        // Afficher le message après une action
        window.addEventListener('load', function() {
            const messageElement = document.querySelector('.status-message');
            if (messageElement) {
                messageElement.style.display = 'block';
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 5000); // Masquer le message après 5 secondes
            }
        });
    </script>
</body>
</html>
