<?php

    require_once 'db_config.php';

    abstract class Model {

        protected $db;
        protected $table_name;

        public function __construct($table_name) {
            $this->db = DataBase::getDB();
            $this->table_name = $table_name;
        }

        public function dbIsNull() {
            return is_null($this->db);
        }

        private function selectData($select_fields = null) {
            if (isset($select_fields)) {
                $field_list = '';
                foreach ($select_fields as $field)
                    $field_list .= "`$field`, ";
                $field_list = substr($field_list, 0, -2);
            } else {
                $field_list = '*';
            }
            $query = "SELECT $field_list FROM `".$this->table_name.'`';
            return $query;
        }

        private function getFilter($params, $logic_or = false) {
            $where = '';
            if ($logic_or) $logic = ' OR ';
            else $logic = ' AND ';
            foreach ($params as $p) {
                if (!empty($where)) $where .= $logic;
                $where .= "`$p` = :$p";
            }
            return " WHERE $where";
        }

        private function getOrder($order_fields, $desc = false) {
            $order = '';
            if (!empty($order_fields)) 
                foreach ($order_fields as $field) {
                    if (!empty($order)) $order .= ', ';
                    $order .= "`$field`";
                }
            if ($order && $desc) $order .= ' DESC';
            if (!empty($order)) $order = " ORDER BY $order";
            return $order;
        }

        protected function getFullData($select_fields = null, $order_fields = null, $desc = false) {
            $query = $this->selectData($select_fields);
            if (!empty($order_fields)) $query .= $this->getOrder($order_fields, $desc);
            return $this->db->pdoQuery($query, [], 'fetchAll', 'fetch');
        }

        protected function insertData($params, $return_value = 'insert_row_id') {
            $query = 'INSERT INTO `'.$this->table_name.'` ';
            $fields = '';
            $values = '';
            foreach (array_keys($params) as $p) {
                $fields .= "`$p`, ";
                $values .= ":$p, ";
            }
            $query .= '('.substr($fields, 0, -2).') VALUES('.substr($values, 0, -2).')';
            return $this->db->pdoQuery($query, $params, '', $return_value);
        }

        protected function deleteData($params, $logic_or = false) {
            $query = 'DELETE FROM `'.$this->table_name.'` ';
            $query .= $this->getFilter(array_keys($params), $logic_or);
            return $this->db->pdoQuery($query, $params);
        }

    }

?>