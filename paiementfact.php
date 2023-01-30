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
               Formulaire de Règlement
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
                    <a href="?page=listfacture">Liste des Factures</a>
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
                    <div class="card-header bg-primary">
                       Régler Facture
                    </div>
                    <div class="card-header bg-secondary">
                        <?php
                         
                             if (isset($_GET['id'])){
                        $id =$_GET['id'];
                        $rsg = $bdd->prepare('select * from tab_recep_facture  WHERE idrecept  =:zid  ');
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }

                        ?>
                            <div class="row">
                                <div class="col-lg-8 input_field_sections">
                                    <h5>Projets : 
                                    <strong>
                                        <span  name="catprojet" onchange="check_marche(this.value)">
                                            <?php

                                            $i=1;
                                            $idp = $rowg['Idprojet'];
                                            $rscat = $bdd->prepare('select * from   type_projet  WHERE Id_typep  =:tp');
                                            $rscat->execute(array("tp"=>$idp));
                                           $rowcat = $rscat->fetch();
                                            echo $rowcat['Nom_Projet']; 

                                              ?>
                                           
                                        </span>  
                                    </strong></h5>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Num Facture :
                                        <strong>
                                        <?php if ($rowg['Num_Facture']) { echo $rowg['Num_Facture']; } ?>
                                        </strong>
                                    </h5>
                                    
                                </div>
                            </div>
                            <!--############################### -->
                             <div class="row">
                               <div class="col-lg-8 input_field_sections">
                                    <h5>Marché :
                                    <strong>

                                            <?php

                                            $i=1;
                                            $idm = $rowg['idmarche'];
                                            $rscam = $bdd->prepare('select * from   tab_projet  WHERE id_projet  =:tp');
                                            $rscam->execute(array("tp"=>$idm));
                                           $rowcam = $rscam->fetch();
                                             echo $rowcam['Num_Contrat'].'-'.$rowcam['Intitule_Contrat'] ;

                                              ?>
                                           

                                    </strong></h5>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Mnt Facture :
                                        <strong>
                                           <?php
                                           $rscont = $bdd->prepare('select * from   contrat  WHERE idmarche  =:tp');
                                           $rscont->execute(array("tp"=>$idm));
                                           $rowcont = $rscont->fetch();
                                           $taux = ($rowg['Mnt_Facture']*100)/$rowcont['mtn_contrat'];
                                           if ($rowg['Mnt_Facture']) { echo number_format($rowg['Mnt_Facture']);
                                           }
                                           echo ' Soit '.round($taux,1).'% du montant total'
                                           ?>
                                        </strong>
                                        
                                    </h5>
                                    
                                </div>
                            </div>
                            <!---##############################-->
                            <div class="row">
                               <div class="col-lg-8 input_field_sections">
                                    <h5>Fournisseurs :
                                        <strong>

                                            <?php

                                            $i=1;
                                            $idf = $rowg['id_fournisseurs'];
                                            $rscaf = $bdd->prepare('select * from   fournisseurs  WHERE id_fournisseurs  =:tp');
                                            $rscaf->execute(array("tp"=>$idf));
                                           $rowcaf = $rscaf->fetch();
                                              echo $rowcaf['Name_entreprise'];

                                            $idr =$_GET['id'];
                                            $rsr = $bdd->prepare("select sum(montant) as mp from  tab_reglement_facture  WHERE idreception  = :zid");
                                            $rsr->execute(array("zid"=>$idr));
                                            $rowr = $rsr->fetch();
                                               ?>
                                           

                                    </strong>

                                    </h5>
                                    
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Mnt Restant  <strong style="color: red">  <?php  echo number_format($rowg['Mnt_Facture']-$rowr['mp']) ?>
                                        </strong></h5>

                                </div>
                            </div>
                            <!---##############################-->
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_POST['ok'])){
                            $scanb = $_FILES['scanb']['name'];
                            if(!empty($scanb)) {
                                $tab = explode(".", $scanb);
                                $ph1 = ajoutitret($tab[0]);
                                $ph2 = $tab[1];
                                $bordero = $ph1 . "_" . pwd_aleatoire(4) . "." . $ph2;
                                $content_dir = 'img/produit/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph = $_FILES['scanb']['tmp_name'];
                                move_uploaded_file($tmp_ph, 'img/pieceid/'.$bordero);
                            }else{
                                $bordero='';
                            }
                            
                                    try {
                        $idrecep = $rowg['idrecept'];
                        $bank =  implode(",",$_POST['typepr']);
         $nomtab10 = "facture";
         $tab10 = array('Mnt_regle' => $_POST['Mnt_regle'],'idrecept' =>$idrecep, 'id_ajout' => $_SESSION['id'],'scanb' => $bordero,'id_bank' => $bank,'modepaiement' => $_POST['actif'], 'Date_Transmission_F' => formatinv_date($_POST['Date_Transmission_F']), 'Date_Paiement_Fact' => formatinv_date($_POST['Date_Paiement_Fact']),'datenr' => gmdate("Y-m-d H:i:s"));
         //var_dump($tab10);
         $sql = insert_tab($nomtab10, $tab10);
         $sql->execute($tab10);
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                        header("location:?page=listfacture");
                                }


                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                             <br>                            
                            <div class="row">
                                <div class="col-lg-12 input_field_sections">
                                    <div class="col-lg-7 push-lg-3">
                                        <label>
                                        <strong>
                                          MODE DE PAIEMENT  
                                        </strong>
                                         
                                        </label>

                                    </div>
                                </div>
                            </div>
                             <hr>
                             <div class="row">
                                 <div class="col-lg-12">

                                     <label for="radio7" class="custom-control custom-radio signin_radio4">
                                         <input  type="radio"   id="radio7"   class="custom-control-input"   name="mdp"  value="Chèque" onclick="affiche(this.value)" required>
                                         <span class="custom-control-indicator"></span>
                                         <span class="custom-control-description" > Chèque</span>
                                     </label>
                                     <label for="radio71" class="custom-control custom-radio signin_radio4">
                                         <input  type="radio"   id="radio71"  class="custom-control-input"  name="mdp"  value="Virement"  onclick="affiche(this.value)" required>
                                         <span class="custom-control-indicator"></span>
                                         <span class="custom-control-description" > Virement</span>
                                     </label>
                                     <label for="radio722" class="custom-control custom-radio signin_radio4">
                                         <input  type="radio"   id="radio722"   class="custom-control-input"   name="mdp"  value="Compte"  onclick="affiche(this.value)" required>
                                         <span class="custom-control-indicator"></span>
                                         <span class="custom-control-description">Compte</span>
                                     </label>
                                     <label for="radio72" class="custom-control custom-radio signin_radio4">
                                         <input  type="radio"   id="radio72"   class="custom-control-input"   name="mdp"  value="Espèces"  onclick="affiche(this.value)" required>
                                         <span class="custom-control-indicator"></span>
                                         <span class="custom-control-description">Espèces</span>
                                     </label>

                                 </div>
                            </div>
                            <div style="display: none" id="blockk" class="row container">
                                <div class="col-lg-4 input_field_sections">
                                    <h5 id="numtext">Numéro chèque</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="num_bq" id="num_blockk" placeholder=" "  >
                                        <span class="input-group-addon text-primary">N°</i></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections" id="bq_espece">
                                    <h5>Banque émettrice</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" id="b_emet" name="b_emet">
                                            <option disabled selected>Selectionner la banque émettrice</option>
                                            <?php
                                            $i=1;
                                            $rbe = $bdd->prepare('select * from table_banque ORDER BY nombanque DESC ');
                                            $rbe->execute();
                                            while($rowbe = $rbe->fetch()) { ?>
                                                <option value="<?php echo $rowbe['idbanque'] ?>">
                                                    <?php if (!empty($rowbe['nombanque']) && !empty($rowbe['nomabrege'])) { echo $rowbe['nombanque'] . '('. $rowbe['nomabrege'] .') '; }
                                                    elseif (empty($rowbe['nombanque'])) { echo $rowbe['nomabrege']; }
                                                    else { echo $rowbe['nomabrege']; }
                                                    ?>
                                                </option>
                                                <?php $i++;}  ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Montant Réglé </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_regle" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-lg-6 input_field_sections">
                                        <h5>Banque réceptrice</h5>
                                        <div class="input-group">
                                            <select class="form-control chzn-select" unik name="typepr[]" onchange="cache(this.value)">
                                                <option value="default"  hidden>Selectionner une Banque</option>
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
                                    
                                </div>
                           
                            <!--############################### -->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date versement Banque</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp8" name="Date_Transmission_F" >
                                        
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Date Enregistrement</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp6" name="Date_Paiement_Fact" >
                                        
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Scan Bordereau</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="scanb" type="file"  class="file-loading" style="display: block">

                                        </div>
                                    </div>
                                </div>  
                            </div>
                                  <br>
                                   <hr /><hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" id="ok" name="ok">
                                            <i class="fa fa-user"></i>
                                           Valider
                                        </button>
                                         <button class="btn btn-warning" type="reset" id="clear">
                                             <a  id="editable_table_new"  href="?page=listcontrat" style="color :white;">
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
        // console.log($('input[name=mdp]:checked').val());
        //  console.log(str);
        if (str =="Chèque"){
            $('#blockk').removeAttr('style');
            $('#b_emet').attr("required", "true");
            $('#num_blockk').attr("required", "true");
            $('#numtext').text("Numéro chèque");
            $('#bq_espece').removeAttr('style');
            $('#comp_block').css("display", "none");
            $('#recep_bq').css("display", "block");
            $('#dvers_bq').css("display", "block");
            $('#courfile').css("display", "block");
        }else if(str =="Virement"){
            $('#recep_bq').css("display", "block");
            $('#dvers_bq').css("display", "block");
            $('#blockk').removeAttr('style');
            $('#b_emet').attr("required", "true");
            $('#num_blockk').attr("required", "false");
            $('#numtext').text("Numéro virement");
            $('#bq_espece').removeAttr('style');
            $('#comp_block').css("display", "none");
            $('#courfile').css("display", "block");
        }
        else if(str =="Compte"){
            $('#recep_bq').css("display", "block");
            $('#dvers_bq').css("display", "block");
            $('#blockk').removeAttr('style');
            $('#b_emet').attr("required", "false");
            $('#num_blockk').val("");
            $('#numtext').text("Numéro bordereau");
            $('#bq_espece').css("display", "none");
            $('#comp_block').css("display", "none");
            $('#courfile').css("display", "block");

        }
        else if(str =="Espèces"){
            $('#recep_bq').css("display", "block");
            $('#bq_espece').css("display", "none");
            $('#num_blockk').css("display", "none");
            $('#dvers_bq').css("display", "block");
            $('#blockk').removeAttr('style');
            $('#numtext').text("Numéro bordereau");
            $('#comp_block').css("display", "none");
            $('#courfile').css("display", "block");

        }

        else {
            $('#b_emet').removeAttr("required", "false");
            $('#num_blockk').removeAttr("required", "false");
            $('#num_blockk').val("");
            $('#numtext').text("");
            $('#recep_bq').removeAttr("style");
            $('#dvers_bq').removeAttr("style");
            $('#recep_bq').removeAttr("style");
            $('#courfile').removeAttr("style");

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
