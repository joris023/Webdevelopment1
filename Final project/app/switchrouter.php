<?php
class SwitchRouter {
    public function route($uri) {    
        // using a simple switch statement to route URL's to controller methods
        switch($uri) {

            //HOME PAGE
            case '': 
                require __DIR__ . '/controllers/login.php';
                $controller = new HomeController();
                $controller->index();
                break;

            case 'about': 
                require __DIR__ . '/controllers/homecontroller.php';
                $controller = new HomeController();
                $controller->about();
                break;

            // MENU PAGE
            case 'menu': 
                require __DIR__ . '/controllers/menucontroller.php';
                $controller = new MenuController();
                $controller->index();
                break;

            // Foodpagina
            case 'menu/food': 
                require __DIR__ . '/controllers/menucontroller.php';
                $controller = new MenuController();
                $controller->food();
                break;

            // Drinkpagina
            case 'menu/drink': 
                require __DIR__ . '/controllers/menucontroller.php';
                $controller = new MenuController();
                $controller->drink();
                break;
            
            //LOGIN PAGE
            case 'login': 
                require __DIR__ . '/controllers/logincontroller.php';
                $controller = new LoginController();
                $controller->index();
                break;

            // Register pagina
            case 'login/register': 
                require __DIR__ . '/controllers/logincontroller.php';
                $controller = new LoginController();
                $controller->register();
                break;

            // forgotpassword pagina
            case 'login/forgotpassword': 
                require __DIR__ . '/controllers/logincontroller.php';
                $controller = new LoginController();
                $controller->forgotpassword();
                break;

            //ORDER PAGE
            case 'order': 
                require __DIR__ . '/controllers/ordercontroller.php';
                $controller = new OrderController();
                $controller->index();
                break;

            case 'admin': 
                require __DIR__ . '/controllers/admincontroller.php';
                $controller = new AdminController();
                $controller->index();
                break;
                
            //ORDER PAGE
            case 'admin/managemenu': 
                require __DIR__ . '/controllers/admincontroller.php';
                $controller = new AdminController();
                $controller->managemenu();
                break;

            case 'admin/manageorders': 
                require __DIR__ . '/controllers/admincontroller.php';
                $controller = new AdminController();
                $controller->manageorders();
                break;

            //DEFAULT
            default:
                http_response_code(404);
                break;
        }
    }
}
?>