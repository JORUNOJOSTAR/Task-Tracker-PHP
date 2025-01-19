<?php
require "readWrite.php";


while(count($argv)<4){
    $argv[] = ""; 
}

[,$operation, $opt1 , $opt2] = $argv;



function isEmptyDescription($description) {
    if(!$description){
        die("Error : Task description is not given.");
    }
}

switch($operation){
    case 'add':
        isEmptyDescription($opt1);
        addData($opt1);
        break;
        
    case 'update':
        isEmptyDescription($opt2);
        updateData($opt1,$opt2);
        break;

    case 'delete':
        deleteData($opt1);
        break;

    case 'mark-in-progress':
        markProgress($opt1);
        break;

    case 'mark-done':
        markDone($opt1);
        break;

    case 'list':
        if(!in_array($opt1,array("","todo","in-progress","done"))){
            die("Invalid option for list command");
        }
        listTask($opt1);
        break;

    default:
        echo "Invalid operation command";
}