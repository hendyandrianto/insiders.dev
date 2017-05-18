<?php

class Comments extends ModuleController {

    public function __construct() {
        parent::__construct();
        $this->sub_table = 'comments';
        $this->position = ['bottomcontent' => 2];
        $this->name = 'comments';
    }

    public function registerModule() {
        foreach ($this->position as $hook => $position)
            Module::instal($this->table, $this->name, $hook, $position);
    }

    public function deleteModule() {
        Module::uninstal($this->table, $this->name);
    }

    public function getContent($table, $slug) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `' . $this->sub_table . '` WHERE content_table = :table AND content_slug = :slug ORDER BY date_add DESC';
        $result = $db->prepare($sql);
        $result->bindParam(':table', $table, PDO::PARAM_STR);
        $result->bindParam(':slug', $slug, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        $all_comments = $result->fetchAll();

        if (!isset($all_comments) || empty($all_comments))
            return FALSE;

        foreach ($all_comments as $value) {
            $comments[$value['id']] = $value;
            $comments_tmp[$value['id']] = $value;
        }

        foreach ($comments as $key => $comment) {
            if ($comment["id_parent"] != 0) {
                $id = $comment["id_parent"];

                $comments[$id]['anwers'] = array_filter(array_reverse($comments_tmp, true), function($innerArray) use ($id) {
                    return ($innerArray["id_parent"] == $id);
                });

                unset($comments[$key]);
            }
        }
        return $comments;
    }

    public function ajaxForm() 
    {
        $response_capcha = $this->verifyRecapcha();
        if ($response_capcha == null && !$response_capcha->success)
            return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                    Не пройдена проверка Capcha.
                </div>';
        
        $name = filter_input(INPUT_POST, 'comment_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $comment = filter_input(INPUT_POST, 'comment_text', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_parent = filter_input(INPUT_POST, 'id_parent');
        $content_slug = filter_input(INPUT_POST, 'content_slug');
        $content_table = filter_input(INPUT_POST, 'content_table');

        $result = $this->insertComment($name, $comment, $content_slug, $content_table, $id_parent);
        
        if ($result) {
            $responce = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                Комментарий успешно добавлен, и будет показан на сайте после проверки модератором.
                </div>';
            
            $param = ['name' => $name, 'comment' => $comment, 'content_slug' => $content_slug];
            $comment_id = $this->getCommentId($param);
            $param['comment_id'] = $comment_id["id"];
            $this->sendMail($param);
        } else
            $responce = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                Ошибка. Комментарий не добавлен. Попробуйте через несколько минут.
                </div>';

        return $responce;
    }

    public function hookBottomcontent($params) {
        $comments = $this->getContent($params['table'], $params['slug']);
        return include MODULE_DIR . $this->name . '/templates/hookBottomcontent.php';
    }

    private function insertComment($name, $comment, $content_slug, $content_table, $id_parent = null) {
        $db = Db::getConnection();
        $sql = "INSERT INTO `" . $this->sub_table . "`(`id_parent`, `name`, `comment`, `content_slug`, `content_table`) "
                . "VALUES (:id_parent, :name, :comment, :content_slug, :content_table)";
        $result = $db->prepare($sql);
        $result->bindParam(':id_parent', $id_parent, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':comment', $comment, PDO::PARAM_STR);
        $result->bindParam(':content_slug', $content_slug, PDO::PARAM_STR);
        $result->bindParam(':content_table', $content_table, PDO::PARAM_STR);

        return $result->execute();
    }

    // отправка сообщения на почту
    private function sendMail($param) {
        $to = "lloonnyyaa@gmail.com";
        $subject = '=?utf-8?B?' . base64_encode('Новый комментарий на сайте') . '?=';
        $message = "
        <html>
            <head>
                <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                <title>Новый комментарий на сайте</title> 
            </head> 
            <body>
                <p><strong>Автор комментария:</strong> " . $param['name'] . "</p>
                <p><strong>Текст комментария:</strong> " . $param['comment'] . "</p>
                <a href='//dev.insiders.com.ua/module/comments/delete/{$param['comment_id']}' style='border:1px solid #d5d5d5;padding:5px;background:#e5e5e5;text-decoration:none'>Удалить комментарий</a>
            </body> 
        </html>";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: insiders: new comment <info@insiders.com.ua>' . "\r\n";
        
        mail($to, $subject, $message, $headers);
    }
    
    // Удаление комментария
    public function actionDelete($id) 
    {
        $db = Db::getConnection();
        $sql = "DELETE FROM " . $this->sub_table . " WHERE `id` = " . $id;
        $result = $db->prepare($sql);
        $result->execute();
        
        echo 'Комментарий удален';
        return true;
    }

    private function getCommentId($param)
    {
        $db = Db::getConnection();
        $sql = "SELECT `id` FROM `comments` WHERE `name` = :name AND `comment` = :comment AND `content_slug` = :content_slug";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $param['name'], PDO::PARAM_STR);
        $result->bindParam(':comment', $param['comment'], PDO::PARAM_STR);
        $result->bindParam(':content_slug', $param['content_slug'], PDO::PARAM_STR);
        $result->execute();
        
        return $result->fetch();
    }
}
