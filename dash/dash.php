<?php
session_start();

//checks whether user has logged in
if (!isset($_SESSION['username'])) {
    header('location: ../8g6TDGxmQP/sign_in.php'); //sends users to login screen if they haven't logged in
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="../js/moment.js"></script>
        <script src="../js/moment-timezone-with-data.js"></script>
        <script>
            //var cur_time = moment().format("ddd. MM/DD/YYYY @ h:mm A");
            var cur_time = moment();
            var cTime = cur_time.tz('America/New_York').format('YYYY-MM-DD HH:MM:SS');
            var cur_time_est = cur_time.tz('America/New_York').format('ddd. DD/MM/YYYY h:mm:ss A');
        </script>
        <title>Welcome</title>

    </head>
    
    <body class="text-center">
        <div class="container">
            <nav>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="../8g6TDGxmQP/signout_process.php">Sign out</a>
                    </li>
                </ul>
            </nav>
            <div class="jumbotron">
                <h1 class="display-4 text-center">Lord of the Pick'em</h1>
                <p class="lead">Welcome <?php echo $_SESSION['username'] ?>.</p>
                <hr class="my-4">
                <div id="client_time"></div>
                <p class="text-center">
                    <form id="choose_week">
                        <select name="choose_week_drop" id="choose_week_drop">
                            <option value="Week 1">Week 1</option>
                            <option value="Week 2">Week 2</option>
                            <option value="Week 3">Week 3</option>
                            <option value="Week 4">Week 4</option>
                            <option value="Week 5">Week 5</option>
                            <option value="Week 6">Week 6</option>
                            <option value="Week 7">Week 7</option>
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
                </p>
            </div>
            <div id="itemView" class="text-left"></div>
        </div><!--container-->
        <!--</div>-->
    </body>
    <script>

        function pickTeam(gameID, league, season, week, dateTime, homeTeam, awayTeam, gamePick){
            $.ajax({
                method: "GET",
                url: "../api/pick_team.php",
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
                }
            }); //ajax 
        };
        //TODO:
        $(function() {
            $("#choose_week_drop").change(function() {
                var selection = $("#choose_week_drop").val().split(" ");
                var week_int = selection[1];
                console.log(week_int);
                $.ajax({
                    method: "GET",
                    url: "../api/games_by_week.php",
                    dataType: "json",
                    data: {
                        "week": week_int
                    },  
                    success: function(data, status) {
                        var home_team_data = "";

                        console.log(data);
                        //console.log(data["user_games"]);
                        let itemStr = "";
                        data["games"].forEach(function(key1) {

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
                            itemStr += "<div class='col-6 text-center'>";
                            $.each( data["teams"], function( key2, value ){
                                if (value.team_id === key1['home_team']){
                                    itemStr += "<br><b>Home</b></br>";
                                    itemStr += "<img src='" + value.icon_url +"' height='75'><br>";
                                    itemStr += value.full_name + " (" + value.team_id + ")<br>";
                                    console.log("cTime: " + cTime + " | databaseTime: " + key1['date_time']);
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
                                        itemStr += "')\">Pick</button>";
                                    }
                                }
                            });
                            itemStr += "</div>";
                            //End HomeTeam col

                            //AwayTeam col
                            itemStr += "<div class='col-6 text-center'>";
                            $.each( data["teams"], function( key2, value ){
                                if (value.team_id === key1['away_team']){
                                    itemStr += "<br><b>Away</b></br>";
                                    itemStr += "<img src='" + value.icon_url +"' height='75'><br>";
                                    itemStr += value.full_name + " (" + value.team_id + ")<br>";
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
                                        itemStr += "')\">Pick</button>";
                                    }
                                }

                            });
                            itemStr += "</div>";
                            //End AwayTeam col

                            itemStr += "</div>";
                            //End Team row



                            //Results row
                            itemStr += "<div class='row'>";

                            //Users current pick col
                            itemStr += "<div class='col-12 text-center'>";
                            itemStr += "<b>Your pick:</b> <span id='";
                            itemStr += key1['game_id'] + "_pick";
                            itemStr += "'>";
                            $.each(data["user_games"], function( key2, value ){
                                if (value.game_key === key1['game_id']){
                                    itemStr += value.pick;
                                }
                            });
                            itemStr += "</span>";
                            itemStr += "</div>";
                            //End Users current pick col

                            //Winner col
                            itemStr += "<div class='col-12 text-center'>";
                            itemStr += "<b>Winner:</b> "+key1['winner'];
                            itemStr += "</div>";
                            //End Winner col

                            itemStr += "</div><hr>";
                            //End Results row
                        });

                        $("#itemView").html(itemStr); 
                    }
                }); //ajax 
            }).triggerHandler('change');
        });

        var cur_time_str = "<strong>Your time</strong><br>";
        cur_time_str += cur_time_est + " (EST)";
        $("#client_time").html(cur_time_str);
    </script>
</html>
