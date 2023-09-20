<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = form_handling($_POST);
    
    if(!create_data($data)):
        trigger_error(MSG_ON_CREATE_DATA_ERROR);
    else:
        header("Location: /");
        exit;
    endif;
}