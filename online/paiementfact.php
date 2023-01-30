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
                        //################################
                                     $idr =$rowg['idrecept'];
                                     $rsr = $bdd->prepare("select sum(Mnt_regle) as mntpaye from  facture  WHERE idrecept  = :tp");
                                $rsr->execute(array("tp"=>$idr));
                                //$nb = $rsr->rowCount();
                                $rowrf = $rsr->fetch();
                                $mntpaye =$rowrf['mntpaye'];
                        //###############################3
                      
                        }

                        ?>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Projets : 
                                    <strong>
                                        <span  name="catprojet" onchange="check_marche(this.value)">
                                            <?php

                                            $i=1;
                                            $idp = $rowg['Idprojet'];
                                            $rscat = $bdd->prepare('select * from   type_projet  WHERE Id_typep  =:tp');
                                            $rscat->execute(array("tp"=>$idp));
                                            while($rowcat = $rscat->fetch()) {
                                            echo $rowcat['Nom_Projet']; 

                                             }  ?>
                                           
                                        </span>  
                                    </strong></h5>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Num Facture :
                                        <strong>
                                        <?php if ($rowg['Num_Facture']) { echo $rowg['Num_Facture']; } ?>
                                        </strong>
                                    </h5>
                                    
                                </div>
                            </div>
                            <!--############################### -->
                             <div class="row">
                               <div class="col-lg-6 input_field_sections">
                                    <h5>Marché :
                                    <strong>
                                        <span  name="marche" onchange="check_marche(this.value)">
                                            <?php

                                            $i=1;
                                            $idm = $rowg['idmarche'];
                                            $rscam = $bdd->prepare('select * from   tab_projet  WHERE id_projet  =:tp');
                                            $rscam->execute(array("tp"=>$idm));
                                            while($rowcam = $rscam->fetch()) {
                                             echo $rowcam['Num_Contrat'].'-'.$rowcam['Intitule_Contrat'] ;

                                             }  ?>
                                           
                                        </span>  
                                    </strong></h5>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Mnt Facture :
                                        <strong>
                                           <?php if ($rowg['Mnt_Facture']) { echo $rowg['Mnt_Facture']; } ?> 
                                        </strong>
                                        
                                    </h5>
                                    
                                </div>
                            </div>
                            <!---##############################-->
                            <div class="row">
                               <div class="col-lg-6 input_field_sections">
                                    <h5>Fournisseurs :
                                        <strong>
                                        <span  name="marche" onchange="check_marche(this.value)">
                                            <?php

                                            $i=1;
                                            $idf = $rowg['id_fournisseurs'];
                                            $rscaf = $bdd->prepare('select * from   fournisseurs  WHERE id_fournisseurs  =:tp');
                                            $rscaf->execute(array("tp"=>$idf));
                                            while($rowcaf = $rscaf->fetch()) {
                                              echo $rowcaf['Name_entreprise']; 

                                             }  ?>
                                           
                                        </span>  
                                    </strong>

                                    </h5>
                                    
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Mnt Restant :
                                        <strong>
                                        <?php  

                                    $restp = $rowg['Mnt_Facture']-$mntpaye;
                                        echo $restp;  ?>
                                            
                                        </strong>
                                    </h5>
                                   
                                </div>
                            </div>
                            <!---##############################-->
                    </div>
                    <div class="card-block">
                        <?php

                         //###########################
                                     if (isset($_POST['ok3'])){
                            $scanb2 = $_FILES['scanb2']['name'];
                            if(!empty($scanb2)) {
                                $tab = explode(".", $scanb2);
                                $ph1 = ajoutitret($tab[0]);
                                $ph2 = $tab[1];
                                $bordero2 = $ph1 . "_" . pwd_aleatoire(4) . "." . $ph2;
                                $content_dir = 'img/produit/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph = $_FILES['scanb2']['tmp_name'];
                                move_uploaded_file($tmp_ph, 'img/pieceid/'.$bordero2);
                            }else{
                                $bordero2='';
                            }
                            
                                    try {
                       // $restp = $rowrf['rest_paye']-;                
                        $idrecep2 = $rowg['idrecept'];
                        $bank2 =  implode(",",$_POST['typepr2']);
         $nomtab8 = "facture";
         $tab8= array('Mnt_regle' => $_POST['Mnt_reglev'],'idrecept' =>$idrecep2, 'id_ajout' => $_SESSION['id'],'scanb' => $bordero2,'id_bank' => $bank2,'modepaiement' => $_POST['actif'], 'Date_Transmission_F' => formatinv_date($_POST['Date_enregis2']), 'Date_Paiement_Fact' => formatinv_date($_POST['Date_Paiement2']),'datenr' => gmdate("Y-m-d H:i:s"));
         //var_dump($tab10);
         $sql = insert_tab($nomtab8, $tab8);
         $sql->execute($tab8);
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                        header("location:?page=listfacture");
                                }
                                
                          //###########################
                                     if (isset($_POST['ok2'])){
                            $scanb1 = $_FILES['scanb1']['name'];
                            if(!empty($scanb1)) {
                                $tab = explode(".", $scanb1);
                                $ph1 = ajoutitret($tab[0]);
                                $ph2 = $tab[1];
                                $bordero1 = $ph1 . "_" . pwd_aleatoire(4) . "." . $ph2;
                                $content_dir = 'img/produit/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph = $_FILES['scanb1']['tmp_name'];
                                move_uploaded_file($tmp_ph, 'img/pieceid/'.$bordero1);
                            }else{
                                $bordero1='';
                            }
                            
                                    try {
                       // $restp = $rowrf['rest_paye']-;                
                        $idrecep1 = $rowg['idrecept'];
                        $bank1 =  implode(",",$_POST['typepr1']);
         $nomtab9 = "facture";
         $tab9 = array('numcheq' => $_POST['numcheq1'],'Mnt_regle' => $_POST['Mnt_reglec'],'idrecept' =>$idrecep1, 'id_ajout' => $_SESSION['id'],'scanb' => $bordero1,'id_bank' => $bank1,'modepaiement' => $_POST['actif'], 'Date_Transmission_F' => formatinv_date($_POST['Date_enregis1']), 'Date_Paiement_Fact' => formatinv_date($_POST['Date_Paiement1']),'datenr' => gmdate("Y-m-d H:i:s"));
         //var_dump($tab10);
         $sql = insert_tab($nomtab9, $tab9);
         $sql->execute($tab9);
                                    } 

                                    catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }

                        header("location:?page=listfacture");
                                }
                                         

                        //#########################

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
                       // $restp = $rowrf['rest_paye']-;                
                        $idrecep = $rowg['idrecept'];
                        $bank =  implode(",",$_POST['typepr']);
         $nomtab10 = "facture";
         $tab10 = array('Mnt_regle' => $_POST['Mnt_regle'],'idrecept' =>$idrecep, 'id_ajout' => $_SESSION['id'],'scanb' => $bordero,'modepaiement' => $_POST['actif'], 'Date_Transmission_F' => formatinv_date($_POST['Date_Transmission_F']), 'Date_Paiement_Fact' => formatinv_date($_POST['Date_Paiement_Fact']),'datenr' => gmdate("Y-m-d H:i:s"));
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
                                <div class="col-lg-12 input_field_sections">
                                    <div class="col-lg-7 push-lg-3">
                                        <label for="radio1" class="custom-control custom-radio signin_radio1">
                                            <input id="radio1" name="actif" type="radio" class="custom-control-input" value="Cheque"  onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Chèque</span>                          
                                        </label>  
                                        <!-- ################-->
                                         <label for="radio2" class="custom-control custom-radio signin_radio2">
                                            <input id="radio2" name="actif" type="radio" class="custom-control-input" value="Virement"   onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Virement</span>                          
                                        </label>
                                        <!-- ################-->
                                         <label for="radio3" class="custom-control custom-radio signin_radio3">
                                            <input id="radio3" name="actif" type="radio" class="custom-control-input" value="Compte"   onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Compte</span>                          
                                        </label>
                                        <!-- ################-->
                                        <label for="radio4" class="custom-control custom-radio signin_radio4">
                                            <input id="radio4" name="actif" type="radio" class="custom-control-input" value="Espece"   onclick="affiche(this.value)">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Espèce</span>                          
                                        </label>
                                        <!-- ################-->     

                                    </div>
                                </div>
                            </div>
                        <div id="Espece">
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Montant Réglé </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_regle" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>                          
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date Paiement</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="Date_Transmission_F" >
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date Enregistrement</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp2" name="Date_Paiement_Fact" >
                                        
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
                            <!--############################### -->
                        <div id="Cheque" style="display: none"> 
                            <div class="row">
                                 <div class="col-lg-3 input_field_sections">
                                    <h5>N° de chèque</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="numcheq1" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Montant Réglé </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_reglec" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-lg-6 input_field_sections">
                                        <h5>Banque réceptrice</h5>
                                        <div class="input-group">
                                            <select class="form-control chzn-select" unik name="typepr1[]" onchange="cache(this.value)">
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
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="Date_enregis1" >
                                        
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Date Enregistrement</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp4" name="Date_Paiement1" >
                                        
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Scan Bordereau</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-2" name="scanb1" type="file"  class="file-loading" style="display: block">

                                        </div>
                                    </div>
                                </div>  
                            </div>
                                  <br>
                                   <hr /><hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" id="ok2" name="ok2">
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
                        <div id="Virement" id="Compte" style="display: none"> 
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Montant Réglé </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_reglev" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div> 
                                <div class="col-lg-6 input_field_sections">
                                        <h5>Banque réceptrice</h5>
                                        <div class="input-group">
                                            <select class="form-control chzn-select" unik name="typepr2[]" onchange="cache(this.value)">
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
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp8" name="Date_enregis2" >
                                        
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Date Enregistrement</h5>
                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp6" name="Date_Paiement2" >
                                        
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Scan Bordereau</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="scanb2" type="file"  class="file-loading" style="display: block">

                                        </div>
                                    </div>
                                </div>  
                            </div>
                                  <br>
                                   <hr /><hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" id="ok3" name="ok3">
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

        if (str == "Espece") {
            $('#Espece').removeAttr('style');
            $('#Cheque').css("display", "none");
            $('#Virement').css("display", "none");
        } else if (str == "Cheque") {
            $('#Cheque').removeAttr('style');
            $('#Espece').css("display", "none");
            $('#Virement').css("display", "none");
        } else{
            $('#Virement').removeAttr('style');
            $('#Espece').css("display", "none");
            $('#Cheque').css("display", "none");
        }
    }
</script>

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
