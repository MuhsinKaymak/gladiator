<table align="center">
<tr>
<th id="name" class="stats-cell"><?php echo (isset($_SESSION["username"]) ? $_SESSION["username"] : "_ERROR") ?></th>
<th class="stats-cell"></th>
<th style="width:5px;position:relative;top:-2px;"><img alt="" src="graphics/icons/ico_heart.png"></th>
<th id="stat" class="stats-cell"><?php echo (isset($_SESSION["health"]) ? $_SESSION["health"] : 0) ?></th>
<th style="width:5px;position:relative;top:-2px;"><img alt="" src="graphics/icons/ico_sword.png"></th>
<th id="stat" class="stats-cell"><?php echo (isset($_SESSION["attack"]) ? $_SESSION["attack"] : 0) ?></th>
<th style="width:5px;position:relative;top:-2px;"><img alt="" src="graphics/icons/ico_shield.png"></th>
<th id="stat" class="stats-cell"><?php echo (isset($_SESSION["defence"]) ? $_SESSION["defence"] : 0) ?></th>
<th style="width:5px;position:relative;top:-2px;"><img alt="" src="graphics/icons/ico_energy.png"></th>
<th id="stat" class="stats-cell"><?php echo (isset($_SESSION["energy"]) ? $_SESSION["energy"] : 0) ?></th>
<th style="width:5px;position:relative;top:-2px;"><img alt="" src="graphics/icons/ico_gold.png"></th>
<th id="stat" class="stats-cell"><?php echo (isset($_SESSION["gold"]) ? $_SESSION["gold"] : 0) ?></th>
</tr>
</table>