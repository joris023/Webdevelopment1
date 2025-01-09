<?php
require_once __DIR__ . '../../init.php';

class Controller {

    protected function displayView($data) {
        // Extract data array to variables
        extract($data);

        // Determine the directory and method for the view file
        $directory = strtolower(str_replace('Controller', '', get_class($this)));
        $view = debug_backtrace()[1]['function'];

        // Include the appropriate view file
        require __DIR__ . "/../views/$directory/$view.php";
    }
}

/*
class Controller {
    
    function displayView($model) {        
        $directory = substr(get_class($this), 0, -10);
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../views/$directory/$view.php";
    }

}*/