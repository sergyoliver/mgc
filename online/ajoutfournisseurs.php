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
  <style>
    .msg{       
                                   
        display: none;
                                   
        }
 </style>
 <script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->
    <script type="text/javascript">

function affiche(str) {
    // console.log($('input[name=type]:checked').val());

    if (str == "entreprise") {
        $('#entreprise').removeAttr('style');
        $('#individuel').css("display", "none");
    } else {
        $('#individuel').removeAttr('style');
        $('#entreprise').css("display", "none");
    }
}

    </script>


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
                    <a href="?page=listfournisseurs">Liste des Fournisseurs</a>
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
         $nomtab10 = "fournisseurs";
         $tab10 = array('id_ajout' => $_SESSION['id'], 'Name_entreprise' => $_POST['Name_entreprise'], 'Forme_juridique' => $_POST['Forme_juridique'], 'Num_Registre_com' => $_POST['Num_Registre_com'],'NCC' => $_POST['NCC'], 'Regime_lmposition' => $_POST['Regime_lmposition'], 'Telephone' => $_POST['Telephone'],'Adresse_electronique' => $_POST['Adresse_electronique'], 'Adresse_postale' => $_POST['Adresse_postale'], 'situationgeo' => $_POST['situationgeo'], 'description' => $_POST['description'],'site' => $_POST['site'],'Peronne_ressource' => $_POST['Peronne_ressource'],'datenr' => gmdate("Y-m-d H:i:s"));
         //var_dump($tab10);
         $sql = insert_tab($nomtab10, $tab10);
         $sql->execute($tab10);
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                        header("location:?page=listfournisseurs");
                                }
                               

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                          
                        
                        <div class="row">
                            <center>                                             
                            <label  for="entreprise">
                               <input type="radio" name="choix" id="ind" value="entreprise" onclick="affiche(this.value)">
                              Entreprise
                            </label>                       
                              <label  for="individuel">
                            <input type="radio" name="choix" id="ind2" value="individuel" onclick="affiche(this.value)">
                              Individuel</label>
                           
                            </center>                           
                        </div>                           
                       
                        <div class="row">                             
                                <div   id="entreprise" style="display: none">
                                    <h5>Nom Entreprise</h5>
                                    
                                </div>
                                <div   id="individuel" style="display: none">
                                    <h5>Forme Juridique</h5>
                                    
                                </div>
                        </div>
                           
                            
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

