<?php


// When You're Writting content inside header() function, You Must write it in One Line
// You Can't Press ENTER, Only Space available.. For Example: Here below in the Last header()
// you've written in One Line, if you would write like: header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, 
//              Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");
// Using ENTER So, That wouldn't Work..


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


header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");
$getData = json_decode(file_get_contents("php://input"), true);
if($_SERVER["REQUEST_METHOD"] == "DELETE" && isset($getData["del"]) && isset($getData["uid"])) {
    
    include('../config/config.php');
    include("DB.php");
    
    $db	 = (!empty($db)) ? $db : new DB();
    $table = (!empty($table)) ? $table : "tbl_pdo_crud_ajax";

    $user_id = $getData["uid"];

    try{
        $deleted = $db->del($table)->where("id", "=", $user_id);
    } catch(PDOException $e) {
        $output = "<p class='text-danger'>Unable to Deleted Data !! </p>";
        echo json_encode([
            "message" => $output,
            "status" => false
        ]);
        die("404 NOT FOUND");
    }

    if($deleted) {
        $row_affected = $deleted->rowCount();
        $output = "Data Deleted Successfully & {$row_affected} ROWS Affected";
        unset($deleted);
        echo json_encode([
            "message" => $output,
            "status" => true
        ]);
    } else {
        $output = "Unable to Deleted Data !!";
        echo json_encode([
            "message" => $output,
            "status" => false
        ]);
    }
    $db->connectionClose();
} else {
    $output = "Unable to Deleted Data !!";
    echo json_encode([
        "message" => $output,
        "status" => false
    ]);
}

?>