<?php
$result = $category->read();
$num = $result->rowCount();

if($num > 0) {
    $cat_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $cat_item = array(
            'id' => $id,
            'category' => $category
        );
        array_push($cat_arr, $cat_item);
    }
    echo json_encode($cat_arr);
} else {
    // Specific message required by the rubric
    echo json_encode(array('message' => 'category_id Not Found'));
}