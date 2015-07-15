<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');


// <editor-fold defaultstate="collapsed" desc="Variable-dumping functions." >
function dump_str($var) {
    ob_start();
    var_dump($var);
    $v = ob_get_clean();
    $v = highlight_string("<?\n" . $v . '?>', true);
    $v = preg_replace('/=&gt;\s*<br\s*\/>\s*(&nbsp;)+/i', '=&gt;' . "\t" . '&nbsp;', $v);
    $v = '<div style="background-color: #FFFFFF;">' . $v . '</div>';
    return $v;
}

function dump($var) {
    @header('Content-Type: text/html; charset=UTF-8');//русский текст пиздит!
    $arg_list = func_get_args();
    foreach ($arg_list as $arg) {
        echo dump_str($arg);
    }
}

function ddump($var) {
    $arg_list = func_get_args();
    foreach ($arg_list as $arg) {
        dump($arg);
    }

    echo '<pre>';
    debug_print_backtrace();
    echo '</pre>';
    die();
}

function strtolower2($string) {
    $lower = 'abcdefghijklmnopqrstuvwxyzабвгдеёжзийклмнопрстуфхцчшщъыьэюя';
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
    return strtr($string, $upper, $lower);
}

function cdump($var) {
    $arg_list = func_get_args();
    foreach ($arg_list as $arg) {
        var_dump($arg);
    }
}
function cddump($var) {
    $arg_list = func_get_args();
    foreach ($arg_list as $arg) {
        var_dump($arg);
    }
    die();
}
// </editor-fold>
