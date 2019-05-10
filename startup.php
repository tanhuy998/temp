<?php 
    //echo microtime();
    session_start();
    require_once 'src/define.php';
    require_once 'src/autoload/autoload.php';
    
    
    Router::Routes()->Add('s/', 'HomeController:Search');
    Router::Routes()->Add('search/', 'HomeController:test')->SetMiddleware('Authentication');
    Router::Routes()->Add('home/', 'HomeController:Index')->SetMiddleware('Authentication');
    Router::Routes()->Add('login/', 'LoginController:Index');
    Router::Routes()->add('logout/', function($_request) {
        setcookie('token', '', 0, '/');
        
        Route::Redirect('home/');
    });

    Router::Routes()->Add('temp/', function() {
        // $db = new Model('TRADER_STOCK','1234','orcl');

        // $sql = 'INSERT INTO TRANSACTION_TYPE (TYPE_NAME) VALUES (\'out\')';
            
        // //$db->Insert($sql);

        // $model = new Model('TRADER_STOCK', '1234', 'orcl');

        // $model->Insert($sql);

        //$res = $db->Select($sql);

        $model = new AccountModel();
        echo $model->InsertSingle('name', '1234');

//         $sql = <<<EOF
//             CREATE TABLE USERS (
//                 ID INT PRIMARY KEY,
//                 NAME CHAR(30) UNIQUE NOT NULL,
//                 PASS CHAR(100) NOT NULL
//             );
// EOF;
    });
    

    Router::SetHome('home/');

    $request = Parser::BindingRequest();
    //echo $_SERVER['REQUEST_URI'];
    // $request['uri'] = Parser::ParseRequestUri($_SERVER['REQUEST_URI']);
    // $request['data'][] = '123';
    //echo $request['uri'];
    //echo $request['uri'];
    $route = Router::GetObject()->Map($request);
    //var_dump($request);
    //echo 5;
    if ($route !== null) {
        
        $route_stat = $route->LoadMiddleWare($request);
        //echo 4;
        
        if (isset($route_stat['redirect'])) {
            $link = $route_stat['redirect'];
            //echo $link;
            Route::Redirect($link);
        }
        else {
            //echo 7;
            if ($route_stat['status'] === true) {
                //echo 6;
                $route->Render($request);
            }
            else {

            }
        }
    }
    else {
        Router::RedirectHttpCode('404');
    }
    

    //session_abort();
    //echo '<br>'.microtime();



