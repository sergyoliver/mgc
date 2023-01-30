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
                    <a href="?page=listprojets">Liste des Projets</a>
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
                    <div class="card-header bg-white">
                       Ajouter un nouveau Projet
                    </div>
                    <div class="card-block">
                       <?php
                        if (isset($_POST['ok'])){

                            $rs21 = $bdd->prepare('select * from tab_projet');
                            $rs21->execute();
                            $nbre2 = $rs21->rowCount();
                            $numpro = "PP-".numauto($nbre2+1);


                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');
                            $prest =  implode(",",$_POST['prest']);
                            $debut = formatinv_date($_POST['Datedebut']);
                            $fin = formatinv_date($_POST['Datefin']); 
                            try {
                                $nomtab102 = "tab_projet";
                                $tab102 = array('typeprojet' => $_POST['catprojet'],'idtypre' =>$prest ,'idprest' => $_POST['idtypre'],'Num_Contrat' => $_POST['Num_Contrat'],'Intitule_Contrat' => $_POST['Intitule_Contrat'],'Mnt_passation' => $_POST['Mnt_passation'],'Methode_passation' => $_POST['methodep'],'typemarche' => $_POST['typecontrat'],'typerevue' => $_POST['typerevue'],'Datedebut' => $debut,'Datefin' => $fin,'datenr' => gmdate("Y-m-d H:i:s"),'id_ajout' => $_SESSION['id'],'numpro' => $numpro);
                                var_dump($tab102);
                                $sql = insert_tab($nomtab102, $tab102);
                                $sql->execute($tab102);
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
                                    <h5>Catégorie de projets</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="catprojet" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                            <?php
                                            $i=1;
                                            $rscat = $bdd->prepare('select * from   type_projet  ORDER by Nom_Projet DESC ');
                                            $rscat->execute();
                                            while($rowcat = $rscat->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowcat['Id_typep'] ?>"><?php echo $rowcat['Nom_Projet'] ?></option>

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
                                            ?>
                                                

                                            
                                            <option value="<?php echo $rowg['id'] ?>"><?php echo $rowg['type_prest'] ?></option>
                                            
                                            <?php }  ?>                                          
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-lg-8 input_field_sections">
                                    <h5>Prestations</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="prest[]" id="Presta" multiple >
                                            <option selected disabled>Selectionner une Prestation</option>

                                            

                                        </select>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Numéro du Marché / contrat</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Num_Contrat" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                     <h5>Intitulé du Marché / Contrat</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Intitule_Contrat" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Montant prévu au PPM </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_passation" style="background-color: rgba(255,118,22,0.13); font-weight: bold" >
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
                                            <option value="default" selected hidden>Selectionner un type</option>
                                            <?php
                                            $i=1;
                                            $rsmp = $bdd->prepare('select * from   table_methode_passation  ORDER by lib_methode DESC ');
                                            $rsmp->execute();
                                            while($rowmp = $rsmp->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowmp['idmeth'] ?>"><?php echo $rowmp['lib_methode'] ?></option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de marché </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typecontrat" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                           <option value="Biens">Biens</option>
                                           <option value="Travaux">Travaux</option>
                                           <option value="Consultants">Consultants</option>
                                           <option value="Autres">Autres</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de revue </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typerevue" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                           <option value="A Priori">A priori</option>
                                           <option value="A Posteriori">A Posteriori</option>
<!--                                           <option value="A Posteriori">A Posteriori</option>-->
                                           <option value="Autres">Autres</option>
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
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="Datedebut">
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">
                                    <h5> Date Fin</h5>

                                      <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                          <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="Datefin">
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
