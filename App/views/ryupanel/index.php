<!DOCTYPE html>
<html>
<title><?=CONFIG['web']['app_name'];?> - <?=CONFIG['web']['app_version'];?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 120px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
</style>
<body class="w3-black">

<!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <!-- Avatar image in top left corner -->
  <img src="assets/img/ryu-logo.png" style="width:100%">
  <a href="?c=ryupanel" class="w3-bar-item w3-button w3-padding-large w3-black">
    <i class="fa fa-home w3-xxlarge"></i>
    <p>HOME</p>
  </a>
  <a href="#ryu_config" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-cog w3-xxlarge"></i>
    <p>CONFIG</p>
  </a>
  <a href="#logs" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-signal w3-xxlarge"></i>
    <p>LOGS</p>
  </a>

  <a href="?c=ryupanel&a=logout" class="w3-bar-item w3-button w3-padding-large w3-hover-black">
    <i class="fa fa-sign-out w3-xxlarge"></i>
    <p>LOGOUT</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="?c=ryupanel" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
    <a href="#ryu_config" class="w3-bar-item w3-button" style="width:25% !important">CONFIG</a>
    <a href="#logs" class="w3-bar-item w3-button" style="width:25% !important">LOGS</a>
    <a href="?c=ryupanel&a=logout" class="w3-bar-item w3-button" style="width:25% !important">LOGOUT</a>
  </div>
</div>

<!-- Page Content -->
<div class="w3-padding-large" id="main">
<div class="w3-green w3-padding">Welcome, <?=@$_SESSION['validate_api']['username'];?> ! <?=@$_SESSION['validate_api']['msg'];?></div>
  <!-- Header/Home -->
    <?php require 'statistic.php'; ?>

  <!-- About Section -->
    <?php require 'config.php'; ?>
  
  <!-- Portfolio Section -->
  <div class="w3-padding-64 w3-content" id="logs">
    <h2 class="w3-text-light-grey">Logs</h2>
    <hr style="width:200px" class="w3-opacity">
    <table class="w3-table-all w3-hoverable w3-text-black">
      <thead>
        <th>No.</th>
        <th>LOGS</th>
        <th>TOTAL</th>
        <th>ACTION</th>
      </thead>
      <tbody>
        <?php
        $ldir = PUBLIC_PATH.'logs/';
        $ss = scandir($ldir);
        $n=1;
        foreach($ss as $s)
        {
          $ext= pathinfo($ldir.$s,PATHINFO_EXTENSION);
          $fname= pathinfo($ldir.$s,PATHINFO_FILENAME);
          if($ext != 'log')continue;
          
          echo '<tr>';
          echo '<td>'.$n++.'</td>';
          echo '<td>'.strtoupper($s).'</td>';
          echo '<td>'.count_stats($fname).'</td>';
          echo '<td><a href="./logs/'.$s.'" target="_blank" class="w3-btn w3-grey">Detail</a> </td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>

  </div>

  
  </div>
  
    <!-- Footer -->
  <footer class="w3-content w3-padding-64 w3-text-grey w3-xlarge">

    <p class="w3-medium">copyright &copy; <?=CONFIG['web']['app_name'];?> ( <?=CONFIG['web']['app_version'];?> ) </p>
  <!-- End footer -->
  </footer>

<!-- END PAGE CONTENT -->
</div>

</body>
</html>
