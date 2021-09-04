<?php
header('Access-Control-Allow-Origin: *');

   $curl = curl_init();
   curl_setopt_array($curl, array(
         CURLOPT_URL => "https://api.sportsdata.io/v3/nfl/scores/json/Schedules/2021?key=3b7225caa1cd495c8049c91930e35d59",
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_TIMEOUT => 30,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
         CURLOPT_HTTPHEADER => array(
         "cache-control: no-cache"
         ),
      ));

   $jsonData = curl_exec($curl);
   $err = curl_error($curl);
   curl_close($curl);
   $data = json_decode($jsonData, true);  //from JSON format to an Array
   //var_dump($data);
   foreach ($data as $game) {
   //  echo $cur[0];
      echo $game['GameKey'] . ",";
      echo $game['Season'] . ",";
      echo $game['Week'] . ",";
      echo $game['DateTime'] . ",";
      echo $game['AwayTeam'] . ",";
      echo $game['HomeTeam'] . "<br>";
   }
   /*
   echo $data[0]['GameKey'];
   echo $data[0]['Season'];
   echo $data[0]['Week'];
   echo $data[0]['DateTime'];
   echo $data[0]['AwayTeamID'];
   echo $data[0]['HomeTeamID'];
   */
?>