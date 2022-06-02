<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Session Status</title>
  </head>
  <body>
    <img src="Icon.jpg"/ height=100>
    <h3>Session Status</h3>
    <form>
        <?php 
$link = mysqli_connect("localhost", "root", "", "lcsdbooking");
if($link){
    $result = mysqli_query($link, "Select * from session inner join venue on session.VenueCode = Venue.VenueCode where FromTime > now()");
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
    echo "no available sessions";
}?>
        <?php if (!empty($datas)):?>
        <ul>
            <?php foreach($datas as $key => $row):?>
            <li>
                <p>Session No: <?php echo $row['SessCode'] ?>, <br/>From:   <?php echo $row['FromTime'] ?>,  To:   
                <?php echo $row['ToTime'] ?>,  </br>   Venue:  <?php echo $row['Address'] ?></p>
                <?php if($row['UserID']==0){ 
                    echo "<p style=\"display:inline\">In Vacant. </p>";echo "<a href=\"booking.php?sesscode=";
                    echo $row['SessCode'];echo"\">Book This </a>";
                }else{
                    if($link){
                        $result = mysqli_query($link, "Select count(*) as count from waitlist where session=".strval($row['SessCode']));
                        if ($result){
                            if(mysqli_num_rows($result)>0){
                                $datas2 = 0;
                                while($row2 = mysqli_fetch_assoc($result)){
                                    $datas2 = $row2;
                                }}}
                        mysqli_free_result($result);}
                    echo "<p style=\"display:inline\">Booked by other users. (Waitlist length: "; echo $datas2['count']; echo ")  </p>";
                    echo "<a href=\"booking.php?sesscode=";echo $row['SessCode'];echo"\">Join waitlist </a>";}?>

            </li>
            <?php endforeach;mysqli_close($link);?>
            <?php endif;?>
        </ul>
    </form>
  </body>
</html>