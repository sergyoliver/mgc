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
                    <a href="?page=listsoumission">Liste des Postulants</a>
                </li>
                <li class="active breadcrumb-item">Postuler à un projet</li>
            </ol>
        </div>
    </div>
</header>
<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-success">
                       Soumissionner à un Projet
                    </div>
                    <div class="card-block">
                        <?php
                        
                        if (isset($_POST['ok'])){




                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');

                             $soumiss = formatinv_date($_POST['date_soumss']);

                            try {
                                $nomtab102 = "tab_depot";
                                $tab102 = array('id_projet' => $_POST['catprojet'],'idmarche' => $_POST['marche'],'id_fournisseurs' => $_POST['id_fournisseurs'],'nom_deposant' => $_POST['nomp'],'contact' => $_POST['tel'],'date_soumss' =>$soumiss  , 'datenr' => gmdate("Y-m-d H:i:s"),'id_ajout' => $_SESSION['id']);
                                //var_dump($tab102);
                                $sql = insert_tab($nomtab102, $tab102);
                                $sql->execute($tab102);
                           //
                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                      header("location:?page=listsoumission");
                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                            
                            <div class="row">
                                <div class="col-lg-12 input_field_sections">
                                    <h5>Projets</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="catprojet" onchange="check_marche(this.value)">
                                            <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                            $rscat = $bdd->prepare('select * from   type_projet  ORDER by Nom_Projet DESC ');
                                            $rscat->execute();
                                            while($rowcat = $rscat->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowcat['Id_typep'] ?>"><?php echo $rowcat['Nom_Projet'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Marché</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="marche" id="marche" >
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Fournisseurs</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="id_fournisseurs" >
                                            <option selected disabled>Selectionner un Fournisseur</option>
                                           <?php 
                                         $i=1;
                                            $rscag = $bdd->prepare('select * from   fournisseurs  ORDER by Name_entreprise DESC ');
                                            $rscag->execute();
                                            while($rowc = $rscag->fetch()) {
                                                ?>
                                            <option value="<?php echo $rowc['id_fournisseurs'];?>">    
                                        <?php  


                                        echo $rowc['Name_entreprise']; ?>      
                                            </option>

                                             <?php }  ?>

                                          ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 input_field_sections">
                                   
                                    <h5>Date soumission</h5>
                                     
                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="date_soumss" >
                                        
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">

                                    <h5>Nom et prénoms du déposant</h5>

                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                            </span>
                                        <input  type="text" class="form-control" placeholder="" id="nomp" name="nomp" >

                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">

                                    <h5>Contacts du déposant</h5>

                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-phone text-primary"></i>
                                            </span>
                                        <input  type="text" class="form-control" placeholder="" id="tel" name="tel" >

                                    </div>
                                </div>

                            </div>
                            
                            <!-- ################################### -->
                           
                            <!-- -->
                            <br>
                             <hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" name="ok">
                                            <i class="fa fa-user"></i>
                                            Soumettre
                                        </button>
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
<!--<script type="text/javascript" src="js/jquery.min.js">-->
    <script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>
<script>
    function affiche(str) {
        // console.log($('input[name=type]:checked').val());

        if (str == "Oui") {
            $('#Oui').removeAttr('style');
            $('#Non').css("display", "none");
        } else {
            $('#Non').removeAttr('style');
            $('#Oui').css("display", "none");
        }
    }
</script>
<script>
    function check_marche(str) {
        //il fait la mise a jour du prix de base et l'observation

        var xhr2;
        var form_data2 = new FormData();
        form_data2.append("idp", str);

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "rech_marche.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {

                document.getElementById("marche").innerHTML = this.responseText;
                $("#marche").trigger("chosen:updated");

            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }
    }
</script>