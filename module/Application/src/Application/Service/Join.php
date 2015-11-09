<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Service;


use Zend\Db\Sql\Select;

class Join {

    private $table;
    private $condition;
    private $columns = array();
    private $type = Select::JOIN_LEFT;

    /**
     * @return mixed
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table) {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getCondition() {
        return $this->condition;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition) {
        $this->condition = $condition;
    }

    /**
     * @return array
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns($columns) {
        $this->columns = $columns;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }
}