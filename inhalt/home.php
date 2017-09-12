<div style="width:605;height:685;position:relative;text-align:center;left:50%;margin-left:-303px;">
<br>



<!-- SUCHE Start -->
<script type="text/javascript">
function searchClick(){
	document.forms.search.action = document.forms.search.action + "&search=" + document.forms.search.search.value;
	if(season!="") document.forms.search.action = document.forms.search.action + "&season=" + season;
	return true;
}
</script>

<div style="text-align:center;">
<form name="search" action="?site=shop" method="post">
<input type="text" name="search" value="" size="50" maxlength="40">
<input type="submit" name="submitti" value="Suche" onclick="searchClick();">
</form>
</div>
<!-- SUCHE Ende -->

<!-- BILD -->
<img src="img/gruppe.jpg" alt="die-vier-lustigen-fuenf" />


<!-- ANGEBOTE Start -->
<a class="angebot" id="ang1" href="ban1.php<?php if($seasonid!=""&&go!="inhalt/logout.php"){echo "?season=$seasonid";}?>">
<span class="angebot">Assassin's Creed</span><br>
<img src="artikel/16.jpg" alt="Assassins Creed" align="left">
Reise im 12. Jahrhundert als Assassine Altaïr durch das Heilige Land und ermeuchel Herscher jener Zeit die Teil einer geheimen Verschwörung sind.<br><br>
<p class="angebot">25.95¹ €</p>
</a>

<a class="angebot" id="ang2" href="ban2.php<?php if($seasonid!=""&&go!="inhalt/logout.php"){echo "?season=$seasonid";}?>">
<span class="angebot">Wrath of the Lichking</span><br>
<img src="artikel/17.jpg" alt="Wrath of the Lich King" align="left">
Das 3. AddOn zum erfolgreichsten MMORPG aller Zeiten, World of Warcraft, mit Abenteuern in Nordrend.<br><br><br>
<p class="angebot">999.95¹ €</p>
</a>

<a class="angebot" id="ang3" href="ban3.php<?php if($seasonid!=""&&go!="inhalt/logout.php"){echo "?season=$seasonid";}?>">
<span class="angebot">Fritz &amp; Fertig 2</span><br>
<img src="artikel/13.jpg" alt="Fritz &amp; Fertig 2" align="left">
In dieser wunderschönen und einfachen Schachlernsoftware werden auch sie ein echter Kasparow.<br><br><br>
<p class="angebot" >69.85¹ €</p>
</a>


<a class="angebot" id="ang4" href="ban4.php<?php if($seasonid!=""&&go!="inhalt/logout.php"){echo "?season=$seasonid";}?>">
<span class="angebot">Call of Duty 4</span><br>
<img src="artikel/1.jpg" alt="Call of Duty 4" align="left">
Spielen Sie in einer nahen fiktiven Zukunft und verhindern Sie die finsteren Pläne von bösen Terroristen.<br><br><br>
<p class="angebot">33.34¹ €</p>
</a>

<!-- ANGEBOTE Ende -->


</div>
<div style="text-align:right;">¹ = ohne mwst.</div>
