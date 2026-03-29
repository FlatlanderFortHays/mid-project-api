<?php
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $quote->id = $data->id;
    if ($quote->delete()) {
        echo json_encode(['id' => $quote->id]); [cite: 97]
    } else {
        echo json_encode(['message' => 'No Quotes Found']); [cite: 97]
    }
} else {
    echo json_encode(['message' => 'Missing Required Parameters']);
}