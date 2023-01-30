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

<link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/scroller.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/colReorder.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/dataTables.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="css/pages/dataTables.bootstrap.css?d=<?php echo time() ?>" />
<!-- end of plugin styles -->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="css/pages/tables.css?d=<?php echo time() ?>" />
<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-table"></i>
              Liste des Projets soumis
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
                    <a href="?page=soumettrepnew">Nouvelle soumission</a>
                </li>
                <li class="active breadcrumb-item">Liste des Projets Soumis</li>
            </ol>
        </div>
    </div>
</header>
<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-success">
                        Faire une  recherche
                    </div>
                    <div class="card-block">

                        <div class="row">
                            <div class="col-lg-12 input_field_sections">
                                <h5>Projets</h5>
                                <div class="input-group">
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="projet" onchange="check_marche(this.value)" >
                                            <option value="-1"  hidden>Selectionner </option>
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

                            </div>

                            <div class="col-lg-6 input_field_sections">
                                <h5>Marché</h5>
                                <div class="input-group">
                                    <select class="form-control chzn-select" name="marche" id="marche" >
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-6 input_field_sections">
                                <h5>Fournisseurs</h5>
                                <div class="input-group">
                                    <select class="form-control chzn-select" name="camp" id="camp" >
                                        <option  value="all">Tous les fournisseurs</option>
                                        <?php
                                        $i=1;
                                        $rsan = $bdd->prepare("select * from fournisseurs ");
                                        $rsan->execute();
                                        while($rowan = $rsan->fetch()) {
                                            ?>
                                            <option value="<?php echo $rowan['id_fournisseurs'] ?>"><?php if (!empty($rowan['Name_entreprise'])) { echo $rowan['Name_entreprise']; }else{ echo $rowan['nom_rep']; } ?></option>

                                        <?php }  ?>

                                    </select>
                                </div>

                            </div>

                            <div class="col-lg-12 input_field_sections">
                                <h5>&nbsp;</h5>
                                <div class="input-group">
                                    <a href="javascript:void (0)" class="btn btn-primary"  name="ok" onclick="affiche_postulants()">
                                        <i class="fa fa-user"></i>
                                        Rechercher
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">

                <div class="card m-t-35">
                        <div class="card-header bg-white">
                            <i class="fa fa-table"></i> Listes des Postulants
                        </div>
                        <div class="card-block m-t-35">
                            <div class="btn-group" style="margin-bottom: 10px;">    
                                        <a href="?page=soumettrepnew" id="editable_table_new" class=" btn btn-default">
                                        Postuler à  un Projet  &nbsp;<i class="fa fa-plus" ></i>
                                        </a>                                     
                                </div>

                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date Soumission</th>
                                    <th>Projet</th>
                                    <th>Marché</th>
                                    <th>Fournisseurs</th>

                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                              <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from type_projet,tab_depot,fournisseurs,tab_projet WHERE type_projet.Id_typep = tab_depot.id_projet and tab_depot.id_fournisseurs=fournisseurs.id_fournisseurs and tab_projet.id_projet=tab_depot.idmarche ORDER by id_depot ASC ');
                                $rsg->execute(array());
                                while($rowg = $rsg->fetch()) {
                                ?>

                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo format_date($rowg['date_soumss']); ?></td>
                                    <td><?php echo $rowg['Nom_Projet']; ?></td>
                                    <td><?php echo $rowg['Intitule_Contrat'] ?></td>
                                    <td><?php if (empty( $rowg['Name_entreprise'])){  echo $rowg['nom_rep']; }else{ echo $rowg['Name_entreprise']; } ?></td>


                                    <td>

                                        
                                            <a href="?page=modifsoumiss&id=<?php echo $rowg['id_depot']; ?>" class="todoedit">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <span class="dividor">|</span>
                                            <a href="#" class="tododelete redcolor">
                                                <span class="fa fa-trash"></span>
                                            </a>

                                    </td>
                                </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/components.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
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