<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Submit Booking</title>
  </head>
  <body>
    <?php 
$link = mysqli_connect("localhost", "root", "", "lcsdbooking");
if($link){
    $result = mysqli_query($link, "Select * from account where account.Areacode=".strval($_POST["areacode"])." and account.PhoneNumber=".strval($_POST["phone"])." and account.password=".strval($_POST["pwd"]));
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
    echo "<span>Username or password is incorrect. <span/>";
    echo "<a href=\"requestrecord.php\">Back</a>";
}else{
    $userid=$datas[0]["UserID"];
    echo "<img src=\"Icon.jpg\" height=150> <br/> <h3 style=\"display:inline\">Booking record of user: "; echo $userid; echo " (+"; echo $datas[0]["AreaCode"];
    echo $datas[0]["PhoneNumber"]; echo ") &#160 &#160 </h3>";
    echo "<a href=\"index.php\">Logout</a>";
echo "<br/> <br/> <h4>Past Booking Records</h4>";
if($link){
    $result = mysqli_query($link, "Select * from session inner join venue on session.VenueCode = Venue.VenueCode where ToTime < now() and session.userid = ".strval($userid));
    if ($result){
        if(mysqli_num_rows($result)>0){
            $datas = array();
            while($row = mysqli_fetch_assoc($result)){
                $datas[] = $row;
        }}else{ $datas = array() ; }
    }
    mysqli_free_result($result);
}

if(empty($datas)){
    echo "<p>You do not have any past bookings.</p>";
}else{
    echo "<p><ul>";
    foreach($datas as $row){
        echo "<li><p>Session No: "; echo $row["SessCode"] ; echo ",<br/>From: "; echo $row['FromTime']; echo ", To: ";
        echo $row['ToTime'] ;  echo ",</br>   Venue:  "; echo $row['Address'] ; echo "</p>";
        if($row['IsAttended']==1){ 
            echo "<p>Attended. </p>";
        }else{
            echo "<p>Absent</p>";}
        echo "</li>";
    }echo "</ul>";}

echo "<br/> <h4>Upcoming Booking Sessions</h4>";
if($link){
    $result = mysqli_query($link, "Select * from session inner join venue on session.VenueCode = Venue.VenueCode where ToTime >= now() and session.userid = ".strval($userid));
    if ($result){
        if(mysqli_num_rows($result)>0){
            $datas = array();
            while($row = mysqli_fetch_assoc($result)){
                $datas[] = $row;
        }}else{ $datas = array() ; }
    }
    mysqli_free_result($result);
}

if(empty($datas)){
    echo "<p>You do not have any upcoming booking sessions.</p>";
}else{
    echo "<ul>";
    foreach($datas as $row){
        echo "<li><p>Session No: "; echo $row["SessCode"] ; echo ",<br/>From: "; echo $row['FromTime']; echo ", To: ";
        echo $row['ToTime'] ;  echo ",</br>   Venue:  "; echo $row['Address'] ; echo "</p>";
        if($row['IsAttended']==1){ 
            echo "<p>Attended. </p>";
        }else{
            echo "<span>Not Attended &#160 &#160 </span>";
            echo "<a href=\"cancel.php?sesscode=";echo $row['SessCode']; echo "&userid="; echo $userid ; echo"\">Cancel This Booking</a><br/>";
        }
        echo "</li>";
    }echo "</ul>";}

echo "<br/> <h4>Sessions in Waitlist</h4>";
if($link){
    $result = mysqli_query($link, "Select * from (waitlist inner join session on session.sesscode = waitlist.session) inner join venue on session.venuecode = venue.venuecode where FromTime >= now() and waitlist.userid = ".strval($userid));
    if ($result){
        if(mysqli_num_rows($result)>0){
            $datas = array();
            while($row = mysqli_fetch_assoc($result)){
                $datas[] = $row;
        }}else{ $datas = array() ; }
    }
    mysqli_free_result($result);
}

if(empty($datas)){
    echo "<p>You did not join any valid waitlist.</p>";
}else{
    echo "<ul>";
    foreach($datas as $row){
        echo "<li><p>Waitlist No: "; echo $row["WLID"];echo ", Session No: "; echo $row["SessCode"] ; echo ",<br/>From: "; echo $row['FromTime']; echo ", To: ";
        echo $row['ToTime'] ;  echo ",</br>   Venue:  "; echo $row['Address'] ; echo "</p>";
        if($link){
            $result = mysqli_query($link, "Select count(*) as count from waitlist where waitlist.session=".strval($row["SessCode"])." and waitlist.WLID <= ".strval($row["WLID"]));
            if ($result){
                if(mysqli_num_rows($result)>0){
                    $datas2 = array();
                    while($row2 = mysqli_fetch_assoc($result)){
                        $datas2[] = $row2;
            }}}
            mysqli_free_result($result);
        }
        if(!empty($datas)){
            echo "<p style=\"display:inline\">Waitlist Position: "; echo $datas2[0]["count"] ; echo " &#160 &#160 </p>";}
        echo "<a href=\"cancel.php?sesscode=";echo $row['SessCode']; echo "&userid="; echo $userid ; echo"\">Cancel waitlisting</a><br/>";
        echo "</li>";
    }echo "</ul>";}
echo "</p>";

        
}    
        mysqli_close($link)
        ?>
    </form>
  </body>
</html>