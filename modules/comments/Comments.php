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

    public function ajaxForm() {
        $name = filter_input(INPUT_POST, 'comment_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $comment = filter_input(INPUT_POST, 'comment_text', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_parent = filter_input(INPUT_POST, 'id_parent');
        $content_slug = filter_input(INPUT_POST, 'content_slug');
        $content_table = filter_input(INPUT_POST, 'content_table');

        $result = $this->insertComment($name, $comment, $content_slug, $content_table, $id_parent);

        if ($result)
            $responce = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                Комментарий успешно добавлен, и будет показан на сайте после проверки модератором.
                </div>';
        else
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

}
