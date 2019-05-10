<?php
    class Route {
        
        public static $ActionType = ['Anonymous' => 0, 'Controller' => 1];
        private static $ActionType_arr = ['Anonymous' , 'Controller'];

        private $uri;
        //private $loadedMethod;
        private $middleware;
        private $meta;
        
        public function __construct() {
            $this->meta = [];
            return $this;
        }

        public function SetUri(string $_uri) {
            $this->uri = $_uri;
            
            return $this;
        }

        public function SetMiddleware($_middleware) {

            if (is_string($_middleware)) {
                $is_single_middleware = strpos($_middleware,'-');

                if ($is_single_middleware === false) {
                    $this->meta['Middleware_exec'] = 'single';

                    $this->middleware = $_middleware;
                }
                else {
                    $middleware_queue = explode('-',$_middleware);

                    $this->meta['Middleware_exec'] = 'queue';
                    $this->middleware = $middleware_queue;
                }

            }

            if (is_callable($_middleware)) {
                $this->meta['Middleware_exec'] = 'anonymous';
                $this->middleware = $_middleware;
            }

            return $this;
        }

        public function SetRedirect(string $_link) {
            $link = str_replace(' ', '', $_link);

            $this->meta['Redirect'] = $link;

            return $this;
        }

        public function SetAction($_action) {
            if (is_callable($_action)) {
                $this->meta['Method'] = $_action;
                //$this->loadMethod = $_action;
            }
            if (is_string($_action)) {
                $this->BindControllerAction($_action);
            }
        }

        private function BindControllerAction($_action) {
            if (strpos($_action,':') != false) {

                $arr = explode(':',$_action);
                $controller = $arr[0];
                $method = $arr[1];

                //$this->loadedMethod = $method;
                $this->meta['Method'] = $method;
                $this->meta['Controller'] = $controller;
            }
        }

        private function IsAnonymousAction() {
        
        }

        public static function Redirect($_link) {
            //echo 1;
            if (filter_var($_link, FILTER_VALIDATE_URL) === true) {
                header('Location: '.$_link, true);
                exit();
            }
            else {
                //echo SUB_PATH_DOMAIN_NAME.$_link;
                //echo 2;
                header('Location: '.SUB_PATH_DOMAIN_NAME.$_link);
                //echo 1; 
                //exit();
            }

        }


        public function Render($_args) {
            if (isset($this->meta['Redirect'])) {
                $redirect_link = $this->meta['Redirect'];

                self::Redirect($redirect_link);
            }

            //var_dump($_args);
            if (!isset($this->meta['Controller'])) {

                $method = $this->meta['Method'];
                if (is_callable($method)) {

                    $this->InvokeAnonymousMethod($method ,$_args);
                    //$method($args);
                    //echo 'true';
                }
            }
            else {
                $this->InvokeControllerMethod($_args);
            }

        }

        private function InvokeAnonymousMethod($_method, $_args) {
            //$method = $this->meta['Method'];

            $func_reflector = new ReflectionFunction($_method);

            $paramNum = $func_reflector->GetNumberOfParameterS();

            $func_reflector->Invoke($_args);
            // if ($paramNum != 0) {
            //     $func_reflector->InvokeArgs($_args);
            // }
            // else {
            //     $func_reflector->Invoke();
            // }
        }

        private function InvokeControllerMethod($_args) {
            $is_anonymous;

            //if (!$is_anonymous) {
                $Class_controller = $this->meta['Controller'];

                $controller = new $Class_controller();

                $method = $this->meta['Method'];

                $method_reflector = new ReflectionMethod($Class_controller, $method);

                $paramNum = $method_reflector->GetNumberOfParameters();

                $method_reflector->Invoke($controller, $_args);
                // if ($paramNum != 0) {
                //     $method_reflector->InvokeArgs($controller,$_args);
                // }
                // else {
                //     $method_reflector->Invoke($controller);
                // }
            //}
        }

        public function LoadMiddleware($_args) {
            $middleware = $this->middleware;
            $middleware_exec_method;

            //var_dump($_args);       
            $status = ['status' => true];

            if (isset($middleware)) {
                $middleware_exec_method = $this->meta['Middleware_exec'];

                switch ($middleware_exec_method) {
                    case 'single':
                        $status = $this->InvokeSingleMiddlewareClass($middleware, $_args);
                        break;
                    case 'queue':
                        $status = $this->InvokeMiddlewareSequence($middleware, $_args);
                        break;
                    case 'anonymous':
                        $status = $this->InvokeAnonymousMethod($middleware, $_args);
                        break;
                    default :
                        break;
                }
            }
            
            return $status;
        }

        public static function ActionType($_type) {
            if (isset(self::$ActionType[$_type])) {
                return  self::$ActionType[$_type];
            }
            return false;
        }

        private function InvokeMiddlewareSequence(array $_queue, $_args) {
            foreach ($_queue as $middleware) {
                // $method_reflector = new ReflectionMethod($middleware_name, 'Invoke');

                // $middleware = new $middleware_name();

                // $paramNum = $method_reflector->GetNumberOfParameters();

                // if ($paramNum > 0) {
                //     $method_reflector->InvokeArgs($middleware, $_args);
                // }
                // else {
                //     $method_reflector->Invoke();
                // }

                $metaData = $this->InvokeSingleMiddlewareClass($middleware, $_args);

                if (isset($metaData['redirect'])) return $metaData;

                if ($metaData['status'] === false) {
                    $metaData['meta'] = [
                        'block_at' => $middleware,
                        'message' => '',
                        'data' => ''
                    ];

                    return $metaData;
                } 
            }
        }

        private function InvokeSingleMiddlewareClass($_middleware, $_args) {
            $method_reflector = new ReflectionMethod($_middleware, 'Invoke');

            $middleware = new $_middleware();

            $paramNum = $method_reflector->GetNumberOfParameters();

            $method_reflector->Invoke($middleware, $_args);
            // if ($paramNum > 0) {
            //     $method_reflector->InvokeArgs($middleware, $_args);
            // }
            // else {
            //     $method_reflector->Invoke($middleware);
            // }

            return $middleware->GetMetaData();
        }
    }