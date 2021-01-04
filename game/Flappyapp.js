/*
Name: Joshua Ramnaraine, Aryan Singh
Date: 11/27/2020
Description: This work behind the flappy game.
 */

//this fucntion is called as soon the the game page is loaded
function game_loaded() {

    //decalaring variables and objects to be used later
    var score = 0;
    var game_screen = document.getElementById('game_screen');
    var bird = document.getElementById('bird');

    //declaring starting left and rigt positions of the bird
    var bird_left = 220;
    var bird_bottom = 100;

    //declaring gravity to make the bird fall down
    var graity = 2.5;

    //"gap" used to determine the the space betweem the obstacles and "isgame_over" used to determine if the game is to be terminated 
    var isgame_over = false;
    var gap = 430;
   
    //postions the bird and used to change its height to make it appear that the bird is falling
    function start_game() {
        bird_bottom = bird_bottom - graity;
        bird.style.bottom = bird_bottom + 'px';
        bird.style.left = bird_left + 'px';

    }

    //calls the above "start_game" function every 20ms to make it appear as if the bird is falling
    var game_timer = setInterval(start_game, 20);

    //takes in the keydown event as paprameter "e" and determines if the key pressed is the space key bar
    function jump_control(e){
        //determines if the space key is pressed and behaves accordingly.
        if(e.keyCode === 32){
            jump();
        }
    }

    //makes the bird jump by increasing its current height
    function jump(){
        if(bird_bottom < 500){
            bird_bottom += 50;
            bird.style.bottom = bird_bottom + 'px';

        }
    }

    //event listener used to listen to a key pressed on the keyboard.
    document.addEventListener('keydown', jump_control);

    //function used to generate obstacles
    function obstacles(){
        //determining obstcle postioning
        var obstacle_left = 500;
        var random_height = Math.random() * 150;
        var obstacle_bottom = random_height;
        //creating a div element to store obstacles
        var obstacle = document.createElement('div');
        var obstacle_reflected = document.createElement('div');
        
        //if the game_over is false then only the obstacles will be used for styling
        if(isgame_over == false){

            obstacle.setAttribute('id', 'obstacles');
            obstacle_reflected.setAttribute('id', 'obstacles_reflect');

        }
        //append the obstacles within the game_screen div
        game_screen.appendChild(obstacle);
        game_screen.appendChild(obstacle_reflected);
        //establishig initial obstacle positions
        obstacle.style.left = obstacle_left + 'px';
        obstacle_reflected.style.left = obstacle_left + 'px';
        obstacle.style.bottom = obstacle_bottom + 'px';
        obstacle_reflected.style.bottom = obstacle_bottom + gap + 'px';

        //used to make the obstacles appear as if they are moving
        function obstacle_graphics(){
            //declaring variable and changing obstacle position
            obstacle_left -= 2;
            obstacle.style.left = obstacle_left + 'px';
            obstacle_reflected.style.left = obstacle_left + 'px';

            //if the bird passes the obstacle increment the score by 1
            if(obstacle_left == 180){
                score++;
            }
            // if the obstacle reaches the end of the screen the make the obstacle div disspear
            if(obstacle_left ==0){
                clearInterval(obstacle_timer);
                game_screen.removeChild(obstacle);
                game_screen.removeChild(obstacle_reflected);
            }

            // if the the bird hits the obstacles or the gound then call the function "game_over" and stop generating obstacles
            if( obstacle_left > 200 && obstacle_left < 280 && bird_left == 220 && (bird_bottom < obstacle_bottom + 153 || bird_bottom > obstacle_bottom + gap - 200) || bird_bottom == 0){
                clearInterval(obstacle_timer);
                game_over();
            }

        }

        //setting the interval for function 20ms to make it appear as if obstacles are moving
        var obstacle_timer = setInterval(obstacle_graphics,20);

        //if the user hasnt caused the game to terminate keep generating the obstacles with a interval of 2s
        if(isgame_over == false){

            setTimeout(obstacles,2000);
        }

    }

    //function call
    obstacles();

    //once game is over the users score is displayed and username prompt is provided
    function game_over() {
        var name;
        alert("Game Over. Your score is: " + score);
        name = prompt("Enter a username you would like to use for the leaderboard");
        while(name == null || name == ""){
            name = prompt("Enter a username you would like to use for the leaderboard");
        }
        window.location.href = "../leaderboard/leaderboard.php?userScore=" + score + "&userName=" + name;
    }

}