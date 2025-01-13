<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../services/orderservice.php';

class AdminController extends Controller {
    private $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
    }

    public function index() {
        $this->displayView([]);
    }

    public function managemenu() {
        $this->displayView([]);
    }

    public function manageorders() {
        // Fetch orders using the MenuService
        $orders = $this->orderService->getAllOrders();
        $this->displayView(['orders' => $orders]);
    }

    public function removeorder() {
        $orderId = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
        if ($orderId === false || $orderId === null) {
            header("Location: /admin/manageorders?error=Invalid order ID");
            exit();
        }

        $this->orderService->removeOrder($orderId);
        header("Location: /admin/manageorders?success=You have succesfully removed a order");
        exit(); // Stop further execution
    }

    public function orderdetails() {
        $orderId = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
        if ($orderId === false || $orderId === null) {
            die("Order ID is required and must be valid.");
        }

        $orderDetails = $this->orderService->getOrderDetails($orderId);
        $this->displayView(['orderDetails' => $orderDetails]);
    }    
}
?>
