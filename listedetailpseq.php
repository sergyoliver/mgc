<?php

    if (isset($_GET['id'])) {
       $id = $_GET['id'];

        $reqsep = $bdd->prepare('select * from table_chronogramme where id_seqchrono=:idsq and supp=0');
        $reqsep->execute(array('idsq' => $id));




        $st1 = $bdd->prepare('select sum(stat) as s from table_detailseqchrono where id_dseq=:it and supp=0');
        $st2 = $bdd->prepare('select * from table_detailseqchrono where id_dseq=:it and supp=0');
        $st1->execute(array('it' => $id));
        $st2->execute(array('it' => $id));
        $rowstt1 = $st1->fetch();
        $nbst = $st2->rowCount();
        $nbrst1 = $rowstt1['s'];

        $rowseq = $reqsep->fetch();

        $reqcontrat = $bdd->prepare('select * from tab_projet,contrat,type_projet where type_projet.Id_typep=tab_projet.typeprojet and  contrat.idmarche=tab_projet.id_projet and id_Contrat = :idc');
        $reqcontrat->execute(array('idc' => $rowseq['idcontrat']));
        $rowcontrat = $reqcontrat->fetch();

        $reqfour = $bdd->prepare('select * from fournisseurs where   id_fournisseurs = :idf');
        $reqfour->execute(array('idf' => $rowcontrat['id_fournisseurs']));
        $rowf = $reqfour->fetch();

        $db = format_date2($rowseq['date_debut']);
        $df = format_date2($rowseq['date_fin']);
    }
    ?>
    <!-- global styles-->
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" />
    <!--End of plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="vendors/chosen/css/chosen.css" />
    <link type="text/css" rel="stylesheet" href="vendors/jquery-tagsinput/css/jquery.tagsinput.css" />
    <link type="text/css" rel="stylesheet" href="vendors/daterangepicker/css/daterangepicker.css" />
    <link type="text/css" rel="stylesheet" href="vendors/datepicker/css/bootstrap-datepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="css/pages/form_elements.css" />
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
                   Repertoire des tâche du planning
                </h4>
            </div>
            <div class="col-sm-7 col-lg-6">
                <ol class="breadcrumb float-xs-right nav_breadcrumb_top_align">
                    <li class="breadcrumb-item">
                        <a href="?page=milieu">
                            <i class="fa fa-home" data-pack="default" data-tags=""></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="?page=listeplanning">
                            Liste des planning
                        </a>
                    </li>


                    <li class="active breadcrumb-item">Détails Chronogramme </li>
                </ol>

            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="row bg-white mb-2">
                <div class="col-md-12 col-lg-12 p-2">
                    <div class="image_text">
                        <div class="float-xs-left">
                            <h4>Projet : <span class="text-primary"> <?php echo $rowcontrat['Nom_Projet'] ?></span></h4>
                            <h5>Marché : <span class="text-warning"><?php echo $rowcontrat['Num_Contrat']." / ".$rowcontrat['Intitule_Contrat'] ?> </span></h5>
                            <h5>Fournisseur : <span class="text-primary"> <?php if(empty($rowf['Name_entreprise'])) echo $rowf['nom_rep']; else echo $rowf['Name_entreprise']; ?> </span></h5>
                            <span><?php
                                echo "<span class='mb-0'>Du " . format_date2($rowseq['date_debut']) . " Au " . format_date2($rowseq['date_fin']) ."</span> ";
                                $jrs_all=  NbJours($rowseq['date_debut'],$rowseq['date_fin']);
                                $jrs_reste = ($jrs_all%30);
                                $nmois = floor ($jrs_all/30);
                                if (isset($rowseq['date_debut'])){
                                    if ($nmois==0) {
                                        echo "<span class='text-danger'>(" .$jrs_reste." jrs)</span>";
                                    } else {
                                        echo "<span class='text-danger'>(" . $nmois." mois ".$jrs_reste." jrs)</span>";
                                    }
                                }
                                ?></span>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-t-35">
                        <div class="card-header bg-white">
                            <i class="fa fa-table"></i> Detail planning d'exécution

                        </div>
                        <div class="card-block m-t-35" id="retour">
                            <table class="display table table-stripped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Designation tâche</th>
                                        <th>Durée</th>
                                        <th>Progression</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                $i = 1;
                                $reqdt = $bdd->prepare('select max(date_fin) as df, min(date_debut) as db, stat,tache,codepl from table_detailseqchrono where id_pl= :ids and supp=0  GROUP BY tache order by tache ASC');
                                $reqdt->execute(array('ids' => $id));
                                while ($rowg = $reqdt->fetch()) {
                                    $reqt = $bdd->prepare('select * from  table_detailseqchrono t2 where t2.supp=0 and  t2.tache=:idt and id_pl= :ids  ORDER BY tache ASC');
                                    $reqt->execute(array('idt' => $rowg['tache'],'ids' => $id));
                                    $rowt = $reqt->fetch();
                                    ?>
                                    <tr style="background-color: #ebebeb;">
                                        <td><?php echo $i; ?></td>
                                        <td><b style="font-size: 14pt;"><?php echo strtoupper($rowt['tache']); ?></b></td>
                                        <td>
                                            <?php
                                            //
                                            echo "<p class='mb-0'>Du " . format_date2($rowg['db']) . " Au " . format_date2($rowg['df']) ."</p>";
                                            $jrs_all=  NbJours($rowg['db'],$rowg['df']);
                                            $jrs_reste = ($jrs_all%30);
                                            $nmois = floor ($jrs_all/30);
                                            if (isset($rowg['db'])){
                                                if ($nmois==0) {
                                                    echo "<span class='text-danger'>(" .$jrs_reste." jrs)</span>";
                                                } else {
                                                    echo "<span class='text-danger'>(" . $nmois." mois ".$jrs_reste." jrs)</span>";
                                                }
                                            } if (strtotime($db) > strtotime($rowg['db']) && strtotime($db) < strtotime($rowg['df'])) { ?>
                                                <br> <span class="text-warning" role="button" data-toggle="tooltip" data-placement="top" title="Incohérense de date avec celle de l'objectif !" data-original-title="Edit" style="font-size: 1.5rem"><i class="fa fa-exclamation-triangle"></i></span>
                                            <?php } ?>
                                        </td>
                                        <td style="font-size: 22px;font-weight: bold"><?php echo strtoupper($rowt['tauxrep']).'%'; ?></td>
                                        <td>
                                            <?php
                                            $eval = $bdd->prepare('select * from table_evaluation WHERE iddetail=:d');
                                            $eval->execute(array("d" => $rowt['id_dseq']));
                                            $nbreev =   $eval->rowCount();
                                            if ($nbreev==0) {
                                                ?>
                                                <button data-target="#modifpseq" class="btn btn-success"
                                                        data-toggle="modal"
                                                        onclick="evaluer('<?php echo $rowt['codepl']; ?>')">
                                                    <span class="fa fa-pencil"></span> Evaluer
                                                </button>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <?php   if ($nbreev==0) {}else{
                                        $rowevaluation =   $eval->fetch();
                                        ?>
                                    <tr style="background-color: green; color: white;font-style: italic">

                                        <td colspan="2"><?php echo $rowevaluation['rapport']; ?></td>
                                        <td colspan="2"><?php
                                            echo "<p class='mb-0'>Du " . format_date2($rowevaluation['datedb']) . " Au " . format_date2($rowevaluation['datefin']) ."</p>";
                                            $jrs_all1=  NbJours($rowevaluation['datedb'],$rowevaluation['datefin']);
                                            $jrs_reste2 = ($jrs_all1%30);
                                            $nmois2 = floor ($jrs_all1/30);
                                            if (isset($rowevaluation['datedb'])){
                                                if ($nmois2==0) {
                                                    echo "<span class='text-danger'>(" .$jrs_reste2." jrs)</span>";
                                                } else {
                                                    echo "<span class='text-danger'>(" . $nmois2." mois ".$jrs_reste2." jrs)</span>";
                                                }
                                            }
                                            ?></td>
                                        <td><?php
                                            echo "Evalué le ". format_date($rowevaluation['dateenr']);
                                            ?></td>
                                    </tr>
                                <?php  } ?>
                                    <?php
                                $nbrest=0;
                                    $recupst = $bdd->prepare('select * from table_detailseqchrono ds WHERE   ds.tache=:idt and ds.supp=0 and id_pl= :ids  order by id_dseq DESC');
                                    $recupst->execute(array("idt" => $rowg['tache'],'ids' => $id));
                                  $nbrest =   $recupst->rowCount();
                                     while ($rowgss = $recupst->fetch()) {
                                         if ($nbrest>1){
                                         ?>

                                        <tr>
                                            <td><?php //echo $i; ?></td>
                                            <td><?php echo $rowgss['stache']; ?></td>
                                            <td colspan="2">
                                                <?php
                                                //
                                                echo "<p class='mb-0'>Du " . format_date2($rowgss['date_debut']) . " Au " . format_date2($rowgss['date_fin']) ."</p>";
                                                $jrs_all=  NbJours($rowgss['date_debut'],$rowgss['date_fin']);
                                                $jrs_reste = ($jrs_all%30);
                                                $nmois = floor ($jrs_all/30);
                                                if (isset($rowgss['date_debut'])){
                                                    if ($nmois==0) {
                                                        echo "<span class='text-danger'>(" .$jrs_reste." jrs)</span>";
                                                    } else {
                                                        echo "<span class='text-danger'>(" . $nmois." mois ".$jrs_reste." jrs)</span>";
                                                    }
                                                } if (strtotime($db) > strtotime($rowgss['date_debut']) && strtotime($db) < strtotime($rowgss['date_fin'])) { ?>
                                                    <br> <span class="text-warning" role="button" data-toggle="tooltip" data-placement="top" title="Incohérense de date avec celle de l'objectif !" data-original-title="Edit" style="font-size: 1.5rem"><i class="fa fa-exclamation-triangle"></i></span>
                                                <?php } ?>

                                            </td>

                                        </tr>
                                         <div class="modal fade bs-example-modal-md" id="suppdseq<?= $rowg['tache'] ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="false" style="z-index: 3000000">
                                             <div class="modal-dialog modal-sm rounded">
                                                 <div class="modal-content">
                                                     <div class="modal-header bg-success">
                                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                         <h4 class="modal-title text-white">Supprimer la tâche <span id="numataj"></span></h4>
                                                     </div>
                                                     <div class="modal-body">
                                                         <div class="input-group d-flex">
                                                             <button type="button" data-dismiss="modal" class="btn btn-primary">Annuler</button> &nbsp;
                                                             <a href="javascript:void(0);" data-dismiss="modal" type="button" class="btn btn-success" onclick="supp_pdseq(<?php echo $rowg['id_tache']; ?>)">Confirmer suppression</a>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="modal fade bs-example-modal-md" id="suppstseq<?php echo $rowgss['stache']; ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="false" style="z-index: 3000000">
                                             <div class="modal-dialog modal-sm rounded">
                                                 <div class="modal-content">
                                                     <div class="modal-header bg-success">
                                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                         <h4 class="modal-title text-white">Supprimer la sous tâche <span id="numataj"></span></h4>
                                                     </div>
                                                     <div class="modal-body">
                                                         <div class="input-group d-flex">
                                                             <button type="button" data-dismiss="modal" class="btn btn-primary">Annuler</button> &nbsp;
                                                             <a href="javascript:void(0);" data-dismiss="modal" type="button" class="btn btn-success" onclick="supp_pstseq(<?php echo $rowgss['id_stache']; ?>)">Confirmer suppression</a>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                    <?php } $i++;} } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade bs-example-modal-sm in display_none" id="modifpseq" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <b id="libt1" style="font-size: 11pt;"></b>
                <h6 id="taux1" style="color: whitesmoke"></h6>
            </div>

            <div class="modal-body">
                <form class="form-horizontal login_validator" id="form_inline_validator" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="idd" id="idd" placeholder="">
                    <input type="hidden" class="form-control" name="idl" id="idl" placeholder="">
                    <input type="hidden" class="form-control" name="taux" id="taux21" placeholder="">
                    <div class="row">
                        <div class="col-lg-12 input_field_sections">
                            <div class="form-group">
                                <label class="control-label">Commentaire</label>
                                <div class="input-group">
                                    <textarea  class="form-control" placeholder="Votre rapport ici..." id="com" name="com"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-6 input_field_sections">
                                    <div class="form-group">
                                        <label class="control-label">Date début </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="dp3" name="dbut">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <div class="form-group">
                                        <label class="control-label">Date fin </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="dp4" name="dfin" >
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6"></div>

                        <div class="col-lg-6 input_field_sections">
                            <div class="input-group">
                                <button id="modifbtn"  data-dismiss="modal" class="btn btn-success" onclick="valider_evaluation();">Valider</button>
                                &nbsp;<button type="button" data-dismiss="modal" class="btn btn-primary">Quitter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- global scripts-->
    <script type="text/javascript" src="js/components.js?d=<?php echo time() ?>"></script>
    <script type="text/javascript" src="js/custom.js?d=<?php echo time() ?>"></script>
    <script type="text/javascript" src="js/form.js"></script>
    <script type="text/javascript" src="js/pages/form_validation2.js"></script>
    <script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>
    <!-- global scripts end--><!-- end of global scripts-->
    <script type="text/javascript">



        function evaluer(str) {
            //il fait la mise a jour du prix de base et l'observation
            var xhr2;
            var form_data1 = new FormData();
            form_data1.append("idq", str);

            if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
            xhr2.open('POST', "rechinfo_det.php", true);
            xhr2.send(form_data1);
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    var myObj = JSON.parse(this.responseText);
                   // console.log(myObj.tache);
//                    document.getElementById("nommaj").innerHTML = myObj.name;
                    document.getElementById("libt1").innerHTML = myObj.tache;
                    $("#idd").val(myObj.id)  ;
                    $("#idl").val(myObj.idl)  ;
                    $("#taux21").val(myObj.taux)  ;

                    document.getElementById("taux1").innerHTML = 'Taux : '+myObj.taux+'%';
                }
                if (xhr2.readyState == 4 && xhr2.status != 200) {
                    alert("Error : returned status code " + xhr2.status);
                }
            }
        }

        function valider_evaluation() {

            var xhr2;
            var form_data2 = new FormData();



            form_data2.append("idd", $('#idd').val());
            form_data2.append("idpl", $('#idl' ).val());
            form_data2.append("db", $('#dp3' ).val());
            form_data2.append("df", $('#dp4' ).val());
            form_data2.append("com", $('#com' ).val());
            form_data2.append("taux", $('#taux21' ).val());

            if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
            xhr2.open('POST', "evaluer.php", true);
            xhr2.send(form_data2);
            xhr2.onreadystatechange = function() {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    afficher_det_planning($('#idl').val());
                }
                if (xhr2.readyState == 4 && xhr2.status != 200) {
                    alert("Error : returned status code " + xhr2.status);
                }
            }
        }

        function afficher_det_planning(str) {

            var xhr2;
            var form_data2 = new FormData();
            form_data2.append("str", str);

            if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
            xhr2.open('POST', "detail_apresevaluation.php", true);
            xhr2.send(form_data2);
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    document.getElementById("retour").innerHTML = this.responseText;
                    if (xhr2.readyState == 4 && xhr2.status != 200) {
                        alert("Error : returned status code " + xhr2.status);
                    }
                }
            }

        }


    </script>
