<link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css"/>
<!--End of plugin styles-->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/inputlimiter/css/jquery.inputlimiter.css"/>
<link type="text/css" rel="stylesheet" href="vendors/chosen/css/chosen.css"/>
<link type="text/css" rel="stylesheet" href="vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/jquery-tagsinput/css/jquery.tagsinput.css"/>
<link type="text/css" rel="stylesheet" href="vendors/daterangepicker/css/daterangepicker.css"/>
<link type="text/css" rel="stylesheet" href="vendors/datepicker/css/bootstrap-datepicker.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css"/>
<link type="text/css" rel="stylesheet" href="vendors/fileinput/css/fileinput.min.css"/>
<link type="text/css" rel="stylesheet" href="css/pages/form_elements.css"/>
<link type="text/css" rel="stylesheet" href="#" id="skin_change"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<script type="text/javascript" src="js/jquery.min.js">-->
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>


<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-pencil"></i>
               Formulaire d'ajout
            </h4>
        </div>
        <div class="col-sm-7 col-lg-6">
            <ol class="breadcrumb float-xs-right nav_breadcrumb_top_align">
                <li class="breadcrumb-item">
                    <a href="?page=milieu">
                        <i class="fa fa-home" data-pack="default" data-tags=""></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="?page=listfournisseursInd">Liste des Fournisseurs</a>
                </li>
                <li class="active breadcrumb-item">Ajouter nouveau Fournisseur</li>
            </ol>
        </div>
    </div>
</header>
<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-white">
                       Ajouter un nouveau Fournisseur
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_POST['ok'])){

                             //require('connexion/function.php');
                             require ('connexion/connectpg.php');
                            
                                    try {
         $nomtab10 = "tab_fournisseursindiv";
         $tab10 = array('id_ajout' => $_SESSION['id'], 'nom' => $_POST['nom'],  'situationgeoind' => $_POST['situationgeoind'],'phoneind' => $_POST['phoneind'], 'adresseEind' => $_POST['adresseEind'], 'adressPind' => $_POST['adressPind'], 'descind' => $_POST['descind'],'siteind' => $_POST['siteind'],'persressourceind' => $_POST['persressourceind'],'datenr' => gmdate("Y-m-d H:i:s"));
         //var_dump($tab10);
         $sql = insert_tab($nomtab10, $tab10);
         $sql->execute($tab10);
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                        header("location:?page=listfournisseursInd");
                                }
                               

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                        
                       
                            <div class="row">                             
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Nom Entreprise</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nom" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Situation géographique*</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="situationgeoind" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                               
                            </div>
                          
                            <!-- ##################################### -->
                            
                            <!-- ##################################### -->

                             <div class="row">
                               

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Telephone</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="phoneind" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse électronique </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="adresseEind" required>
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ##################################### -->
                             <div class="row">
                                

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Site Web</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="siteind" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse Postale</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="adressPind" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                               
                            </div>
                            <!-- ##################################### -->
                          <div class="row">
                             <div class="col-lg-6 input_field_sections">
                                    <h5>Personne à Contacter (Nom,Tél,Adresse électronique)</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="persressourceind" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                          </div>
                           <div class="row">

                            <div  class="col-lg-12 input_field_sections">
                                <h3>References</h3>
                                <div class="form-group">
                                    <textarea id="summernote"  name="descind" rows="10" cols="100"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>

                            <!-- ######################################-->
                            
                            <br>
                            <hr />
                            <div class="row">
                                <div class="col-lg-5 input_field_sections"></div>
                                <div class="col-lg-5 push-lg-2">
                                    <button class="btn btn-primary" type="submit" name="ok">
                                        <i class="fa fa-user"></i>
                                       Ajouter Fournisseur
                                    </button> &nbsp; &nbsp;
                                    <button class="btn btn-warning" type="reset" id="clear">
                                        <i class="fa fa-refresh"></i>
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
