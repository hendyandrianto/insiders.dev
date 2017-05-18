<?php

class ModuleController extends FrontController {
    
    public $position;
    public $name;
    public $display_only_on_cat; // показывать только на определенных категориях
    public $exclude_pages; // не показывать на страницах


    public function __construct() {
        parent::__construct();
        $this->table = 'modules';
    }
    
    public function getModules($hook, $params = []){        
        $module_list = Module::getModules($this->table, $hook);
        
        foreach ($module_list as $module){
            $position[] = $module['position'];
        }
        if(isset($position) && is_array($position))
            array_multisort($position, $module_list);
        
        foreach($module_list as $single_module){
            $display_categories = explode(',', $single_module['display_only_on_cat']);
            $exclude_pages = explode(',', $single_module['exclude_pages']);

            if(empty($params) 
                    || (empty(array_filter($display_categories)) && empty(array_filter($exclude_pages))) 
                    || (in_array($params['category'], $display_categories) && !in_array($params['slug'], $exclude_pages))
                    || (empty(array_filter($display_categories)) && !in_array($params['slug'], $exclude_pages))
                    || (empty(array_filter($exclude_pages)) && in_array($params['slug'], $display_categories)))
                $this->loadModule($single_module['name'], $hook, $params);
        }

        return true;
    }
    
    private function loadModule($name, $hook, $params = [], $no_hook = false){        
        $module_dir = MODULE_DIR . $name . '/';
        $module_class = ucfirst($name);
        $module_file = $module_dir . $module_class . '.php';
        
        if(!$no_hook)
            $method = 'hook' . ucfirst($hook);
        else
            $method = $hook;
        
        include_once($module_file);
        $module_obj = new $module_class;
        
        $content = call_user_func([$module_obj, $method], $params);
        
        return $content;        
    }
    
    public function formsProcessing($module_name){
        $responce = $this->loadModule($module_name, 'ajaxForm', [], true);
        die($responce);        
    }
    
    public function noAjaxRequest($module_name, $action, $id)
    {
        $action = 'action' . ucfirst($action);
        $this->loadModule($module_name, $action, $id, true);
        return true;
    }
}
