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

<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-pencil"></i>
               Formulaire de mise à jour
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
                    <a href="?page=listsoumission">Liste des Soumissions</a>
                </li>
                <li class="active breadcrumb-item">Soumissioner à un marché</li>
            </ol>
        </div>
    </div>
</header>
<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-success">
                       Soumissionner à un marché
                    </div>
                    <div class="card-block">
                        <?php
                         
                         $id =$_GET['id'];
                         $rsa = $bdd->prepare("select * from  tab_depot  WHERE id_depot  = :zid");
                            //var_dump($id);
                         $rsa->execute(array("zid"=>$_GET['id']));
                         $rowp = $rsa->fetch();
                          if (isset($_POST['ok'])){
                          $soumiss = formatinv_date($_POST['date_soumss']);

                            try {
                                $rsql1 = $bdd->prepare('UPDATE  tab_depot SET  id_projet = :id_projet,idmarche = :idmarche,  id_fournisseurs = :id_fournisseurs,nom_deposant = :nom_deposant,  contact = :contact,date_soumss = :date_soumss,datemodif = :datemodif,id_modif = :id_modif,coutoffre= :coutoffre WHERE id_depot =:id');
                                //$nomtab102 = "tab_depot";
                                $tab10 = $rsql1->execute(array('id_projet' => $_POST['catprojet'],'idmarche' => $_POST['marche'],'id_fournisseurs' => $_POST['id_fournisseurs'],'nom_deposant' => $_POST['nomp'],'contact' => $_POST['tel'],'date_soumss' =>$soumiss  , 'datemodif' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'coutoffre' => $_POST['coffre'],'id' => $_GET['id']));
                                
                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                      header("location:?page=listsoumission");
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
                                                <option value="<?php echo $rowcat['Id_typep'] ?>" <?php if ($rowp['id_projet']==$rowcat['Id_typep']){echo  'selected'; } ?>><?php echo $rowcat['Nom_Projet'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Marché</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="marche" id="marche" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $rsg = $bdd->prepare('select * from   tab_projet WHERE typeprojet = :tp');
                                            $rsg->execute(array("tp"=>$rowp['id_projet']));
                                            ?>

                                            <?php
                                            while($rowg = $rsg->fetch()) {

                                                ?>
                                                <option value="<?php echo $rowg['id_projet'] ?>"  <?php if ($rowp['idmarche']==$rowg['id_projet']){echo  'selected'; } ?>><?php echo $rowg['Num_Contrat'].'-'.$rowg['Intitule_Contrat'] ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Fournisseurs</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="id_fournisseurs" >
                                            <option selected disabled>Selectionner un Fournisseur</option>
                                           <?php 
                                         $i=1;
                                            $rscag = $bdd->prepare('select * from   fournisseurs  ORDER by Name_entreprise DESC ');
                                            $rscag->execute();
                                            while($rowc = $rscag->fetch()) {
                                                ?>
                                            <option value="<?php echo $rowc['id_fournisseurs'];?>" <?php
                                                $tb2 = explode(',',$rowp['id_fournisseurs']);
                                                    foreach ($tb2 as $v){
                                                        if ($v==$rowc['id_fournisseurs']){echo  'selected'; }
                                                    }
                                                    ?>>    
                                        <?php  


                                        echo $rowc['Name_entreprise']; ?>      
                                            </option>

                                             <?php }  ?>

                                          ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 input_field_sections">
                                   
                                    <h5>Date soumission</h5>
                                     
                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="date_soumss" value="<?php if ($rowp['date_soumss']) { echo format_date($rowp['date_soumss']); } ?>">
                                        
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">

                                    <h5>Nom et prénoms du déposant</h5>

                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                            </span>
                                        <input  type="text" class="form-control" placeholder="" id="nomp" name="nomp" value="<?php if ($rowp['nom_deposant']) { echo $rowp['nom_deposant']; } ?>" >

                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">

                                    <h5>Contacts du déposant</h5>

                                    <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-phone text-primary"></i>
                                            </span>
                                        <input  type="text" class="form-control" placeholder="" id="tel" name="tel" value="<?php if ($rowp['contact']) { echo $rowp['contact']; } ?>">

                                    </div>
                                </div>

                            </div>
                             <div class="row">

                                 <div class="col-lg-6 input_field_sections">

                                     <h5>Montant de l'offfre</h5>

                                     <div class="input-group">
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                            </span>
                                         <input  type="text" class="form-control" placeholder="" id="coffre" name="coffre" style="background-color: rgba(251,199,44,0.54); font-weight: bold; font-size: 16px"  value="<?php if ($rowp['coutoffre']) { echo $rowp['coutoffre']; } ?>" >

                                     </div>
                                 </div>


                             </div>
                            
                            <!-- ################################### -->
                           
                            <!-- -->
                            <br>
                             <hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" type="submit" name="ok">
                                            <i class="fa fa-user"></i>
                                            Soumettre
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
