<?php

/*
| =============================================================================
| --------------- One Important Thing to Remember -------------
| 
| Before Using/Creating REST-API PHP PDO Crud with Ajax-JQuery Modal, We
| Created PHP PDO Crud with Ajax-JQuery Modal, which was withot REST-API
| There in out JS Code in custom_script.js FILE we could use JSON.parse()
| Method to Conver the JSON to JavaScript Object to parse JSON String
| which Returned From Back-END, But Here inth REST-API You Can't Use
| JSON.parse() Method to Convert JSON to JS Object, It's Bcoz We're Using 
| header() METHOD in the Action FILE in PHP Back-END HERE, & It's Generate
| Pure JSON, Instead of JSON-String, So, It's Already an JS-OBJECT So,
| So, You Don't Need to Convert it to JS Object. & You Can't Use JSON.parse()
| =============================================================================
*/

// Code for Data Edit by ID..

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$getData = json_decode(file_get_contents("php://input"), true);
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($getData["uid"]) && isset($getData["one"])) {
    
    include('../config/config.php');
    include("DB.php");

    $db	 = (!empty($db)) ? $db : new DB();
    $table = (!empty($table)) ? $table : "tbl_pdo_crud_ajax";
    $user_id = (int) $getData["uid"];
    try{
        $selected = $db->read($table)->where("id", "=", $user_id);
    } catch(PDOException $e) {
        die("404 NOT FOUND");
    }

    if($selected->rowCount() > 0) {
        $resultById = $selected->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultById);
    } else {
        echo json_encode([
            "message" => "No Record Found",
            "status" => false
        ]);
    }
    $db->connectionClose();
} else {
    echo json_encode([
        "message" => "No Record Found",
        "status" => false
    ]);
}

?>