    <!-- global styles-->
    <link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css?d=<?php echo time() ?>" />
    <link type="text/css" rel="stylesheet" href="vendors/datatables/css/scroller.bootstrap.min.css?d=<?php echo time() ?>" />
    <link type="text/css" rel="stylesheet" href="vendors/datatables/css/colReorder.bootstrap.min.css?d=<?php echo time() ?>" />
    <link type="text/css" rel="stylesheet" href="vendors/datatables/css/dataTables.bootstrap.min.css?d=<?php echo time() ?>" />
    <link type="text/css" rel="stylesheet" href="css/pages/dataTables.bootstrap.css?d=<?php echo time() ?>" />
    <link type="text/css" rel="stylesheet" href="vendors/chosen/css/chosen.css" />
    <link type="text/css" rel="stylesheet" href="css/pages/form_elements.css" />
    <link type="text/css" rel="stylesheet" href="vendors/inputlimiter/css/jquery.inputlimiter.css" />
    <link type="text/css" rel="stylesheet" href="vendors/daterangepicker/css/daterangepicker.css" />
    <link type="text/css" rel="stylesheet" href="vendors/datepicker/css/bootstrap-datepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/modal/css/component.css" />
    <!-- end of plugin styles -->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="css/pages/tables.css?d=<?php echo time() ?>" />
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-5 col-lg-6 skin_txt">
                <h4 class="nav_top_align">
                    <i class="fa fa-table"></i>
                    Chronogramme séquentiel
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


                    <li class="active breadcrumb-item">Chronogramme d'exécution</li>
                </ol>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-t-35">

                        <div class="card-header bg-white">
                            <i class="fa fa-table"></i> Chronogrammes séquentiel
                            <a href="?page=ajoutchronosequentiel"  role="button"  class="btn btn-primary float-xs-right">
                                <i class="fa fa-plus" style="margin-right: 3%;"></i> Ajouter une séquence
                            </a>
                        </div>
                        <div class="card-block m-t-15">
                            <table id="example2" class="display table table-stripped table-bordered" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Projet</th>
                                    <th>Entreprise Contractant</th>
                                    <th>Durée</th>
                                    <th>Début de l'exécution</th>
                                    <th>Délai global d'exécution (en jours)</th>
                                    <th>Date Fin Prev.</th>

                                    <th>Taux d'execution</th>
                                    <th>Date effectif</th>
                                    <th>Jours Retard</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $i = 1;
                                $rsgss = $bdd->prepare('select * from table_chronogramme,tab_projet,fournisseurs WHERE tab_projet.id_projet=table_chronogramme.idmarche  and table_chronogramme.idfour=fournisseurs.id_fournisseurs and   table_chronogramme.supp=0 ORDER BY table_chronogramme.date_debut, table_chronogramme.date_fin ASC ');
                                $rsgss->execute();
                                while ($rowgss = $rsgss->fetch()) {

                                            $rsev = $bdd->prepare('select sum(Taux) as t,min(datedb) as db,max(datefin) as df  from table_evaluation  WHERE idchro = :d ');
                                            $rsev->execute(array('d' => $rowgss['id_seqchrono']));
                                            $rowe = $rsev->fetch();




                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td style="vertical-align: middle; background: #0a6aa1; color: #ffffff">
                                            <?php echo $rowgss['Intitule_Contrat']; ?>
<!--                                            <a href="img/rapport/dddd" target="_blank" style="color: #FFFFFF !important;"><span class="fa fa-file-pdf-o"></span></a>-->
                                        </td>

                                        <td style="vertical-align: middle;">
                                            <?php if (empty($rowgss['Name_entreprise']))echo $rowgss['nom_rep'];else echo $rowgss['Name_entreprise'];?>
                                            <br>
<!--                                            <a href="img/rapport/dddd" target="_blank" style="color: #FFFFFF !important;"><span class="fa fa-file-pdf-o"></span></a>-->
                                        </td>
                                        <td style="vertical-align: middle">
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
                                            } ?>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <?php
                                            $rstt = $bdd->prepare('select max(date_fin) as df, min(date_debut) as db from table_detailseqchrono ds WHERE ds.id_pl= :idseq and ds.supp=0');
                                            $rstt->execute(array('idseq' => $rowgss['id_seqchrono']));
                                            $rowdf = $rstt->fetch();
                                            echo format_date2($rowdf['db'])
                                           ?>

                                            <!--                                            <a href="img/rapport/dddd" target="_blank" style="color: #FFFFFF !important;"><span class="fa fa-file-pdf-o"></span></a>-->
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <?php
                                            echo  NbJours($rowdf['db'],$rowdf['df']);
                                            ?>

                                            <!--                                            <a href="img/rapport/dddd" target="_blank" style="color: #FFFFFF !important;"><span class="fa fa-file-pdf-o"></span></a>-->
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <?php

                                            echo format_date2($rowdf['df'])
                                           ?>

                                            <!--                                            <a href="img/rapport/dddd" target="_blank" style="color: #FFFFFF !important;"><span class="fa fa-file-pdf-o"></span></a>-->
                                        </td>
                                        <td style="vertical-align: middle">

                                            <div class="">


                                                <span class="float-xs-right text-muted progress-info"><?php echo   round($rowe['t'],2)."%" ?></span>
                                                <div id="progress-bar">
                                                    <progress class="progress progress-striped progress-primary" value="<?php echo round($rowe['t'],2) ?>"  max="100"></progress>
                                                </div>
                                            </div>
                                        </td>

                                        <td style="vertical-align: middle"> <?php
                                            if ($rowe['t']==100){

                                                $jrs_alle=  NbJours($rowe['db'],$rowe['df']);
                                                $jrs_restee = ($jrs_alle%30);
                                                $nmoise = floor ($jrs_alle/30);
                                                if (isset($rowe['db'])){
                                                    if ($nmoise==0) {
                                                      //  echo "<span class='text-danger'>" .$jrs_restee." jrs</span>";
                                                    } else {
                                                       // echo "<span class='text-danger'>" . $nmoise." mois ".$jrs_restee." jrs</span>";
                                                    }

                                                }
                                               echo "<span class='text-primary'>" . format_date2($rowe['df']) ." </span>";
                                            }

                                            ?></td>
                                        <td style="vertical-align: middle">
                                            <?php
                                            if (strtotime(gmdate('Y-m-d H:i:s')) > strtotime($rowdf['df'])){


                                                    $jrs_retard=  NbJours($rowdf['df'],gmdate('Y-m-d H:i:s'));

                                                echo "<span class='text-danger'>" .$jrs_retard." jrs</span>";


                                            }


                                            ?>
                                        </td>
                                        <td style="font-size: 12pt; vertical-align: middle">


                                                <button data-target="#modifpseq" onclick='afficheafficheobj("<?= $rowgss['id_seqchrono'] ?>")' data-toggle="modal">
                                                    <span class="fa fa-pencil"></span>
                                                </button>
                                                &nbsp;
                                                <button style="margin-bottom: 5px" data-target="#suppppseq<?php echo $rowgss['id_seqchrono']; ?>" data-toggle="modal">
                                                    <span class="fa fa-trash-o"></span>
                                                </button>
                                                <a href="?page=listedetailpseq&id=<?= $rowgss['id_seqchrono'] ?>" class="btn btn-success">Détail</a>

                                        </td>
                                    </tr>
                                    <div class="modal fade bs-example-modal-md" id="suppppseq<?= $rowgss['id_seqchrono'] ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="false" style="z-index: 3000000">
                                        <div class="modal-dialog modal-sm rounded">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title text-white">Supprimer le planning  <span id="numataj"></span></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group d-flex">
                                                        <button type="button" data-dismiss="modal" class="btn btn-primary">Annuler</button> &nbsp;
                                                        <a href="javascript:void(0);" data-dismiss="modal" type="button" class="btn btn-success" onclick="supp_pseq(<?php echo $rowgss['id_seqchrono']; ?>)">Confirmer suppression</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php  $i++; }?>
                                <div class="modal fade bs-example-modal-sm in display_none" id="modifpseq" tabindex="-1" role="dialog" aria-hidden="false">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                            </div>

                                            <div class="modal-body">
                                                <form class="form-horizontal login_validator" id="form_inline_validator" action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" class="form-control" name="idseq" id="idseq" placeholder=" ">
                                                    <div class="row">
                                                        <div class="col-lg-12 input_field_sections">
                                                            <div class="form-group">
                                                                <label class="control-label">Objectif </label>
                                                                <textarea class="form-control" name="obj" id="obj" cols="30" rows="5" required></textarea>
                                                                <span id="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 input_field_sections">
                                                            <div class="form-group">
                                                                <label class="control-label">Date début </label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="dp3" name="dbut"
                                                                           onchange='verifdate1("<?= $db ?>","<?= $df ?>");'
                                                                    >
                                                                    <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 input_field_sections">
                                                            <div class="form-group">
                                                                <label class="control-label">Date fin </label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="dp4" name="dfin" onchange='verifdate2("<?= $df ?>");'
                                                                    >
                                                                    <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 input_field_sections">
                                                            <div class="input-group">
                                                                <button id="modifbtn" class="btn btn-success" onclick="modifpseq();">Valider</button>
                                                                &nbsp;<button type="button" data-dismiss="modal" class="btn btn-primary">Quitter</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- global scripts-->
    <script type="text/javascript" src="js/components.js?d=<?php echo time() ?>"></script>
    <script type="text/javascript" src="js/custom.js?d=<?php echo time() ?>"></script>
    <script type="text/javascript" src="js/pages/form_validation2.js"></script>
    <script type="text/javascript" src="js/form.js"></script>
    <script type="text/javascript" src="js/pages/modals.js"></script>
    <!-- global scripts end-->
    <!-- end of global scripts-->
    <script type="text/javascript">

        function afficheafficheobj(str) {
            //il fait la mise a jour du prix de base et l'observation
            var xhr2;
            var form_data2 = new FormData();

            form_data2.append("idseq",str);
            if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
            xhr2.open('POST', "rech/afficheobj.php", true);
            xhr2.send(form_data2);
            xhr2.onreadystatechange = function () {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    var myObj = JSON.parse(this.responseText);
//                    document.getElementById("nommaj").innerHTML = myObj.name;
                    $('#idseq').val(myObj.idseq);
                    $('#obj').append(myObj.obj);
                    $('#dp3').val(myObj.dbut);
                    $('#dp4').val(myObj.dfin);
                }
                if (xhr2.readyState == 4 && xhr2.status != 200) {
                    alert("Error : returned status code " + xhr2.status);
                }
            }
        }

        function modifpseq() {

            var xhr2;
            var form_data2 = new FormData();
            var idseq = "idseq";
            var obj = "obj";
            var db = "dp3";
            var df = "dp4";

            var idseq2 = $('#' + idseq).val();
            var obj2 = $('#' + obj).val();
            var db2 = $('#' + db).val();
            var df2 = $('#' + df).val();

            form_data2.append("obj", obj2);
            form_data2.append("db", db2);
            form_data2.append("df", df2);
            form_data2.append("id", idseq2);

            if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
            xhr2.open('POST', "rech/modifobjseq.php", true);
            xhr2.send(form_data2);
            xhr2.onreadystatechange = function() {
                if (xhr2.readyState == 4 && xhr2.status == 200) {
                    //                    var urlcourante = document.location.href;
                    //                    window.location.href ="'"+urlcourante+"'";
                    window.location.reload(true);
                }
                if (xhr2.readyState == 4 && xhr2.status != 200) {
                    alert("Error : returned status code " + xhr2.status);
                }
            }
        }

        function supp_pseq(str) {
            var xhr;
            var form_data = new FormData();
            form_data.append("id", str);

            //form_data.append("imgparc",imgparc);
            if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr = new ActiveXObject('Microsoft.XMLHTTP');
            xhr.open('POST', "rech/delete_pseq.php", true);
            xhr.send(form_data);

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    window.location.reload(true);
                }
                if (xhr.readyState == 4 && xhr.status != 200) {
                    alert("Error : returned status code " + xhr.status);
                }
            }
        }

        function stringToDate(_date, _format, _delimiter) {
            var formatLowerCase = _format.toLowerCase();
            var formatItems = formatLowerCase.split(_delimiter);
            var dateItems = _date.split(_delimiter);
            var monthIndex = formatItems.indexOf("mm");
            var dayIndex = formatItems.indexOf("dd");
            var yearIndex = formatItems.indexOf("yyyy");
            var month = parseInt(dateItems[monthIndex]);
            month -= 1;
            var formatedDate = new Date(
                dateItems[yearIndex],
                month,
                dateItems[dayIndex]
            );
            return formatedDate;
        }

        function verifdate1(p1, p2) {
            // var d = $('div#someID').datepicker('getDate');
            // console.log(p1, p2)
            var dval = $('#dp3').val();
            var  d = stringToDate(dval, "dd-mm-yyyy", "-");
            var  d1 = stringToDate(p1, "dd-mm-yyyy", "-");
            var  d2 = stringToDate(p2, "dd-mm-yyyy", "-");
            // console.log(d)
            if (d.getTime() < d1.getTime() || d.getTime()>=d2.getTime()) {
                $('#modifbtn').prop('disabled', true);
            } else {
                console.log("not ok")
                $('#modifbtn').prop('disabled', false);
            }
        }
        function verifdate2(p1) {
            // var d = $('div#someID').datepicker('getDate');
            // console.log(p1, p2)
            var dval = $('#dp4').val();
            var dval1 = $('#dp3').val()
            var  d = stringToDate(dval, "dd-mm-yyyy", "-");
            var  d1 = stringToDate(dval1, "dd-mm-yyyy", "-");
            var  d2 = stringToDate(p1, "dd-mm-yyyy", "-");
            // console.log(d)
            if (d.getTime() <= d1.getTime() || d.getTime()>d2.getTime()) {
                $('#modifbtn').prop('disabled', true)

            } else {
                $('#modifbtn').prop('disabled', false)
            }
        }

    </script>
