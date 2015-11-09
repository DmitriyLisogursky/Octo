<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Model;


abstract class Model {

    protected $id;
    protected $nonCamelColumns = array();

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function exchangeArray($data) {
        $this->hydrateMainTableColumns($data);
        $this->hydrateJoinedColumns($data);
    }

    public function getArrayCopy() {
        return $this->replaceNonCamelCaseColumns($this->nonCamelColumns);
    }

    /**
     * @param $keys
     * @return mixed
     */
    protected function replaceNonCamelCaseColumns($keys) {
        $arr = get_object_vars($this);

        foreach ($keys as $key) {
            $arr[$key] = $arr[self::toCamelCase($key)];
            unset($arr[self::toCamelCase($key)]);
        }

        return $arr;
    }

    /**
     * @param $data
     */
    protected function hydrateMainTableColumns($data) {

        foreach ($data as $property => $value) {
            $property = self::toCamelCase($property);

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    public static function toCamelCase($str, array $noStrip = []) {
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }

    protected function hydrateJoinedColumns($data) {
    }
}