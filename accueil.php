<?php
session_start();
//error_reporting(0);
ob_start();

if(isset($_SESSION['email']) && $_SESSION['gpe']=='admin' or isset($_SESSION['email']) && $_SESSION['gpe']=='SuperAdmin' or isset($_SESSION['email']) && $_SESSION['gpe']=='consul' )
{



require('connexion/function.php');
require ('connexion/connectpg.php');
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin | Ministère des Transports </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/loader.ico?d=<?php echo time() ?>"/>

    <!--global styles-->
    <link type="text/css" rel="stylesheet" href="css/components.css?d=<?php echo time() ?>"/>
    <link type="text/css" rel="stylesheet" href="css/custom.css?d=<?php echo time() ?>"/>
    <!-- plugin styles-->
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css?d=<?php echo time() ?>"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css?d=<?php echo time() ?>"/>
    <!-- end of global styles-->
    <link type="text/css" rel="stylesheet" href="vendors/c3/css/c3.min.css?d=<?php echo time() ?>"/>
    <link type="text/css" rel="stylesheet" href="vendors/toastr/css/toastr.min.css?d=<?php echo time() ?>"/>
    <link type="text/css" rel="stylesheet" href="vendors/switchery/css/switchery.min.css?d=<?php echo time() ?>" />
    <link type="text/css" rel="stylesheet" href="css/pages/new_dashboard.css?d=<?php echo time() ?>"/>

    <link type="text/css" rel="stylesheet" href="vendors/fileinput/css/fileinput.min.css?d=<?php echo time() ?>"/>
    <link type="text/css" rel="stylesheet" href="css/pages/form_elements.css?d=<?php echo time() ?>"/>


    <!--End of plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="css/pages/form_validations.css?d=<?php echo time() ?>" />
<!--     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->

</head>

<body class="fixedMenu_header">


<div class="bg-dark" id="wrap">
    <div id="top" class="fixed">
        <!-- .navbar -->
        <?php include 'menuh.php' ?>
        
        <!-- /.navbar -->
        <!-- /.head -->
    </div>
    <!-- /#top -->
    <div class="wrapper" >
           <?php  if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="SuperAdmin"  ) {
            include 'menudg.php';
           }?>
           <?php  if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="agent"  ) { 
            include 'menuAgent.php';
           }?>
           <?php  if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="respo"  ){
            include 'menuRespo.php';

           }?>
           <?php  if (isset($_SESSION['email']) && $_SESSION['gpe']&& $_SESSION['gpe']=="assistant"  ) {
            include 'menuAssis.php';

           }?>
     
        <!-- /#left -->
        <div id="content" class="bg-container">


            <?php
            if (isset($_GET["page"]) && $_GET["page"] != '') {


                $page = htmlspecialchars_decode($_GET["page"]);

                $fichier = $page . '.php';
                if (file_exists($fichier)) {
                    include($fichier);
                } else {
                    header("location:?page=milieu");
                }
            } else {
                header("location:?page=milieu");
            }
            ?>
            <br>       <br>       <br>       <br>       <br>       <br>

             <!-- # right side -->
                <?php //include 'index2.php' ?>
            <!-- /#content -->
            <footer class="footer" style="margin-left: 100px; margin-bottom: 0;text-align: center;">
                © 2021 DCP-Emploi - All Rights Reserved.
            </footer>
        </div>

    </div>
   

</div>
<!-- /#wrap -->


<script type="text/javascript" src="vendors/jquery-validation-engine/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="vendors/jquery-validation-engine/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="vendors/jquery-validation/js/jquery.validate.js"></script>
<script type="text/javascript" src="vendors/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="vendors/datetimepicker/js/DateTimePicker.min.js"></script>
<script type="text/javascript" src="vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="vendors/moment/js/moment.min.js"></script>
<!--End of plugin scripts-->
<!--plugin scripts-->
<script type="text/javascript" src="vendors/select2/js/select2.js"></script>
<script type="text/javascript" src="vendors/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/pluginjs/dataTables.tableTools.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.responsive.min.js"></script>
<!--<script type="text/javascript" src="vendors/datatables/js/dataTables.rowReorder.min.js"></script>-->
<script type="text/javascript" src="vendors/datatables/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript" src="vendors/datatables/js/dataTables.scroller.min.js"></script>
<!-- end of plugin scripts -->
<!--Page level scripts-->
<script type="text/javascript" src="js/pages/simple_datatables.js"></script>




<script type="text/javascript" src="vendors/jquery.uniform/js/jquery.uniform.js"></script>
<script type="text/javascript" src="vendors/inputlimiter/js/jquery.inputlimiter.js"></script>
<script type="text/javascript" src="vendors/chosen/js/chosen.jquery.js?d=<?php echo time() ?>"></script>
<script type="text/javascript" src="vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript" src="vendors/jquery-tagsinput/js/jquery.tagsinput.js"></script>
<script type="text/javascript" src="vendors/validval/js/jquery.validVal.min.js"></script>
<script type="text/javascript" src="vendors/moment/js/moment.min.js"></script>
<script type="text/javascript" src="vendors/daterangepicker/js/daterangepicker.js"></script>
<script type="text/javascript" src="vendors/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="vendors/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="vendors/autosize/js/jquery.autosize.min.js"></script>
<script type="text/javascript" src="vendors/inputmask/js/inputmask.js"></script>
<script type="text/javascript" src="vendors/inputmask/js/jquery.inputmask.js"></script>
<script type="text/javascript" src="vendors/inputmask/js/inputmask.date.extensions.js"></script>
<script type="text/javascript" src="vendors/inputmask/js/inputmask.extensions.js"></script>
<script type="text/javascript" src="vendors/fileinput/js/fileinput.min.js"></script>
<script type="text/javascript" src="vendors/fileinput/js/theme.js"></script>


<!--end of plugin scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_elements.js?d=<?php echo time() ?>"></script>
<script type="text/javascript" src="js/pages/datetime_piker.js?d=<?php echo time() ?>"></script>


<script type="text/javascript" src="vendors/holderjs/js/holder.js?d=<?php echo time() ?>"></script>


</body>

</html>
    <?php

}else {
    include 'logout.php';
    header('location:index.php');
}
ob_end_flush() ;

    ?>