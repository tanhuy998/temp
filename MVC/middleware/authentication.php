<?php
    class Authentication extends Middleware {
        
        public function __construct() {
            $this->meta = [
                'status' => false
            ];

            //$this->meta['redirect-reference'] = '';

            $this->passStatus = false;
        }

        public function Invoke($_request) {
            //var_dump($_request);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                return $this->FormInputAuthenticate($_request['uri']);
            }
            else {
                return $this->TokenAuthenticate($_request['uri']);
            }

        }
        
        private function FormInputAuthenticate($_target) {


            $username = $_POST['username'];
            $password = $_POST['password'];

            $acc = new Account($username,$password);

            if ($acc->IsValid()) {
                $this->passStatus = true;
                    //echo 'pass';
                $token = $this->GenerateToken($acc->GetId() ,$username);

                $this->PlaceToken($token);

                $this->passStatus = true;
                $this->meta['status'] = $this->passStatus;
                return $this->meta;
            }
            else {
                echo 'wrong user';
                $this->meta['status'] = $this->passStatus;
                $this->meta['redirect'] = 'login?error=1&target='.$_target;

                return $this->meta;
            }
        }

        private function TokenAuthenticate($_target) {
            $token = $this->GetToken();
            $toke_data;

            if (isset($token)) {
                $token_data = self::ParseToken($token);
                
                //return $data;
            }
            
            //$token_data = $this->TokenAuthenticate();
            if (!isset($token_data)) {

                $this->passStatus = false;

                $this->meta['status'] = $this->passStatus;
                $this->meta['redirect'] = 'login?target='.$_target;
                
                return $this->meta;
            }
            else {
                $model = new AccountModel();

                $username = $token_data['username'];
                $id = $token_data['id'];

                $account = $model->GetByUsername($username);
                
                if ($account != null) {
                    if ($id == $account['ID']) {
                        $this->passStatus = true;
                        $this->meta['status'] = $this->passStatus;
                        //$this->meta['redirect'] = 'home/';
                        //echo 'acount';
                        return $this->meta;
                    }
                }
                else {
                    $this->passStatus = false;

                    $this->meta['status'] = $this->passStatus;
                    $this->meta['redirect'] = 'login?error=2&target='.$_target;
                }
                return $this->meta;
            }
        }

        private function GetToken() {

            if (isset($_COOKIE['token'])) {

                if ($_COOKIE['token'] != '') return $_COOKIE['token'];
            }

            return null;
        }

        private function PlaceToken(string $_token) {
            setcookie('token', $_token, time() + (60*5), '/');
        }

        public static function ParseToken($_token): array {
            $return_data = [];

            $token_lvl1 = base64_decode($_token);

            $arr = explode('@-@', $token_lvl1);

            $return_data['id'] = convert_uudecode($arr[1]);
            $return_data['username'] = convert_uudecode($arr[0]);

            return $return_data;
        }

        private function GenerateToken($_id, $_username) {
            $token_lvl1 = convert_uuencode($_username).'@-@'.convert_uuencode($_id);

            $token_lvl2 = base64_encode($token_lvl1);

            return $token_lvl2;
        }
    }