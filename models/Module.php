<?php

class Module extends Front {

    public static function instal($table, $name, $hook, $position) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO `' . $table . '`(`name`, `hook`, `position`) VALUES (:name, :hook, :position)';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':hook', $hook, PDO::PARAM_STR);
        $result->bindParam(':position', $position, PDO::PARAM_INT);
        $result->execute();

        return true;
    }

    public static function uninstal($table, $module_name) {
        $db = Db::getConnection();
        $sql = 'DELETE FROM `' . $table . '` WHERE `name` = :name';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $module_name, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function getModules($table, $hook) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `' . $table . '` WHERE `hook` = :hook';
        $result = $db->prepare($sql);
        $result->bindParam(':hook', $hook, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchAll();
    }

}
