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
    $taskData = readData();
    if(isset($taskData[$id])){
        $taskData[$id]["description"] = $newDescription;
        $time = new DateTime();
        $taskData[$id]["updatedAt"] = $time->format('Y/m/d H:i:s'); 
        echo writeData($taskData)?"Task has been Updated (ID : {$id})\n":"Error occurs when updating data";
    }else{
        echo "Task Not Found.(ID : {$id})";
    }
}

function deleteData($id){
    $taskData = readData();
    unset($taskData[$id]);
    writeData($taskData);
}

function markProgress($id){
    $taskData = readData();
    if(isset($taskData[$id])){
        $taskData[$id]["status"] = "in-progress";
        $time = new DateTime();
        $taskData[$id]["updatedAt"] = $time->format('Y/m/d H:i:s'); 
        echo writeData($taskData)?"Status has been marked as progress (ID : {$id})\n":"Error occurs when updating data";
    }else{
        echo "Task Not Found.(ID : {$id})";
    }
}

function markDone($id){
    $taskData = readData();
    if(isset($taskData[$id])){
        $taskData[$id]["status"] = "done";
        $time = new DateTime();
        $taskData[$id]["updatedAt"] = $time->format('Y/m/d H:i:s');  
        echo writeData($taskData)?"Status has been marked as done (ID : {$id})\n":"Error occurs when updating data";
    }else{
        echo "Task Not Found.(ID : {$id})";
    }
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