
<?php

    session_start();

    require "conn.php";

    $mess="";

    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $description=$_POST['description'];
        $incredients=$_POST['incredients'];
        $catageroy=$_POST['catageroy'];
        $tags=$_POST['tags'];
        $instructions=$_POST['instructions'];


        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $mess="File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $mess="File is not an image.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $mess="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $mess="Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "images/$title.".$imageFileType)) {
                $profile="images/$title." .$imageFileType;

                
                $status=1;
                while($status!=0){
                    $id=rand(0000,9999);
                    $id=$title.$id;
                    

                    $sq="select id from ids where id=$id";
                    $result = $conn->query($sq);

                    if (!$result){
                        $status=0;

                        $s="insert into ids values('$id')";
                        if($conn->query($s)){
                            $sql="insert into collection values('$id','$title','$description','$incredients','$catageroy','$tags','$instructions','$profile')";

                            if($conn->query($sql))
                            {
                                header("Location:index.php");
                            }
                            else{
                                $mess="Unable to add $title";
                            }
                        }
                        
                    }
                }

            } else {
                $mess="Sorry, there was an error uploading your file.";
            }
        }



        }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/add.css">
    <title>Add New Item</title>
</head>
<body>

    <h1>Add New Item Here</h1>

    <div class="form">
        <form action="" method="post" enctype="multipart/form-data" name="form">
            <label for="title">Title :</label> <input type="text" id="title" name="title" placeholder="Enter the recipe Title" required>
            <label for="description">Description :</label> <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter Description of the recipe" required></textarea>
            <label for="incredients">Incredients List :</label> <textarea name="incredients" id="incredients" cols="30" rows="10" placeholder="Enter Incredients" required></textarea>
            <label for="catageroy">Catageroy :</label> <select name="catageroy" id="catageroy" required class="cat">
                                                    <option value="">select</option>
                                                    <option value="curries">Curries</option>
                                                    <option value="staters">Staters</option>
                                                    <option value="rice items">Rice items</option>
                                                    <option value="tiffens">Tiffens</option>
                                                    <option value="others">others</option>
                                                </select>
            <label for="tags">Tags :</label><textarea name="tags" id="tags" cols="30" rows="5" placeholder="Enter tags for the recipe" required></textarea>
            <label for="instructions">Instructions :</label> <textarea name="instructions" id="instructions" cols="30" rows="10" placeholder="Enter the instructions to prepare the recipe" required></textarea>
            <label for="fileToUpload">Picture :</label> <label for="fileToUpload" class="pic"> <a>Add Picture</a></label> <input type="file" name="fileToUpload" id="fileToUpload"> 
    
                <span class="info"><?php echo $mess;  ?></span>

            <input type="submit" value="Add" name="submit" class="submit">
        </form>

        <a href="index.php" class="back">Back</a>

    </div>
    
</body>
</html>