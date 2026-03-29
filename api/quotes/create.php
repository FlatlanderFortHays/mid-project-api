<?php
require_once('../../models/Author.php');
require_once('../../models/Category.php');

$data = json_decode(file_get_contents("php://input"));

// Adding this since below for whatever reason wasn't catching it
if (empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

if (!empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // 1. Check if author exists
    $author_check = new Author($db);
    $author_check->id = $quote->author_id;
    if (!$author_check->read_single()) {
        echo json_encode(['message' => 'author_id Not Found']);
        exit();
    }

    // 2. Check if category exists
    $category_check = new Category($db);
    $category_check->id = $quote->category_id;
    if (!$category_check->read_single()) {
        echo json_encode(['message' => 'category_id Not Found']);
        exit();
    }

    // 3. Create the quote
    if ($quote->create()) {
        echo json_encode([
            'id' => $db->lastInsertId(),
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id
        ]);
    }
} else {
    echo json_encode(['message' => 'Missing Required Parameters']);
}