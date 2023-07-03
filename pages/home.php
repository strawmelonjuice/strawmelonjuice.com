<!DOCTYPE html>
<html lang="en">
<?php
include_once(__DIR__ . "/../init.php");
echo(ReturnUniversalHeader("Home","base"));
?>
  <body class="body">
  <button class="openbtn" onclick="openNav()">☰</button>
    <div class="sidebar" id="mySidebar"><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <?php echo(ReturnMenuLinksFromJSON("side"));
      include(__DIR__. "/../assets/scripts/badgearea.php");
      ?>
    </div>
    <div class="content" id="pagecontent" align="center">

      <h1>Good <span id="wishes">day</span>!</h1>
      <?php
      $Parsedown = new Parsedown();
      echo $Parsedown->text(file_get_contents(__DIR__ . "/md/home.md"));
      echo($GLOBALS['bottomlink_morelinks_start'] . $GLOBALS['bottomlink_morelinks_end']);?>
    </div>
    <div class="bottombar" id="mybottombar">
      <?php echo(ReturnMenuLinksFromJSON("bottom"))?>
    </div>
  <script type="text/javascript">
    var today = new Date()
    var curHr = today.getHours()
    var wishes = null;

    if (curHr < 12) {
      var wishes = "Morning";
    } else if (curHr < 18) {
      var wishes = "Afternoon";
    } else {
      var wishes = "Evening";
    }

    document.getElementById("wishes").innerHTML = wishes;
  </script>
  <script src="/assets/scripts/index.js"></script>
<script src="https://cdn.jsdelivr.net/gh/strawmelonjuice/hl-img.js@main/hl-img.min.js"></script>
  <!-- <script type="javascript"><?php //echo(file_get_contents('http://raw.githubusercontent.com/adryd325/oneko.js/main/oneko.js'). "\n\r");?></script> -->
  <script src="/assets/scripts/oneko.js"></script>
  </body>
</html>
