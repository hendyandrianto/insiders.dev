<?php

class DepositController extends FrontController{
    
    public function __construct() {
        parent::__construct();
        $this->table = 'deposit';
    }
    
    public function actionContent($slug) {
        
        $content = Deposit::getContent($slug, $this->table);
        switch ($slug) {
            case "depozitnyj-kalkulyator":
                require_once(ROOT . '/views/templates/page_deposit_calc.php');
                break;
           default:
               require_once(ROOT . '/views/templates/page_empty.php');
               break;
        }
        
        return true;
    }
}
