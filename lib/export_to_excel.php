<?php

// Code for Export Data to Excel..
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST["export"]) && $_REQUEST["export"] == "Export Data To Excel") {

    include('../config/config.php');
    include("DB.php");

    $db	 = (!empty($db)) ? $db : new DB();
    $table = (!empty($table)) ? $table : "tbl_pdo_crud_ajax";

    header("content-Type: application/xls");
    header("content-Disposition: attachment; filename=Ajax_Crud_Data.xls");
    header("pragma: no-cache");
    header("Expires: 0");

    try{
        $result = $db->readAll($table);
    } catch(PDOException $e) {
        die("404 NOT FOUND");
    }

    if($result->rowCount() > 0) { 
        echo "<table border='1' cellspacing='0' cellpadding='3'>
                    <tr>
                        <th>SL.</th>
                        <th>ID.</th>
                        <th>Name</th>
                        <th>Roll</th>
                        <th>Address</th>
                    </tr>";
        
        $i = 1;
        while ( $rows = $result->fetch(PDO::FETCH_ASSOC) ) {
    
            echo    "<tr>
                        <td>{$i}</td>
                        <td>{$rows['id']}</td>
                        <td>{$rows['name']}</td>
                        <td>{$rows['roll']}</td>
                        <td>{$rows['address']}</td>
                    </tr>";
            $i += 1;
        }

        unset($result);
    
            echo  "</table>";
    } else {
        echo "0 Records Exists !!";
    }
}


?>