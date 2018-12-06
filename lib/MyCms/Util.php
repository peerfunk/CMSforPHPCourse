<?php

namespace MyCms;


class Util extends BaseObject
{
    public static function escape(string $string) : string {
        return nl2br(htmlentities($string));
    }

    public static function action(string $action, array $params = null) : string {
        $page = isset($_REQUEST[Controller::PAGE]) ?
            $_REQUEST[Controller::PAGE] :
            $_SERVER['REQUEST_URI'];

        
        $res = 'index.php?' . Controller::ACTION . '=' . rawurlencode($action) . '&' . Controller::PAGE . '=' .
            rawurlencode($page);

        if (is_array($params)) {
            foreach ($params as $name => $value) {
                $res .= '&' . rawurlencode($name) . '=' . rawurlencode($value);
            }
        }

        return $res;
    }

    public static function redirect(string $page = null) {
        if ($page == null) {
            $page = isset($_REQUEST[Controller::PAGE]) ?
                $_REQUEST[Controller::PAGE] :
                $_SERVER['REQUEST_URI'];
        }
        header("Location: $page");
        exit();
    }
}