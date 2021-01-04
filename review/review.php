<!--
Name: Joshua Ramnaraine, Aryan Singh
Date: 11/27/2020
Description: User is able to write a review on what they think of the game
and able to see other people thoughts on our game.
-->
<?php

//Create database connection
$dbhost="localhost";
$dbuser="admin_scores";
$dbpass="finalgroup32";
$dbname="scores_form";
$connection= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

//To read table in database
$reviewQuery = "SELECT * FROM reviews";
$info = mysqli_query($connection,$reviewQuery);

//Checks to see if php can connect to database
if(mysqli_connect_errno()){
    die ("Database connection failed: ".mysqli_connect_error."(".mysqli_connect_errno().")");
}
//This validation will make sure the user inputs their information
if(!empty($_POST)){
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    //store the insertion command in the sql variable
    $sql = "INSERT INTO reviews ( Names,Rating,Comments) VALUES (
            '{$connection->real_escape_string($name)}',
            '{$connection->real_escape_string($rating)}',
            '{$connection->real_escape_string($comment)}')";
    $insert = $connection->query($sql);//sends the command to the database table

    //When the user information is inserted the database table, the webpage will refresh
    //So that user can see their comment on the review rage
    if($insert==true) {
        header("Location: review.php");
        exit();
    }
    else
        die("Error: {$connection->errno}:{$connection->error}");

}//end of if statement
?>
<DOCTYPE! html>
<html>
    <head>
        <title>Reviews</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
        <link rel="icon"  type="image.ico" href="../favicon.ico">
    </head>
    <style>
        table,th,td{
            border: 6px solid darkgreen;
            border-collapse: collapse;
            background-color: #4cbb17;
            font-size: 25px;
            padding: 10px;
        }
        #review{
            border: 10px solid darkgreen;
            background-color: #4cbb17;
            margin: auto;
            font-size: 20px;
            text-align: center;
            width: 30%;
        }
        input{
            font-size: 20px;
        }
    </style>
    <body>
        <h1 style="text-align: center;">Review</h1>
        <br><br>
        <ul id="nav">
            <li class="right"><a href="../index.html">Home</a></li>
            <li class="left"><a href="../aboutUs/aboutUs.html">About Us</a></li>
            <li class="right"><a href="../howToPlay/HowToPlay.html">How To Play</a></li>
            <li class="left"><a href="../game/game.html">Play Flappy Birds</a></li>
            <li class="right"><a href="../leaderboard/leaderBoard.php">Leaderboard</a></li>
            <li class="left"><a href="review.php">Write a review</a></li>
        </ul>
        <br><br><br><br><br>
        <h2>Comments from other users</h2>
        <br><br>
        <!--   Output users comments as well as previous users comments in table   -->
        <table style="margin: auto; width: 50%; text-align: center">
            <tr>
                <th>Name</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
            <?php
            //Reads each row in the database table
            while ($row = mysqli_fetch_assoc($info)){
                ?>
                <tr>
                    <td><?php echo $row['Names'] ?></td>
                    <td><?php echo $row['Rating'] ?></td>
                    <td><?php echo $row['Comments'] ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <h2>Tell us what you think</h2>
        <br>
        <form method="POST" action="review.php">
            <div id="review">
                Name: <input type="text" name="name" required><br>
                Rating 1-10: <input type="number" name="rating" min="1" max="10" required><br>
                Comment:<br> <textarea style="resize: none; font-size: 15px" name="comment" rows="5" cols="50" required></textarea><br><br>
                <br>
                <input type="submit">
            </div>
        </form>
        <br>
        <br>
    </body>
</html>
