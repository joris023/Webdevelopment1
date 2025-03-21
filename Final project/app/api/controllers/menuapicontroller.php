<?php
require_once __DIR__ . '/../../services/menuservice.php';

class MenuApiController {
    private $menuService;

    public function __construct() {
        $this->menuService = new MenuService();
    }

    public function index() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Always set the correct JSON header
        header('Content-Type: application/json');

        try {
            if ($method === 'GET') {
                $menuItems = $this->menuService->getAllMenuItems();
                echo json_encode($menuItems);
            } elseif ($method === 'POST') {
                // Validate input data
                if (empty($_POST['type']) || empty($_POST['name']) || empty($_POST['description']) || 
                    !isset($_POST['price']) || !isset($_POST['stock']) || 
                    !is_numeric($_POST['price']) || !is_numeric($_POST['stock'])) {
            
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'All fields are required except the image file.']);
                    return;
                }
            
                $imagePath = null;
            
                // Handle image upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/images/' . $_POST['type'] . '/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
            
                    $imageName = basename($_FILES['image']['name']);
                    $uploadFile = $uploadDir . $imageName;
            
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $imagePath = '/images/' . $_POST['type'] . '/' . $imageName;
                    } else {
                        http_response_code(500);
                        echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
                        return;
                    }
                }
            
                // Prepare item data
                $type = htmlspecialchars($_POST['type']);
                $item = [
                    'name' => htmlspecialchars($_POST['name']),
                    'description' => htmlspecialchars($_POST['description']),
                    'price' => floatval($_POST['price']),
                    'stock' => intval($_POST['stock']),
                    'image' => $imagePath
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

                if (!isset($data['type'], $data['id'], $data['stock'])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                    return;
                }

                $type = $data['type'];
                $id = $data['id'];
                $newStock = $data['stock'];

                $this->menuService->updateStock($type, $id, $newStock);
                echo json_encode(['success' => true, 'newStock' => $newStock]);
            } elseif ($method === 'DELETE') {
                $data = json_decode(file_get_contents('php://input'), true);

                if (!isset($data['type'], $data['id'])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                    return;
                }

                $type = $data['type'];
                $id = $data['id'];

                $this->menuService->deleteMenuItem($type, $id);
                echo json_encode(['success' => true, 'message' => 'Item deleted successfully.']);
            } else {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An error occurred.']);
            error_log($e->getMessage());
        }
    }
}
