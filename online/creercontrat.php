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
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<style type="text/css">
  .register-club-form{
  visibility: hidden;
}
.register-user-form{
  visibility: hidden;
}

</style>


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
                    <a href="?page=listcontrat">Liste des contrats</a>
                </li>
                <li class="active breadcrumb-item">Ajouter nouveau compte</li>
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
                       Ajouter un nouveau contrat
                    </div>
                    <div class="card-block">
                        <?php
                        
                        if (isset($_POST['ok'])){

                            $rs21 = $bdd->prepare('select * from contrat1');
                            $rs21->execute();
                            $nbre2 = $rs21->rowCount();
                            $numcc = "CC-".numauto($nbre2+1);
                            $bank =  implode(",",$_POST['typepr']);
                            $debut = formatinv_date($_POST['Datedebut']);
                             $previs = formatinv_date($_POST['date_previs_G']);
                             $reel = formatinv_date($_POST['date_reel_G']);
                             $prisef = formatinv_date($_POST['date_prise_effet_G']);
                             $expg = formatinv_date($_POST['date_exp_G']);
                             $libg = formatinv_date($_POST['dat_lib_G']);
                             $datmisd = formatinv_date($_POST['Datemisdem']);
                             $datachev = formatinv_date($_POST['Dateachev']);
                              try {
                                $nomtab102 = "contrat";
                                $tab102 = array('Id_Projet' => $_POST['catprojet'],'id_fournisseurs' =>$_POST['id_fournisseurs'],'idmarche' =>$_POST['marche'],'Date_signature_C' => formatinv_date($_POST['Datesign']),'Date_achevement' => formatinv_date($_POST['Date_achevement']),'Date_Notif_Contrat' => formatinv_date($_POST['Datenotif']),'Datemisdem' => $datmisd,'Dateachev' => $datachev,'mtn_contrat' => $_POST['Mnt_contrat'],'garantie' => $_POST['actif'],'typegarantie' => $_POST['typegarantie'],'date_previs_G' => $previs,'date_reel_G' => $reel, 'date_prise_effet_G' => $prisef,'id_bank' => $bank,  'mtn_G' => $_POST['mtn_G'],'num_G' => $_POST['num_G'],'date_exp_G' =>$expg ,'dat_lib_G'=>$libg,'comment' => $_POST['comment'],'datenr' => gmdate("Y-m-d H:i:s"),'id_ajout' => $_SESSION['id'],'numcc' => $numcc);
                                //var_dump($tab102);
                                $sql = insert_tab($nomtab102, $tab102);
                                $sql->execute($tab102);
                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                           

                     header("location:?page=listcontrat");
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
                                        <select class="form-control chzn-select" name="marche" id="marche" onchange="check_fourniss(this.value)">
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Fournisseurs</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="id_fournisseurs" id="fourniss"> 
                                           
 
                                        </select>
                                    </div>
                                </div>
                            </div>                            
                            
                            <!-- ################################## -->
                            <!-- ################################ -->

                            <!-- ################################## -->
                            <div class="row">  
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date Signature</h5>
                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="Datesign">
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">
                                    <h5> Date Prévisionnelle</h5>
                                      <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                          <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp2" name="Date_achevement">
                                      </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                             <div class="row">                              

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date Notification</h5>

                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="Datenotif">
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date mis en vigueur</h5>

                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp9" name="Datemisdem">
                                    </div>
                                </div>  
                                  
                            </div>

                            <div class="row">
                              
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date achèvement</h5>

                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp10" name="Dateachev">
                                    </div>
                                </div> 
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Montant Contrat </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_contrat" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ################################## -->
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
                                        <h5>Etablissement Emetteur</h5>
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
                                    <h5>Type de Garantie </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typegarantie">
                                            <option value="-1" selected hidden>Selectionner </option>
                                           <option value="restitution">Restitution d’Avance </option>
                                           <option value="execution">Bonne Exécution ou Cautionnement définitif </option>
                                           <option value="retenue">Retenue de Garantie</option>
                                           <option value="Autres">Autres</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                            <div class="row">
                            <div class="col-lg-6 input_field_sections">
                                    <h5>Date réelle de transmission</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp4" name="date_reel_G" >
                                        
                                    </div>
                                </div> 
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Date Prévisionnelle</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp5" name="date_previs_G" >
                                        
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
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp6" name="date_prise_effet_G" >
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date d'expiration de la garantie</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp7" name="date_exp_G" >
                                        
                                    </div>
                                </div>  
                            </div>
                                <!-- ##################################### -->
                                <div class="row">


                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Montant garantie</h5>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="mtn_G" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
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
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp8" name="dat_lib_G" >
                                        
                                    </div>
                                </div>  
                            </div>
                           
                              <div class="row">

                                    <div  class="col-lg-12 input_field_sections">
                                        <h3>Commentaires</h3>
                                        <div class="form-group">
                                            <textarea class="form-control"  name="comment" rows="10" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            
                            <!-- ################################## -->

                           
                            <br>
                            <hr />
                            <div class="form-group row">
                                <div class="col-lg-7 input_field_sections"></div>
                                <div class="col-lg-5 push-lg-2">
                                    <button class="btn btn-primary" type="submit" name="ok">
                                        <i class="fa fa-user"></i>
                                       Ajouter Contrat
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

<!--<script type="text/javascript" src="js/jquery.min.js">-->
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>

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
<script>
    function check_fourniss(str) {
        //il fait la mise a jour du prix de base et l'observation

        var xhr2;
        var form_data2 = new FormData();
        form_data2.append("idf", str);

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "rech_fourniss.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {

                document.getElementById("fourniss").innerHTML = this.responseText;
                $("#fourniss").trigger("chosen:updated");

            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }
    }
</script>
