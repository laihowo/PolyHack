<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cancel Booking</title>
  </head>
  <body>
    <img src="Icon.jpg" height=150/>
    <h3>Cancel Booking</h3>
    <p>Session ID: <?php echo $_GET['sesscode']; ?> </p>
    <form action="cancelprocess.php?sesscode=<?php echo $_GET['sesscode']; ?>&userid=<?php echo $_GET['userid']; ?>" method="post">
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
    echo "This session is not available or the deadline of cancelling this session has passed.";
}else{
    echo "<p>From: "; echo $datas[0]['FromTime']; echo ", To: ";
    echo $datas[0]['ToTime'] ;  echo "</br>   Venue:  "; echo $datas[0]['Address'] ; echo "</p>";
    if($datas[0]['UserID']==0){ 
        echo "<p>This Session is in vacant.</p>";
    }else{
        echo "<br/><input type=\"text\" name=\"areacode\" value=\"";echo $_GET["areacode"];echo "\" style=\"display:inline\" placeholder=\"Area Code\" disabled/>" ;
        echo "<input type=\"text\" name=\"phone\" value=\"";echo $_GET["phone"];echo "\" style=\"display:inline\" placeholder=\"Phone Number\" disabled/>";
        echo "<br/> <p style=\"display:inline\">Password&#160&#160</p>  <input type=\"password\" name=\"pwd\"/>";
        echo "<br/><br/>";
        if($datas[0]['UserID']==$_GET["userid"]){ echo "<button type=\"submit\">Cancel Booking.</button>";
        }else{echo "<button type=\"submit\">Cancel Waitlisting</button>";}
        echo "<span>&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";
    }


    
    }
        mysqli_close($link)
        ?>
    </form>
  </body>
</html>