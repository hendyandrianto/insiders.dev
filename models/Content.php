<?php

class Content {
    
    public static function getContentBySlug($slug) 
    {
        
        echo $slug;
        /*$db = Db::getConnection();
        
        $sql = 'SELECT * FROM Content WHERE slug = :slug';
        
        $result = $db->prepare($sql);
        $result->bindParam(':slug', $slug, PDO::PARAM_INT);
        
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $result->execute();
        
        return $result->fetch();*/
        
    }
}
