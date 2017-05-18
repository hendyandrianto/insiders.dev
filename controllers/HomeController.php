<?php

class HomeController extends FrontController {
    public function __construct() {
        parent::__construct();
        $this->table = 'home';
    }
    
    public function actionContent(){
        $content = Bank::getContent('home', $this->table, "");
        require_once(ROOT . '/views/templates/page_home.php');
        
        return true;
    }
}