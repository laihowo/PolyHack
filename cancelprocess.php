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
    $result = mysqli_query($link, "Select * from account where account.UserID=".strval($_GET["userid"])." and account.password=".strval($_POST["pwd"]));
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
    echo "<a href=\"requestrecord.php\">Back</a>";
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
        echo "Cancel failed, this session is not available.";
    }else{
        if($datas[0]["UserID"]==$userid){
            if($link){
                $result = mysqli_query($link, "Select  * from waitlist where waitlist.WLID=( SELECT MIN(WLID) FROM waitlist WHERE waitlist.Session=".strval($_GET["sesscode"]).")");
                if ($result){
                    if(mysqli_num_rows($result)>0){
                        $datas = array();
                        while($row = mysqli_fetch_assoc($result)){
                            $datas[] = $row;}
                }else{ $datas=array(); }
            } mysqli_free_result($result);
            }
            if (empty($datas)){
                if($link){
                    mysqli_query($link, "UPDATE session set UserID=0 where sesscode=".strval($_GET["sesscode"]));
                    echo "<span>You have successfully cancelled this session.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";}
            }else{
                if($link){
                    mysqli_query($link, "UPDATE session set UserID=".strval($datas[0]["UserID"])." where sesscode=".strval($_GET["sesscode"]));
                    mysqli_query($link, "DELETE FROM waitlist where WLID=".strval($datas[0]["WLID"]));
                    echo "<span>You have successfully cancelled this session.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";}
            }
        }else{
            if($link){
                $result = mysqli_query($link, "Select * from waitlist where waitlist.session=".strval($_GET["sesscode"])." and waitlist.UserID=".strval($_GET["sesscode"]));
                if ($result){
                    if(mysqli_num_rows($result)>0){
                        $datas = array();
                        while($row = mysqli_fetch_assoc($result)){
                            $datas[] = $row;}
                }else{ $datas=array(); }
            }} mysqli_free_result($result);
            
            if(empty($datas)){
                echo "<span>Failed: You have neither booked this session nor waitlisted this session.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";
            }else{
                mysqli_query($link, "DELETE FROM waitlist where WLID=".strval($datas[0]["WLID"]));
                echo "<span>You have successfully cancelled the waitlist of this session.&#160&#160&#160&#160</span> <a href=\"index.php\">Back</a>";
            } 
        }   
    }
}
        mysqli_close($link)
        ?>
    </form>
  </body>
</html>