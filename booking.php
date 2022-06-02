<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Submit Booking</title>
  </head>
  <body>
    <img src="Icon.jpg"/ height=150>
    <h3>Submit Booking</h3>
    <p>Session ID: <?php echo $_GET['sesscode']; ?> </p>
    <form action="process.php?sesscode=<?php echo $_GET['sesscode']; ?>" method="post">
        <?php 
$link = mysqli_connect("localhost", "root", "", "lcsdbooking");
if($link){
    $result = mysqli_query($link, "Select * from session inner join venue on session.VenueCode = Venue.VenueCode where FromTime > now() and session.sesscode = ".strval($_GET["sesscode"]));
    if ($result){
        if(mysqli_num_rows($result)>0){
            $datas = array();
            while($row = mysqli_fetch_assoc($result)){
                $datas[] = $row;
            }
        }
    }
    mysqli_free_result($result);
}

if(empty($datas)){
    echo "This session is not available.";
}else{
    echo "<p>From: "; echo $datas[0]['FromTime']; echo ", To: ";
    echo $datas[0]['ToTime'] ;  echo "</br>   Venue:  "; echo $datas[0]['Address'] ; echo "</p>";
    if($datas[0]['UserID']==0){ 
        echo "<p>In Vacant. </p>";
    }else{
        if($link){
            $result = mysqli_query($link, "Select count(*) as count from waitlist where session=".strval($datas[0]['SessCode']));
            if ($result){
                if(mysqli_num_rows($result)>0){
                    $datas2 = 0;
                    while($row2 = mysqli_fetch_assoc($result)){
                        $datas2 = $row2;
                    }}}
            mysqli_free_result($result);}
        echo "<p>Booked by other users. (Waitlist length: "; echo $datas2['count']; echo ")  </p>";}

    echo "<br/><input type=\"text\" name=\"areacode\" value=\"852\" style=\"display:inline\" placeholder=\"Area Code\"/>" ;
    echo "<input type=\"text\" name=\"phone\" style=\"display:inline\" placeholder=\"Phone Number\"/>";
    echo "<br/> <p style=\"display:inline\">Password&#160&#160</p>  <input type=\"password\" name=\"pwd\"/>";
    //echo "<br/> <p style=\"display:inline\">Session ID </p>";
    //echo "<input type=\"text\" name=\"sesscode\"  value=\""; echo $_GET["sesscode"] ; echo "\"/>";
    echo "<br/><br/>";
    if($datas[0]['UserID']==0){ echo "<button type=\"submit\">Book</button>";
    }else{echo "<button type=\"submit\">Join Waitlist</button>";}
    echo "<span>&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";
    
    }
        mysqli_close($link)
        ?>
    </form>
  </body>
</html>