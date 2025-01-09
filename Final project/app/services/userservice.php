<?php
require_once __DIR__ . '/../repositories/userrepository.php';

class UserService {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function authenticate($email, $password) {
        $user = $this->userRepository->getUserByEmail($email);
        //var_dump($user);

        if ($user) {
            error_log("User found: " . print_r($user, true));
            //if ($password == $user->getPassword()) 
            if (password_verify($password, $user->getPassword())){
                return $user;
            } else {
                error_log("Password verification failed.");
            }
        } else {
            error_log("No user found with email: $email");
        }
        

        return null;
    }

    public function registerUser($name, $email, $password) {
        $this->userRepository->saveUser($name, $email, $password);
    }
}
?>
