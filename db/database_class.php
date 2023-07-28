<?php

    require_once 'db_config.php';

    class DataBase {

        private static $db = null;
        private $pdo;

        // запись в лог ошибок БД
        private function writeDBErrorLog($item_text) {
            $handler = fopen('log/db_errors.txt', 'a', true);
            fwrite($handler, date("Y-m-d H:i:s")."\n$item_text\n\n");
            fclose($handler);
        }

        public static function getDB() {
            if (self::$db == null) self::$db = new DataBase();
            return self::$db;
        }

        private function __construct() {
            try {
                $this->pdo = new PDO(
                    'mysql:host='.DB_HOST.';dbname='.DB_NAME,
                    DB_USER,
                    DB_PASSWORD,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                $this->writeDBErrorLog($e->getMessage());
            }
        }

        //универсальный метод, позволяющий выполнять разные типы запросов к БД
        public function pdoQuery($query, $params, $fetch_type = '', $return_value = '') {
            try {
                $result = $this->pdo->prepare($query);
                $ex_result = $result->execute($params);
                $result_data = false;
                if ($return_value == 'fetch') $result_data = $result->$fetch_type(PDO::FETCH_ASSOC);
                if ($return_value == 'select_row_id') {
                    $result = $result->$fetch_type(PDO::FETCH_ASSOC);
                    $result_data = $result['id'];
                }
                if ($return_value == 'insert_row_id') $result_data = $this->pdo->lastInsertId();

                return ['result' => $ex_result, 'result_data' => $result_data];

            } catch (PDOException $e) {
                $error_code = $e->getCode();
                $error_msg = $e->getMessage();
                $e = "Ошибка выполнения запроса:\n".$error_msg."\n";
                $e .= "Такой был запрос:\n".$query."\n";
                $e .= "Такие передали параметры:\n";
                foreach ($params as $p) $e .= "$p\n";
                $this->writeDBErrorLog($e);

                return ['result' => false, 'error_code' => $error_code, 'error_msg' => $error_msg];
            }
        }
    }

?>