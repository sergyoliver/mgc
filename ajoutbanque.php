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
                    <a href="?page=listbanque">Liste des Banques</a>
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
                       Ajouter une Banque
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_POST['ok'])){
                            $logob = $_FILES['logob']['name'];
                            if(!empty($logob)) {
                                $tab2 = explode(".", $logob);
                                $ph12 = ajoutitret($tab2[0]);
                                $ph22 = $tab2[1];
                                $logo = $ph12 . "_" . pwd_aleatoire(4) . "." . $ph22;
                                $content_dir2 = 'img/plaque/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph2 = $_FILES['logob']['tmp_name'];
                                move_uploaded_file($tmp_ph2, 'img/plaque/'.$logo);
                            }else{
                                $logo='';
                            }

                                                        try {
         $nomtab10 = "banque";
         $tab10 = array('id_ajout' => $_SESSION['id'], 'logob' => $logo,'sigleb' => $_POST['sigleb'],'denomination' => $_POST['denomination'],'N_inscription' => $_POST['N_inscription'], 'adresseb' => $_POST['adresseb'], 'contactb' => $_POST['contactb'], 'respob' => $_POST['respob'],'capitalb' => $_POST['capitalb'],'actionnaire' => $_POST['actionnaire'],'datenb' => gmdate("Y-m-d H:i:s"));
         //var_dump($tab10);
         $sql = insert_tab($nomtab10, $tab10);
         $sql->execute($tab10);
         header("location:?page=listbanque");
                              
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                       
                               
                            }
                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                        
                       
                            <div class="row">                             
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Sigle</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="sigleb" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Dénomination</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="denomination" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                               
                            </div>
                          
                            <!-- ##################################### -->
                            
                            <!-- ##################################### -->

                             <div class="row">
                               

                                <div class="col-lg-6 input_field_sections">
                                    <h5>N inscription</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="N_inscription" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="adresseb" required>
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ##################################### -->
                             <div class="row">
                                

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Contact</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="contactb" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Responsable</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="respob" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                               
                            </div>
                            <!-- ##################################### -->
                          <div class="row">
                             <div class="col-lg-6 input_field_sections">
                                    <h5>Capital Social</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="capitalb" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                            </div>
                            <div class="col-lg-6 input_field_sections">
                                    <h5>Actionnaire et Parts</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="actionnaire" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                          </div>
                          <div class="row">
                             <div class="col-lg-4 input_field_sections">
                                    <h5>Logo Banque</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="logob" type="file"  class="file-loading" style="display: block">

                                        </div>
                                    </div>
                                </div>
                          </div>
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
