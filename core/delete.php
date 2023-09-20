<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = form_handling($_POST);
    $id = $data["id"];

    if(!$id) exit;

    if(!delete_data($id)):
        trigger_error(MSG_ON_DELETE_DATA_ERROR);
    else:
        header("Location: /");
        exit;
    endif;
} else {
    $id = clear_id($_GET["remove"]);

    if(!$id) return;

    $data = read_data_by_id($id);
}