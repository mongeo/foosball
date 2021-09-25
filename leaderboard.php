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
            var cur_time_est = cur_time.tz('America/New_York').format('ddd. DD/MM/YYYY h:mm:ss A');
            var selected_week = 1;
        </script>
        <style>
            body {
                font-family: "Merriweather";
            }
        </style>
        <title>Welcome</title>

    </head>
    
    <body class="text-center">
        <div class="container-fluid">
            <nav>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <u><a class="nav-link" href="dash.php">Dashboard</a></u>
                    </li>
                    <li class="nav-item">
                        <u><a class="nav-link disabled" href="#">Leaderboard</a></u>
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
            </div>
            <div id="itemView" class="text-left"></div>
            <div id="help"><br><br><p>For questions or comments contact: <a href="mailto:nfl_admin@lordofthepickem.com">nfl_admin@lordofthepickem.com</a>.</p></div>
        </div><!--container-->
        <!--</div>-->
    </body>
    <script>
        //TODO:
        $(document).ready(function() {
            //console.log(selected_week);
            $.ajax({
                method: "GET",
                url: "api/leaderboard_stats.php",
                dataType: "json",
                data: {
                },  
                success: function(data, status) {
                    //console.log(data);
                    //console.log(data["wins_by_week"]);
                    let itemStr = "";
                    var cur_week = 0;

                    itemStr += "<div class='row' id='balance'>";
                    itemStr += "<div class='col-12 text-center'>";
                    itemStr += "<h2>User Balance</h2>";
                    itemStr += "</div>";
                    itemStr += "</div>";

                    //
                    itemStr += "<div class='row'>";

                    //
                    itemStr += "<div class='col-6 text-left'><b>Username</b>";
                    itemStr += "</div>";
                    itemStr += "<div class='col-6 text-center'><b>Balance</b>";
                    itemStr += "</div>";
                    //
                    itemStr += "</div>";


                    
                    data["balance"].forEach(function(key) {
                        itemStr += "<div class='row border-bottom'>";

                        //Date col
                        itemStr += "<div class='col-6 text-left'>" + key.username;
                        itemStr += "</div>";
                        itemStr += "<div class='col-6 text-center'>$" + key.balance;
                        itemStr += "</div>";
                        //EndDate col   

                        itemStr += "</div>";                     
                       
                    });

                    itemStr += "<div class='row' id='total_wins'>";
                    itemStr += "<div class='col-12 text-center'>";
                    itemStr += "<h2>Total Wins</h2>";
                    itemStr += "</div>";
                    itemStr += "</div>";

                    //
                    itemStr += "<div class='row'>";

                    //
                    itemStr += "<div class='col-6 text-left'><b>Username</b>";
                    itemStr += "</div>";
                    itemStr += "<div class='col-6 text-center'><b>Wins</b>";
                    itemStr += "</div>";
                    //
                    itemStr += "</div>";


                    
                    data["total_wins"].forEach(function(key) {
                        itemStr += "<div class='row border-bottom'>";

                        //Date col
                        itemStr += "<div class='col-6 text-left'>" + key.username;
                        itemStr += "</div>";
                        itemStr += "<div class='col-6 text-center'>" + key.wins;
                        itemStr += "</div>";
                        //EndDate col   

                        itemStr += "</div>";                     
                       
                    });
                    

                    data["wins_by_week"].forEach(function(key) {
                        if (key.week > cur_week){   
                            itemStr += "<br><div class='row' id='week_" + key.week + "'>";
                            cur_week++;
                            itemStr += "<div class='col-12 text-center'>";
                            itemStr += "<h2>Week " + key.week + "</h2>";
                            itemStr += "</div>";
                            itemStr += "</div>";
                            //
                            itemStr += "<div class='row'>";

                            //
                            itemStr += "<div class='col-6 text-left'><b>Username</b>";
                            itemStr += "</div>";
                            itemStr += "<div class='col-6 text-center'><b>Wins</b>";
                            itemStr += "</div>";
                            //

                            itemStr += "</div>";
                            //
                        }
                        //Date row
                        itemStr += "<div class='row border-bottom'>";

                        //Date col
                        itemStr += "<div class='col-6 text-left'>" + key.username;
                        itemStr += "</div>";
                        itemStr += "<div class='col-6 text-center'>" + key.wins;
                        itemStr += "</div>";
                        //EndDate col

                        itemStr += "</div>";
                        //End Date row
                    });
                    $("#itemView").html(itemStr); 
                }
            }); //ajax 
        });
    </script>
</html>
