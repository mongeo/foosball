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
        <div class="container-fluid">
            <nav>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <u><a class="nav-link disabled" href="#">Dashboard</a></u>
                    </li>
                    <li class="nav-item">
                        <u><a class="nav-link" href="head2head.php">Head2Head</a></u>
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
                <hr class="my-4" style>
                <div id="client_time"></div>
                <div id="week_results"></div>

                <div class="text-center">
                    <form id="choose_week">
                        <select name="choose_week_drop" id="choose_week_drop">
                            <option value="Week 1">Week 1</option>
                            <option value="Week 2">Week 2</option>
                            <option value="Week 3">Week 3</option>
                            <option value="Week 4">Week 4</option>
                            <option value="Week 5">Week 5</option>
                            <option value="Week 6">Week 6</option>
                            <option value="Week 7" selected>Week 7</option>
                            <option value="Week 8">Week 8</option>
                            <option value="Week 9">Week 9</option>
                            <option value="Week 10">Week 10</option>
                            <option value="Week 11">Week 11</option>
                            <option value="Week 12">Week 12</option>
                            <option value="Week 13">Week 13</option>
                            <option value="Week 14">Week 14</option>
                            <option value="Week 15">Week 15</option>
                            <option value="Week 16">Week 16</option>
                            <option value="Week 17">Week 17</option>
                        </select>
                    </form>
                    <br>
                </div>
                <div id="week_msg">Game wins for week 6 will be updated no later than 10/20/21 @ 10PM PST.<br>Game spread details updated from <a href="https://www.sportingnews.com/us/nfl/news/nfl-odds-lines-spreads-week-6/onbmyo5rfm4d1668du84h7obw" target="_blank">sportingnews.com</a> on 10/13/21.<br><a href="https://www.youtube.com/watch?v=x3feHj30r_Q" target="_blank">(More about spreads)</a>
                
                </div>
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

        function pickTeam(gameID, league, season, week, dateTime, homeTeam, awayTeam, gamePick){
            $.ajax({
                method: "GET",
                url: "api/pick_team.php",
                dataType: "json",
                data: {
                    "game_key": gameID,
                    "league": league,
                    "season": season,
                    "week": week, 
                    "date_time": dateTime,
                    "home_team": homeTeam,
                    "away_team": awayTeam,
                    "pick": gamePick
                },  
                success: function(data, status) {
                    $("#"+ gameID + "_pick").html(data);
                    if (gamePick === homeTeam){
                        $("#"+gameID+"_home").css({"border-style":"solid","border-color":"#339955"})
                        $("#"+gameID+"_away").css({"border-style":"none"})
                    } else {
                        $("#"+gameID+"_away").css({"border-style":"solid","border-color":"#339955"})
                        $("#"+gameID+"_home").css({"border-style":"none"})
                    }
                }
            }); //ajax 
        };
        //TODO:
        $(function() {
            $("#choose_week_drop").change(function() {
                var selection = $("#choose_week_drop").val().split(" ");
                var week_int = selection[1];
                selected_week = week_int;
                //console.log(selected_week);
                $.ajax({
                    method: "GET",
                    url: "api/games_by_week.php",
                    dataType: "json",
                    data: {
                        "week": week_int
                    },  
                    success: function(data, status) {
                        var home_team_data = "";
                        var number_of_games = 0;
                        var number_of_wins = 0;

                        //console.log(data);
                        //console.log(data["user_games"]);
                        let itemStr = "";
                        data["games"].forEach(function(key1) {
                            number_of_games++;
                            //Date row
                            itemStr += "<div class='row'>";

                            //Date col
                            itemStr += "<div class='col-12 text-center'>";
                            var game_time = moment(key1['date_time']).format("ddd. MM/DD/YYYY @ h:mm A");
                            itemStr += "<h3>" + game_time + " (EST)</h3>";
                            itemStr += "</div>";
                            //EndDate col

                            itemStr += "</div>";
                            //End Date row
                            
                            //Team row
                            itemStr += "<div class='row'>";

                            //HomeTeam col
                            itemStr += "<div class='col-6 text-center' id='" + key1['game_id'] + "_home'>";
                            $.each( data["teams"], function( key2, value ){
                                if (value.team_id === key1['home_team']){
                                    itemStr += "<br><b>Home</b></br>";
                                    itemStr += "<img src='" + value.icon_url +"' height='75'><br>";
                                    itemStr += value.full_name + " (" + value.team_id + ")<br>";
                                    itemStr += value.record + "<br><br>";
                                    //console.log("cTime: " + cTime + " | databaseTime: " + key1['date_time']);
                                    if (cTime < key1['date_time']){
                                        itemStr += "<button class='btn btn-primary' onclick=\"pickTeam("; 
                                        itemStr += "'" + key1['game_id'] + "', ";
                                        itemStr += "'2021', ";
                                        itemStr += "'" + key1['season'] + "', ";
                                        itemStr += "'" + key1['week'] + "', ";
                                        itemStr += "'" + key1['date_time'] + "', ";
                                        itemStr += "'" + key1['home_team'] + "', ";
                                        itemStr += "'" + key1['away_team'] + "', ";
                                        itemStr += "'" + key1['home_team'];
                                        itemStr += "')\">Pick</button><br><br>";
                                    }
                                }
                            });
                            itemStr += "</div>";
                            //End HomeTeam col

                            //AwayTeam col
                            itemStr += "<div class='col-6 text-center' id='" + key1['game_id'] + "_away'>";
                            $.each( data["teams"], function( key2, value ){
                                if (value.team_id === key1['away_team']){
                                    itemStr += "<br><b>Away</b></br>";
                                    itemStr += "<img src='" + value.icon_url +"' height='75'><br>";
                                    itemStr += value.full_name + " (" + value.team_id + ")<br>";
                                    itemStr += value.record + "<br><br>";
                                    if (cTime < key1['date_time']){
                                        itemStr += "<button class='btn btn-primary' onclick=\"pickTeam("; 
                                        itemStr += "'" + key1['game_id'] + "', ";
                                        itemStr += "'2021', ";
                                        itemStr += "'" + key1['season'] + "', ";
                                        itemStr += "'" + key1['week'] + "', ";
                                        itemStr += "'" + key1['date_time'] + "', ";
                                        itemStr += "'" + key1['home_team'] + "', ";
                                        itemStr += "'" + key1['away_team'] + "', ";
                                        itemStr += "'" + key1['away_team'];
                                        itemStr += "')\">Pick</button><br><br>";
                                    }
                                }
                            });
                            itemStr += "</div>";
                            //End AwayTeam col

                            itemStr += "</div>";
                            //End Team row



                            //Results row
                            itemStr += "<div class='row mt-3'>";

                            //Game spread
                            itemStr += "<div class='col-12 text-center'>";
                            itemStr += "<b>Game spread:</b> <span id='";
                            itemStr += key1['game_spread'];
                            itemStr += "'>";
                            itemStr += key1['game_spread'];
                            itemStr += "</span>";
                            itemStr += "</div>";
                            //End Game spread

                            //Users current pick col
                            itemStr += "<div class='col-12 text-center'>";
                            itemStr += "<b>Your pick:</b> <span id='";
                            itemStr += key1['game_id'] + "_pick";
                            itemStr += "'>";
                            $.each(data["user_games"], function( key2, value ){
                                if (value.game_key === key1['game_id']){
                                    itemStr += value.pick;
                                    if (value.result == 'W'){
                                        number_of_wins++;
                                    }
                                }
                            });
                            itemStr += "</span>";
                            itemStr += "</div>";
                            //End Users current pick col

                            //Winner col
                            itemStr += "<div class='col-12 text-center'>";
                            itemStr += "<b>Winner:</b> "+ key1['winner'];
                            itemStr += "</div>";
                            //End Winner col

                            itemStr += "</div><hr>";
                            //End Results row
                        });
                        var weeks_score_str = "<br>";
                        weeks_score_str += "<b>Week " + selected_week + " Stats:</b><br>";
                        weeks_score_str += "Wins: " + number_of_wins + " / Total games: " + number_of_games + "<br>";
                        $("#week_results").html(weeks_score_str);

                        $("#itemView").html(itemStr); 
                        $.each(data["user_games"], function( key2, value ){
                            if (value.home_team === value.pick){
                                $("#"+value.game_key+"_home").css({"border-style":"solid","border-color":"#339955"});
                                $("#"+value.game_key+"_away").css({"border-style":"none"});
                            } else {
                                $("#"+value.game_key+"_away").css({"border-style":"solid","border-color":"#339955"});
                                $("#"+value.game_key+"_home").css({"border-style":"none"});
                            }
                        });
                    }
                }); //ajax 
            }).triggerHandler('change');
        });

        var cur_time_str = "<strong>Your time</strong><br>";
        cur_time_str += cur_time_est + " (EST)";
        $("#client_time").html(cur_time_str);
    </script>
</html>
