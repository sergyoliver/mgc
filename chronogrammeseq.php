<?php
if (isset($_SESSION['num']) &&  isset($_SESSION['email'])) {
    if (isset($_GET['idop'])) {
        $idop = $_GET['idop'];
        $reqop = $bdd->prepare('select * from table_operation where idop=:op');
        $reqop->execute(array('op' => $idop));
        $rowop = $reqop->fetch();

        $db = format_date2($rowop['datedb']);
        $df = format_date2($rowop['datefin']);

    }
    ?>
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
                    <li class="breadcrumb-item">
                        <a href="?page=listeprojet_tech">
                            Liste des projets
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="?page=detailop_tech&id=<?php echo $idop; ?>">
                            Details du projet
                        </a>
                    </li>
                    <li class="active breadcrumb-item">Chronogramme séquentiel</li>
                </ol>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container forms">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-t-35">
                        <!--                        <div class="card-header bg-white">-->
                        <!--                            <span style="font-size: 15pt;font-weight: bold;">CHRONOGRAMME SEQUENTIEL D'EXECUTION DES TRAVAUX</span>-->
                        <!--                            <a href="docchrono.php?id=--><?php //echo $idop; ?><!--" role="button" class="btn btn-gray float-xs-right" target="_blank">-->
                        <!--                                <i class="fa fa-file-pdf-o" style="margin-right: 3%;font-size: large"></i> Télécharger le chronogramme-->
                        <!--                            </a>-->
                        <!--                        </div>-->
                        <div class="card-header bg-white">
                            <i class="fa fa-table"></i> Chronogrammes séquentiel
                            <a href="?page=ajoutchronosequentiel&id=<?= $idop ?>"  role="button"  class="btn btn-primary float-xs-right">
                                <i class="fa fa-plus" style="margin-right: 3%;"></i> Ajouter une séquence
                            </a>
                        </div>
                        <div class="card-block m-t-15">
                            <table id="example2" class="display table table-stripped table-bordered" >
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Objectif</th>
                                    <th>Durée</th>
                                    <th>Progression</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $i = 1;
                                $rsgss = $bdd->prepare('select * from table_seqchrono WHERE idop=:op and supp=0 ORDER BY date_debut, date_fin ASC ');
                                $rsgss->execute(array('op' => $idop));
                                while ($rowgss = $rsgss->fetch()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td style="vertical-align: middle; background: #0a6aa1; color: #ffffff">
                                            <?php echo $rowgss['objectif']; ?>
                                            <br>
                                            <a href="img/rapport/dddd" target="_blank" style="color: #FFFFFF !important;"><span class="fa fa-file-pdf-o"></span></a>
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
                                        <td style="vertical-align: middle">
                                            <?php
                                            $rstt = $bdd->prepare('select * from table_detailseqchrono ds WHERE ds.id_seq=:idseq and ds.supp=0');
                                            $rstt1 = $bdd->prepare('select sum(stat) as s from table_detailseqchrono ds WHERE ds.id_seq=:idseq and ds.supp=0');
                                            $rstt->execute(array('idseq' => $rowgss['id_seqchrono']));
                                            $rstt1->execute(array('idseq' => $rowgss['id_seqchrono']));
                                            $rowstt = $rstt1->fetch();
                                            $nbst = $rstt->rowCount();
                                            $som = $rowstt['s'];
                                            if ($som > 0 && $som < $nbst*2) { ?>
                                                <span class="tag tag-warning">En cours</span>
                                           <? } elseif ($som == $nbst*2) { ?>
                                               <span class="tag tag-success">Terminer</span>
                                            <?php } else { ?>
                                              <span class="tag tag-danger">Non démarré</span>
                                           <?php }?>
                                        </td>
                                        <td style="font-size: 12pt; vertical-align: middle">
                                            <?php if (($som > 0 && $som < $nbst*2) || $som == $nbst*2) { ?>
                                                <a href="?page=listedetailpseq&id=<?= $rowgss['id_seqchrono'] ?>&idop=<?= $idop ?>" class="btn btn-success">Détail</a>
                                            <?php } else { ?>
                                                <button data-target="#modifpseq" onclick='afficheafficheobj("<?= $rowgss['id_seqchrono'] ?>")' data-toggle="modal">
                                                    <span class="fa fa-pencil"></span>
                                                </button>
                                                &nbsp;
                                                <button style="margin-bottom: 5px" data-target="#suppppseq<?php echo $rowgss['id_seqchrono']; ?>" data-toggle="modal">
                                                    <span class="fa fa-trash-o"></span>
                                                </button>
                                                <a href="?page=listedetailpseq&id=<?= $rowgss['id_seqchrono'] ?>&idop=<?= $idop ?>" class="btn btn-success">Détail</a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <div class="modal fade bs-example-modal-md" id="suppppseq<?= $rowgss['id_seqchrono'] ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="false" style="z-index: 3000000">
                                        <div class="modal-dialog modal-sm rounded">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title text-white">Supprimer le planning sequentiel <span id="numataj"></span></h4>
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
<?php } else {
    header("location:index.php");
} ?>