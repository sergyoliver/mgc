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
                    <a href="?page=listfournisseurs">Liste des fournisseurs</a>
                </li>
                <li class="active breadcrumb-item">Ajouter nouveau fournisseur</li>
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
                        Ajouter un nouveau fournisseur
                    </div>
                    <div class="card-block">
                        <?php
                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                            $rsa = $bdd->prepare("select * from  tab_projet  WHERE id_projet  = :zid");
                            //var_dump($id);
                            $rsa->execute(array("zid"=>$_GET['id']));
                            $rowg = $rsa->fetch();



                        }
                      
                        if (isset($_POST['ok'])){

                           
   
    try {
         $prest =  implode(",",$_POST['prest']);
        $rsql1 = $bdd->prepare('UPDATE  tab_projet SET  typeprojet = :typeprojet,idtypre = :idtypre,  idprest = :idprest,Num_Contrat = :Num_Contrat,  Intitule_Contrat = :Intitule_Contrat,Mnt_passation = :Mnt_passation,Methode_passation = :Methode_passation, typemarche =:typemarche,  typerevue = :typerevue,Datedebut = :Datedebut,Datefin = :Datefin,datenr = :datenr,id_modif = :id_modif WHERE id_projet =:id');                                   
         $nomtab10 = "tab_projet";
         $tab10 = $rsql1->execute(array('typeprojet' => $_POST['catprojet'],'idtypre' => $_POST['idtypre'],'idprest' => $prest,'Num_Contrat' => $_POST['Num_Contrat'],'Intitule_Contrat' => $_POST['Intitule_Contrat'],'Mnt_passation' => $_POST['Mnt_passation'],'Methode_passation' => $_POST['methodep'],'typemarche' => $_POST['typecontrat'],'typerevue' => $_POST['typerevue'],'Datedebut' => formatinv_date($_POST['Datedebut']),'Datefin' => formatinv_date($_POST['Datefin']),'datenr' => gmdate("Y-m-d H:i:s"),'id_modif' => $_SESSION['id'],'id' => $id));
       
    } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listprojets");


                               



                        }
                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Catégorie de projets</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="catprojet" >
                                            <option value="0">Selectionner </option>
                                          <?php 
                                         $i=1;
                                            $rscat = $bdd->prepare('select * from   type_projet  ORDER by Nom_Projet DESC ');
                                            $rscat->execute();
                                            while($rowcat = $rscat->fetch()) {
                                                ?>
                                            <option value="<?php echo $rowcat['Id_typep'];?>" <?php if(isset($rowg['typeprojet']) && $rowg['typeprojet']==$rowcat['Id_typep']){ echo "selected";} ?>>    
                                        <?php  


                                        echo $rowcat['Nom_Projet']; ?>      
                                            </option>

                                             <?php }  ?>

                                          ?>
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-lg-4 input_field_sections">
                                    <h5>Type de Prestation</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="idtypre" onchange="cache(this.value)">
                                        <option value="0" selected hidden>Selectionner un type</option>
                                            <?php 
                                         $i=1;
                                        $rst = $bdd->prepare('select * from   type_prestation  ORDER by type_prest DESC ');
                                            $rst->execute();
                                            while($rowf = $rst->fetch()) {
                                                ?>
                                        <option value="<?php echo $rowf['id'];?>" <?php if(isset($rowg['idtypre']) && $rowg['idtypre']==$rowf['id']){ echo "selected";} ?>>    
                                        <?php  echo $rowf['type_prest']; ?>      
                                        </option>

                                             <?php }  ?>

                                          ?>                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Prestations</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="prest[]" id="Presta" multiple >
                                            <option selected disabled>Selectionner une Prestation</option>
                                         <?php
                                                $i=1;
                                                $rss = $bdd->prepare('select * from   prestations  ORDER by libprestation DESC ');
                                                $rss->execute();
                                                while($rowz= $rss->fetch()) {
                                                    ?>
                                            <option value="<?php echo $rowz['idprest'] ?>" <?php
                                                $tb2 = explode(',',$rowg['idprest']);
                                                    foreach ($tb2 as $v){
                                                        if ($v==$rowz['idprest']){echo  'selected'; }
                                                    }
                                                    ?>>
                                                    <?php echo $rowz['libprestation'] ?> 
                                            </option>

                                                <?php }  ?>
                                            

                                        </select>
                                    </div>
                                </div>
                               
                            </div> 
                            <div class="row">
                                <?php //var_dump($rowg['Num_Contrat'] ;?>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Numéro du Marché / contrat</h5>
                                    <div class="input-group">
                                        
                                        <input type="text" class="form-control" name="Num_Contrat" value="<?php if(isset($rowg['Num_Contrat'])){ echo $rowg['Num_Contrat'] ;} 
                                        //var_dump($rowg['Num_Contrat']);
                                         ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6 input_field_sections">
                                     <h5>Intitulé du Marché / Contrat</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Intitule_Contrat" value="<?php if(isset($rowg['Intitule_Contrat'])){ echo $rowg['Intitule_Contrat'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file  text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Montant prévu au PPM </h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="Mnt_passation" style="background-color: rgba(255,118,22,0.13); font-weight: bold" value="<?php if(isset($rowg['Mnt_passation'])){ echo $rowg['Mnt_passation'] ;}  ?>" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                                <option value="<?php echo $rowmp['idmeth'] ?>" <?php if(isset($rowg['Methode_passation']) && $rowg['Methode_passation']==$rowmp['idmeth']){ echo "selected";} ?>>
                                            <?php echo $rowmp['lib_methode'] ?>
                                                    
                                                </option>

                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de marché </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typecontrat" >
                                        <option value="-1" selected hidden
                                            <?php if(isset($rowg['typemarche']) && $rowg['typemarche']=="0"){ echo "selected";} ?>
                                            >Selectionner 
                                        </option>
                                        <option value="Biens" <?php if(isset($rowg['typemarche']) && $rowg['typemarche']=="Biens"){ echo "selected";} ?>>

                                           Biens
                                       </option>
                                        <option value="Travaux" <?php if(isset($rowg['typemarche']) && $rowg['typemarche']=="Travaux"){ echo "selected";} ?> >
                                           Travaux
                                       </option>
                                       <option value="Consultants" <?php if(isset($rowg['typemarche']) && $rowg['typemarche']=="Consultants"){ echo "selected";} ?> >Consultants
                                        </option>
                                        <option value="Autres"<?php if(isset($rowg['typemarche']) && $rowg['typemarche']=="Autres"){ echo "selected";} ?> >

                                           Autres
                                       </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 input_field_sections">
                                    <h5>Type de revue </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typerevue" >
                                            <option value="-1" selected hidden>Selectionner </option>
                                           <option value="A Posteriori" <?php if(isset($rowg['typerevue']) && $rowg['typerevue']=="A Posteriori"){ echo "selected";} ?>>A Posteriori</option>
<!--                                           <option value="A Posteriori">A Posteriori</option>-->
                                           <option value="Autres" <?php if(isset($rowg['typerevue']) && $rowg['typerevue']=="Autres"){ echo "selected";} ?>>
                                           Autres</option>
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
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="Datedebut" value="<?php if(isset($rowg['Datedebut'])){ echo $rowg['Datedebut'] ;}  ?>">
                                    </div>
                                </div>
                                  <div class="col-lg-6 input_field_sections">
                                    <h5> Date Fin</h5>

                                      <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                          <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="Datefin" value="<?php if(isset($rowg['Datefin'])){ echo $rowg['Datefin'] ;}  ?>">
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
                                       Modifier Projet
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
    function affiche(str) {
        // console.log($('input[name=type]:checked').val());

        if (str == "Entreprise") {
            $('#entreprise').removeAttr('style');
            $('#individuel').css("display", "none");
        } else {
            $('#individuel').removeAttr('style');
            $('#entreprise').css("display", "none");
        }
    }
</script>
