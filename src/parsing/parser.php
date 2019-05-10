<?php 
    class Parser {

        public static function ParseRequestUri(string $_uri) {
            $uri = str_replace(SUB_PATH_DOMAIN_NAME, '', $_uri);
            //echo $uri;
            if (strpos($uri, '?') > 0) {
                $arr = explode('?', $uri);
                
                $str_route = $arr[0];

                $length = strlen($str_route);

                //if (substr($str_route, $length -1) != '/') {
                if ($str_route[$length-1] != '/') {
                    $str_route = $str_route.'/';
                }
                return $str_route;
            }

            return $uri;
        }

        public static function ParseInitURI(string $_uri) {
            $uri = str_replace(SUB_PATH_DOMAIN_NAME, '', $_uri);

            $pattern = '/\([a-zA-Z0-9]+\)/';

            if (preg_match($pattern,$uri,$matches)) {
                
            }

            else return $uri;
        }

        public static function BindingRequest() {
            $request = [];
            $server = $_SERVER;

            $request['uri'] = self::ParseRequestUri($server['REQUEST_URI']);
            
            if ($server['REQUEST_METHOD'] == 'GET') {
                $request['data'] = $_GET;
            }
            else if ($server['REQUEST_METHOD'] == 'POST') {
                $request['data'] = $_POST;
            }

            return $request;
        }
    }