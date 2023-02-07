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
                    <a href="?page=listsecteur">Liste des Secteurs </a>
                </li>
                <li class="active breadcrumb-item">Ajout d'un secteur </li>
            </ol>
        </div>
    </div>
</header>
<div class="outer">

<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                       Modifier secteur
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                        $rsg = $bdd->prepare('select * from table_secteur  WHERE id_section  =:zid  ');
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                          if (isset($_POST['ok'])){

                            
    try {

        //$dat = date("Y-m-d H:i:s");
        $rsql1 = $bdd->prepare('UPDATE  table_secteur SET  noms = :noms,  contacts = :contacts , emails = :emails,
                            sieges = :sieges,  nbrecs = :nbrecs,idfed = :idfed,datenrs = :datenrs ,id_modif = :id_modif WHERE id_section = :id ');
        //  print_r($rsql1);
        $tab = $rsql1->execute(array('noms' => $_POST['noms'],  'contacts' => $_POST['contacts'], 'emails' => $_POST['emails'], 'sieges' => $_POST['sieges'], 
            'nbrecs' => $_POST['nbrecs'],'idfed' => 
            $_POST['feder'],'datenrs' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'], 'id' =>$id ));
  } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listsecteur");

    }                   

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                             <br>
                            <h4 style="margin-top: 5px; margin-bottom: 10px">Modifier un secteur  </h4>
                            <hr>
                            <!--############################### -->
                             <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>FEDERATIONS </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="feder">
                                            <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                           $rscat = $bdd->prepare('select * from   table_federal  ORDER by nomf_f DESC ');
                                            $rscat->execute();
                                            while($rowcat = $rscat->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowcat['id_fed'] ?>" <?php if(isset($rowg['idfed']) && $rowg['idfed']==$rowcat['id_fed']){ echo "selected";} ?>><?php echo $rowcat['nomf_f'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                               
                                
                            </div>
                            <!--############################### -->
                           
                            <!--############################### -->
                            <div class="row">    
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Nom</h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="noms"  value="<?php if(isset($rowg['noms'])){ echo $rowg['noms'] ;}  ?>">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Contact</h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="contacts"  value="<?php if(isset($rowg['contacts'])){ echo $rowg['contacts'] ;}  ?>">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div>
                                                           
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Email</h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="emails"  value="<?php if(isset($rowg['emails'])){ echo $rowg['emails'] ;}  ?>">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div> 
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Siège</h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="sieges"  value="<?php if(isset($rowg['sieges'])){ echo $rowg['sieges'] ;}  ?>">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div> 
                               
                            </div>
                            <div class="row">                                
                               <div class="col-lg-6 input_field_sections">
                                    <h5>Nombre </h5>
                                    <div class="input-group">
                                    <input type="text" class="form-control" name="nbrecs"  value="<?php if(isset($rowg['nbrecs'])){ echo $rowg['nbrecs'] ;}  ?>">
                                    <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                    </span>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Logo Secteur</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="desig_sec" type="file"  class="file-loading"  style="display: block">

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
                                            Modifier 
                                        </button>
                                         <button class="btn btn-warning" type="reset" id="clear">
                                             <a  id="editable_table_new"  href="?page=listregions" style="color :white;">
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