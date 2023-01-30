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
               Formulaire de Modification
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
                       Modification Dépot
                    </div>
                    <div class="card-block">
                        <?php
                         
                             if (isset($_GET['id'])){
                        $id =$_GET['id'];
                        $rsg = $bdd->prepare('select * from tab_recep_facture  WHERE idrecept  =:zid  ');
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                         if (isset($_POST['ok'])){
                             $scan = $_FILES['scan']['name'];
                            if(!empty($scan)) {
                                $tab = explode(".", $scan);
                                $ph1 = ajoutitret($tab[0]);
                                $ph2 = $tab[1];
                                $photor = $ph1 . "_" . pwd_aleatoire(4) . "." . $ph2;
                                $content_dir = 'img/produit/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph = $_FILES['scan']['tmp_name'];
                                move_uploaded_file($tmp_ph, 'img/pieceid/'.$photor);
                            }else{
                                $photor='';
                            }

                            try {
                                    
        $rsql1 = $bdd->prepare('UPDATE  tab_recep_facture SET  Num_Facture = :Num_Facture,Mnt_Facture = :Mnt_Facture,scan = :scan,date_reception = :date_reception, Idprojet = :Idprojet,  idmarche = :idmarche,id_fournisseurs = :id_fournisseurs,datemodif = :datemodif,id_modif = :id_modif WHERE idrecept = :id');
         $nomtab10 = "tab_recep_facture";
         $tab10 = $rsql1->execute(array('Num_Facture' => $_POST['Num_Facture'],'Mnt_Facture' => $_POST['Mnt_Facture'],'scan' => $photor, 'date_reception' => formatinv_date($_POST['date_reception']),'Idprojet' => $_POST['catprojet'],'idmarche' => $_POST['marche'],'id_fournisseurs' => $_POST['id_fournisseurs'],'datemodif' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' => $id));
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                        header("location:?page=listfacture");
                            }
                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                             <br>
                            <h4 style="margin-top: 5px; margin-bottom: 10px">Déposer une Facture </h4>
                            <hr>
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
                                                <option value="<?php echo $rowcat['Id_typep'] ?>" <?php
                                                $tb2 = explode(',',$rowg['Idprojet']);
                                                    foreach ($tb2 as $v){
                                                        if ($v==$rowcat['Id_typep']){echo  'selected'; }
                                                    }
                                                    ?>><?php echo $rowcat['Nom_Projet'] ?></option>

                                            <?php }  ?>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Marché</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="marche" id="marche" onchange="check_fourniss1(this.value)">
                                             <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                            $rsc = $bdd->prepare('select * from   tab_projet  ORDER by Num_Contrat DESC ');
                                            $rsc->execute();
                                            while($rowm = $rsc->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowm['id_projet'] ;?>" <?php
                                                $tb2 = explode(',',$rowg['idmarche']);
                                                    foreach ($tb2 as $v){
                                                        if ($v==$rowm['id_projet']){echo  'selected'; }
                                                    }
                                                    ?>> <?php echo $rowm['Num_Contrat'].'-'.$rowm['Intitule_Contrat'] ?></option>
                                                     <?php }  ?>
                                           </select>
                                    </div>

                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Fournisseurs</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="id_fournisseurs" id="fourniss1">
                                           <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                            $rscaf = $bdd->prepare('select * from   fournisseurs  ORDER by Name_entreprise DESC ');
                                            $rscaf->execute();
                                            while($rowcaf = $rscaf->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowcaf['id_fournisseurs'] ;?>" <?php
                                                $tb2 = explode(',',$rowg['id_fournisseurs']);
                                                    foreach ($tb2 as $v){
                                                        if ($v==$rowcaf['id_fournisseurs']){echo  'selected'; }
                                                    }
                                                    ?>><?php echo $rowcaf['Name_entreprise'] ;?></option>  
                                                     <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--############################### -->

                            <div class="row">    
                               <div class="col-lg-6 input_field_sections">
                                    <h5>Numero Facture</h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="Num_Facture" value="<?php if ($rowg['Num_Facture']) { echo $rowg['Num_Facture']; } ?>">
                                    <span class="input-group-addon"> 
                                        <i class="fa fa-file text-primary">
                                            
                                        </i>
                                    </span>
                                    </div>
                                </div> 
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Montant Facture </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_Facture" style="background-color: rgba(255,118,22,0.13); font-weight: bold" value="<?php if ($rowg['Mnt_Facture']) { echo $rowg['Mnt_Facture']; } ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>                              
                            </div>
                            <!--################################-->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date Réception</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp8" name="date_reception" value="<?php if ($rowg['date_reception']) { echo format_date($rowg['date_reception']); } ?>">
                                        
                                    </div>
                                </div>
                                
                                <!--#####################--> 
                                <div class="col-lg-2 input_field_sections">
                                    <h5>Scan Facture</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="scan" type="file"class="file-loading"  <?php if (empty($rowg['scan'])) { ?>required<?php }?>style="display: block">

                                        </div>
                                    </div>
                                </div> 
                                <!--#####################-->
                                <div class="col-lg-2 input_field_sections">

                                    <div class="input-group">
                                        <div class="input-group">
                                            <div class="file-preview-frame" id="preview-1631103769724-0" data-fileindex="0" data-template="image"><div class="kv-file-content">
                                                    <img src="img/pieceid/<?php echo $rowg['scan']; ?>"   class="kv-preview-data file-preview-image" title="<?php echo $rowg['scan']; ?>" alt="facture.jpg" style="width:100px;height:110px;">
                                                </div><div class="file-thumbnail-footer">
                                                    <div class="file-footer-caption" title="facture.jpg"></div>
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
                            <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" id="ok" name="ok">
                                            <i class="fa fa-user"></i>
                                            Modifier
                                        </button>
                                         <button class="btn btn-warning" type="reset" id="clear">
                                             <a  id="editable_table_new"  href="?page=listcontrat" style="color :white;">
                                                        <i class="fa fa-refresh"></i>
                                                       Annuler
                                             </a>
                                        </button>
                                          

                                    </div>
                                </div>
                                  <br>
                                   <hr /><hr />
                            <!-- ###############################-->
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

                document.getElementById("fourniss1").innerHTML = this.responseText;
                $("#fourniss1").trigger("chosen:updated");

            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }
    }
</script>