<?php

class BanksRatingController extends FrontController {

    public function __construct() {
        parent::__construct();
        $this->table = 'banks_rating';
    }

    public function actionContent() {
        $content = BanksRating::getContent('rejting-bankov-ukraini', $this->table);
        $table = json_decode($content['table_data'], true);
        $top_10_aktiv = BanksRating::buildTop10Table($table, 'aktivi');
        $top_10_dfl = BanksRating::buildTop10Table($table, 'dfl');
        $top_10_sk = BanksRating::buildTop10Table($table, 'sk');
        $top_10_profit = BanksRating::buildTop10Table($table, 'profit');
        $top_10_loss = BanksRating::buildTop10Table($table, 'loss');
        $chart_aktiv = BanksRating::chartData($table, 'aktivi');
        $chart_dfl = BanksRating::chartData($table, 'dfl');
        $arr1 = ['{$top_10_aktiv}', '{$top_10_dfl}', '{$top_10_sk}', '{$top_10_profit}', '{$top_10_loss}'];
        $arr2 = [$top_10_aktiv, $top_10_dfl, $top_10_sk, $top_10_profit, $top_10_loss];
        $content['text'] = str_replace($arr1, $arr2, $content['text']);

        //$arr = BanksRating::updateTop10Data();
        require_once(ROOT . '/views/templates/page_raitings_banks_all.php');

        return true;
    }

    public function actionView($slug) {
        $content = BanksRating::getContent($slug, $this->table);

        switch ($slug) {
            case "rejting-bankov-nbu":
                $latest_file = BanksRating::getLatestFile();
                $table = FrontController::parseCSVTable($latest_file['filename']);
                $attributes = BanksRating::tableAttributes();
                require_once(ROOT . '/views/templates/page_raiting_banks.php');
                break;
            case "rejting-bankov-aub":
                require_once(ROOT . '/views/templates/page_empty.php');
                break;
        }
        
        return true;
    }

    public function actionAjaxContent() {
        $dir = 'data/raiting_nbu/';
        $indicator = $_POST['indicator'];
        $year = $_POST['year'];
        $quarter = $_POST['quarter'];
        $filename = $indicator . '_' . $quarter . '_' . $year . '.csv';
        $attributes = BanksRating::tableAttributes();
        $file_name = BanksRating::fileName($indicator, $quarter, $year);
        if (false === $table = FrontController::parseCSVTable($dir . $filename))
            die('<div class="alert alert-danger" role="alert">'
                    . 'Нет данных на выбранную дату'
                    . '</div>');
        $responce = require_once(ROOT . '/views/templates/page_raiting_table.php');
        die($responce);
    }

}
