<?php
require_once('classes/Provider.php');

session_start();
if(isset($_SESSION["playerID"]))
{
    if(!isset($_SESSION["username"]) || !isset($_SESSION["health"]) || !isset($_SESSION["attack"]) || !isset($_SESSION["defence"]) || !isset($_SESSION["gold"]) || !isset($_SESSION["energy"]) || !isset($_SESSION["levelID"]) || !isset($_SESSION["xp"]))
    {
        $sql = new Provider();
        $stats = $sql->getStats($_SESSION["playerID"]);

        $_SESSION["username"] = $stats['username'];
        $_SESSION["health"] = $stats['health'];
        $_SESSION["attack"] = $stats['attack'];
        $_SESSION["defence"] = $stats['defence'];
        $_SESSION["gold"] = $stats['gold'];
        $_SESSION["energy"] = $stats['energy'];
        $_SESSION["levelID"] = $stats['levelID'];
        $_SESSION["xp"] = $stats['xp'];
    }
    
    if($_SESSION['health'] < 1)
    {
        header("Location: hospital.php");
    }
}
else
{
    header("Location: index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Arena | Gladiators</title>

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
<div class="box" style="width:98,5%">
    
    <table>
        <tr>
            <th style="width:100%;text-align:left;font-size:20px;">Gladiator</th>
            <th style="width:10%;text-align:right;font-size:20px;">Level</th>
            <th style="width:10%;text-align:right;font-size:20px;">Strength</th>
            <th style="width:10%;font-size:20px;">Actions</th>
        </tr>
        
        <form action="battle.php" method="post">
        <input type="hidden" name="o_username" value=""/>
        <input type="hidden" name="o_attack" value=""/>
        <input type="hidden" name="o_defence" value=""/>
        <?php
        require_once('classes/Provider.php');

        $sql = new Provider();

        $opps = $sql->getOpponents($_SESSION['levelID'], $_SESSION['playerID']);

        foreach($opps as $gladiator)
        {
            $output = "<tr style=\"border-bottom:5px;\">";
            $output .= "<td style=\"\">".$gladiator->getUsername()."</td>";
            $output .= "<td style=\"text-align:right\">".$gladiator->getLevel()."</td>";
            $output .= "<td style=\"text-align:right\">???</td>";
            $output .= "<td>"
                    . "<input type=\"hidden\" name=\"o_id\" value=\"".$gladiator->getId()."\"/> "
                    . "<input type=\"hidden\" name=\"o_username\" value=\"".$gladiator->getUsername()."\"/> "
                    . "<input type=\"hidden\" name=\"o_health\" value=\"".$gladiator->getHealth()."\"/> "
                    . "<input type=\"hidden\" name=\"o_attack\" value=\"".$gladiator->getAttack()."\"/> "
                    . "<input type=\"hidden\" name=\"o_defence\" value=\"".$gladiator->getDefence()."\"/>"
                    . "<input type=\"hidden\" name=\"o_level\" value=\"".$gladiator->getLevel()."\"/>"
                    . "<input class=\"log-btn\" type=\"submit\" name=\"btnAttack\" value=\"ATTACK!\"/></td>";
            
            $output .= "</tr>";
            
            echo $output;
            $output = "";
        }
        ?>
        </form>
    </table>

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
</script>
</body>
</html>

<?php

?>