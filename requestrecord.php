<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>View / Manage your booking</title>
  </head>
  <body>
    <img src="Icon.jpg" height=150/>
    <h3>View / Manage your booking</h3>
    <form action="showrecord.php" method="post">
        <input type="text" name="areacode" style="display:inline" placeholder="Area Code" value="852"/>
        <input type="text" name="phone" style="display:inline" placeholder="Phone Number"/>
        <br/> <p style="display:inline">Password&#160&#160</p>
        <input type="password"  name="pwd"/> <br/><br/>
        <button type="submit">View Booking</button>
        <span>&#160&#160&#160&#160</span> <a href="index.php">Back</a>

    </form>
  </body>
</html>