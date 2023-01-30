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
                    <a href="?page=listsoumission">Liste des soumissions</a>
                </li>
                <li class="active breadcrumb-item">Soumissioner à un projet</li>
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

                            $rs21 = $bdd->prepare('select * from tab_depot');
                            $rs21->execute();
                            $nbre2 = $rs21->rowCount();
                           $numg = "PR-".numauto($nbre2+1);


                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');
                            $emetteur =  implode(",",$_POST['typepr']);
                             $soumiss = formatinv_date($_POST['date_soumss']);
                             $previs = formatinv_date($_POST['date_previs_G']);
                             $reel = formatinv_date($_POST['date_reel_G']);
                             $prisef = formatinv_date($_POST['date_prise_effet_G']);
                             $expg = formatinv_date($_POST['date_exp_G']);
                             $libg = formatinv_date($_POST['dat_lib_G']);
                            try {
                                $nomtab102 = "tab_depot";
                                $tab102 = array('id_projet' => $_POST['catprojet'],'id_fournisseurs' => $_POST['id_fournisseurs'],'garantie' => $_POST['actif'],'typegarantie' => $_POST['typegarantie'],'date_soumss' =>$soumiss ,'date_previs_G' => $previs,'date_reel_G' => $reel, 'date_prise_effet_G' => $prisef,'id_bank' => $emetteur,  'mtn_G' => $_POST['mtn_G'],'num_G' => $_POST['num_G'],'numg' => $numg,'date_exp_G' =>$expg , 'dat_lib_G'=>$libg , 'datenrg' => gmdate("Y-m-d H:i:s"),'id_ajout' => $_SESSION['id']);
                                var_dump($tab102);
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
                                    <div class="col-lg-4 input_field_sections">
                                    <h5>Catégorie de projets</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="catprojet" >
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
                                <div class="col-lg-6 input_field_sections">
                                   
                                    <h5>Date soumission</h5>
                                     
                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="date_soumss" >
                                        
                                    </div>
                                </div>
                                 
                            </div>
                            
                            <!-- ################################### -->
                           
                            <!-- -->
                            <div class="row">

                                <div class="col-lg-6 input_field_sections">
                                    <div class="col-lg-7 push-lg-3">
                                        <label>
                                            Garantie
                                        </label>
                                        <label for="radio3" class="custom-control custom-radio signin_radio3">
                                            <input id="radio3" name="actif" type="radio" class="custom-control-input" value="Oui"   onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Oui</span>
                                        </label>
                                        <label for="radio4" class="custom-control custom-radio signin_radio4">
                                            <input id="radio4" name="actif" type="radio" class="custom-control-input" value="Non" onclick="affiche(this.value)" checked>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Non</span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <div id="Oui" style="display: none">
                                 
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Type d'Emetteur</h5>
                                        <div class="input-group">
                                            <select class="form-control chzn-select" multiple name="typepr[]" onchange="cache(this.value)">
                                                <option value="default"  hidden>Selectionner un Emetteur</option>
                                                <?php
                                                $i=1;
                                                $rsg = $bdd->prepare('select * from   banque ORDER by sigleb DESC ');
                                                $rsg->execute();
                                                while($rowg = $rsg->fetch()) {
                                                    ?>



                                            <option value="<?php echo $rowg['id_bank'] ?>"><?php echo $rowg['sigleb'] ?>
                                                
                                            </option>

                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-lg-6 input_field_sections">
                                        <h5>Type Garantie</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="typegarantie" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                            <div class="col-lg-6 input_field_sections">
                                    <h5>Date réelle de transmission</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp6" name="date_reel_G" >
                                        
                                    </div>
                                </div> 
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Date Prévisionnelle</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp4" name="date_previs_G" >
                                        
                                    </div>
                                </div>   
                            </div>
                                <!-- ##################################### -->

                                <!-- ##################################### -->

                                <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                   
                                    <h5>Date prise d'effet de la garantie</h5>
                                     
                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp2" name="date_prise_effet_G" >
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date d'expiration de la garantie</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="date_exp_G" >
                                        
                                    </div>
                                </div>  
                            </div>
                                <!-- ##################################### -->
                                <div class="row">


                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Montant garantie</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mtn_G" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Numéro de la garantie</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="num_G" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>

                                </div>
                                <!-- ##################################### -->
                                 <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date de libération de la garantie</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp5" name="dat_lib_G" >
                                        
                                    </div>
                                </div>  
                            </div>
                           
                               
                                <br>
                               
                            </div>
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
