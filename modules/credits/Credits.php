<?php

class Credits  extends ModuleController {
    public function __construct() {
        parent::__construct();
        $this->position = ['rightcolum' => 3]; // array(hook name => position)
        $this->name = 'credits';
    }

    public function registerModule() {
        Module::instal($this->table, $this->name, $this->position);
    }

    public function deleteModule() {
        Module::uninstal($this->table, $this->name);
    }

    public function getContent($qantity) {
        $list = Credit::getList('credit', ' category IN ("kreditnie-karty", "kredit-nalichnymi")');
        $random_keys = array_rand($list, $qantity);
        foreach ($random_keys as $key){
            $return[] = $list[$key];
        }
        return $return;
    }
    
    public function hookRightcolum() {        
        $list = $this->getContent(5);
        require_once MODULE_DIR . $this->name . '/templates/hookRightcolum.php';
        return true;
    }
}
