<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Util;


class StringUtils {

    public static function startsWith($haystack, $needle) {
        return (substr($haystack, 0, strlen($needle)) === $needle);
    }

    public static function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    /**
     * @param $controllerName
     * @return string
     */
    public static function camelCaseToHyphen($controllerName) {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $controllerName));
    }
}