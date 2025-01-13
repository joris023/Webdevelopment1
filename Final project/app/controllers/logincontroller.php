<?php
require __DIR__ . '/controller.php';
require_once __DIR__ . '/../services/userservice.php';

class LoginController extends Controller {

    private $userService;

    public function __construct() {
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

    public function tablenumber() {
        $this->displayview([]);
    }

    public function authenticate() {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password']; // No sanitization to preserve integrity for authentication

        try {
            $user = $this->userService->authenticate($email, $password);

            if ($user) {
                $_SESSION['user_role'] = $user->getRole();
                $_SESSION['user_id'] = $user->getId();

                if ($_SESSION['user_role'] == 'admin') {
                    header("Location: /admin");
                } elseif ($_SESSION['user_role'] == 'customer') {
                    header("Location: /login/tablenumber");
                }
                exit();
            } else {
                header("Location: /login?error=Wrong email or password");
            }
        } catch (Exception $e) {
            header("Location: /login?error=Something went wrong try again");
        }
    }

    public function setTableNumber() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tableNumber = filter_var($_POST['table_number'], FILTER_VALIDATE_INT);

            if ($tableNumber && $tableNumber > 0) {
                $_SESSION['table_number'] = $tableNumber;
                header("Location: /menu");
                exit();
            } else {
                header("Location: /login/tablenumber?error=Invalid tablenumber");
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit();
    }

    public function registerUser() {
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if (!$email) {
            header("Location: /login/register?error=Invalid email format");
            exit();
        }

        if ($password !== $confirmPassword) {
            header("Location: /login/register?error=Passwords do not match");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->userService->registerUser($name, $email, $hashedPassword);
            header("Location: /login");
            exit();
        } catch (Exception $e) {
            header("Location: /login/register?error=Failed to register");
            exit();
        }
    }
}
?>
