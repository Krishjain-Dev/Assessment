<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
require 'config.php';

// Function to get input JSON data
function getRequestData() {
    return json_decode(file_get_contents("php://input"), true);
}

$method = $_SERVER['REQUEST_METHOD'];

// Handle CRUD Operations directly
switch ($method) {
    case 'GET':  // Read users (single or all)
        if (isset($_GET['id'])) {
            // Fetch single user
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($user ?: ["error" => "User not found"]);
        } else {
            // Fetch all users
            $stmt = $pdo->query("SELECT * FROM users");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;

    case 'POST':  // Create user
        $data = getRequestData();
        if (!isset($data['name'], $data['email'], $data['password'], $data['dob'])) {
            echo json_encode(["error" => "Missing fields"]);
            http_response_code(400);
            exit;
        }
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, dob) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$data['name'], $data['email'], $passwordHash, $data['dob']])) {
            echo json_encode(["message" => "User created successfully"]);
        } else {
            echo json_encode(["error" => "User creation failed"]);
        }
        break;

    case 'PUT':  // Update user
        $data = getRequestData();
        if (isset($data['id'], $data['name'], $data['email'], $data['dob'])) {
            echo json_encode(["error" => "Missing fields"]);
            http_response_code(400);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, dob = ? WHERE id = ?");
        if ($stmt->execute([$data['name'], $data['email'], $data['dob'], $data['id']])) {
            echo json_encode(["message" => "User updated successfully"]);
        } else {
            echo json_encode(["error" => "User update failed"]);
        }
        break;

        case 'DELETE':  // Delete user
            parse_str(file_get_contents("php://input"), $data);
            $id = $_GET['id'] ?? $data['id'] ?? null;  // Accept both query params & request body
        
            if (!$id) {
                echo json_encode(["error" => "Missing user ID"]);
                http_response_code(400);
                exit;
            }
        
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            if ($stmt->execute([$id])) {
                echo json_encode(["message" => "User deleted successfully"]);
            } else {
                echo json_encode(["error" => "User deletion failed"]);
            }
            break;
        

    default:
        echo json_encode(["error" => "Invalid request method"]);
        http_response_code(405);
        break;
}
?>
