<?php
// Headers for CORS and JSON response
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight OPTIONS request
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Include required files
// Note: Using ../../ to go up two levels from api/authors/ to the root
require_once('../../config/Database.php');
require_once('../../models/Author.php');

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Simple router based on the request method
switch($method) {
    case 'GET':
        // Check for ?id= parameter
        if(isset($_GET['id'])) {
            require_once('read_single.php');
        } else {
            require_once('read.php');
        }
        break;
        
    case 'POST':
        require_once('create.php');
        break;
        
    case 'PUT':
        require_once('update.php');
        break;
        
    case 'DELETE':
        require_once('delete.php');
        break;
        
    default:
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}