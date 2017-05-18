<?php

class CatalogueController extends FrontController {

    public function __construct() {
        parent::__construct();
        $this->table = 'catalogue';        
    }
    
    public function actionList(){
        $content = Catalogue::getContent('bankovskie-terminy', $this->table);
        $list = Front::getList($this->table, ' category LIKE "bankovskie-terminy"', 'title');
        require_once(ROOT . '/views/templates/page_glossary.php');
        return true;
    }

    public function actionContent($slug) {

        $content = Catalogue::getContent($slug, $this->table, "");

        switch ($slug) {
            case "zolotovalyutnye-rezervy":
                $table_current = Catalogue::tableAllZVR($content['table_data']);
                $table_all = Catalogue::tableYearZVR($content['table_data']);
                $chart = Catalogue::dashboardZVR($content['table_data'], false);
                $dashboard = Catalogue::dashboardZVR($content['table_data'], true);
                $content['text'] = str_replace('{$table_current}', $table_current, $content['text']);
                $content['text'] = str_replace('{$table_all}', $table_all, $content['text']);
                break;
            case "indeks-inflyatsii":
                $table_current = Catalogue::tableAllInfl($content['table_data']);
                $table_all = Catalogue::summaryTableInfl($content['table_data']);
                $chart = Catalogue::dashboardInfl($content['table_data'], false);
                $dashboard = Catalogue::dashboardInfl($content['table_data'], true);
                $content['text'] = str_replace('{$table_current}', $table_current, $content['text']);
                $content['text'] = str_replace('{$table_all}', $table_all, $content['text']);
                break;
            case "vneshnij-dolg":
                $table_current = Catalogue::tableAllVVD($content['table_data']);    
                $table_ratio = Catalogue::tableRatioVVP_VVD($content['table_data']);
                $chart = Catalogue::dashboardStuctureVVD($content['table_data']);
                $dashboard = Catalogue::dashboardVVD($content['table_data']);
                $content['text'] = str_replace('{$table_current}', $table_current, $content['text']);
                $content['text'] = str_replace('{$table_ratio}', $table_ratio, $content['text']);
                break;
            case "inostrannye-investitsii":
                $table_current = Catalogue::tableAllPII($content['table_data']);
                $table_all = Catalogue::tableYearPII($content['table_data']);                
                $chart = Catalogue::dashboardPII($content['table_data'], false);
                $dashboard = Catalogue::dashboardPII($content['table_data'], true);
                $chart_structure_from = Catalogue::dashboardStructurePII($content['table_data'], 'from');
                $chart_structure_to = Catalogue::dashboardStructurePII($content['table_data'], 'to');
                $content['text'] = str_replace('{$table_current}', $table_current, $content['text']);
                $content['text'] = str_replace('{$table_all}', $table_all, $content['text']);
                break;
            case "valovoj-vnutrennij-produkt":
                $table_current = Catalogue::tableAllVVP($content['table_data']);
                $table_all = Catalogue::tableYearVVP($content['table_data']);
                $table_vrp = Catalogue::tabledVRP($content['table_data']);
                $dashboard = Catalogue::dashboardVVP($content['table_data'], true);
                $chart = Catalogue::dashboardVVP($content['table_data'], false);                
                $content['text'] = str_replace('{$table_current}', $table_current, $content['text']);
                $content['text'] = str_replace('{$table_all}', $table_all, $content['text']);
                $content['text'] = str_replace('{$table_vrp}', $table_vrp, $content['text']);
                break;
        }

        require_once(ROOT . '/views/templates/page_catalogue.php');

        return true;
    }

    /*
     * парсиг данных в каталог
     * пример ссылки http://new.insiders.com.ua/parsing/catalogue?key=key
     */      
    
    public function actionParsing() {
        
        if(!$_GET || $this->secret_key != $_GET["key"])
            die("неверный ключ");
        
        $dir = 'data/catalogue/';
        $csv = array_diff(scandir($dir), array('..', '.'));

        foreach($csv as $value){
            $str = strpos($value, ".");
            $link = substr($value, 0, $str);
            $id = Front::getContent($link, $this->table, '');
            $id = $id['id'];
            Front::parseCSV($dir.$value, $this->table, $id);            
        }
        return true;
    }
    
    public function actionAjaxGlossary(){
        $letter = $_POST['letter'];
        $list = Front::getList($this->table, ' category LIKE "bankovskie-terminy" AND title LIKE "' . $letter .'%"', 'title');
        $responce = require_once(ROOT . '/views/templates/page_catalogue_pagi.php');
        die($responce);
    }
}
