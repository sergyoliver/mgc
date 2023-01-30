<?php
session_start();
ob_start();
if(isset($_SESSION['email']))
{
    header('location:accueil.php?page=milieu');
}else{


    ?>
<!DOCTYPE html>
<html>
<head>
    <title>MGC - DISTRICT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="img/loader.ico"/>
    <!-- Global styles -->
    <link type="text/css" rel="stylesheet" href="css/components.css?v=<?php echo time(); ?>"/>
    <link type="text/css" rel="stylesheet" href="css/custom.css?v=<?php echo time(); ?>"/>
    <!--End of Global styles -->
    <link type="text/css" rel="stylesheet" href="vendors/inputlimiter/css/jquery.inputlimiter.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/chosen/css/chosen.css"/>
    <!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="vendors/datepicker/css/bootstrap-datepicker.min.css">
    <link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css"/>
    <link type="text/css" rel="stylesheet" href="vendors/wow/css/animate.css"/>
    <!--End of Plugin styles-->
    <link type="text/css" rel="stylesheet" href="vendors/radio_css/css/radiobox.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/checkbox_css/css/checkbox.min.css" />
    <!--End of Plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="css/pages/radio_checkbox.css" />
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="css/pages/login.css?v=<?php echo time(); ?>"/>
    <link type="text/css" rel="stylesheet" href="css/pages/form_elements.css"/>
    <!--End of Page level styles-->
</head>

<body class="fixedMenu_header no_left" >

<div  id="wrap">

    <!-- /#top -->
    <div class="wrapper">
        <div id="content" class="bg-container2">
            <header class="head" style="background-position:top; background-repeat: repeat-x; background-color: #f0ad37; background-image: url(img/kit/haut2.jpg?v=<?php echo time()?>)">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <img src="img/armoirie.png" alt="" height="60" style="margin-top: -10px">
                    </div>
                    <div class="col-lg-6 col-md-8 col-sm-8" >
                        <ol class="breadcrumb float-xs-right ">
                            <li class="breadcrumb-item active"><h4>MGC-DISTRICT </h4></li>
                        </ol>
                    </div>
                </div>
            </header>
            <div class="row" >
                <div class="container wow fadeInDown" data-wow-delay="0.5s" data-wow-duration="2s">
                    <div class="row">
                        <div class="col-lg-8 push-lg-2 col-md-10 push-md-1 col-sm-10 push-sm-1 " style="margin-top: 60px">
                            <div class="row">

                                <div class="col-lg-8 push-lg-2 col-md-10 push-md-1 col-sm-12">
                                    <?php
                                    if(isset($_POST['ok'])){

                                        require ('connexion/connectpg.php');
                                        require('connexion/function.php');

                                        // cette page gere la verification pr la connexion :)
                                        require('auth.php');




                                    }else{
                                        // echo "rien";
                                        //echo  $_SERVER['REQUEST_METHOD'];

                                    }

                                    ?>
                                    <div class="login_logo login_border_radius1" style="text-align: center">
                                        <img src="img/logoreduit.png?v=<?php echo time()?>"  style="align-content: center; margin-top: 3px">

                                        <p style="margin-bottom:3px;text-align: center; color: #000; font-size: 17px; font-weight: bold"> BIENVENUE SUR  <span style="font-size: 20px"> VOTRE ESPACE</span> </p>
                                    </div>
                                    <div class="login_content login_border_radius " style="border:solid 1px darkblue">
                                        <form action="" id="login_validator" method="post" class="login_validator">
                                            <div class="form-group">
                                                <label for="email" class="form-control-label"> Login</label>
                                                <div class="input-group">
                                    <span class="input-group-addon input_email"><i
                                                class="fa fa-envelope text-primary"></i></span>
                                                    <input type="text" class="form-control  form-control-md" id="login" name="login" required placeholder="E-mail">
                                                </div>
                                            </div>
                                            <!--</h3>-->
                                            <div class="form-group">
                                                <label for="password" class="form-control-label">Mot de passe</label>
                                                <div class="input-group">
                                    <span class="input-group-addon addon_password"><i
                                                class="fa fa-lock text-primary"></i></span>
                                                    <input type="password" class="form-control form-control-md" id="pwd" required  name="pwd" placeholder="***********">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="submit" value="Se connecter" class="btn btn-primary btn-block login_button" name="ok">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <br>
                                    <div class="row" style="text-align: center; font-size: small; color: #3f6718;"> <div class="form-group">MGC-DISTRIT @2023 - Tous droits réservés   </div></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>



        <!-- /#content -->
    </div>

    <!-- # right side -->
<!--    <header class="head" style="background-color: #eaeaea; background-image: url(img/kit/bas.png); background-repeat:repeat-x;background-position: bottom; height: 80px">-->
<!---->
<!--    </header>-->

</div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/tether.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- end of global js-->
    <!--Plugin js-->
    <script type="text/javascript" src="vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>

<script>
    $('#login_validator').bootstrapValidator({
        fields: {
            login: {
                validators: {
                    notEmpty: {
                        message: 'Login obligatoires'
                    }
                }
            },
            pwd: {
                validators: {
                    notEmpty: {
                        message: 'Mot de passe obligatoire'
                    }

                }
            }

        }

    });
    function affiche(str) {
        //console.log($('input[name=proj]:checked').val());

        if ($('input[name=proj]:checked').val() =="1"){
            $('.cache').removeAttr('style');
        }else{

            $('.cache').css("display", "none");
        }
    }

</script>
<!-- end of page level js -->
</body>
</html>
<?php  }
ob_end_flush() ;
?>