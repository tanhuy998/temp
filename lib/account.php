<?php
    class Account {
        private $valid;
        private $id;
    
        public function __construct(string $_username, string $_password) {
            $this->valid = false;
            
            $this->valid = $this->Authenticate($_username, $_password);
        }

        public function GetId() {
            return $this->id;
        }

        private function Authenticate(string $_username, string $_password): bool {
            $model =  new AccountModel();

            $account = $model->GetByUserName($_username);

            //var_dump($account);

            if (isset($account)) {
                $hash_pass = $account['PASS'];
                $hash_pass = str_replace(' ', '', $hash_pass);
                
                //echo $hash_pass;
                if (password_verify($_password, $hash_pass)) {
                    $this->id = $account['ID'];
                    
                    //echo 'verify';

                    return true;
                };

                //exit;
            }

            return false;
        }

        public function IsValid():bool {
            return $this->valid;
        }

    }