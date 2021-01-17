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
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

$getData = json_decode(file_get_contents("php://input"), true);
if( $_SERVER["REQUEST_METHOD"] == "PUT" && isset($getData["update"]) && isset($getData["id"]) && !empty($getData["id"]) ) {
    
    include('../config/config.php');
    include("DB.php");
    include("Validation.php");
    
    $db	 = (!empty($db)) ? $db : new DB();
    $table = (!empty($table)) ? $table : "tbl_pdo_crud_ajax";
	$validated_data[] = "";
	$error_page_redirect = "../404.php";

    
    // echo json_encode($getData);

    $id = (int) $getData["id"];
    array_shift($getData);  // Removing the $getData['id'] From the Array Element at the Beginning
    array_pop($getData);	// Removing the $getData['update'] From the Array Element at the End		
    
    $output = "";

    $v = new Validation();
    $userValidation = $v->checkValidation($getData);

    if($userValidation->isValid()) {
        try{
            $updated = $db->edit($table, $getData)->where("id", "=", $id);
        } catch(PDOException $e) {
            $output = "Unable to Update Data !! Failed";
            echo json_encode([
                "message" => $output,
                "status" => false
            ]);
            die("404 NOT FOUND");
        }

        $row_affected = $updated->rowCount();

        if( $updated && $row_affected > 0 ) {
            $output = "Data Updated Successfully & {$row_affected} ROWS Affected";
            unset($updated);
            echo json_encode([
                "message" => $output,
                "status" => true
            ]);
        } else if( $updated && $row_affected == 0 ) {
            $output = "Data Already Exists & {$row_affected} ROWS Affected";
            unset($updated);
            echo json_encode([
                "message" => $output,
                "status" => true
            ]);
        } else {
            $output = "Unable to Update Data !! Failed";
            echo json_encode([
                "message" => $output,
                "status" => false
            ]);
        }
    } else {
        $errs = $userValidation->getErrors();
        $errs['status'] = false;
        echo json_encode($err);
    }
    $db->connectionClose();
} else {
    $output = "Data Unable to Update !! Failed.";
    echo json_encode([
        "message" => $output,
        "status" => false
    ]);
}


?>