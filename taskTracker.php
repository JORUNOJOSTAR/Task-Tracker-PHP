<?php
require "readWrite.php";

while(count($argv)<4){
    $argv[] = ""; 
}


[,$operation, $opt1 , $opt2] = $argv;

switch($operation){
    case 'add':
        addData($opt1);
        break;
        
    case 'update':
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
        listTask($opt1);
        break;

    default:
        echo "Invalid operation command";
}