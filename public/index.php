<?php
define('DEBUG', 2);
define('BASIC_PATH', dirname(dirname(__FILE__)) . '/');
define('APP_LOCATION', BASIC_PATH . 'app/');

if (DEBUG == 2) {
    error_reporting(E_ALL &~ E_NOTICE);
    ini_set('display_errors', 1);
}

include BASIC_PATH . 'functions.php';

spl_autoload_register('fari_load');

if (empty($_GET['url'])) {
    $_GET['url'] = 'pages';
}

if (!empty($_GET['url'])) {
    $url = explode('/', $_GET['url']);
    $page = strtolower(preg_replace('/[^a-zA-Z0-9\_]/', '', $url[0]));
    
    $action = !empty($url[1]) ? $url[1] : 'index';
    
    if (file_exists(APP_LOCATION . 'controllers/' . $page . '.class.php')) {
        
        if ($page != $url[0]) {
            die("Error 3000 you screw too much!");
        }
        
        include APP_LOCATION . 'page.class.php';
        //include APP_LOCATION . 'app_page.class.php';
        include APP_LOCATION . 'controllers/' . $page . '.class.php';
        $className = 'pages__' . $page;
        $Page = new $className();
        if (is_callable(array($Page, $action))) {
        //if (method_exists($Page, $action)) {
            $Page->callAction($action);
        }
    }
}