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
        $orderId = $_POST['order_id'];
        $this->orderService->removeOrder($orderId);
        header("Location: /admin/manageorders");
        exit(); // Stop further execution
    }

    public function orderdetails() {
        $orderId = $_GET['order_id'];
    
        if (!$orderId) {
            die("Order ID is required");
        }

        $orderDetails = $this->orderService->getOrderDetails($orderId);
    
        $this->displayView(['orderDetails' => $orderDetails]);
    }    
}
?>
