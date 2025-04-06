<?php
require_once "Database.php";
class Categories_Database extends Database
{
    public function getCategories()
    {
        $sql = self::$connection->prepare("SELECT * FROM categories");
        $sql->execute();
        $item = array();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }

}