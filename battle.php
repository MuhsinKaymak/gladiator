<?php
require_once('classes/Provider.php');

if(!isset($_POST['o_id']))
{
    header("Location: arena.php");
}

$sql = new Provider();

session_start();

if(!isset($_SESSION["playerID"]))
{
    header("Location: index.php");
}
else if($_SESSION['health'] < 1)
{
    header("Location: hospital.php");
}

$playerUsername = $_SESSION["username"];
$playerLevel = $_SESSION["levelID"];
$playerHP = $_SESSION["health"];
$playerAttack = $_SESSION["attack"];

$enemyUsername = $_POST['o_username'];
$enemyLevel = $_POST['o_level'];
$enemyHP = $_POST['o_health'];
$enemyAttack = $_POST['o_attack'];


$battleStr = "";
while($playerHP > 0 && $enemyHP >0)
{
    $battleStr .= $playerUsername." HP: ".$playerHP." - ".$enemyUsername." HP: ".$enemyHP."<br>";
    $turn = rand(0, 101);
    
    if($turn % 2)
    {
        $battleStr .= $playerUsername." attacks<br>";
        //players turn
        
        $hit = rand(0,100);
        if($hit > 25)
        {
            //hits
            $attackSTR = rand($playerAttack-2,$playerAttack+2);
            $enemyHP -= $attackSTR; 
            
            $battleStr .= "He Hits! $attackSTR in damage!<br>";
        }
        else
        {
            $battleStr .= "He missed!<br>";
        }
    }
    else
    {
        $battleStr .= $enemyUsername." attacks<br>";
        //enemy turn
        
        $hit = rand(0,100);
        if($hit > 25)
        {
            //hits
            $attackSTR = rand($enemyAttack-2,$enemyAttack+2);
            $playerHP -= $attackSTR; 
            
            $battleStr .= "He Hits! $attackSTR in damage!<br>";
        }
        else
        {
            $battleStr .= "He missed!<br>";
        }
    }
    $battleStr .="<br><br> ||";
}

$battleStr .= "Battle Ends! WINNER: ";

if($playerHP > $enemyHP)
{
    $battleStr .=$playerUsername;
    $sql->saveBattleResults($_SESSION['playerID'], $_POST['o_id'], $_POST['o_level']*20, $_POST['o_level']*50);
    
    $_SESSION['xp'] = $_SESSION['xp'] + ($_POST['o_level']*20);
    $_SESSION["gold"] = $_SESSION["gold"] + ($_POST['o_level']*50);
}
else if($playerHP < $enemyHP)
{
    $battleStr .=$enemyUsername;
    $sql->saveBattleResults($_POST['o_id'],$_SESSION['playerID'], $_SESSION['levelID']*20, $_SESSION['levelID']*50);
    $_SESSION['health'] = 0;
}
else 
{
    $battleStr .="NO ONE. It ended with a draw!";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Battle | Gladiators</title>

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
    <img alt="" src="graphics/banners/banner_arena.png"/>
</div>
<br>
<table style="width: 100%;">
    <tr >
        <td style="width:40%;font-size:60px;text-align:right;"><?php echo $playerUsername; ?></td>
        <td style="width:20%;font-size:20px;text-align: center;font-weight: bold">vs.</td>
        <td style="width:40%;font-size:60px;text-align:left;"><?php echo $enemyUsername; ?></td>
    </tr>
</table>
<br><br><br>

<div id="battlelog" style="font-weight:bold;font-size: 20px;text-align:center;width:100%">

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

    var battlelog = "<?php echo $battleStr; ?>";
    var logs = battlelog.split("||");

    var number = 0;
    var roundID = setInterval("CountdownTimer()",1000);

    var div = document.getElementById('battlelog');
    function CountdownTimer() 
    {
        if(number < logs.length) 
        {
            div.innerHTML = div.innerHTML + logs[number];
            window.scrollTo(0,document.body.scrollHeight);
            number++;
        }
        else
        {
            clearInterval(roundID);
        }
    }

</script>
</body>
</html>

<?php

?>