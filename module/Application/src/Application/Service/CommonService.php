<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 26-Oct-15
 * Time: 10:32
 */

namespace Application\Service;


use Application\Controller\CommonController;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class CommonService extends CommonController {

    /**
     * @var TableGateway
     */
    protected $table;
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;
    /**
     * @var mixed
     */
    protected $prototype;
    /**
     * @var array|Join[]
     */
    protected $joins = array();

    /**
     * @param $name
     * @param ServiceLocatorInterface $sm
     * @param string $module
     * @return mixed
     */
    public static function newService($name, $sm, $module = 'Application') {
        $service = $module . '\Service\\' . $name . 'ServiceInterface';

        return $sm->get($service);
    }

    /**
     * @param int|string $id
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function find($id) {
        return $this->findRecordByColumnValue(array('id' => $id));
    }

    /**
     * @param array $where
     * @param array $order
     * @return mixed
     */
    public function findRecordByColumnValue($where, $order = array()) {
        $result = $this->findRecordsByColumnValue($where, $order);

        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
    }

    public function save($record) {
        $reportArray = array_filter($this->hydrator->extract($record), function ($e) {
            return $e !== null;
        });

        if ($record->getId() > 0) {
            $this->table->update($reportArray, array('id' => $record->getId()));

            return $record->getId();
        } else {
            $this->table->insert($reportArray);

            return $this->table->getAdapter()->getDriver()->getLastGeneratedValue($this->table->getTable() . '_id_seq');
        }
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete($id) {
        return $this->table->delete(array('id' => $id));
    }

    /**
     * @param array $columnValueArr
     * @return int
     */
    public function deleteRecordByColumnValue($columnValueArr) {
        return $this->table->delete($columnValueArr);
    }

    /**
     * @param null $where
     * @param array $order
     * @param array $limit
     * @return array
     */
    public function findAll($where = null, $order = array(), $limit = array()) {
        return $this->findRecordsByColumnValue($where, $order, $limit);
    }

    /**
     * @param array|Where $where
     * @param array $order
     * @param array $limit
     * @return array
     */
    public function findRecordsByColumnValue($where, $order = array(), $limit = array()) {
        $table = $this->table->getTable();

        $sqlSelect = $this->table->getSql()->select();

        if (is_array($where)) {
            $options = $this->getWhereOptions($table, $where);
            $sqlSelect->where($options);

        } else if ($where instanceof Where) {
            $sqlSelect->where($where);
        }

        if (count($limit) > 1) {
            $sqlSelect->limit($limit['limit'])->offset($limit['offset']);
        }

        $sqlSelect->order($order);

        foreach ($this->joins as $join) {
            $sqlSelect->join($join->getTable(), $join->getCondition(), $join->getColumns(), $join->getType());
        }

        $result = $this->table->selectWith($sqlSelect);
        $items = array();

        foreach ($result as $item) {
            $items[] = $item;
        }

        return $items;
    }

    /**
     * @param $table
     * @param array $where
     * @return array
     */
    private function getWhereOptions($table, $where) {
        $options = array();

        if (is_array($where)) {
            $options = $this->iterateColumns($table, $where);
        }

        return $options;
    }

    /**
     * @param $table
     * @param $where
     * @return array
     */
    private function iterateColumns($table, $where) {
        $options = array();

        foreach ($where as $column => $value) {

            if ($this->isColumnWithoutAlias($column)) {
                $options += array($table . '.' . $column => $value);
            }
        }

        return $options;
    }

    /**
     * @param $column
     * @return bool
     */
    private function isColumnWithoutAlias($column) {
        return strpos($column, '.') === false;
    }
}