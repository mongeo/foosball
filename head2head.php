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
                        <u><a class="nav-link" href="dash.php">Dashboard</a></u>
                    </li>
                    <li class="nav-item">
                        <u><a class="nav-link disabled" href="#">Head2Head</a></u>
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
                url: "api/head2head_by_week.php",
                dataType: "json",
                data: {
                },  
                success: function(data, status) {
                    var itemStr = "";

                    itemStr += "<div class='row border-bottom'>";

                    //Date col
                    itemStr += "<div class='col-6 text-left'><b>Team</b>";
                    itemStr += "</div>";
                    itemStr += "<div class='col-6 text-center'><b>Number of picks</b>";
                    itemStr += "</div>";
                    //EndDate col   

                    itemStr += "</div>"; 

                    data["head2head"].forEach(function(key) {
                        itemStr += "<div class='row border-bottom'>";

                        //Date col
                        itemStr += "<div class='col-6 text-left'>" + key.pick;
                        itemStr += "</div>";
                        itemStr += "<div class='col-6 text-center'>" + key.count_num;
                        itemStr += "</div>";
                        //EndDate col   

                        itemStr += "</div>";                     
                       
                    });
                    $("#itemView").html(itemStr); 
                }
            }); //ajax 
        });
    </script>
</html>
