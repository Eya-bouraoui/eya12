<?php

include_once('Category.php');

class CategoryController
{
    private $categories = [];

    // Ajouter une catégorie
    public function addCategory($nom, $description)
    {
        $category = new Category($nom, $description);
        $this->categories[] = $category; // Ajouter la catégorie au tableau
        echo "Catégorie ajoutée : " . $category->get_nom() . "<br>";
    }

    // Afficher toutes les catégories
    public function showAllCategories()
    {
        if (empty($this->categories)) {
            echo "Aucune catégorie disponible.<br>";
        } else {
            foreach ($this->categories as $category) {
                echo "Nom : " . $category->get_nom() . " | Description : " . $category->get_description() . "<br>";
            }
        }
    }

    // Modifier une catégorie
    public function editCategory($index, $newNom, $newDescription)
    {
        if (isset($this->categories[$index])) {
            $this->categories[$index]->set_nom($newNom);
            $this->categories[$index]->set_description($newDescription);
            echo "Catégorie mise à jour : " . $newNom . "<br>";
        } else {
            echo "Catégorie introuvable.<br>";
        }
    }

    // Supprimer une catégorie
    public function deleteCategory($index)
    {
        if (isset($this->categories[$index])) {
            unset($this->categories[$index]);
            echo "Catégorie supprimée.<br>";
        } else {
            echo "Catégorie introuvable.<br>";
        }
    }
}

?>
