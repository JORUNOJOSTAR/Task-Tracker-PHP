<?php

$dataFile = 'data.json';

// Create File if not exists
if(!file_exists($dataFile)){
    $data = [];
    file_put_contents($dataFile,json_encode($data));
}

function readData(){
    global $dataFile;
    $json_data = file_get_contents($dataFile);
    $array_data = json_decode($json_data,true);
    return $array_data;
}

function writeData($data){
    global $dataFile;
    return file_put_contents($dataFile,json_encode($data));
}

function updateTaskData($id,$name,$value){
    $taskData = readData();
    if(isset($taskData[$id])){
        $taskData[$id][$name] = $value;
        $time = new DateTime();
        $taskData[$id]["updatedAt"] = $time->format('Y/m/d H:i:s'); 
        echo writeData($taskData)?"Task has been Updated (ID : {$id})\n":"Error occurs when updating data";
    }else{
        echo "Task Not Found.(ID : {$id})";
    }
}


function addData($description){
    $taskData = readData();
    $newID = strval(count($taskData) + 1);
    $time = new DateTime();
    $taskData[$newID] = [
        "description" => $description,
        "status" => "todo",
        "createdAt" => $time->format('Y/m/d H:i:s'),
        "updatedAt" => $time->format('Y/m/d H:i:s')
    ];
    echo writeData($taskData)?"Task Added Successfully for (ID : {$newID})\n":"Erro occurs when adding data";
}

function updateData($id,$newDescription){
    updateTaskData($id,"description",$newDescription);
}

function deleteData($id){
    $taskData = readData();
    if(isset($taskData[$id])){
        unset($taskData[$id]);
        writeData($taskData);
        echo "Task deleted Successfully (ID : {$id})";
    }else{
        echo "Error: Task id not found (ID : {$id})";
    }
}

function markProgress($id){
    updateTaskData($id,"status","in-progress");
}

function markDone($id){
    updateTaskData($id,"status","done");
}

function listTask($status){
    $taskData = readData();
    
    // filter task data with status
    $taskData = array_filter($taskData,function($data) use($status){
        //if $status is falsy all element of array will be returned
        return $data["status"] === ($status ?:$data["status"]);
    });
    foreach($taskData as $id=>$value){
        echo "ID:{$id}  | Description: {$value["description"]}   | Status: {$value["status"]}   | CreatedAt: {$value["createdAt"]}    | UpdatedAt: {$value["updatedAt"]}\n";
    }
}