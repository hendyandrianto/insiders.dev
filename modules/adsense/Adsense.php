<?php

class Adsense extends ModuleController{
    
    public function __construct() {
        parent::__construct();
        $this->position = ['rightcolum' => 1, 'topcontent' => 1, 'bottomcontent' => 1];
        $this->name = 'adsense';
    }
    
    public function registerModule(){
        foreach($this->position as $hook => $position)
            Module::instal($this->table, $this->name, $hook, $position);
    }
    
    public function deleteModule(){
        Module::uninstal($this->table, $this->name);
    }
    
    public function getContent(){
        
    }
    
    public function hookRightcolum(){
        return require_once MODULE_DIR . $this->name . '/templates/hookRightcolum.php';
    }
    
    public function hookTopcontent(){
        return require_once MODULE_DIR . $this->name . '/templates/hookTopcontent.php';
    }
    public function hookBottomcontent(){
        return require_once MODULE_DIR . $this->name . '/templates/hookBottomcontent.php';
    }
}