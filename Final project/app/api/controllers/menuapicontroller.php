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
                if (!isset($_POST['type'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock'])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                    return;
                }

            
                $imagePath = null;

                // Check if an image was uploaded and handle it
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
                $type = $_POST['type'];
                $item = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock'],
                    'image' => $imagePath
                ];
                
                $id = $this->menuService->addMenuItem($type, $item);
                //echo json_encode(['success' => true, 'id' => $id, 'imagePath' => $imagePath]);
                echo json_encode(['success' => true]);
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
