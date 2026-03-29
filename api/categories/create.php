<?php
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->category)) {
    $category->category = $data->category;

    if($category->create()) {
        echo json_encode(
            array('id' => $db->lastInsertId(), 'category' => $category->category)
        );
    } else {
        echo json_encode(array('message' => 'Category Not Created'));
    }
} else {
    // Message required if the "category" parameter is missing
    echo json_encode(array('message' => 'Missing Required Parameters'));
}