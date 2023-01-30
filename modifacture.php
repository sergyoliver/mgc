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
                <i class="fa fa-table"></i>
              Liste des Factures
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
                    <a href="?page=milieu">Nouvelle Facture</a>
                </li>
                <li class="active breadcrumb-item"> Liste des Factures</li>
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
                       Modifier Enrolement
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                        $rsg = $bdd->prepare('select * from facture  WHERE id_Facture  =:zid  ');
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                          if (isset($_POST['ok'])){

                             try {
                               /// le numero d'ordre
                                    $Num_Facture=$rowg['Num_Facture'];
                                    $rsg = $bdd->prepare("select * from facture WHERE Num_Facture =:nf and Num_Facture <>'$Num_Facture'");
                                    $rsg->execute(array('nf'=>$_POST['Num_Facture']));
                                    $nb = $rsg->rowCount();
                                   
if ($nb==0){
    
        
    try {

        //$dat = date("Y-m-d H:i:s");
        $rsql1 = $bdd->prepare('UPDATE  facture SET  Num_Facture = :Num_Facture,  name_pers_transmi = :name_pers_transmi, Date_Transmission_F = :Date_Transmission_F,
                            Taux_Execution_financiere = :Taux_Execution_financiere,  Delai_Paiement_Facture = :Delai_Paiement_Facture, Mnt_Facture = :Mnt_Facture,  mntpaye = :mntpaye,  Id_Garantie = :Id_Garantie,Id_typep = :Id_typep,id_fournisseurs = :id_fournisseurs,datenrf = :datenrf,id_modif = :id_modif WHERE id_Facture = :id ');
        //  print_r($rsql1);
        $tab = $rsql1->execute(array('Num_Facture' => $_POST['Num_Facture'],  'name_pers_transmi' => $_POST['name_pers_transmi'], 'Date_Transmission_F' => $_POST['Date_Transmission_F'], 'Date_Transmission_F' => $_POST['Date_Transmission_F'], 
            'Taux_Execution_financiere' => $_POST['Taux_Execution_financiere'], 'Delai_Paiement_Facture' => $_POST['Delai_Paiement_Facture'], 'Mnt_Facture' => $_POST['Mnt_Facture'], 'mntpaye' => $_POST['mntpaye'], 'Id_Garantie' => $_POST['Id_Garantie'], 'Id_typep' => $_POST['Id_typep'], 'id_fournisseurs' => $_POST['id_fournisseurs'],'datenrf' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'], 'id' =>$id ));
  } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listfournisseurs");
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
                             <br>
                            <h4 style="margin-top: 5px; margin-bottom: 10px">Generer une Facture </h4>
                            <hr>
                             <div class="row">
                                        <div class="col-lg-6 input_field_sections">
                                            <h5>Selectionnez Projet</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" name="Id_typep" onchange="cartegrise(this.value)" >
                                                    <option selected value="0">Selectionnez</option>
                                                    <option value="1">C2D - Phase 2</option>
                                                    <option value="2">Mutation  ORM</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="col-lg-6 input_field_sections">
                                            <h5>Selectionnez  Fournisseurs</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" name="id_fournisseurs" onchange="cartegrise(this.value)" >
                                                    <option selected value="0">Selectionnez</option>
                                                    <option value="1">SGBCI</option>
    </option>
                                                        <option value="2">Mutation  ORM</option>
                                                    </select>
                                                </div>
                                            </div>
                                </div>
                                <div class="row">    
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Numero Facture
    </h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Num_Facture" value="<?php if(isset($rowg['Num_Facture'])){ echo $rowg['Num_Facture'] ;}  ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Nom Personne ayant transmis la facture</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name_pers_transmi" value="<?php if(isset($rowg['name_pers_transmi'])){ echo $rowg['name_pers_transmi'] ;}  ?>">
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="row">                            
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Date de transmission de la facture</h5>
                                        <div class="input-group">
                                            <input type="Date" class="form-control" name="Date_Transmission_F" value="<?php if(isset($rowg['Date_Transmission_F'])){ echo $rowg['Date_Transmission_F'] ;}  ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Taux d'exécution financière (%)  </h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Taux_Execution_financiere" value="<?php if(isset($rowg['Taux_Execution_financiere'])){ echo $rowg['Taux_Execution_financiere'] ;}  ?>">
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>                            
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Delai de paiement</h5>
                                        <div class="input-group">
                                            <input type="Date" class="form-control" name="Delai_Paiement_Facture" value="<?php if(isset($rowg['Delai_Paiement_Facture'])){ echo $rowg['Delai_Paiement_Facture'] ;}  ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                     <div class="col-lg-6 input_field_sections">
                                        <h5>Montant Facture </h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Mnt_Facture" value="<?php if(isset($rowg['Mnt_Facture'])){ echo $rowg['Mnt_Facture'] ;}  ?>" >
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>                             
                                <div class="row">
                                    <div class="col-lg-6 input_field_sections">
                                        <h5>Montant Payé</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mntpaye" value="<?php if(isset($rowg['mntpaye'])){ echo $rowg['mntpaye'] ;}  ?>">
                                            <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 input_field_sections">
                                                <h5>Type de Garantie</h5>
                                                <div class="input-group">
                                                    <select class="form-control chzn-select" name="Id_Garantie" onchange="cartegrise(this.value)" >
                                                        <option selected value="0">Selectionnez</option>
                                                        <option value="1">Garantie de restitution d'avance</option>
                                                        <option value="2">Mutation  ORM</option>
                                                    </select>
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
                                </div>
                                <!--<input type="text" id="ag" value="<?php //echo $_SESSION['id'] ?>">-->
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