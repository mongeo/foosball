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
            var cur_time_est = cur_time.tz('America/New_York').format('ddd. DD/MM/YYYY h:mm:ss A');
        </script>
        <title>Welcome</title>

    </head>
    
    <body class="text-center">
            <!--<h1 class='title'>Welcome <?php echo $_SESSION['username'] ?>!</h1>
            <p>Stay tuned. More to come soon.</p>
            <a class="nav-link" href="../8g6TDGxmQP/signout_process.php">Sign out</a>-->
        <div class="container">
            <div class="jumbotron">
                <h1 class="display-4 text-center">NFL Pick'em</h1>
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

                        //console.log(data["teams"]);
                        let itemStr = "";
                        data["games"].forEach(function(key1) {
                            itemStr += "<div class='row'>";
                            itemStr += "<div class='col-12 text-center'>";

                            var game_time = moment(key1['date_time']).format("ddd. MM/DD/YYYY @ h:mm A");

                            itemStr += "<h3>" + game_time + " (EST)</h3>";

                            itemStr += "</div>";

                            itemStr += "<div class='col-6 text-center'>";
                            $.each( data["teams"], function( key2, value ){
                                if (value.team_id === key1['home_team']){
                                    itemStr += "<br><b>Home</b></br>";
                                    itemStr += "<img src='" + value.icon_url +"' height='75'><br>";
                                    itemStr += value.full_name + " (" + value.team_id + ")<br>";
                                    itemStr += "<button class='btn btn-primary'>Pick</button>";
                                }
                            });
                            itemStr += "</div>";

                            itemStr += "<div class='col-6 text-center'>";
                            $.each( data["teams"], function( key2, value ){
                                if (value.team_id === key1['away_team']){
                                    itemStr += "<br><b>Away</b></br>";
                                    itemStr += "<img src='" + value.icon_url +"' height='75'><br>";
                                    itemStr += value.full_name + " (" + value.team_id + ")<br>";
                                    itemStr += "<button class='btn btn-primary'>Pick</button>";

                                }

                            });
                            itemStr += "</div>";
                            itemStr += "<div class='col-12 text-center'><br><b>Winner: "+key1['winner'] +"</b></div>";
                            itemStr += "</div><hr>";
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
