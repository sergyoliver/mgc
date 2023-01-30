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
                    <a href="?page=listfournisseurs">Liste des fournisseurs</a>
                </li>
                <li class="active breadcrumb-item">Ajouter nouveau fournisseur</li>
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
                       Ajouter un nouveau fournisseur
                    </div>
                    <div class="card-block">
                        <?php
                        if (isset($_POST['ok2'])){

                            $rs1 = $bdd->prepare('select * from fournisseurs');
                            $rs1->execute();
                            $nbre = $rs1->rowCount();
                            $numdoc = "DF-".numauto($nbre+1);


                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');
                              $typeprest2 =  implode(",",$_POST['typepr2']);
                            try {
                                $nomtab10 = "fournisseurs";
                                $tab10 = array('Num_dossier' => $numdoc,'type_prest' => $typeprest2,'typefournisseurs' => $_POST['actif'], 'nom_rep' => $_POST['nom'],  'situationgeo' => $_POST['situationgeoind'],'Telephone' => $_POST['phoneind'], 'Adresse_electronique' => $_POST['adresseEind'], 'Adresse_postale' => $_POST['adressPind'], 'description' => $_POST['descind'],'site' => $_POST['siteind'],'Peronne_ressource' => $_POST['persressourceind'],'datenr' => gmdate("Y-m-d H:i:s"),'id_ajout' => $_SESSION['id']);
                                var_dump($tab10);
                                $sql = insert_tab($nomtab10, $tab10);
                                $sql->execute($tab10);
                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                      header("location:?page=listfournisseurs");
                        }
                        if (isset($_POST['ok'])){

                            $rs21 = $bdd->prepare('select * from fournisseurs');
                            $rs21->execute();
                            $nbre2 = $rs21->rowCount();
                            $numdoc2 = "DF-".numauto($nbre2+1);


                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');
                              $typeprest =  implode(",",$_POST['typepr']);
                            try {
                                $nomtab102 = "fournisseurs";
                                $tab102 = array('typefournisseurs' => $_POST['actif'],'Name_entreprise' => $_POST['Name_entreprise'],'Forme_juridique' => $_POST['Forme_juridique'], 'Num_Registre_com' => $_POST['Num_Registre_com'],'NCC' => $_POST['NCC'], 'Regime_lmposition' => $_POST['Regime_lmposition'],'Num_dossier' => $numdoc2,'type_prest' => $typeprest, 'nom_rep' => $_POST['nom'],  'situationgeo' => $_POST['situationgeo'],'Telephone' => $_POST['Telephone'], 'Adresse_electronique' => $_POST['Adresse_electronique'], 'Adresse_postale' => $_POST['Adresse_postale'], 'description' => $_POST['description'],'site' => $_POST['site'],'Peronne_ressource' => $_POST['Peronne_ressource'],'datenr' => gmdate("Y-m-d H:i:s"),'id_ajout' => $_SESSION['id']);
                                var_dump($tab102);
                                $sql = insert_tab($nomtab102, $tab102);
                                $sql->execute($tab102);
                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                     header("location:?page=listfournisseurs");
                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-8 input_field_sections">
                                </div>
                                <div class="col-lg-4 input_field_sections" style="display: none">
                                         <div class="form-group row m-t-25">

                                    <div class="col-lg-6 text-xs-center text-lg-left">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new img-thumbnail text-xs-center">
                                                <img src="#" data-src="holder.js/100%x100%"  alt="not found"></div>
                                            <div class="fileinput-preview fileinput-exists img-thumbnail"></div>
                                            <div class="m-t-20 text-xs-center">
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Changer</span>
                                                                <input type="file" name="ph1"></span>
                                                <a href="#" class="btn btn-warning fileinput-exists"
                                                   data-dismiss="fileinput">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-6 input_field_sections">

                                    <div class="col-lg-7 push-lg-3">
                                        <label for="radio3" class="custom-control custom-radio signin_radio3">
                                            <input id="radio3" name="actif" type="radio" class="custom-control-input" value="Entreprise"   onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Entreprise</span>
                                        </label>
                                        <label for="radio4" class="custom-control custom-radio signin_radio4">
                                            <input id="radio4" name="actif" type="radio" class="custom-control-input" value="Consultant" onclick="affiche(this.value)" checked>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Consultant individuel</span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <div id="entreprise" style="display: none">
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Type de Prestation</h5>
                                        <div class="input-group">
                                            <select class="form-control chzn-select" multiple name="typepr[]" onchange="cache(this.value)">
                                                <option value="default"  hidden>Selectionner un type</option>
                                                <?php
                                                $i=1;
                                                $rsg = $bdd->prepare('select * from   type_prestation  ORDER by type_prest DESC ');
                                                $rsg->execute();
                                                while($rowg = $rsg->fetch()) {
                                                    ?>



                                                    <option value="<?php echo $rowg['id'] ?>"><?php echo $rowg['type_prest'] ?></option>

                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections" >
                                    <h5>Nom Entreprise</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Name_entreprise" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections" >
                                    <h5>Forme Juridique</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Forme_juridique" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################### -->
                            <div class="row">

                                <div class="col-lg-6 input_field_sections">
                                    <h5>N° Registre de Commerce</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Num_Registre_com" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Régime d'imposition</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Regime_lmposition" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ##################################### -->
                            <div class="row">


                                <div class="col-lg-6 input_field_sections">
                                    <h5>Situation géographique*</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="situationgeo" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>N° Compte Contribuable</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="NCC" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ##################################### -->

                            <div class="row">


                                <div class="col-lg-6 input_field_sections">
                                    <h5>Telephone</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Telephone" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse électronique </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Adresse_electronique" required>
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
                                        <input type="text" class="form-control" name="site" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse Postale</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Adresse_postale" value="<?php if(isset($rowg['Adresse_postale'])){ echo $rowg['Adresse_postale'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <!-- ##################################### -->
                            <div class="row">
                                <div class="col-lg-12 input_field_sections">
                                    <h5>Personne à Contacter (Nom,Tél,Adresse électronique)</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Peronne_ressource" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div  class="col-lg-12 input_field_sections">
                                    <h3>References</h3>
                                    <div class="form-group">
                                        <textarea  class="form-control"  name="description" rows="10" cols="50"></textarea>
                                    </div>
                                </div>
                            </div>
                                <br>
                                <hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" name="ok">
                                            <i class="fa fa-user"></i>
                                            Ajouter Entreprise
                                        </button>
                                        <button class="btn btn-warning" type="reset" id="clear">
                                            <i class="fa fa-refresh"></i>
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="individuel" >
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Type de Prestation</h5>
                                        <div class="input-group">
                                            <select class="form-control chzn-select" multiple name="typepr2[]" onchange="cache(this.value)">
                                                <option value="default"  hidden>Selectionner un type</option>
                                                <?php
                                                $i=1;
                                                $rsg = $bdd->prepare('select * from   type_prestation  ORDER by type_prest DESC ');
                                                $rsg->execute();
                                                while($rowg = $rsg->fetch()) {
                                                    ?>



                                                    <option value="<?php echo $rowg['id'] ?>"><?php echo $rowg['type_prest'] ?></option>

                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Nom et Prenoms</h5>
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
                                    <div class="col-lg-12 input_field_sections">
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
                                            <textarea class="form-control"  name="descind" rows="10" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" name="ok2">
                                            <i class="fa fa-user"></i>
                                            Ajouter individu
                                        </button>
                                        <button class="btn btn-warning" type="reset" id="clear">
                                            <i class="fa fa-refresh"></i>
                                            Annuler
                                        </button>
                                    </div>
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

        if (str == "Entreprise") {
            $('#entreprise').removeAttr('style');
            $('#individuel').css("display", "none");
        } else {
            $('#individuel').removeAttr('style');
            $('#entreprise').css("display", "none");
        }
    }
</script>
