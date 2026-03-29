<?php
// Include necessary models for validation
require_once('../../models/Author.php');
require_once('../../models/Category.php');

$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// 1. Validate author_id if provided
if ($author_id !== null) {
    $author_check = new Author($db);
    $author_check->id = $author_id;
    if (!$author_check->read_single()) {
        echo json_encode(['message' => 'author_id Not Found']);
        exit();
    }
}

// 2. Validate category_id if provided
if ($category_id !== null) {
    $category_check = new Category($db);
    $category_check->id = $category_id;
    if (!$category_check->read_single()) {
        echo json_encode(['message' => 'category_id Not Found']);
        exit();
    }
}

// 3. Fetch Quotes
$result = $quote->read($author_id, $category_id);
$num = $result->rowCount();

if($num > 0) {
    $quotes_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $quotes_arr[] = [
            'id' => $id,
            'quote' => $quote,
            'author' => $author_name,
            'category' => $category_name
        ];
    }
    echo json_encode($quotes_arr);
} else {
    echo json_encode([]); 
}