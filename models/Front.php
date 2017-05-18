<?php

class Front {

    public static function getContent($slug, $table, $where = '') {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `' . $table . '` WHERE slug = :slug ' . $where;
        $result = $db->prepare($sql);
        $result->bindParam(':slug', $slug, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $content = $result->fetch();

        if ($content !== false) {
            return $content;
        } else {
            header("HTTP/1.0 404 Not Found");
            require_once(ROOT . '/views/templates/page_errors.php');
            exit();
        }
    }

    public static function searchByName($name, $table, $strict = false) {
        if ($strict) {
            $compliance = '=';
        } else {
            $compliance = 'LIKE';
            $name = '%' . $name . '%';
        }

        $db = Db::getConnection();
        $sql = 'SELECT * FROM `' . $table . '` WHERE title ' . $compliance . ' :title';
        $result = $db->prepare($sql);
        $result->bindParam(':title', $name, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    public static function getList($table, $where, $orderby = 'id', $order = 'ASC', $limit = 30) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `' . $table . '` WHERE ' . $where . ' ORDER BY `' . $orderby . '` ' . $order . ' LIMIT ' . $limit;
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $answer = $result->fetchAll();
        foreach ($answer as $key => $value) {
            if (isset($answer[$key]['table_data']))
                $answer[$key]['table_data'] = json_decode($value['table_data'], TRUE);
        }
        return $answer;
    }

    public static function insertContent($table, $title, $slug, $category, $text = '', $sub_title = '', $meta_title = '', $meta_desc = '', $table_data = '') {
        $db = Db::getConnection();
        $sql = "INSERT INTO `" . $table . "` (title, sub_title, text, slug, category, meta_title, meta_desc, table_data) "
                . "VALUES (:title, :sub_title, :text, :slug, :category, :meta_title, :meta_desc, :table_data)";
        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':sub_title', $sub_title, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':slug', $slug, PDO::PARAM_STR);
        $result->bindParam(':category', $category, PDO::PARAM_STR);
        $result->bindParam(':meta_title', $meta_title, PDO::PARAM_STR);
        $result->bindParam(':meta_desc', $meta_desc, PDO::PARAM_STR);
        $result->bindParam(':table_data', $table_data, PDO::PARAM_STR);

        if ($result->execute())
            return self::searchByName($title, $table);
        else
            return false;
    }

    public static function updateContent($table, $id, $title = null, $slug, $category = null, $text = null, $sub_title = null, $meta_title = null, $meta_desc = null, $table_data = null) {
        $content = Front::getContent($slug, $table, '');
        if ($title == null)
            $title = $content['title'];
        if ($category == null)
            $category = $content['category'];
        if ($text == null)
            $text = $content['text'];
        if ($sub_title == null)
            $sub_title = $content['sub_title'];
        if ($meta_title == null)
            $meta_title = $content['meta_title'];
        if ($meta_desc == null)
            $meta_desc = $content['meta_desc'];
        if ($table_data == null)
            $table_data = $content['table_data'];

        $db = Db::getConnection();
        $sql = "UPDATE `" . $table
                . "` SET "
                . " title = :title, sub_title = :sub_title, text = :text, slug = :slug, category = :category, meta_title = :meta_title, meta_desc = :meta_desc, table_data = :table_data"
                . " WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':sub_title', $sub_title, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        $result->bindParam(':slug', $slug, PDO::PARAM_STR);
        $result->bindParam(':category', $category, PDO::PARAM_STR);
        $result->bindParam(':meta_title', $meta_title, PDO::PARAM_STR);
        $result->bindParam(':meta_desc', $meta_desc, PDO::PARAM_STR);
        $result->bindParam(':table_data', $table_data, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function parseCSV($file, $table, $id = null, $get_data = false) {
        if (!file_exists($file))
            exit('Файл ' . $file . ' не найден');

        $csv_arr = array_map('str_getcsv', file($file));

        unset($csv_arr[0]);

        foreach ($csv_arr as $value) {
            if (!isset($value[1])) {
                $key = $value[0];
                continue;
            }

            foreach ($value as $value2) {
                $data[$key][$value[0]][] = $value2;
            }
        }

        if ($get_data)
            return $data;

        $data = json_encode($data);

        $date_upd = date('Y-m-d H:i:s');

        $db = Db::getConnection();
        $sql = "UPDATE `" . $table . "` SET table_data = :data, date_upd = :date_upd WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':data', $data, PDO::PARAM_STR);
        $result->bindParam(':date_upd', $date_upd, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        return true;
    }

    public static function parseXML(array $files, $table, $curr_type) {

        if ($curr_type == 'cache') {
            foreach ($files as $key => $file) {
                if (!$xml = simplexml_load_file($file[0]))
                    exit('error load file ' . $file[0]);
                $currency_date = $xml['CashDate'];
                $currency_ratest[$key][] = $xml;
            }
        } elseif ($curr_type == 'nbu') {
            if (!$xml = simplexml_load_file($files[0]))
                exit('error load file ' . $files[0]);
            $currency_date = $xml['OfficialDate'];
            $currency_ratest = $xml;
        } elseif ($curr_type == 'mettal') {
            if (!$xml = simplexml_load_file($files[0]))
                exit('error load file ' . $files[0]);
            $currency_date = $xml[0]->item->date;
            $currency_ratest = $xml;
        }

        $type_array = [
            'cache' => ['id' => 1, 'type' => 'kurs-nalichnoj-valyuty'],
            'nbu' => ['id' => 2, 'type' => 'kurs-valyut-nbu'],
            'mettal' => ['id' => 3, 'type' => 'kurs-bankovskikh-metallov'],
        ];

        $currency_ratest_json = json_encode($currency_ratest);

        $db = Db::getConnection();

        //$date_upd = date('Y-m-d H:i:s');

        if ($table == 'currency') {
            $id = $type_array[$curr_type]['id'];
            $sql = "UPDATE `" . $table . "` SET table_data = :data WHERE id = :id"; //, date_upd = :date_upd
            $result = $db->prepare($sql);
            $result->bindParam(':data', $currency_ratest_json, PDO::PARAM_STR);
            //$result->bindParam(':date_upd', $date_upd, PDO::PARAM_STR);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute();
        } else if ($table == 'currency_rate') {
            $type = $type_array[$curr_type]['type'];
            $date_check = "SELECT MAX(`date`) FROM `currency_rate` WHERE slug = :type";
            $result = $db->prepare($date_check);
            $result->bindParam(':type', $type, PDO::PARAM_STR);
            $result->execute();
            $current_date_db = $result->fetchColumn();

            if ((string) $currency_date == (string) $current_date_db) {
                $sql = "UPDATE `" . $table . "` SET table_data = :data WHERE date = :date AND slug = :type"; //, date_upd = :date_upd
            } else {
                $sql = "INSERT INTO `" . $table . "` (`date`, `slug`, `table_data`) VALUES (:date, :type, :data)"; //, `date_upd` , :date_upd
            }

            $paste = $db->prepare($sql);
            $paste->bindParam(':type', $type, PDO::PARAM_STR);
            $paste->bindParam(':data', $currency_ratest_json, PDO::PARAM_STR);
            $paste->bindParam(':date', $currency_date, PDO::PARAM_STR);
            //$paste->bindParam(':date_upd', $date_upd, PDO::PARAM_STR);
            $paste->execute();
        }

        return true;
    }

    public static function getSiteLinks($exclude = []) {
        $tables = ['banks', 'banks_rating', 'bank_reviews', 'catalogue', 'credit', 'currency', 'deposit'];
        $db = Db::getConnection();
        foreach ($tables as $table) {
            $sql = 'SELECT `slug`, `category` FROM `' . $table . '` WHERE 1';
            $result = $db->prepare($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();
            $data_arr[$table] = $result->fetchAll();
        }

        foreach ($data_arr as $key => $value) {
            foreach ($value as $alias) {                
                $category = $alias["category"];
                
                if(in_array($category, $exclude))
                    continue;
                
                $result = array_filter($data_arr[$key], function($innerArray) use ($category) {
                    return ($category == $innerArray["slug"]);
                });

                $arr_keys = array_keys($result);
                !empty($result) ? $prefix = $result[$arr_keys[0]]["category"] . '/' : $prefix = '';
                $links[] = 'https://insiders.com.ua/' . $prefix . $alias["category"] . '/' . $alias["slug"];
            }            
        }
        return $links;
    }

}
