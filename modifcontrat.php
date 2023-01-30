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
   <!--<script type="text/javascript" src="js/jquery.min.js">-->
<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!--Page level scripts-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/pages/form_validation2.js"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>

<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-pencil"></i>
               Formulaire Modification
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
                       Modifier Contrat
                    </div>
                    <div class="card-block">
                  <?php

                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                         $rsg = $bdd->prepare("select * from contratanc  WHERE id_Contrat = :zid");
                         //var_dump($id); 
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                        if (isset($_POST['ok'])){

                             try {
                                    //                            $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , datecon, statconn) VALUES(:ipadress, :log, :datc, :statc)');
                                    //                            $rs3->execute(array('ipadress' => get_ip(), 'log' => $log ,'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));


                               /// le numero d'ordre
                                    $Num_Contrat=$rowg['Num_Contrat'];
                                    $rsg = $bdd->prepare("select * from contratanc WHERE Num_Contrat =:nc and Num_Contrat <>'$Num_Contrat'");
                                    $rsg->execute(array('nc'=>$_POST['Num_Contrat']));
                                    $nb = $rsg->rowCount();
                                    //$identite = $_POST['nom']." ".$_POST['pnom'];

                        
if ($nb==0){
   
    try {

        $rsql1 = $bdd->prepare('UPDATE  contratanc SET  Num_Contrat = :Num_Contrat,Intitule_Contrat = :Intitule_Contrat,  Methode_passation = :Methode_passation,  typemarche = :typemarche,  typerevue = :typerevue, mtn_contrat = :mtn_contrat,Mnt_passation = :Mnt_passation,Date_signature_C = :Date_signature_C,Date_Notif_Contrat = :Date_Notif_Contrat,Date_mis_vigueur = :Date_mis_vigueur,  Date_achevement =:Date_achevement,Duree_contrat = :Duree_contrat,  Id_typep = :Id_typep,  id_fournisseurs = :id_fournisseurs,datenr = :datenr,id_modif = :id_modif WHERE id_Contrat =:id');
                            //var_dump($rsql1);                             
         $nomtab10 = "contrat";
         $tab10 = $rsql1->execute(array(
            'Num_Contrat' => $_POST['Num_Contrat'],
            'Intitule_Contrat' => $_POST['Intitule_Contrat'],
            'Methode_passation' => $_POST['Methode_passation'], 
            'typemarche' => $_POST['typemarche'],
            'typerevue' => $_POST['typerevue'],
            'mtn_contrat' => $_POST['mtn_contrat'],
            'Mnt_passation' => $_POST['Mnt_passation'],
            'Date_signature_C' => $_POST['Date_signature_C'],
            'Date_Notif_Contrat' => $_POST['Date_Notif_Contrat'],
            'Date_mis_vigueur' => $_POST['Date_mis_vigueur'],
            'Date_achevement' => $_POST['Date_achevement'], 
            'Duree_contrat' => $_POST['Duree_contrat'],
            'Id_typep' => $_POST['Id_typep'],
            'id_fournisseurs' => $_POST['id_fournisseurs'],
            'datenr' => gmdate("Y-m-d H:i:s"),
            'id_modif' => $_SESSION['id'],
            'id' => $id));
       
    } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listcontrat");
}else{

    echo ' <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">× </button><strong> Accès erroné : </strong>
       Numéro de la plaque numérologique doit etre uniques ! </div>';
}

                                } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }



                        }
                        ?>
                         <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Type de Projet</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="Id_typep" >
                                            <option selected disabled>Selectionner un Projet</option>
                                             <option value="1">C2D - Phase 2</option>
                                            <option value="2">Mutation  ORM</option>
                                            <?php
                                           /* $i=1;
                                            $rsg = $bdd->prepare('select * from  table_gpe_users  ORDER by descn DESC ');
                                            $rsg->execute();
                                            while($rowg = $rsg->fetch()) {
                                            ?>
                                                <option value="<?php echo $rowg['idgpe'] ?>"><?php echo $rowg['descn'] ?></option>

                                            <?php }  */?>

                                        </select>
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Type de Fournisseur</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="id_fournisseurs" >
                                            <option selected disabled>Selectionner un Fournisseur</option>
                                             <?php
                                           /* $i=1;
                                            $rsg = $bdd->prepare('select * from  table_gpe_users  ORDER by descn DESC ');
                                            $rsg->execute();
                                            while($rowg = $rsg->fetch()) {
                                            ?>
                                                <option value="<?php echo $rowg['idgpe'] ?>"><?php echo $rowg['descn'] ?></option>

                                            <?php }  */?>
                                             <option value="1">C2D - Phase 2</option>
                                             <option value="2">Mutation  ORM</option>

                                        </select>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Numéro du Marché / contrat</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Num_Contrat"value="<?php if(isset($rowg['Num_Contrat'])){ echo $rowg['Num_Contrat'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                     <h5>Intitulé du Marché / Contrat</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Intitule_Contrat" value="<?php if(isset($rowg['Intitule_Contrat'])){ echo $rowg['Intitule_Contrat'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################ -->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Méthode de passation</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Methode_passation" value="<?php if(isset($rowg['Methode_passation'])){ echo $rowg['Methode_passation'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Type de Contrat </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="typemarche" value="<?php if(isset($rowg['typemarche'])){ echo $rowg['typemarche'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                            <!-- ################################ -->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Type de Revue</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="typerevue" value="<?php if(isset($rowg['typerevue'])){ echo $rowg['typerevue'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                   <h5>Montant prévu au PPM </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_passation" value="<?php if(isset($rowg['Mnt_passation'])){ echo $rowg['Mnt_passation'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                     <h5>Montant du contrat (FCFA)</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="mtn_contrat" value="<?php if(isset($rowg['mtn_contrat'])){ echo $rowg['mtn_contrat'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date de signature</h5>

                                    <div class="input-group">
                                        <input type="Date" class="form-control" name="Date_signature_C" value="<?php if(isset($rowg['Date_signature_C'])){ echo $rowg['Date_signature_C'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                             <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Achèvement du contrat</h5>

                                    <div class="input-group">
                                        <input type="Date" class="form-control" name="Date_achevement" value="<?php if(isset($rowg['Date_achevement'])){ echo $rowg['Date_achevement'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date de notification du contrat</h5>

                                    <div class="input-group">
                                        <input type="Date" class="form-control" name="Date_Notif_Contrat" value="<?php if(isset($rowg['Date_Notif_Contrat'])){ echo $rowg['Date_Notif_Contrat'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                             <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                     <h5>Mise en vigueur du contrat</h5>

                                    <div class="input-group">
                                        <input type="Date" class="form-control" name="Date_mis_vigueur" value="<?php if(isset($rowg['Date_mis_vigueur'])){ echo $rowg['Date_mis_vigueur'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Durée du contrat</h5>

                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Duree_contrat" value="<?php if(isset($rowg['Duree_contrat'])){ echo $rowg['Duree_contrat'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
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
                                      Modifier Contrat
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