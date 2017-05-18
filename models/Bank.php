<?php

class Bank extends Front {
    
    public static function getBanksList(){
        $db = Db::getConnection();
        $sql = 'SELECT `id`, `title` FROM  `banks` WHERE  `category` = "banki-ukrainy" ORDER BY `title` ASC';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll();
    }
    
    public static function getBankData($id){
        $db = Db::getConnection();
        $sql = 'SELECT title, slug FROM  `banks` WHERE  `id` = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }
}
