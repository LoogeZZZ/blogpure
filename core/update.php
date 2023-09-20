<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = form_handling($_POST);

    if(!$data["id"]) exit;

    if(!update_data($data)):
        trigger_error(MSG_ON_UPDATE_DATA_ERROR);
    else:
        header("Location: /");
        exit;
    endif;
} else {
    $id = clear_id($_GET["edit"]);

    if(!$id) return;

    $data = read_data_by_id($id);
}