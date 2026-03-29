<?php
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Check author existence
    $author_check = new Author($db);
    $author_check->id = $quote->author_id;
    if (!$author_check->read_single()) {
        echo json_encode(['message' => 'author_id Not Found']); [cite: 87]
        exit();
    }

    // Check category existence
    $category_check = new Category($db);
    $category_check->id = $quote->category_id;
    if (!$category_check->read_single()) {
        echo json_encode(['message' => 'category_id Not Found']); [cite: 91]
        exit();
    }

    if ($quote->update()) {
        echo json_encode([
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id
        ]);
    } else {
        echo json_encode(['message' => 'No Quotes Found']); [cite: 92]
    }
} else {
    echo json_encode(['message' => 'Missing Required Parameters']); [cite: 93]
}