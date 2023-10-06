
<?php

    session_start();

    require "conn.php";

    $id=$_GET['id'];
    
    $sql="select * from collection where id='$id'";
    $result = $conn->query($sql);

    if ($result){
        while($row=$result->fetch_assoc()){

    

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view.css">
    <title><?php echo $row['title']; ?></title>
</head>
<body>
    <div class="details">
        <h1><?php echo $row['title']; ?></h2>
        <img src="<?php echo $row['picture']; ?>" alt="">
        <div class="item">
            <label for="id">Id : </label><span id="id"><?php echo $row['id']; ?></span><br><br>
            <label for="title">Title : </label><span id="title"><?php echo $row['title']; ?></span><br><br>
            <label for="description">Description : </label><span id="description"><?php echo $row['description']; ?></span><br><br>
            <label for="ingredients">Ingredients : </label><span id="ingredients"><?php echo $row['ingredients']; ?></span><br><br>
            <label for="category">Category : </label><span id="category"><?php echo $row['category']; ?></span><br><br>
            <label for="instructions">Process : </label><span id="instructions"><?php echo $row['instructions']; ?></span>
        </div>
        <div class="butts">
            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="index.php">Back</a>
        </div>
    </div>
</body>
</html>

<?php  
        }
    }

?>