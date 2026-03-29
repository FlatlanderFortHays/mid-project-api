<?php
// Call the read method
$result = $author->read();

// Get row count
$num = $result->rowCount();

// Check if any authors exist
if($num > 0) {
    // Author array
    $authors_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        // Push to array
        array_push($authors_arr, $author_item);
    }

    // Turn to JSON & output
    echo json_encode($authors_arr);

} else {
    // No Authors found
    // Note: requirements specify this message for authors [cite: 46, 49]
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
}