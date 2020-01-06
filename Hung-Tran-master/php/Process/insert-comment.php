<?php 
    include "connect.php";


    $task_id = $_POST['id_task'];   //line 940 ajax.js
    $comment = $_POST['title_comment']; // line 941 ajax.js
    
    $insert_comment = $db->prepare("INSERT INTO comment(title,taskId) VALUES (?,?)");
    $insert_comment->bindParam('1',$comment);
    $insert_comment->bindParam('2',$task_id);
    $insert_comment->execute();

    $last_id = $db->lastInsertId();
    echo $last_id;
?>