<?php

    class HomeController {

        public function Index($_request) {
            //echo 'fuck yeah'.$_temp;

            //echo __DIR__;
            // $db = new Model('TRADER_STOCK','1234','orcl');

            // //$sql = 'INSERT INTO ACCOUNT (ID,ACCOUNT_NAME,PASSWORD) VALUES (2,\'trade2\',\'123\')';
            
            // //$db->Insert($sql);
            // $acc_model = new AccountModel();

            // $acc_model->InsertSingle('name', '1234');

            // $sql = 'SELECT * FROM ACCOUNT';

            // $res = $db->Select($sql);

            // var_dump($res);
            //echo $_SERVER['SERVER_ADDR'];
            //echo 'home';
            //var_dump($_args);
            $view = new HomeView();
        }

        public function Test($_request) {
            $view = new SearchView();
        }

        public function Search($_request) {
            if (isset($_POST['name'])) {
                
                $name = $_POST['name'];

                $model = new Model();

                $sql = "SELECT * FROM USERS WHERE USERS.NAME = '$name'";

                $data = $model->Select($sql);

                if ($data) {
                    echo '<h3>user exists</h3>';
                }
                else {
                    echo '<h3>user no exists</h3>';
                }
            }
        }
    }