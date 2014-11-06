<?php 
require_once('classes/Provider.php');
$sql = new Provider();

session_start();

if(isset($_POST['btnRelease']))
{
    $_SESSION['health'] = $sql->refillHealth($_SESSION['playerID']);
    
    header("Location: profile.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Hospital | Gladiators</title>

<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

<div align="center">

<div id="title" class="title">
<a href="index.php"><img alt="Gladiators" src="graphics/title.png"/></a>
</div>

<div id="menu" class="menu">
<img src="graphics/marble_menu_side_l.png"/>
<div class="menu background">


<?php include('nav-menu.html'); ?>

</div>
<img src="graphics/marble_menu_side_r.png"/>
</div>

<div id="frame" align="left">

<div id="leftside" class="pillar left">

</div>

<div id="inner-frame">

<div class="chain-divider upper">
</div>

<div id="player-stats" class="player-stats">

<div id="stats">
<?php include('stats-display.php'); ?>
</div>
</div>

<div class="chain-divider lower"></div>

<div id="inner" class="inner">
<div style="height:50px"></div>

<div class="banner">
    <img alt="" src="graphics/banners/banner_hospital.png"/>
</div>
<br>

<div align="center" style="color:white;">

    <h1>You have been injured!</h1>
    <h2>Please wait:</h2>
    <div id="timer"><h4>You are free from hospital</h4></div>
    <br>
    <div id="releaseBtn" style="width:180px;display:none;">
    <form action="hospital.php" method="post">
        <input style="text-align:center;color:white;height:45px;" class="log-btn" type="submit" name="btnRelease" value="Release from hospital"/>
    </form>
    </div>
    
</div>

</div>

<div class="chain-divider lower"></div>

</div>

<div id="rightside" class="pillar right">

</div>
</div>

<div id="copyright" class="copyright">
copyright &copy 2014-2015
</div>

</div>

<script type="text/javascript">
    document.getElementById("btnProfile").onclick = function () {
        location.href = "profile.php";
    };
    document.getElementById("btnMarket").onclick = function () {
        location.href = "market.php";
    };
    document.getElementById("btnArena").onclick = function () {
        location.href = "arena.php";
    };
    document.getElementById("btnHospital").onclick = function () {
        location.href = "hospital.php";
    };
    
    <?php if($_SESSION['health'] < 1){ ?>
    var number = 100;
    number = <?php echo $sql->getSecondsToRelease($_SESSION['playerID']); ?>;
    var timerID = setInterval("CountdownTimer()",1000);

    var div = document.getElementById('timer');
    div.innerHTML = "--";
    function CountdownTimer() 
    {
        if(number > 0) 
        {
            var hours = 0;
            var mins = 0;
            
            if(number / 60 > 0)
            {
                mins = Math.floor(number / 60);
            }
            
            if(mins / 60 > 0)
            {
                hours = Math.floor(mins / 60);
            }
            
            var secs = number - ((hours > 0 ? hours * 60 : 0) + (mins > 0 ? mins * 60 : 0));
            
            var hourStr = ""+hours; 
            var minStr = ""+mins;
            var secStr = ""+secs;
            
            if(mins < 10)
            {
                minStr = "0"+mins;
            }
            if(hours < 10)
            {
                hourStr = "0"+hours;
            }
            if(secs < 10)
            {
                secStr = "0"+secs;
            }
            
            div.innerHTML = hourStr+":"+minStr+":"+secStr;
            number--;
        }
        else
        {
            div.innerHTML = number;
            document.getElementById("releaseBtn").style.display = 'block';
            clearInterval(timerID);
        }
    }
    <?php } ?>
</script>
</body>
</html>

<?php

?>