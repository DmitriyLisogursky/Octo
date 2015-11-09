<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Util;


class CachePath {

    const INDEX_FILE = 'index.html';

    private $url;
    private $dir;
    private $needPublicDir = true;

    function __construct($url) {
        $this->url = $url;
    }

    public function getDir() {

        if (!$this->dir) {
            $this->dir = $this->getPublicDir() . CACHE_DIR . parse_url($this->url, PHP_URL_PATH);
        }

        return $this->dir;
    }

    public function getFile() {
        $dir = StringUtils::endsWith($this->getDir(), '/') ? $this->getDir() : $this->getDir() . '/';

        return $dir . self::INDEX_FILE;
    }

    public function generateTemplate($controller, $action) {
        $template = preg_replace('/[\/\\\]controller/', '', StringUtils::camelCaseToHyphen($controller)) . '/' . $action;

        return str_replace('\\', '/', $template);
    }

    public function writeToFile($html) {
        $myFile = fopen($this->getFile(), "w") or die("Unable to open file!");
        fwrite($myFile, $html);
        fclose($myFile);
    }

    public function isFileExists() {
        return file_exists($this->getFile());
    }

    public function createDirIfNotExists() {

        if (!file_exists($this->getDir())) {
            mkdir($this->getDir(), 0777, true);
        }
    }

    public function readFile() {
        readfile($this->getFile());
    }

    private function getPublicDir() {
        return $this->needPublicDir ? "public/" : '';
    }

    /**
     * @param boolean $needPublic
     */
    public function setNeedPublicDir($needPublic) {
        $this->needPublicDir = $needPublic;
    }
}