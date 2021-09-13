<?php
session_start();

//checks whether user has logged in
if (!isset($_SESSION['username'])) {
    header('location: ../api/sign_in.php'); //sends users to login screen if they haven't logged in
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&display=swap" rel="stylesheet">
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
        <style>
            body {
                font-family: "Merriweather";
            }
        </style>
        <title>Welcome</title>

    </head>
    
    <body class="text-center">
        <div class="container">
            <nav>
                <ul class="nav justify-content-end">
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
            <div id="help"><p>For questions or comments contact: <a href="mailto:nfl_admin@lordofthepickem.com">nfl_admin@lordofthepickem.com</a>.</p></div>
        </div><!--container-->
        <!--</div>-->
    </body>
    <script>

        //TODO:
        $( document ).ready(function() {
                $.ajax({
                    method: "GET",
                    url: "api/gamez.php",
                    dataType: "json",
                    success: function(data, status) {
                        console.log(data);
                        console.log(data["user_games"]);
                        let itemStr = "";
                        //Game row header
                        itemStr += "<div class='row'>";

                        //Game col header
                        itemStr += "<div class='col-1 text-center'>";
                        itemStr += "<b>Key</b>";
                        itemStr += "</div>";

                        itemStr += "<div class='col-3 text-center'>";
                        itemStr += "<b>User</b>";
                        itemStr += "</div>";

                        itemStr += "<div class='col-1 text-center'>";
                        itemStr += "<b>Week</b>";
                        itemStr += "</div>";

                        itemStr += "<div class='col-4 text-center'>";
                        itemStr += "<b>Time</b>";
                        itemStr += "</div>";

                        itemStr += "<div class='col-1 text-center'>";
                        itemStr += "<b>Home</b>";
                        itemStr += "</div>";                           

                        itemStr += "<div class='col-1 text-center'>";
                        itemStr += "<b>Away</b>";
                        itemStr += "</div>";

                        itemStr += "<div class='col-1 text-center'>";
                        itemStr += "<b>Result</b>";
                        itemStr += "</div>";

                        //Game col header

                        itemStr += "</div>";
                        //End Game row header



                        data["user_games"].forEach(function(key, value) {
                            //Game row
                            itemStr += "<div class='row'>";

                            //Game col 
                            itemStr += "<div class='col-1 text-center'>";
                            itemStr += key.game_key;
                            itemStr += "</div>";

                            itemStr += "<div class='col-3 text-center'>";
                            itemStr += key.username;
                            itemStr += "</div>";

                            itemStr += "<div class='col-1 text-center'>";
                            itemStr += key.week;
                            itemStr += "</div>";

                            itemStr += "<div class='col-4 text-center'>";
                            itemStr += key.date_time;
                            itemStr += "</div>";

                            itemStr += "<div class='col-1 text-center'>";
                            itemStr += key.home_team;
                            itemStr += "</div>";                           

                            itemStr += "<div class='col-1 text-center'>";
                            itemStr += key.away_team;
                            itemStr += "</div>";

                            itemStr += "<div class='col-1 text-center'>";
                            itemStr += key.result;
                            itemStr += "</div>";
                            //Game col

                            itemStr += "</div>";
                            //End Game row
                        });
                        $("#itemView").html(itemStr); 
                    }
                }); //ajax 
        });

        var cur_time_str = "<strong>Your time</strong><br>";
        cur_time_str += cur_time_est + " (EST)";
        $("#client_time").html(cur_time_str);
    </script>
</html>
