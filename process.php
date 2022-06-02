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
    echo "Username or password is incorrect. ";
    echo "<a href=\"booking.php?sesscode="; echo strval($_GET["sesscode"]); echo "\">Back</a>";
}else{
    $userid = $datas[0]["UserID"];
    if($link){
        $result = mysqli_query($link, "Select * from session where session.sesscode=".strval($_GET["sesscode"]));
        if ($result){
            if(mysqli_num_rows($result)>0){
                $datas = array();
                while($row = mysqli_fetch_assoc($result)){
                    $datas[] = $row;
        }}} mysqli_free_result($result);
    }
    if(empty($datas)){
        echo "Booking failed, this session is not available.";
    }else{
        if($datas[0]["UserID"]==0){
            if($datas[0]["UserID"]!=$userid){
                if($link){
                    mysqli_query($link, "UPDATE session set UserID=".strval($userid)." where sesscode=".strval($datas[0]["SessCode"]));
                    echo "<span>You have successfully booked this session.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";}
            }else{ echo "Booking failed: You have booked this session before.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";}
        }else{
            if($datas[0]["UserID"]!=$userid){
                if($link){
                    $result = mysqli_query($link, "Select * from waitlist where waitlist.session=".strval($datas[0]["SessCode"])." and waitlist.userID=".strval($userid));
                    if ($result){
                        if(mysqli_num_rows($result)>0){
                            $datas2 = array();
                            while($row = mysqli_fetch_assoc($result)){
                                $datas2[] = $row;
                    }}} mysqli_free_result($result);
                    if(empty($datas2)){
                        mysqli_query($link, "INSERT INTO waitlist (Session, UserID) VALUES (".strval($datas[0]["SessCode"]).", ".strval($userid).")");
                        echo "<span>You have successfully joined the waitlist of this session.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";
                    }else{echo "Failed to join the waitlist: You have joined the waitlist of this session before.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";}
                }
            }else{ echo "Failed to join the waitlist: You have booked this session before.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";}
        }

    }
}   

        mysqli_close($link)
        ?>
    </form>
  </body>
</html>