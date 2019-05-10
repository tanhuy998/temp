<?php
    class Middleware {
        protected $passStatus;
        protected $meta;

        public function __construct() {
            $this->passStatus = true;

            $this->meta['status'] = $this->passStatus; 
        }

        public function Invoke($_args) {

        }

        public function CanPass():bool {
            return $this->passStatus;
        }

        public function GetMetaData() {
            return $this->meta;
        }
        
    }