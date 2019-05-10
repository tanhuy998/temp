<?php
    class TransactionSession extends Middleware {

        public function __construct() {
            $this->passStatus = true;
        }

        public function Invoke($_request) {

            if (isset($_SESSION['tran_sess'])) {
                unset($_SESSION['tran_sess']);
            }
                var_dump($_request);
                $args = $_request['data'];

                $acc_id = $args['acc_id'];
                $current_time = date('Y-m-d H:i:s');
                $tran_type = $args['tran_type'];
                $produt_type = $args['pro_type'];

                $data = [
                    'acc_id' => $acc_id,
                    'time' => $current_time,
                    'tran_type' => $tran_type,
                    'pro_type' => $produt_type
                ];

            echo 'session';
            $this->meta['status'] = $this->passStatus;
            //$this->meta['redirect']
            return $this->meta;
        }

        public function CanPass():bool {
            return $this->passStatus;
        }

        public function GetMetaData() {
            return $this->meta;
        }

    }