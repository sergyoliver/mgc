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

    <!--<script type="text/javascript" src="js/jquery.min.js">-->
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>

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
                    <div class="card-header bg-primary">
                       Modifier Les Donnees de la Banque
                    </div>
                    <div class="card-block">
                        <?php
                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                         $rsg = $bdd->prepare("select * from banque  WHERE id_bank= :zid");
                         
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                        if(!empty($logob)) {
                        $tab2 = explode(".", $logob);
                        $ph12 = ajoutitret($tab2[0]);
                        $ph22 = $tab2[1];
                        $logo = $ph12 . "_" . pwd_aleatoire(4) . "." . $ph22;
                        $content_dir2 = 'img/plaque/'; // dossier o� sera d�plac� le fichier
                        $tmp_ph2 = $_FILES['logob']['tmp_name'];
                        move_uploaded_file($tmp_ph2, 'img/plaque/'.$logo);
    }else{
        if (empty($rowg['logob'])){
            $logo='';
        }else{
            $logob=$rowg['logob'];
        }

    }

                        if (isset($_POST['ok'])){
     /*##############################################*/
   /*######################################*/
                           
    
   
   
    try {

                            $rsql1 = $bdd->prepare('UPDATE  banque SET logob= :logo, sigleb = :sigleb,denomination = :denomination, N_inscription = :N_inscription,adresseb = :adresseb,contactb = :contactb,  respob =:respob,capitalb = :capitalb,actionnaire = :actionnaire,datenb = :datenb,id_modif = :id_modif WHERE id_bank =:id');
                            $tab = $rsql1->execute(array('logob' => $logo,'sigleb' => $_POST['sigleb'],'denomination' => $_POST['denomination'],'N_inscription' => $_POST['N_inscription'], 'adresseb' => $_POST['adresseb'], 'contactb' => $_POST['contactb'], 'respob' => $_POST['respob'],'capitalb' => $_POST['capitalb'],'actionnaire' => $_POST['actionnaire'],'datenb' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' =>$id));

    } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listbanque");
/*}else{

    echo ' <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">× </button><strong> Accès erroné : </strong>
       Numéro de la plaque numérologique doit etre uniques ! </div>';
}
                                } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }*/



}
                        ?>
                      <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                        
                       
                            <div class="row">                             
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Sigle</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="sigleb" value="<?php if(isset($rowg['sigleb'])){ echo $rowg['sigleb'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Dénomination</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="denomination" value="<?php if(isset($rowg['denomination'])){ echo $rowg['denomination'] ;}  ?>">
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
                                        <input type="text" class="form-control" name="N_inscription" value="<?php if(isset($rowg['N_inscription'])){ echo $rowg['N_inscription'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="adresseb" value="<?php if(isset($rowg['adresseb'])){ echo $rowg['adresseb'] ;}  ?>">
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
                                        <input type="text" class="form-control" name="contactb" value="<?php if(isset($rowg['contactb'])){ echo $rowg['contactb'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Responsable</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="respob" value="<?php if(isset($rowg['respob'])){ echo $rowg['respob'] ;}  ?>">
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
                                        <input type="text" class="form-control" name="capitalb" value="<?php if(isset($rowg['capitalb'])){ echo $rowg['capitalb'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                            </div>
                            <div class="col-lg-6 input_field_sections">
                                    <h5>Actionnaire et Parts</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="actionnaire" value="<?php if(isset($rowg['actionnaire'])){ echo $rowg['actionnaire'] ;}  ?>">
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
                                            <input id="input-4" name="logob" type="file"  class="file-loading" style="display: block" value="<?php if(isset($rowg['logob'])){ echo $rowg['logob'] ;}  ?>">

                                        </div>
                                    </div>
                                </div>
                                 <div class="col-lg-4 input_field_sections">

                                    <div class="input-group">
                                        <div class="input-group">
                                            <div class="file-preview-frame" id="preview-1631103769724-0" data-fileindex="0" data-template="image">
                                                <div class="kv-file-content">
                                                    <img src="img/plaque/<?php echo $rowg['logob']; ?>"   class="kv-preview-data file-preview-image" title="<?php echo $rowg['logob']; ?>" alt="<?php echo $rowg['logob']; ?>" style="width:100px;height:110px;">
                                                </div>
                                                <div class="file-thumbnail-footer">
                                                    <div class="file-footer-caption" title="<?php echo $rowg['logob']; ?>">
                                                        
                                                    </div>
                                                <div class="file-actions">
                                                        <div class="file-upload-indicator" title="Not uploaded yet"></div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
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
                                       Modifier Banque
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
<!--<script type="text/javascript" src="js/jquery.min.js">-->
    <script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>
<script>
    function plaque(str){

        if(str=='Absence de plaque'){
            $('#plaq').removeAttr('style');
            document.getElementById("retourplaque").innerHTML = '<h5>-</h5>'
                +'<div class="input-group"> <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i> </span>'
                +'<input autocomplete="off" type="text" class="form-control" placeholder=""  readonly name="lieup" value="Guichet Unique"> </div>';
        } else if(str=='Défaut de plaque'){
            $('#plaq').removeAttr('style');
            document.getElementById("retourplaque").innerHTML = '<h5>-</h5>'
               +'<div class="input-group"> <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i> </span>'
                +'<input autocomplete="off" type="text" class="form-control" value="Operateur de plaque" placeholder=""  readonly name="lieup">  </div>';
        }else{
            document.getElementById("retourplaque").innerHTML =  '<h5>-</h5>'
                +'<div class="input-group"> <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i> </span>'
                +'<input autocomplete="off" type="text" class="form-control" placeholder=""  readonly name="lieup"></div>';
            $('#plaq').css("display", "none");
        }



    }
    function cartegrise(str){
        if(str==0){
            $('#retourgrise').css("display", "none");
        }else{
            $('#retourgrise').removeAttr('style');

            var xhr2;
            var form_data2 = new FormData();

            form_data2.append("typed", str);

            if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
            xhr2.open('POST', "listecgi.php", true);
            xhr2.send(form_data2);
            xhr2.onreadystatechange = function() {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    document.getElementById("cgi").innerHTML = this.responseText;
                    $("#cgi").trigger("chosen:updated");

                    //                document.getElementById("retourajprix").innerHTML = this.responseText;
                }
                if (xhr2.readyState == 4 && xhr2.status != 200) {
                    alert("Error : returned status code " + xhr2.status);
                }
            }

        }



    }
    function verifiersms(){
        var xhr2;
        var form_data2 = new FormData();
        var tel=$('#telp').val();
        form_data2.append("tel", tel);

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "verifiersms.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
                document.getElementById("retoursms").innerHTML = '<img src="img/loader.gif" style=" width: 20px;" alt="Patience...">';
                var r = this.responseText;
                if(r=='oui'){
                    document.getElementById("retoursms").innerHTML ='Sms envoyé avec succès !'
                }else {
                    document.getElementById("retoursms").innerHTML ='Sms echoué !'
                }

                //                document.getElementById("retourajprix").innerHTML = this.responseText;
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }
    }



</script>