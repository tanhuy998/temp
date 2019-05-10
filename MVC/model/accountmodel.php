<?php
    class AccountModel extends Model {

        public function __construct() {
            parent::__construct();
        }

        public function GetAll() {

        }

        public function GetSingle(string $_account, string $_pass) {
            $sql = "SELECT * FROM USERS WHERE USERS.NAME = $_account AND USERS.PASS = $_pass";

            //$binding_pairs = [':account' => $_account, ':pass' => $_pass];

            $resource = $this->Select($sql);

            if (count($resource) === 1) {
                return $resource;
            }
            else return null;
        }

        public function GetByUserName(string $_username) {
            $sql = 'SELECT * FROM USERS WHERE USERS.NAME = \''.$_username.'\'';

            //$sql = 'SELECT * FROM ACCOUNT WHERE ACCOUNT.ACCOUNT_NAME = :account';
            
            //$binding_pairs = [':account' => $_username];

            $resource = $this->Select($sql);

            //var_dump($resource);
            if (count($resource) === 1) {
                return $resource[0];
            }
            else return null;
        }

        public function InsertSingle(string $_username, string $_password): bool {
            $pass = password_hash($_password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO USERS(NAME, PASS) VALUES ('$_username','$pass')";

            //$current_time = date('d/m/Y');

            //$binding_pairs = [':username' => $_username, ':password' => $pass, ':reg_time' => $current_time];

            //var_dump($binding_pairs);
            return $this->Insert($sql);
        }
    }