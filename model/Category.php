<?php

class Category
{
    private $nom;
    private $description;

    public function __construct($nom, $description)
    {
        $this->nom = $nom;
        $this->description = $description;
    }

    //--------------------- Getters  --------------------------//

    public function get_nom()
    {
        return $this->nom;
    }

    public function get_description()
    {
        return $this->description;
    }

    //----------------------- Setters  -------------------------//

    public function set_nom($newName)
    {
        $this->nom = $newName;
    }

    public function set_description($newDescription)
    {
        $this->description = $newDescription;
    }
}

?>