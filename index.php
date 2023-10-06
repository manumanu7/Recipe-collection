
<?php

    session_start();

    require "conn.php";

    

    if(isset($_GET['searchitem'])){
        $opt="%".$_GET['searchitem']."%";
        $sql="select * from collection where tag like '$opt'";
        $result = $conn->query($sql);
        // echo $result;
    }
    else if(isset($_GET['cate'])){
        $opt=$_GET['cate'];
        $sql="select * from collection where category = '$opt'";
        $result = $conn->query($sql);
    }
    
    else{
        $sql="select * from collection";
        $result = $conn->query($sql);
    }

    

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Collection</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>Recipe Collections</h1>

    <!-- <a href="" class="search">Search</a> -->
    <select name="catageroy" id="catageroy" class="cat" onchange="fun()">
        <option value="">select</option>
        <option value="all">All</option>
        <option value="curries">Curries</option>
        <option value="staters">Staters</option>
        <option value="rice items">Rice items</option>
        <option value="tiffens">Tiffens</option>
        <option value="others">others</option>
    </select>
    <input type="search" name="search" class="search" id="search" placeholder="Search..." onsearch="search()">
    <a href="add.php" class="addnew">Add New Item</a>

    <?php
        if(isset($_GET['cate'])){
            echo "<h3>Categorey : <span style='text-transform:uppercase;'>".$_GET['cate']."</span><h3><br><br>";
        }
    ?>

    <div class="grid">

        <?php
        if($result->num_rows>0){
            
            while($row = $result->fetch_assoc()){
                ?>

            <div class="items">
                <h2><?php echo $row['title']; ?></h2>
                <img src="<?php echo $row['picture']; ?>" alt="<?php echo $row['title']; ?>" >
                <br>
                <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
            </div>

        <?php
            }
            

        ?> 

        <?php

        }
        else{
            echo "<h1 style='transform: translate(150%,250%);'>No Results Found</h1>";
        }

        ?>

        
       
        
    </div>


    <script>
        function fun(){
            var y=document.getElementById("catageroy").value;
            if(y=="all"){
                window.location="index.php";
            }
            else{
                window.location="index.php?cate="+y;
            }
        }
        function search(){
            var x=document.getElementById("search").value;
            if(x==""){
                window.location="index.php";
            }
            else{
                window.location="index.php?searchitem="+x;
            }
        }
    </script>


    
</body>
</html>


