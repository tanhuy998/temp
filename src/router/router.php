<?php
    // require_once '../autoload/autoload.php';
    // require_once 'Singleton.php';
    // require_once 'route_map.php';

    /**
     * ------------------------------------------------------------------------------------
     *      Class router define router for 
     * ------------------------------------------------------------------------------------
     */
    class Router {
        private static $router;

        private $routes;
        private $home;
        private $redirectMap;

        //private static $router;

        private function __construct() {
            $this->routes = new RouteMap();
            $this->redirectMap = [];
        }

        public function SetRoute(string $_uri, $action) {
            if(!$this->ExistsRoute($_uri)) {
                return false;
            }

            $new_route = new Route();
            
            $new_route->Uri($_uri);
            $new_route->LoadMethod($_action);

            $this->map[$_uri] = $new_route;

            return $this->map[$_uri];
        }

        public function Route($_uri){

        }

        private function IsRedirected(string $_uri): bool {
            if (isset($this->redirectMap[$_uri])) {
                return true;
            }
            else return false;
        }

        public function Map(array &$_request) {
            $uri = $_request['uri'];
            $request_data = $_request['data'];

            if ($this->IsRedirected($uri)) {
                $redirect_link = $this->redirectMap[$uri];
                
                if (filter_var($redirect_link, FILTER_VALIDATE_URL) === true) {
                    
                    header('Location: '.$redirect_link);
                }
                else {
                    header('Location: '.SUB_PATH_DOMAIN_NAME.$redirect_link);
                }
            }
            
            if ($uri === '') {
                $uri = $this->home;
                $_request['uri'] = $this->home;
            }

            
            if ($this->ExistsRoute($uri)) {
                $routes = $this->routes;
                //
                //var_dump($uri);
                //echo $uri;
                return $routes->$uri();    
            }
            else return $this->TryMap($uri);
            //else return $this->redirectHttpCode('404');
        }

        private function TryMap(string $_uri) {
            $length = strlen($_uri);

            if ($_uri[$length-1] != '/') {
                $_uri = $_uri.'/';
                
                if ($this->ExistsRoute($_uri)) {
                    $routes = $this->routes;
             
                    return $routes->$_uri();    
                }

                return null;
            }
            
            return null;
        }

        public static function RedirectHttpCode($_code) {
            $supported_respone_code = include('http_status.php');

            if (isset($supported_respone_code[$_code])) {
                $code = intval($_code);
                http_response_code($code);

                echo $supported_respone_code[$_code];
            }
            
            return false;
        }

        private function ExistsRoute(string $_uri):bool {
            return $this->routes->Exist($_uri);
        }

        public static function GetObject() {
            if (self::$router !== null) {
                return self::$router;
            }

            self::$router = new self();
            return self::$router;

        }

        public static function SetRedirect(string $_redirected_uri, string $_link) {
            $redirected_uri = str_replace(' ', '', $_redirected_uri);
            $link = str_replace(' ', '', $_link);

            self::GetObject()->redirectMap[$redirected_uri] = $link;
        }
        
        public static function New($uri, $_action) {
            
            self::$router->SetRoute($uri, $_action);

        }

        public static function Routes() {
            return self::GetObject()->routes;
        }

        public static function SetHome(string $_route) {
            $router = self::GetObject();

            if ($router->ExistsRoute($_route)) {
                $router->home = $_route;
            }
        }

    }
