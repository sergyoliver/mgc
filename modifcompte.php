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
               Formulaire de Mise à jour
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
                    <a href="?page=listecompte">Liste des comptes</a>
                </li>
                <li class="active breadcrumb-item">Modifier un compte</li>
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
                      Modifier compte
                    </div>
                    <div class="card-block">
                        <?php
                        if(isset($_GET['id'])){


                        try{
                            $id = $_GET['id'];
                            $rsa = $bdd->prepare('select * from users where  idqag = :j2');
                            $rsa->execute(array("j2" => $id));
                            $rowa = $rsa->fetch();

                            } catch (Exception $e) {
                                echo 'Erreur : ' . $e->getMessage() . '<br />';
                                echo 'N� : ' . $e->getCode();
                            }
                        }
                        if (isset($_POST['ok'])){



                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
//                            require ('connexion/connectpg.php');
                                try {
                                    //                            $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , datecon, statconn) VALUES(:ipadress, :log, :datc, :statc)');
                                    //                            $rs3->execute(array('ipadress' => get_ip(), 'log' => $log ,'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));

                                    $dat = date("Y-m-d H:i:s");
                                    $rsql1 = $bdd->prepare('UPDATE  users SET  nomag = :nomag,  prenom = :prenom, emailag = :emailag, 
                            telag = :telag,  pass = :pass, gpe = :gpe,  user_status = :user_status,    datemodify = :datemodify,   author_modify = :author_modify
                               WHERE idqag = :iduser ');
                                  //  print_r($rsql1);
                                    $tab = $rsql1->execute(array('nomag' => $_POST['nom'], 'prenom' => $_POST['pnom'], 'emailag' => $_POST['mail'], 'telag' => $_POST['tel'], 'pass' => $_POST['pwd'], 'gpe' => $_POST['typec'], 'user_status' => $_POST['actif'],   'datemodify' => $dat, 'author_modify' =>$_SESSION['id'], 'iduser' =>$id ));


                                } catch (Exception $e) {

                                    echo 'Erreur : ' . $e->getMessage() . '<br />';

                                    echo 'N° : ' . $e->getCode();

                                }


                       header("location:?page=listecompte");
                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Nom</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nom" required  value="<?php if(isset($rowa['nomag'])){ echo $rowa['nomag'];}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-8 input_field_sections">
                                    <h5>Prénoms</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pnom"  value="<?php if(isset($rowa['prenom'])){ echo $rowa['prenom'];}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Contact</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="tel" value="<?php if(isset($rowa['telag'])){ echo $rowa['telag'];}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-phone text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Email</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mail" value="<?php if(isset($rowa['emailag'])){ echo $rowa['emailag'];}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-envelope text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Mot de passe</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pwd" value="<?php if(isset($rowa['pass'])){ echo $rowa['pass'];}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de compte</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typec" >
                                            <option selected disabled>Selectionner un compte</option>
                                            <?php
                                            $i=1;
                                            $rsg = $bdd->prepare('select * from table_gpe_users  ORDER by descn DESC ');
                                            $rsg->execute();
                                            while($rowg = $rsg->fetch()) {
                                            ?>
                                                <option value="<?php echo $rowg['idgpe'] ?>" <?php if(isset($rowa['gpe']) && $rowa['gpe']==$rowg['idgpe']){ echo "selected";} ?>><?php echo $rowg['descn'] ?></option>

                                            <?php }  ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                    <h5 style="text-align: center">Statut compte</h5>
                                    <div class="col-lg-7 push-lg-3">
                                        <label for="radio3" class="custom-control custom-radio signin_radio3">
                                            <input id="radio3" name="actif" type="radio" class="custom-control-input" value="1" <?php if($rowa['user_status']==1){ echo "checked";} ?>  >
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Activé</span>
                                        </label>
                                        <label for="radio4" class="custom-control custom-radio signin_radio4">
                                            <input id="radio4" name="actif" type="radio" class="custom-control-input" value="0" <?php if($rowa['user_status']==0){ echo "checked";} ?>>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Désactivé</span>
                                        </label>
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
                                      Modifier Utilisateur
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
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>