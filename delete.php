<?php

    session_start();

    require "conn.php";

    $id=$_GET['id'];

    $s="select picture from collection where id='$id'";
    $rs = $conn->query($s);

    if($rs){
        while($row=$rs->fetch_assoc()){
            unlink($row['picture']);
        }
    }
    
    $sql="delete from collection where id='$id'";
    $result = $conn->query($sql);
    if($result){
        $sq="delete from ids where id='$id'";
        $r = $conn->query($sq);

        if($r){
            header("Location:index.php");
        }
    }else{
        header("Location:index.php");
    }


?>