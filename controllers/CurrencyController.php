<?php

class CurrencyController extends FrontController {

    public function __construct() {
        parent::__construct();
        $this->table = 'currency';
        $this->sub_table = 'currency_rate';
    }

    public function actionContent($slug) {
        $content = Currency::getContent($slug, $this->table, "");

        switch ($slug) {
            case "kurs-nalichnoj-valyuty":
                $content['table'] = Currency::tableCache($content['table_data']);
                $dashboard = Currency::dashboardCache($slug);
                require_once(ROOT . '/views/templates/page_currency.php');
                break;
            case "kurs-valyut-nbu":
                $content['table'] = Currency::tableNBU($content['table_data']);
                $dashboard = Currency::dashboardNBU($slug);
                require_once(ROOT . '/views/templates/page_currency.php');
                break;
            case "kurs-bankovskikh-metallov":
                $content['table'] = Currency::tableMetall($content['table_data']);
                $dashboard = Currency::dashboardMetall($slug);
                require_once(ROOT . '/views/templates/page_currency.php');
                break;
            case "konverter-valyut":
                $cache = Currency::dataConverterCache();
                $nbu = Currency::dataConverterNBU();
                require_once(ROOT . '/views/templates/page_currency_converter.php');
                break;
        }

        return true;
    }

    public function actionAjaxCurrency() {
        $where = 'AND date = ' . '"' . $_POST['currencydate'] . '"';
        $slug = $_POST['currency_type'];
        $content = Currency::getContent($slug, $this->sub_table, $where);
        if (!$content['table_data'])
            die('<div class="alert alert-danger" role="alert">Нет данных на выбранную дату</div>');

        switch ($slug) {
            case "kurs-nalichnoj-valyuty":
                $content['table'] = Currency::tableCache($content['table_data']);
                break;
            case "kurs-valyut-nbu":
                $content['table'] = Currency::tableNBU($content['table_data']);
                break;
            case "kurs-bankovskikh-metallov":
                $content['table'] = Currency::tableMetall($content['table_data']);
                break;
        }
        die($content['table']);
    }

    /*
     * парсиг данных в бд
     * пример ссылки http://new.insiders.com.ua/parsing/currency?key=key
     */

    public function actionParsing() {
        if (!$_GET || $this->secret_key != $_GET["key"])
            die("неверный ключ");

        //date_default_timezone_set('Europe/Kiev');
        if (date('w') == 0 or date('w') == 6)
            exit('выходной');

        $tables = [$this->table, $this->sub_table];

        foreach ($tables as $table) {
            $currency_array = ['usd', 'eur', 'rub', 'chf', 'gbp'];
            $url = "http://sravnibank.com.ua/kursy-valut/cash_xml/?id=insiderscomua-032723&currency=";

            foreach ($currency_array as $currency) {
                $temp_url = $url . $currency . "&date=" . date('Y-m-d');
                $files_cache[$currency][] = $temp_url;
            }
            Currency::parseXML($files_cache, $table, 'cache');

            $files_nbu [] = "http://sravnibank.com.ua/kursy-valut/nbu_xml/?id=insiderscomua-032723"; // . $sufix;
            Currency::parseXML($files_nbu, $table, 'nbu');

            $files_mettal [] = "http://bank-ua.com/export/metalrate.xml";
            Currency::parseXML($files_mettal, $table, 'mettal');
        }
        return true;
    }
}
