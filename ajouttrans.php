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
                <i class="fa fa-table"></i>
              Liste des Transactions 
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
                    <a href="?page=ajoutadherent">Nouvelle Transactions</a>
                </li>
                <li class="active breadcrumb-item">Liste des Transactions </li>
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
                      AJOUT D'UN NOUVEAU PAIEMENT 
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_POST['ok'])){
                           


                                    try {
         $nomtab10 = "table_transaction";
         $tab10 = array('mtn_trans' => $_POST['mtn_trans'], 'id_ajout' => $_SESSION['id'], 'Date_trans' => $_POST['Date_trans'], 'num_paiem' => $_POST['num_paiem'], 'modep_trans' => $_POST['modep_trans'],'motif_trans' => $_POST['actif'],'id_nomadr' => $_POST['id_nomadr'],'datenr' => gmdate("Y-m-d H:i:s"));
        // var_dump($tab10);
         $sql = insert_tab($nomtab10, $tab10);
         $sql->execute($tab10);
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }
                      header("location:?page=listtransaction");
                                }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                             <br>
                            <h4 style="margin-top: 5px; margin-bottom: 10px"> AJOUT PAIEMENT </h4>
                            <hr>
                             <!--############################### -->
                             <div class="row">
                                 <div class="col-lg-12 input_field_sections">
                                    <h4 style="text-align: center">Motif Paiement</h4>
                                    <div class="col-lg-7 push-lg-3">
                                        <label for="radio1" class="custom-control custom-radio signin_radio1">
                                            <input id="radio1" name="actif" type="radio" class="custom-control-input" value="0"  checked>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">DON</span>
                                        </label>
                                        <label for="radio4" class="custom-control custom-radio signin_radio4">
                                            <input id="radio4" name="actif" type="radio" class="custom-control-input" value="1">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">COTISATION</span>
                                        </label>
                                        <label for="radio2" class="custom-control custom-radio signin_radio2">
                                            <input id="radio2" name="actif" type="radio" class="custom-control-input" value="2">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">FRAIS ADHESION </span>
                                        </label>
                                    </div>
                                </div>
                             </div>
                              <!--############################### -->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>ADHÉRENTS</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="id_nomadr">
                                            <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                            $rscat = $bdd->prepare('select * from   table_adherent  ORDER by nom_adh DESC ');
                                            $rscat->execute();
                                            while($rowcat = $rscat->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowcat['id_adhr'] ?>"><?php echo $rowcat['nom_adh'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                            <div class="input-group">
                                                <label><h5>
                                                Mode de Paiement </h5></label>
                                               <select id="idproprio" class="form-control chzn-select" name="modep_trans" onchange="showproprio(this.value)">
                                                <option value="-1">Selectionnez </option>
                                                                      

                                                  <option value="Wave">
                                                    Wave
                                                  </option>
                                                  <option value="OM">
                                                    Orange Money
                                                  </option>
                                                 
                                                          >
                                      </select>

                                         </div>
                                       </div>
                                  
                            </div>
                            <!--############################### -->
                            
                            <!--############################### -->
                            <div class="row">    
                                <div class="col-lg-6 input_field_sections">
                                    <h5>
                                        Montant
                                    </h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="mtn_trans">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date Paiement</h5>
                                    <div class="input-group">
                                    <input type="date" class="form-control" name="Date_trans">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div>
                                                           
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Numéro Paiement </h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="num_paiem">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div> 
                                 
                               
                            </div>
                            
                            <!-- ########################## -->
                         
                            <!-- ########################### -->
                                  <br>
                                   <hr /><hr />
                            <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" id="ok" name="ok">
                                            <i class="fa fa-user"></i>
                                            Enregistrer
                                        </button>
                                         <button class="btn btn-warning" type="reset" id="clear">
                                             <a  id="editable_table_new"  href="?page=listtransaction" style="color :white;">
                                                        <i class="fa fa-refresh"></i>
                                                       Annuler
                                             </a>
                                        </button>
                                          

                                    </div>
                                </div>
                                </div>
                                <!--<input type="text" id="ag" value="<?php //echo $_SESSION['id'] ?>">-->
                                </div> 
                            
                                
                               
                               
                        </form>
                          
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
    function check_fourniss1(str) {
        //il fait la mise a jour du prix de base et l'observation

        var xhr2;
        var form_data2 = new FormData();
        form_data2.append("idf", str);

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "rech_fourniss1.php", true);
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
