<?php
    class Model {
        protected $conn;

        public function __construct() {
            $this->conn = new mysqli('localhost', 'root', '', 'TEST');
            $this->conn->set_charset('ascii');

            if ($this->conn->connect_errno) {
                printf("Connect failed: %s\n", $mysqli->connect_error);
                exit();
            }
            // $base_path = dirname(dirname(__DIR__));
            // //exit;
            // $this->conn = new SQLite3($base_path.'\database\test.db');
            //exit;
        }

        public function __destruct() {
            if ($this->conn) {
                $this->conn->close();
            }
        }

        // private function BindValues($stid , array $_binding_pairs) {
        //     foreach ($_binding_pairs as $key => $value) {
        //         //echo $key.' '.$value.'<br>';
        //         oci_bind_by_name($stid, $key, $_binding_pairs[$key]);
        //     }

        //     return $stid;
        // }

        public function Execute(string $_sql) {
            return $this->conn->exec($_sql);
        }

        public function Insert(string $_sql, array $_binding_pairs = []) {
           return $resource = $this->conn->query($_sql);

            //$res = $this->BindValues($resource, $_binding_pairs);
            
            //var_dump($resource);
            //return oci_execute($res);
        }

        public function Select(string $_sql, array $_binding_pairs = []) {
            $res = $this->conn->multi_query($_sql);
            //echo $this->conn->error;
            //$res = $this->BindValues($resource, $_binding_pairs);
            
            //oci_execute($res);
            //var_dump($res);
            //exit;
            $return_val = null;
            //echo oci_num_rows($resource);s
            //echo $res->num_row;

            do {
                /* store first result set */
                if ($result = $this->conn->store_result()) {
                    while ($row = $result->fetch_assoc()) {
                        $return_val[] = $row;
                    }
                    $result->free();
                }
                /* print divider */
                if ($this->conn->more_results()) {
                    
                }
            } while ($this->conn->next_result());

            // while ($row = $res->fetch_assoc()) {
            //     //var_dump($row);
            //     $return_val[] = $row;
            // }
            
            return $return_val;
        }
    }