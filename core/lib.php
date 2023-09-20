<?php
function error_handler($no, $msg, $file, $line) {
    if(IS_DEBUG):
        echo $msg;
    endif;

    switch($no):
        case E_USER_NOTICE:
        case E_USER_WARNING:
            echo $msg; break;
        case E_USER_ERROR:
            echo $msg; exit;
    endswitch;
}

function clear_text($data) {
    global $db_conn;
    $data = trim(strip_tags($data));
    return mysqli_real_escape_string($db_conn, $data);
}

function clear_number($data) {
    return (int)$data;
}

function clear_id($data) {
    return abs(clear_number($data));
}

function is_id($id) {
    return $id > 0;
}

function form_handling($form) {
    $data = [];
    $data["title"] = clear_text($form["title"]);
    $data["msg"] = clear_text($form["msg"]);
    $data["id"] = clear_id($form["id"]);

    return $data;
}

function create_data($params) {
    global $db_conn;
    $sql = "call spCreateData('{$params["title"]}', '{$params ["msg"]}')";
    return mysqli_query($db_conn, $sql);
}

function update_data($params) {
    global $db_conn;
    $sql = "call spUpdateData({$params["id"]}, '{$params["title"]}', '{$params ["msg"]}')";
    return mysqli_query($db_conn, $sql);
}

function delete_data($id) {
    global $db_conn;
    $sql = "call spDeleteData({$id})";
    return mysqli_query($db_conn, $sql);
}

function read_data_by_id($id) {
    global $db_conn;
    $sql = "call spReadDataById({$id})";
    $result = mysqli_query($db_conn, $sql);

    return mysqli_fetch_assoc($result);
}

function read_data() {
    global $db_conn;
    $sql = "call spReadData()";
    $result = mysqli_query($db_conn, $sql);

    if(!$result):
        trigger_error(MSG_ON_READ_DATA_ERROR);
        return;
    endif;

    $data = [];
    while($row = mysqli_fetch_assoc($result)):
        $data[] = built_data($row);
    endwhile;

    return $data;
}

function built_data($params) {
    $tpl = file_get_contents(DATA_TEMPLATE);
    $tpl = str_replace("{{TITLE}}", $params["title"], $tpl);
    $tpl = str_replace("{{TEXT}}", nl2br($params["msg"]), $tpl);
    $tpl = str_replace("{{DATE_CREATED}}", date("d-m-y H:i", $params["created"]), $tpl);

    if(isset($_SESSION["admin"])):
        $links_tpl = file_get_contents(LINKS_TEMPLATE);
        $links_tpl = str_replace("{{ID_EDIT}}", "/?edit=".$params["id"], $links_tpl);
        $links_tpl = str_replace("{{ID_DELETE}}", "/?remove=".$params["id"], $links_tpl);
        $tpl = str_replace("<!--{{PLACE_FOR_LINKS_TEMPLATE}}-->", $links_tpl, $tpl);
    endif;

    return $tpl;
}

function built_edit_form($params) {
    $tpl = file_get_contents(EDIT_FORM_TEMPLATE);
    $tpl = str_replace("{{ID}}", $params["id"], $tpl);
    $tpl = str_replace("{{TITLE}}", $params["title"], $tpl);
    $tpl = str_replace("{{TEXT}}", nl2br($params["msg"]), $tpl);

    return $tpl;
}

function built_remove_form($params) {
    $tpl = file_get_contents(REMOVE_FORM_TEMPLATE);
    $tpl = str_replace("{{ID}}", $params["id"], $tpl);

    return $tpl;
}