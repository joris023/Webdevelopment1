<?php
require __DIR__ . '/controller.php';
require_once __DIR__ . '/../services/userservice.php';

    class LoginController extends Controller{

        private $userService;

        public function __construct() {
            //session_start();
            $this->userService = new UserService();
        }

        public function index() {
            $this->displayView([]);
        }

        public function register() {
            $this->displayView([]);
        }

        public function forgotpassword() {
            $this->displayview([]);
        }

        public function tablenumber(){
            $this->displayview([]);
        }

        public function authenticate() {
            $email = $_POST['email'];
            $password = $_POST['password'];
            //var_dump($email, $password);
            try {
                $user = $this->userService->authenticate($email, $password);
        
                if ($user) {
                    //session_start();
                    $_SESSION['user_role'] = $user->getRole();
                    $_SESSION['user_id'] = $user->getId();

        
                    if($_SESSION['user_role'] == 'admin'){
                        header("Location: /admin");
                    }
                    elseif($_SESSION['user_role'] == 'customer'){
                        header("Location: /login/tablenumber");
                    }
                    exit();
                } else {
                    header("Location: /login");
                }
            } catch (Exception $e) {
                header("Location: /login");
            }
        }

        public function setTableNumber() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tableNumber = $_POST['table_number'];
        
                if (is_numeric($tableNumber) && $tableNumber > 0) {
                    //session_start();
                    $_SESSION['table_number'] = $tableNumber;
                    //header('Content-Type: application/json');
                    //echo json_encode($_SESSION);
                    header("Location: /menu");
                    exit();
                } else {
                    header("Location: /login/tablenumber");
                }
            }
        }
        
        public function logout() {
            session_destroy();
            header("Location: /login");
            exit();
        }

        public function registerUser() {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
        
            if ($password !== $confirmPassword) {
                header("Location: /login/register?error=Passwords do not match");
                exit();
            }
        
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
            //var_dump($name, $email, $password);
            try {
                $this->userService->registerUser($name, $email, $hashedPassword);
                header("Location: /login");
                exit();
            } catch (Exception $e) {
                header("Location: /login/register?error=Passwords do not match");
                exit();
            }
        }
    }
?>