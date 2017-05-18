<?php

class BanksReviews extends Front {

    public static function insertReview($title, $bank, $name, $text, $rating = 0) {
        $slug = FrontController::linkRewrite($title . '-' . time());
        $category = 'otzyvy-o-bankakh';
        $sub_title = Bank::getBankData($bank)['title'];
        $meta_title = $title . ' - отзыв о банке ' . Bank::getBankData($bank)['title'];
        $meta_desc = '';
        $db = Db::getConnection();
        $sql = "INSERT INTO `bank_reviews`(`title`, `bank`, `name`, `text`, `slug`, `category`, `meta_title`, `meta_desc`, `rating`, `sub_title`) "
                . "VALUES (:title, :bank, :name, :text, :slug, :category, :meta_title, :meta_desc, :rating, :sub_title)";
        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':bank', $bank, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':slug', $slug, PDO::PARAM_STR);
        $result->bindParam(':category', $category, PDO::PARAM_STR);
        $result->bindParam(':meta_title', $meta_title, PDO::PARAM_STR);
        $result->bindParam(':meta_desc', $meta_desc, PDO::PARAM_STR);
        $result->bindParam(':rating', $rating, PDO::PARAM_STR);
        $result->bindParam(':sub_title', $sub_title, PDO::PARAM_STR);

        if($result->execute())
            return true;
        else
            return false;
    }
    
    public static function getRatingData($id){
        $sql = "SELECT COUNT(`rating`) AS count_rating, AVG(`rating`) AS avg_rating 
            FROM  `bank_reviews` WHERE  `bank` = :id";
        $db = Db::getConnection();
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute(); 
        return $result->fetch();
    }
    
    public static function getBankRewiev($id){
        $sql = "SELECT `text`, `name`, `date_add`, `rating`, `slug` FROM `bank_reviews` WHERE  `bank` = :id";
        $db = Db::getConnection();
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute(); 
        return $result->fetchAll();
    }
}
