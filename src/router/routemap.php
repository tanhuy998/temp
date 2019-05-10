<?php 
    require_once 'route.php';

    class RouteMap {
        private $map;

        public function __construct() {
            $map = [];
        }

        public function Add(string $_uri, $_action) {
            if (!isset($this->map[$_uri])) {


                $new_route = new Route();

                $new_route->SetUri($_uri);
                $new_route->SetAction($_action);
                

                $this->map[$_uri] = $new_route;
                
                return $this->map[$_uri];
            }
            else return false;
        }

        public function Exist(string $_uri): bool {
            if (isset($this->map[$_uri])) {
                return true;
            }
            
            return false;
        }

        public function __call(string $uri, $args) {
            if ($this->Exist($uri)) {
                $route = $this->map[$uri];

                //$route->Render($args);
                return $route;
            }
        }

        private function CheckAction($_action) {
            if (is_callable($_action)) {
                
            }
        }
    }