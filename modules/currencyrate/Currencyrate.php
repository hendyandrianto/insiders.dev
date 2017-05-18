<?php

class Currencyrate extends ModuleController {

    public function __construct() {
        parent::__construct();
        $this->position = ['rightcolum' => 1, 'homeright' => 1]; // array(hook name => position)
        $this->name = 'currencyrate';
    }

    public function registerModule() {
        Module::instal($this->table, $this->name, $this->position);
    }

    public function deleteModule() {
        Module::uninstal($this->table, $this->name);
    }

    public function getContent() {
        $db = DB::getConnection();
        $sql = "SELECT c.`table_data` AS 'cash', n.`table_data` AS 'nbu' "
                . "FROM `currency_rate` c "
                . "JOIN `currency_rate` n ON n.`slug` = 'kurs-valyut-nbu' AND n.`date` = (SELECT MAX(`date`) FROM `currency_rate` WHERE `slug` = 'kurs-valyut-nbu') "
                . "WHERE c.`slug` = 'kurs-nalichnoj-valyuty' AND c.`date` = (SELECT MAX(`date`) FROM `currency_rate` WHERE `slug` = 'kurs-nalichnoj-valyuty')";
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $ratest = $result->fetch();

        $curr_arr = ['usd', 'eur', 'rub'];

        $rate_cash = json_decode($ratest["cash"], true);
        $rate_nbu = json_decode($ratest["nbu"], true);

        foreach ($curr_arr as $curr) {
            $summ_buy = 0;
            $summ_sell = 0;
            $kol = 0;
            foreach ($rate_cash[$curr][0]["Bank"] as $bank) {
                $summ_buy += $bank['Buy'];
                $summ_sell += $bank['Sale'];
                $kol++;
            }
            $average_array[$curr]['average_buy'] = $summ_buy / $kol;
            $average_array[$curr]['average_sell'] = $summ_sell / $kol;
            
            foreach($rate_nbu["Currency"] as $curr_nbu){
                if(strtoupper($curr) != $curr_nbu["Code"])
                    continue;
                
                $average_array[$curr]['nbu'] = $curr_nbu["Rate"];
            }
        }     
        
        return $average_array;
    }

    public function hookRightcolum() {
        $content = $this->getContent();
        require_once MODULE_DIR . $this->name . '/templates/hookRightcolum.php';
        return true;
    }

}
