<?php
if (isset($_SESSION['email']) && $_SESSION['gpe']=='admin'  or isset($_SESSION['email']) &&  $_SESSION['gpe']=='SuperAdmin' ) {

    include "index2.php";

}

if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="assistant" ) {

    include "dashassistant.php";
}

if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="respo" ) {

    include "dashrespo.php";
}





?>
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
