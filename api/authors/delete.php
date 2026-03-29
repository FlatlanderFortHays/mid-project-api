<?php
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Requirement: Must contain id 
if(!empty($data->id)) {
    $category->id = $data->id;

    // Attempt to delete
    if($category->delete()) {
        echo json_encode(array('id' => $category->id));
    } else {
        // Message if no category found to delete [cite: 53]
        echo json_encode(array('message' => 'category_id Not Found'));
    }
} else {
    // General missing parameter message [cite: 73]
    echo json_encode(array('message' => 'Missing Required Parameters'));
}