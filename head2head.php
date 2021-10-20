<?php
session_start();

//checks whether user has logged in
if (!isset($_SESSION['username'])) {
    header('location: api/sign_in.php'); //sends users to login screen if they haven't logged in
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="js/moment.js"></script>
        <script src="js/moment-timezone-with-data.js"></script>
        <script>
            //var cur_time = moment().format("ddd. MM/DD/YYYY @ h:mm A");
            var cur_time = moment();
            var cTime = cur_time.tz('America/New_York').format('YYYY-MM-DD HH:MM:SS');
            var cur_time_est = cur_time.tz('America/New_York').format('ddd. MM/DD/YYYY h:mm:ss A');
            var selected_week = 1;
            class Game {
                constructor(gameKey, homeName, awayName, homeImg, awayImg, pick, userName){
                    this.gameKey = gameKey;
                    this.homeName = homeName;
                    this.awayName = awayName;
                    this.homeImg = homeImg;
                    this.awayImg = awayImg;
                    this.homePick = [];
                    this.awayPick = [];
                    this.addPick(pick, userName);
                }
                addPick(pickName, userName){
                    if (pickName === this.homeName){
                        this.homePick.push(userName);
                    } else {
                        this.awayPick.push(userName);
                    }

                }
            }
            let gamesArray = [];
        </script>
        <style>
            body {
                font-family: "Merriweather";
                font-size: 16px;
            }
        </style>
        <title>Welcome</title>

    </head>
    
    <body class="text-center">
        <div class="container">
            <nav>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <u><a class="nav-link" href="dash.php">Pick</a></u>
                    </li>
                    <li class="nav-item">
                        <u><a class="nav-link disabled" href="#">Matches</a></u>
                    </li>
                    <li class="nav-item">
                        <u><a class="nav-link" href="leaderboard.php">Leaderboard</a></u>
                    </li>
                    <li class="nav-item">
                        <u><a class="nav-link" href="api/signout_process.php">Sign out</a></u>
                    </li>
                </ul>
            </nav>
            <div class="jumbotron">
                <h1 class="display-4 text-center">Lord of the Pick'em</h1>
                <p class="lead">Welcome <?php echo $_SESSION['username'] ?>.</p>
                
                <p>Games in play will be displayed below showing which users picked which team.</p>
            </div>
            <div id="itemView" class="text-left"></div>

            <br>
            <div id="fun" class="text-center"><img src="https://c.tenor.com/nTfGANr9MlAAAAAi/lord-of-the-rings-my-precious.gif" width="15%">
            </div>
            <br>
            <div id="help"><p>For questions or comments contact: <a href="mailto:nfl_admin@lordofthepickem.com">nfl_admin@lordofthepickem.com</a>.</p></div>
        </div><!--container-->
        <!--</div>-->
    </body>
    <script>
        //TODO:
        $(function() {
            $.ajax({
                method: "GET",
                url: "api/head2head_now.php",
                dataType: "json",
                data: {
                },  
                success: function(data, status) {
                    console.log(data);
                    data["head2head"].forEach(function(key) {
                        var found = false;
                        gamesArray.forEach(function(key2){
                            if (key.game_key === key2.gameKey){
                                key2.addPick(key.pick, key.username);
                                found = true;
                            }
                        });
                        if (found === false){
                            var homeURL;
                            var awayURL;
                            data["teams"].forEach(function(key3) {
                                if (key.home_team === key3.team_id){
                                    homeURL = key3.icon_url;
                                }
                                if (key.away_team === key3.team_id){
                                    awayURL = key3.icon_url;
                                }
                            });
                            const game = new Game(key.game_key, key.home_team, key.away_team, homeURL, awayURL, key.pick, key.username);
                            gamesArray.push(game);
                        }

                    });
                    console.log(gamesArray);
                    
                    var itemStr = "";
                    gamesArray.forEach(function(key4) {
                        itemStr += "<div class='card'>";
                        itemStr += "<div class='card-header text-center'>";
                        itemStr += key4.homeName + " vs. " + key4.awayName;
                        itemStr += "</div>";
                        itemStr += "<div class='row no-gutters text-center'>";
                        itemStr += "<div class='col-6'>";
                        itemStr += "<br><img src='"+ key4.homeImg + "' height=75px>";
                        itemStr += "</div>";
                        itemStr += "<div class='col-6'>";
                        itemStr += "<br><img src='"+ key4.awayImg + "' height=75px>";
                        itemStr += "</div>";
                        itemStr += "</div>";
                        itemStr += "<div class='row text-center no-gutters'>";
                        itemStr += "<div class='col-6 text-center'><h3>";
                        itemStr += key4.homePick.length;
                        itemStr += "</h3></div>";
                        itemStr += "<div class='col-6' text-center><h3>";
                        itemStr += key4.awayPick.length;
                        itemStr += "</h3></div>";
                        itemStr += "</div>";
                        itemStr += "<div class='row text-center no-gutters'>";
                        itemStr += "<div class='col-6' text-center>";
                        key4.homePick.forEach(function(key5) {
                            itemStr += key5 + "<br>";
                        });
                        itemStr += "</div>";
                        itemStr += "<div class='col-6' text-center>";
                        key4.awayPick.forEach(function(key6) {
                            itemStr += key6 + "<br>";
                        });
                        itemStr += "</div>";
                        itemStr += "</div>";
                        itemStr += "</div>";
                    });
                    $("#itemView").html(itemStr);
                }
            }); //ajax 
        });
    </script>
</html>
