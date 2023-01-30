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
                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                            $rsa = $bdd->prepare("select * from fournisseurs  WHERE id_fournisseurs= :zid");
                            //var_dump($id);
                            $rsa->execute(array("zid"=>$_GET['id']));
                            $rowa = $rsa->fetch();

                        }
                        if (isset($_POST['ok2'])){




                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                            // require ('connexion/connectpg.php');
                            $typeprest2 =  implode(",",$_POST['typepr2']);
                            try {
                                $rsql23 = $bdd->prepare('UPDATE  fournisseurs SET type_prest = :type_prest, typefournisseurs = :typefournisseurs,Name_entreprise = :Name_entreprise,nom_rep = :nom_rep,  situationgeo = :situationgeo, Telephone = :Telephone, Adresse_electronique = :Adresse_electronique,Adresse_postale = :Adresse_postale,description = :description,  site =:site,Peronne_ressource = :Peronne_ressource,datemodif = :datemodif,id_modif = :id_modif WHERE id_fournisseurs =:id');
                                $tab23 = $rsql23->execute( array('type_prest' => $typeprest2,'typefournisseurs' => $_POST['actif'],'Name_entreprise' => $_POST['Name_entreprise'],'nom_rep' => $_POST['nom'],  'situationgeo' => $_POST['situationgeoind'],'Telephone' => $_POST['phoneind'], 'Adresse_electronique' => $_POST['adresseEind'], 'Adresse_postale' => $_POST['adressPind'], 'description' => $_POST['descind'],'site' => $_POST['siteind'],'Peronne_ressource' => $_POST['persressourceind'],'datemodif' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' => $_GET['id']));


                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                            header("location:?page=listfournisseurs");
                        }
                        if (isset($_POST['ok'])){
                        try {
                            $typeprest =  implode(",",$_POST['typepr']);
                            $rsql2 = $bdd->prepare('UPDATE  fournisseurs SET typefournisseurs = :typefournisseurs,Name_entreprise = :Name_entreprise,Forme_juridique = :Forme_juridique, Num_Registre_com = :Num_Registre_com, NCC = :NCC,Regime_lmposition = :Regime_lmposition,type_prest = :type_prest,nom_rep = :nom_rep,situationgeo = :situationgeo, Telephone = :Telephone,Adresse_electronique = :Adresse_electronique,Adresse_postale = :Adresse_postale,description = :description,  site =:site,Peronne_ressource = :Peronne_ressource,datemodif = :datemodif,id_modif = :id_modif WHERE id_fournisseurs =:id');
                            $tab2 = $rsql2->execute( array('typefournisseurs' => $_POST['actif'],'Name_entreprise' => $_POST['Name_entreprise'],'Forme_juridique' => $_POST['Forme_juridique'], 'Num_Registre_com' => $_POST['Num_Registre_com'],'NCC' => $_POST['NCC'], 'Regime_lmposition' => $_POST['Regime_lmposition'],'type_prest' => $typeprest, 'nom_rep' => $_POST['nom'],  'situationgeo' => $_POST['situationgeo'],'Telephone' => $_POST['Telephone'], 'Adresse_electronique' => $_POST['Adresse_electronique'], 'Adresse_postale' => $_POST['Adresse_postale'], 'description' => $_POST['description'],'site' => $_POST['site'],'Peronne_ressource' => $_POST['Peronne_ressource'],'datemodif' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' => $_GET['id']));




                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                            header("location:?page=listfournisseurs");
                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-lg-6 input_field_sections">

                                    <div class="col-lg-7 push-lg-3">
                                        <label for="radio3" class="custom-control custom-radio signin_radio3">
                                            <input id="radio3" name="actif" type="radio" class="custom-control-input" value="Entreprise" <?php if ($rowa['typefournisseurs']=='Entreprise') { echo 'checked'; } ?>   onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Entreprise</span>
                                        </label>
                                        <label for="radio4" class="custom-control custom-radio signin_radio4">
                                            <input id="radio4" name="actif" type="radio" class="custom-control-input" value="Consultant" onclick="affiche(this.value)" <?php if ($rowa['typefournisseurs']=='Consultant') { echo 'checked'; } ?> >
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Consultant individuel</span>
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <div id="entreprise" <?php if ($rowa['typefournisseurs']=='Entreprise') { }else{ ?>  style="display: none" <?php } ?>>
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
                                                    <option value="<?php echo $rowg['id'] ?>" <?php
                                                    $tb2 = explode(',',$rowa['type_prest']);
                                                    foreach ($tb2 as $v){
                                                        if ($v==$rowg['id']){echo  'selected'; }
                                                    }
                                                    ?>><?php echo $rowg['type_prest'] ?></option>

                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections" >
                                        <h5>Nom Entreprise</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Name_entreprise" value="<?php if ($rowa['Name_entreprise']) { echo $rowa['Name_entreprise']; } ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections" >
                                        <h5>Forme Juridique</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Forme_juridique" value="<?php if ($rowa['Forme_juridique']) { echo $rowa['Forme_juridique']; } ?>" >
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
                                            <input type="text" class="form-control" name="Num_Registre_com" value="<?php if ($rowa['Num_Registre_com']) { echo $rowa['Num_Registre_com']; } ?>">
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Régime d'imposition</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Regime_lmposition" value="<?php if ($rowa['Regime_lmposition']) { echo $rowa['Regime_lmposition']; } ?>" >
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
                                            <input type="text" class="form-control" name="situationgeo" value="<?php if ($rowa['situationgeo']) { echo $rowa['situationgeo']; } ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>N° Compte Contribuable</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="NCC" value="<?php if ($rowa['NCC']) { echo $rowa['NCC']; } ?>"  >
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
                                            <input type="text" class="form-control" name="Telephone" value="<?php if ($rowa['Telephone']) { echo $rowa['Telephone']; } ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Adresse électronique </h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Adresse_electronique" required value="<?php if ($rowa['Adresse_electronique']) { echo $rowa['Adresse_electronique']; } ?>" >
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
                                            <input type="text" class="form-control" name="site" value="<?php if ($rowa['site']) { echo $rowa['site']; } ?>">
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Adresse Postale</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Adresse_postale" value="<?php if(isset($rowa['Adresse_postale'])){ echo $rowa['Adresse_postale'] ;}  ?>">
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
                                            <input type="text" class="form-control" name="Peronne_ressource" value="<?php if ($rowa['Peronne_ressource']) { echo $rowa['Peronne_ressource']; } ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div  class="col-lg-12 input_field_sections">
                                        <h3>References</h3>
                                        <div class="form-group">
                                            <textarea  class="form-control"  name="description" rows="10" cols="50"><?php if ($rowa['description']) { echo $rowa['description']; } ?></textarea>
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
                                            Modifier Entreprise
                                        </button>
                                        <button class="btn btn-warning" type="reset" id="clear">
                                            <i class="fa fa-refresh"></i>
                                            Annuler
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="individuel" <?php if ($rowg['typefournisseurs']=='Consultant') { }else{ ?>  style="display: none" <?php } ?> >
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
                                                    <option value="<?php echo $rowg['id'] ?>" <?php
                                                    $tb = explode(',',$rowa['type_prest']);
                                                    foreach ($tb as $val){
                                                        if ($val==$rowg['id']){echo  'selected'; }
                                                    }
                                                    ?>><?php echo $rowg['type_prest'] ?></option>

                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                      <div class="col-lg-6 input_field_sections" >
                                        <h5>Nom Entreprise</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Name_entreprise" value="<?php if ($rowa['Name_entreprise']) { echo $rowa['Name_entreprise']; } ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Nom et Prenoms</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nom" value="<?php echo $rowa['nom_rep'] ?>">
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Situation géographique*</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="situationgeoind"  value="<?php echo $rowa['situationgeo'] ?>" >
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
                                            <input type="text" class="form-control" name="phoneind"   value="<?php if (isset($rowa['situationgeo'] )){ echo $rowa['situationgeo'];  }?>">
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Adresse électronique </h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="adresseEind" required value="<?php if (isset($rowa['Adresse_electronique'] )){ echo $rowa['Adresse_electronique'];  }?>">
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
                                            <input type="text" class="form-control" name="siteind"  value="<?php if (isset($rowa['site'] )){ echo $rowa['site'];  }?>">
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Adresse Postale</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="adressPind"  value="<?php if (isset($rowa['Adresse_postale'] )){ echo $rowa['Adresse_postale'];  }?>">
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
                                            <input type="text" class="form-control" name="persressourceind"  value="<?php if (isset($rowa['Peronne_ressource'] )){ echo $rowa['Peronne_ressource'];  }?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div  class="col-lg-12 input_field_sections">
                                        <h3>References</h3>
                                        <div class="form-group">
                                            <textarea class="form-control"  name="descind" rows="10" cols="50"><?php if (isset($rowa['description'] )){ echo $rowa['description'];  }?></textarea>
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
                                            Modifier 
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
