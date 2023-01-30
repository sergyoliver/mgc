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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <a href="?page=listprojets">Liste des marches</a>
                </li>
                <li class="active breadcrumb-item">Modifier</li>
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
                      Modifier marché
                    </div>
                    <div class="card-block">
                       <?php
                       if (isset($_GET['id'])){
                           $id =$_GET['id'];
                           $rsa = $bdd->prepare("select * from tab_projet  WHERE id_projet= :zid");
                           //var_dump($id);
                           $rsa->execute(array("zid"=>$_GET['id']));
                           $rowa = $rsa->fetch();

                       }
                        if (isset($_POST['ok'])){




                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');
                            $prest =  implode(",",$_POST['prest']);
                            $debut = formatinv_date($_POST['Datedebut']);
                            $fin = formatinv_date($_POST['Datefin']); 
                            try {


                                $rsql2 = $bdd->prepare('UPDATE  tab_projet SET typeprojet = :typeprojet,idtypre = :idtypre,  idprest = :idprest, Num_Contrat = :Num_Contrat, Intitule_Contrat = :Intitule_Contrat,Mnt_passation = :Mnt_passation,Methode_passation = :Methode_passation,typemarche = :typemarche,typerevue = :typerevue, Datedebut = :Datedebut,Datefin = :Datefin,datemodif = :datemodif,id_modif = :id_modif WHERE id_projet =:id');
                                $tab2 = $rsql2->execute( array('typeprojet' => $_POST['catprojet'],'idtypre' =>$prest ,'idprest' => $_POST['idtypre'],'Num_Contrat' => $_POST['Num_Contrat'],'Intitule_Contrat' => $_POST['Intitule_Contrat'],'Mnt_passation' => $_POST['Mnt_passation'],'Methode_passation' => $_POST['methodep'],'typemarche' => $_POST['typecontrat'],'typerevue' => $_POST['typerevue'],'Datedebut' => $debut,'Datefin' => $fin,'datemodif' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' => $id));

                            }

                            catch (Exception $e) {
                                die("Erreur ! " . $e->getMessage());
                            }

                     header("location:?page=listprojets");
                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12 input_field_sections">
                                    <h5>Projets</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="catprojet" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                            $rscat = $bdd->prepare('select * from   type_projet  ORDER by Nom_Projet DESC ');
                                            $rscat->execute();
                                            while($rowcat = $rscat->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowcat['Id_typep'] ?>" <?php if ($rowcat['Id_typep']==$rowa['typeprojet']){echo  'selected'; } ?> ><?php echo $rowcat['Nom_Projet'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Type de Prestation</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="idtypre" onchange="cache(this.value)">
                                            <option value="default" selected hidden>Selectionner un type</option>                                            
                                            <?php
                                            $i=1;
                                            $rsg = $bdd->prepare('select * from   type_prestation  ORDER by type_prest DESC ');
                                            $rsg->execute();
                                            while($rowg = $rsg->fetch()) {
                                            ?><option value="<?php echo $rowg['id'] ?>" <?php if ($rowg['id']==$rowa['idprest']){echo  'selected'; } ?> ><?php echo $rowg['type_prest'] ?></option>
                                            
                                            <?php }  ?>                                          
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-lg-8 input_field_sections">
                                    <h5>Prestations</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="prest[]" id="Presta" multiple >
                                            <option  disabled>Selectionner une Prestation</option>
                                            <?php
                                            $i=1;
                                            $rsg1 = $bdd->prepare('select * from   prestations WHERE idtype_prest = :t ORDER by libprestation DESC ');
                                            $rsg1->execute(array("t"=>$rowa['idprest']));
                                            while($rowg2 = $rsg1->fetch()) {
                                            ?>
                                                <option value="<?php echo $rowg2['idprest'] ?>" <?php
                                                $tb2 = explode(',',$rowa['idtypre']);
                                                foreach ($tb2 as $v){
                                                    if ($v==$rowg2['idprest']){echo  'selected'; }
                                                }
                                                ?> ><?php echo $rowg2['libprestation'] ?></option>

                                            <?php }  ?>
                                            

                                        </select>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Numéro du Marché </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Num_Contrat" value="<?php if ($rowa['Num_Contrat']) { echo $rowa['Num_Contrat']; } ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                     <h5>Intitulé du Marché / Contrat</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Intitule_Contrat" value="<?php if ($rowa['Intitule_Contrat']) { echo $rowa['Intitule_Contrat']; } ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Montant prévu au PPM </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_passation" style="background-color: rgba(255,118,22,0.13); font-weight: bold"   value="<?php if ($rowa['Mnt_passation']) { echo $rowa['Mnt_passation']; } ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################ -->
                            <div class="row">
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Méthode de passation</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="methodep" >
                                            <option value="default"  hidden>Selectionner un type</option>
                                            <?php
                                            $i=1;
                                            $rsmp = $bdd->prepare('select * from   table_methode_passation  ORDER by lib_methode DESC ');
                                            $rsmp->execute();
                                            while($rowmp = $rsmp->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowmp['idmeth'] ?>"  <?php if ($rowmp['idmeth']==$rowa['Methode_passation']){echo  'selected'; } ?>><?php echo $rowmp['lib_methode'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de marché </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typecontrat" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                           <option  value="Biens"  <?php if ($rowa['typemarche']=='Biens'){echo  'selected'; } ?> >Biens</option>
                                           <option value="Travaux"  <?php if ($rowa['typemarche']=='Travaux'){echo  'selected'; } ?> >Travaux</option>
                                           <option value="Consultants"  <?php if ($rowa['typemarche']=='Consultants'){echo  'selected'; } ?> >Consultants</option>
                                           <option value="Autres"  <?php if ($rowa['typemarche']=='Autres'){echo  'selected'; } ?> >Autres</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de revue </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typerevue" >
                                            <option value="-1"  hidden>Selectionner </option>
                                            <option value="A Priori"  <?php if ($rowa['typerevue']=='A priori'){echo  'selected'; } ?>>A Priori</option>
                                           <option value="A Posteriori"  <?php if ($rowa['typerevue']=='A Posteriori'){echo  'selected'; } ?>>A Posteriori</option>
<!--                                           <option value="A Posteriori">A Posteriori</option>-->
                                           <option value="Autres"  <?php if ($rowa['typerevue']=='Autres'){echo  'selected'; } ?>>Autres</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                            <!-- ################################ -->

                            <!-- ################################## -->
                            <div class="row">                              

                                <div class="col-lg-6 input_field_sections">
                                    <h5>Date de debut </h5>

                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="Datedebut" value="<?php if ($rowa['Datedebut']) { echo format_date($rowa['Datedebut']); } ?>">
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">
                                    <h5> Date Fin</h5>

                                      <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                          <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="Datefin" value="<?php if ($rowa['Mnt_passation']) { echo format_date($rowa['Datefin']); } ?>">
                                      </div>
                                </div>
                            </div>
                            <!-- ################################## -->
                            
                            <!-- ################################## -->
                             
                            <!-- ################################## -->

                           
                            <br>
                            <hr />
                            <div class="form-group row">
                                <div class="col-lg-7 input_field_sections"></div>
                                <div class="col-lg-5 push-lg-2">
                                    <button class="btn btn-primary" type="submit" name="ok">
                                        <i class="fa fa-user"></i>
                                       Ajouter Projet
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

<script type="text/javascript">
  
function cache(str) {
        //il fait la mise a jour du prix de base et l'observation

        var xhr2;
        var form_data2 = new FormData();
        form_data2.append("idtypre", str);

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "traite.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {

                document.getElementById("Presta").innerHTML = this.responseText;
                $("#Presta").trigger("chosen:updated");

            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
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
