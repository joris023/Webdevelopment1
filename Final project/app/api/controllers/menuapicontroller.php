<?php
require_once __DIR__ . '/../../services/menuservice.php';

class MenuApiController {
    private $menuService;

    public function __construct() {
        $this->menuService = new MenuService();
    }

    public function index() {
        $method = $_SERVER['REQUEST_METHOD'];
    
        if ($method === 'GET') {
            $menuItems = $this->menuService->getAllMenuItems();
            echo json_encode($menuItems);
        } elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($data['type'], $data['name'], $data['description'], $data['price'], $data['stock'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                return;
            }
    
            $type = $data['type'];
            $item = [
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => $data['stock']
            ];
    
            try {
                $id = $this->menuService->addMenuItem($type, $item);
                echo json_encode(['success' => true, 'id' => $id]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to add menu item.']);
            }
        } elseif ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            //echo($data);
    
            if (!isset($data['type'], $data['id'], $data['stock'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                return;
            }
    
            $type = $data['type'];
            $id = $data['id'];
            $newStock = $data['stock'];
    
            try {
                $this->menuService->updateStock($type, $id, $newStock);
                echo json_encode(['success' => true, 'newStock' => $newStock]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to update stock.']);
            }
        } elseif ($method === 'DELETE') {
            $data = json_decode(file_get_contents('php://input'), true);
    
            if (!isset($data['type'], $data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                return;
            }
    
            $type = $data['type'];
            $id = $data['id'];
    
            try {
                $this->menuService->deleteMenuItem($type, $id);
                echo json_encode(['success' => true, 'message' => 'Item deleted successfully.']);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to delete item.']);
            }
        }
    }    
}
?>
