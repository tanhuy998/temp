<?php 
    class LoginController {

        public function Index($_request) {
            if (isset($_COOKIE['token']) && $_COOKIE['token'] !== '') {
                Route::Redirect('home/');
            } 

            //var_dump($_request);
            $view = new SigninView();
        }
    }