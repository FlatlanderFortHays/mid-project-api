<?php
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Requirement: Must contain id and category 
if(!empty($data->id) && !empty($data->category)) {
    $category->id = $data->id;
    $category->category = $data->category;

    // Attempt to update
    if($category->update()) {
        echo json_encode(
            array('id' => $category->id, 'category' => $category->category)
        );
    } else {
        // If the ID is valid but the record wasn't found [cite: 91]
        echo json_encode(array('message' => 'category_id Not Found'));
    }
} else {
    // Required if parameters are missing [cite: 93]
    echo json_encode(array('message' => 'Missing Required Parameters'));
}