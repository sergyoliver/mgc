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
                    <a href="?page=listfournisseursInd">Liste des Fournisseurs</a>
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
                       Modifier Les Donnees du Fournisseur
                    </div>
                    <div class="card-block">
                        <?php
                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                         $rsg = $bdd->prepare("select * from tab_fournisseursindiv  WHERE id_indiv= :zid");
                         //var_dump($id); 
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                        if (isset($_POST['ok'])){

                            /*  try {
                                    //                            $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , datecon, statconn) VALUES(:ipadress, :log, :datc, :statc)');
                                    //                            $rs3->execute(array('ipadress' => get_ip(), 'log' => $log ,'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));


                               le numero d'ordre
                                    $Num_Registre_com=$rowg['nom'];
                                    $rsg = $bdd->prepare("select * from tab_fournisseursindiv WHERE nom =:nd and nom <>'$nom'");
                                    $rsg->execute(array('nd'=>$_POST['nom']));
                                    $nb = $rsg->rowCount();
                                    //$identite = $_POST['nom']." ".$_POST['pnom'];

                        
if ($nb==0){*/
   
    try {

                            $rsql1 = $bdd->prepare('UPDATE  tab_fournisseursindiv SET nom= :nom, phoneind = :phoneind,adresseEind = :adresseEind, adressPind = :adressPind,situationgeoind = :situationgeoind,descind = :descind,  persressourceind =:persressourceind,siteind = :siteind,datenr = :datenr,id_modif = :id_modif WHERE id_indiv =:id');
                            $tab = $rsql1->execute(array('nom' => $_POST['nom'],'phoneind' => $_POST['phoneind'], 'adresseEind' => $_POST['adresseEind'],'adressPind' => $_POST['adressPind'],'situationgeoind' => $_POST['situationgeoind'],'descind' => $_POST['descind'],'persressourceind' => $_POST['persressourceind'],'siteind' => $_POST['siteind'], 'datenr' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' =>$id));

    } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listfournisseursInd");
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
                                    <h5>Nom Entreprise</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nom" value="<?php if(isset($rowg['nom'])){ echo $rowg['nom'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">
                                    <h5>Situation géographique*</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="situationgeoind" value="<?php if(isset($rowg['situationgeoind'])){ echo $rowg['situationgeoind'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                 
                            </div>
                            <!-- ################################### -->
                          
                            <!-- ##################################### -->
                          
                            <!-- ##################################### -->

                             <div class="row">
                               

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Telephone</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="phoneind" value="<?php if(isset($rowg['phoneind'])){ echo $rowg['phoneind'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse électronique</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="adresseEind" value="<?php if(isset($rowg['adresseEind'])){ echo $rowg['adresseEind'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ##################################### -->
                             <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Site Web</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="siteind" value="<?php if(isset($rowg['siteind'])){ echo $rowg['siteind'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Adresse Postale</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="adressPind" value="<?php if(isset($rowg['adressPind'])){ echo $rowg['adressPind'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                               
                            </div>
                            <!-- ##################################### -->
                             <div class="row">
                                

                                 <div class="col-lg-6 input_field_sections">
                                    <h5>Personne à Contacter (Nom,Tél,Adresse électronique)</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="persressourceind" value="<?php if(isset($rowg['persressourceind'])){ echo $rowg['persressourceind'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ##################################### -->
                           <!-- ##################################### -->
                           <div class="row">
                            <center>
                            <div  class="col-lg-12 input_field_sections">
                                <h3>References</h3>
                                <div class="form-group">
                                    <textarea id="summernote"  name="descind" rows="10" cols="100">
                                           
                                    <?php if(isset($rowg['descind'])){ echo $rowg['descind'] ;}  ?>
                                    </textarea>
                                </div>
                            </div></center>
                        </div>

                        <hr>

                            <!-- ######################################-->
                            
                            <br>
                            <hr />
                            <div class="row">
                                <div class="col-lg-7 input_field_sections"></div>
                                <div class="col-lg-5 push-lg-2">
                                    <button class="btn btn-primary" type="submit" name="ok">
                                        <i class="fa fa-user"></i>
                                       Modifier Fournisseur
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