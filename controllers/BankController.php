<?php

class BankController extends FrontController {

    public function __construct() {
        parent::__construct();
        $this->table = 'banks';
    }

    public function actionContent($slug) {
        $content = Bank::getContent($slug, $this->table);
        $list = Bank::getList($this->table, ' category LIKE ' . '"' . $slug . '"');
        require_once(ROOT . '/views/templates/page_banks_view.php');

        return true;
    }

    public function actionView($category, $slug) {
        $content = Bank::getContent($slug, $this->table);
        $reviews = BanksReviews::getBankRewiev($content['id']);
        $rating_bank = BanksReviews::getRatingData($content['id']);
        $bank_data = json_decode($content['table_data'], true);
        $finrez = $bank_data['finrez_all'];
        if(isset($finrez) && !empty($finrez))
            $date_finrez = $finrez['Активы']['date'];
        unset($bank_data['Название']);
        unset($bank_data['finrez_all']);
        $banks_list = Bank::getBanksList();
        require_once(ROOT . '/views/templates/page_bank.php');
        return true;
    }

    public function actionParsingBanks() {
        $dir = 'data/banks/';
        //var_dump(BanksRating::bankFinRez(2));
        $out = parent::actionParsings($dir, $this->table);
        foreach ($out as $id => $slug){
            $finrez = BanksRating::bankFinRez($id);
            $content = Front::getContent($slug, $this->table);
            $table_data = json_decode($content['table_data'], true);
            $table_data['finrez_all'] = $finrez;
            $table_data = json_encode($table_data);
            Front::updateContent($this->table, $id, null, $slug, null, null, null, null, null, $table_data);
        }
        
        BanksRating::updateTop10Data(); // обновляем топ 10 в общем рейтинге

        return true;
    }

}
