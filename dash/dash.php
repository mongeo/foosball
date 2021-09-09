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
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                <p class="text-center">
                    <span class="lead">
                        Item: <input type ="text" name="searchItem" id="searchItem"/><br/> 
                    </span>
                </p>
            </div>
            <div id="itemView" class="text-left"></div>
        </div><!--container-->
        <!--</div>-->
    </body>
    <script>
        //TODO: List all items
        $.ajax({
            method: "GET",
            url: "../api/games_by_week.php",
            dataType: "json",
            data: {
                "week": 1
                },
            success: function(data, status) {
                // console.log(data);

                //<div class='card-columns'>
               let itemStr = "<div class='card-columns'>";
               //itemStr = "<div class='card-group'>"
               data.forEach(function(key) {
                    itemStr += "<div class='card' style='width: 18rem;'>";
                    itemStr +=      "<div class='card-body'>";
                    itemStr +=          "<h5 class='card-title'>Game ID"+ key['game_id'] +"</h5>";
                    itemStr +=      "</div>";
                    itemStr +=      "<ul class='list-group list-group-flush'>";
                    itemStr +=          "<li class='list-group-item'>Season: "+key['season'] +"</li>";
                    itemStr +=          "<li class='list-group-item'>Week: "+key['week'] +"</li>";
                    itemStr +=          "<li class='list-group-item'>Date: "+key['date_time'] +"</li>";
                    itemStr +=          "<li class='list-group-item'>Home: "+key['home_team'] +"<br><button type='button' class='btn btn-primary'>Pick</button></li>";
                    itemStr +=          "<li class='list-group-item'>Away: "+key['away_team'] +"<br><button type='button' class='btn btn-primary'>Pick</button></li>";
                    itemStr +=          "<li class='list-group-item'>Winner: "+key['winner'] +"</li>";
                    itemStr +=      "</ul>";
                    itemStr += "</div>";
                });
                itemStr += "</div>"
                $("#itemView").html(itemStr);

                
            }
        }); //ajax 
    </script>
</html>
