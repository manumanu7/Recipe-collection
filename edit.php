
<?php

    session_start();

    require "conn.php";


    $profile="";

    $mess="";

    $id=$_GET['id'];


    if(isset($_POST['submit'])){
        $title=$_POST['title'];
        $description=$_POST['description'];
        $incredients=$_POST['incredients'];
        $catageroy=$_POST['catageroy'];
        $tags=$_POST['tags'];
        $instructions=$_POST['instructions'];

        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        if($target_file!=$target_dir){
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

                        $sql="update collection set title='$title',description='$description',ingredients='$incredients',category='$catageroy',tag='$tags',instructions='$instructions',picture='$profile' where id='$id'";
        
                        if($conn->query($sql))
                        {
                            $link="view.php?id=".$_GET['id'];
                            // echo $id;
                            header("Location:$link");
                        }
                        else{
                            $mess="Unable to Update $title";
                        }
                    } else {
                        $mess="Sorry, there was an error uploading your file.";
                }
            }
        }
        else{
            $sql="update collection set title='$title',description='$description',ingredients='$incredients',category='$catageroy',tag='$tags',instructions='$instructions' where id='$id'";
        
            if($conn->query($sql))
            {
                $link="view.php?id=".$_GET['id'];
                // echo $id;
                header("Location:$link");
            }
            else{
                $mess="Unable to Update $title";
            }
        }

    }


   

    $sql="select * from collection where id='$id'";
    $result=$conn->query($sql);

    while($row=$result->fetch_assoc()){

        $profile=$row['picture'];
   
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <title>Edit page</title>
</head>
<body>
    <h1>Edit Item Here</h1>

    <div class="form">
        <form action="" method="post" enctype="multipart/form-data" name="form">
            <label for="title">Title :</label> <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" placeholder="Enter the recipe Title" required>
            <label for="description">Description :</label> <textarea name="description" id="description"  cols="30" rows="10" placeholder="Enter Description of the recipe" required> <?php echo $row['description']; ?></textarea>
            <label for="incredients">Incredients List :</label> <textarea name="incredients" id="incredients" cols="30" rows="10" placeholder="Enter Incredients" required><?php echo $row['ingredients']; ?></textarea>
            <label for="catageroy">Catageroy :</label> <input type="text" id="catageroy" name="catageroy" value="<?php echo $row['category']; ?>" required placeholder="Enter the catageroy of the recipe">
            <label for="tags">Tags :</label><textarea name="tags" id="tags" cols="30" rows="5" placeholder="Enter tags for the recipe" required><?php echo $row['tag']; ?></textarea>
            <label for="instructions">Instructions :</label> <textarea name="instructions" id="instructions" cols="30" rows="10" placeholder="Enter the instructions to prepare the recipe" required><?php echo $row['instructions']; ?></textarea>
            <label for="fileToUpload">Picture :</label> <label for="fileToUpload" class="pic"> <a>Add Picture</a></label> <input type="file" name="fileToUpload" id="fileToUpload"> 
    
                <span class="info"><?php echo $mess;  ?></span>

            <input type="submit" value="Edit" name="submit" class="submit">
        </form>

        <a href="index.php" class="back">Back</a>

    </div>
</body>
</html>

<?php

    }


?>