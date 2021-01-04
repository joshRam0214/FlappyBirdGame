<!--
Name: Joshua Ramnaraine, Aryan Singh
Date: 11/27/2020
Description: This php file connects to the database leaderboard_table table to insert user name and score
from the flappy bird game. this program will also check to make sure all name enter cannot be repeated and will sort the user score
from highest to lowest and display in a table showing the user their rank in the game.
-->
<?php
//Create Database connection
$dbhost="localhost";
$dbuser="admin_scores";
$dbpass="finalgroup32";
$dbname="scores_form";
$connection= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

$tableQuery = "SELECT * FROM leaderboard_table";
$info = mysqli_query($connection,$tableQuery);//sends the command to the database
$dataName = array(); //stores all the name that comes from the database table
$dataScore = array();// stores all the scores that comes from the database table
$dataSwap =0; // temp variable for scores
$dataSwap2 = ""; // temp variable for name

if(mysqli_connect_errno()){
    die ("Database connection failed: ".mysqli_connect_error."(".mysqli_connect_errno().")");
}
if(!empty($_GET)){
    $userScore = $_GET["userScore"];
    $userName = strtoupper($_GET["userName"]);
    $checksql = "SELECT * FROM leaderboard_table WHERE name = '$userName'";
    $checkUser = mysqli_query($connection,$checksql);
    $count = mysqli_num_rows($checkUser);

    if($count==1)
    {
        $scoreSql = $connection->query("UPDATE leaderboard_table SET scores = '$userScore' WHERE name = '$userName' AND '$userScore'>scores");
        header("Location: leaderboard.php");
        exit();
    }
    else
    {
        $sql = "INSERT INTO leaderboard_table ( name,scores) VALUES (
            '{$connection->real_escape_string($userName)}',
            '{$connection->real_escape_string($userScore)}')";
        $insert = $connection->query($sql);
        if($insert==true) {
            header("Location: leaderboard.php");
            exit();
        }
        else
            die("Error: {$connection->errno}:{$connection->error}");
    }
}//end of if statement



//Fetches that data from leaderboard_table
while ($row = mysqli_fetch_assoc($info)){
    $dataName = array_merge($dataName, array_map('trim', explode(",", $row['name'])));
    $dataScore =array_merge($dataScore, array_map('trim', explode(",", $row['scores'])));
    /*
     * explode will split a string by a delimiter. For this we use a coma
     * array_merge will combine two arrays.
     * array_map will apply trim to all elements.
     * trim will remove any white space on either side of your tags.
     */
}

//Sorting Arrays
for($x=0; $x<sizeof($dataScore);$x++){
    for($y=0; $y<sizeof($dataScore)-$x-1;$y++){
        if($dataScore[$y]<$dataScore[$y+1]){
            //As we swap the scores we are swapping the users name to their score.
            $dataSwap = $dataScore[$y];
            $dataScore[$y] = $dataScore[$y+1];
            $dataScore[$y+1] = $dataSwap;

            $dataSwap2 = $dataName[$y];
            $dataName[$y] = $dataName[$y+1];
            $dataName[$y+1] = $dataSwap2;
        }
    }
}

$connection->close();
?>
<DOCTYPE! html>
<html>
    <head>
        <title>LeaderBoard</title>
        <link rel="icon"  type="image.ico" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <style>
        table,th,td{
            border: 6px solid darkgreen;
            border-collapse: collapse;
            background-color: #4cbb17;
            font-size: 25px;
            padding: 10px;
        }
    </style>
    <body>
        <h1 style="text-align: center;">Leaderboard Page</h1>
        <br><br>
        <ul id="nav">
            <li class="right"><a href="../index.html">Home</a></li>
            <li class="left"><a href="../aboutUs/aboutUs.html">About Us</a></li>
            <li class="right"><a href="../howToPlay/HowToPlay.html">How To Play</a></li>
            <li class="left"><a href="../game/game.html">Play Flappy Birds</a></li>
            <li class="right"><a href="leaderBoard.php">Leaderboard</a></li>
            <li class="left"><a href="../review/review.php">Write a review</a></li>
        </ul>

        <table style="margin: auto; width: 50%; text-align: center">
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
            </tr>
            <?php
            //Outputting the leaderboards in table to keep it organized
            for($x=0; $x<(sizeof($dataScore));$x++){
            ?>
            <tr>
                <td><?php echo ($x+1)  ?></td>
                <td><?php echo $dataName[$x] ?></td>
                <td><?php echo $dataScore[$x] ?></td>
            </tr>
            <?php
            }
            ?>
        </table>
        <br>
        <br>
    </body>
</html>
