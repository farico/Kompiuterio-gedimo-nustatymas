<?php
function fari_load($className) {
    $autoloadFile = BASIC_PATH . 'autoload/' . str_replace('__', '/', $className) . '.class.php';
    if (file_exists($autoloadFile)) {
        include_once BASIC_PATH . 'autoload/' . str_replace('__', '/', $className) . '.class.php';
    } else {
        include_once APP_LOCATION . str_replace('__', '/', $className) . '.class.php';
    }
}

function pr() {
    $args = func_get_args();
    foreach ($args as $var) { 
        echo '<pre>' . print_r($var, true) . '</pre>';
    }
}

/**
 * Translations function
 * @param string $string string to translate
 * @param array $params replaceable params
 * @return string translated string
 */
function t($string, $params = array()) {
    if (!empty($params)) {
        $find = array();
        $replace = array();
        foreach($params as $f => $r) {
            $find[] = '{' . $f . '}';
            $replace[] = $r;
        }
        
        $string = str_replace($find, $replace, $string);
    }
    return $string;
}

function n($iCount, $sSingular, $sPlural) {
    if ($iCount == 1 || substr($iCount, -1) == 1){
        return $sSingular;
    } elseif (substr($iCount, -1) == 0){
        return $sPlural;
    } else {
        return $sPlural;
    }
}