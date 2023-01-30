
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" />
    <!--End of plugin styles-->
    <!--Page level styles-->
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrapvalidator/css/bootstrapValidator.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/inputlimiter/css/jquery.inputlimiter.css" />
    <link type="text/css" rel="stylesheet" href="vendors/chosen/css/chosen.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/jquery-tagsinput/css/jquery.tagsinput.css" />
    <link type="text/css" rel="stylesheet" href="vendors/daterangepicker/css/daterangepicker.css" />
    <link type="text/css" rel="stylesheet" href="vendors/datepicker/css/bootstrap-datepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/bootstrap-switch/css/bootstrap-switch.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/jasny-bootstrap/css/jasny-bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="vendors/fileinput/css/fileinput.min.css" />
    <link type="text/css" rel="stylesheet" href="css/pages/form_elements.css" />

    <style>
        #error {
            color: #ff0000;
            font-size: 7px;
        }
    </style>
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-5 col-lg-6 skin_txt">
                <h4 class="nav_top_align">
                    <i class="fa fa-pencil"></i>
                    Formulaire du planning sequentiel
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

                    <li class="active breadcrumb-item">Ajout chronogramme</li>
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
                            ajout chronogramme
                        </div>
                        <div class="card-block">
                            <?php
                            if (isset($_POST['ok'])) {

                                $datejr = gmdate("Y-m-d H:i:s");
                                require('connexion/connectpg.php');
                                require('connexion/functionpchronoseq.php');

                                $datejr = gmdate("Y-m-d H:i:s");
                                $contrat = $_POST['marche'];
                                $marche = $_POST['march'];
                                $datedebt = $_POST['dbut'];
                                $datefin = $_POST['dfin'];
                                   try {
                                       //insertion dans la table  table_seqchrono
                                       $nomtab = "table_chronogramme";
                                       $tab = array('idmarche' => $marche, 'idfour' => $_POST['four'],'idcontrat' => $contrat, 'date_debut' => formatinv_date($datedebt), 'date_fin' => formatinv_date($datefin),  'dateenr' => $datejr, 'idenr' => $_SESSION['id']);
                                   //var_dump($tab);
                                       $st = insert_tab($nomtab, $tab);
                                       $st->execute($tab);

                                       $rsts = $bdd->prepare("select max(id_seqchrono) as idseq  from table_chronogramme ");
                                       $rsts->execute();
                                       $rowsms = $rsts->fetch();
                                       $idseq = $rowsms['idseq'];
                                       $idfour = $rowsms['idfour'];
                                   } catch (Exception $e) {
                                       echo 'Erreur : ' . $e->getMessage() . '<br />';
                                       echo 'N° : ' . $e->getCode();
                                   }

                                   try {
                                       $nbreart1 = count($_SESSION['panier']['id_sstach']);
                                       //var_dump($_SESSION['panier']);
                                       $in = $pins = 0;

                                       for ($in = 0; $in < $nbreart1; $in++) {
                                           $idt = $_SESSION['panier']['tache'][$in]; // l'identifiant de la tache
                                           $idst = $_SESSION['panier']['id_sstach'][$in]; // l'identifiant de la sous tache
                                           $taux = $_SESSION['panier']['taux'][$in]; // l'identifiant de la sous tache
                                           $code = $_SESSION['panier']['code'][$in]; // l'identifiant de la sous tache

                                           $dbut = $_SESSION['panier']['date_debut'][$in]; // date debut de la sous tâche
                                           $dfin = $_SESSION['panier']['date_fin'][$in]; // date fin de la sous tâche

                                           $nomtab1 = "table_detailseqchrono";
                                           $tab1 = array('tache' => $idt, 'stache' => $idst, 'tauxrep' => $taux, 'codepl' => $code, 'id_pl' =>$idseq , 'idfour' =>$idfour , 'date_debut' => formatinv_date($dbut), 'date_fin' => formatinv_date($dfin), 'dateenr' => $datejr);
                                           $stmt = insert_tab($nomtab1, $tab1);

                                           $stmt->execute($tab1);
                                       }

                                       vider_panier();
                                       unset($_SESSION['panier']['tache']);
                                       unset($_SESSION['panier']['id_sstach']);
                                       unset($_SESSION['panier']['date_debut'][$in]);
                                       unset($_SESSION['panier']['date_fin'][$in]);
                                       unset($_SESSION['panier']['code'][$in]);
                                       unset($_SESSION['panier']['taux'][$in]);
                                   } catch (Exception $e) {

                                       echo 'Erreur : ' . $e->getMessage() . '<br />';

                                       echo 'N° : ' . $e->getCode();
                                   }
                                header("location:?page=listeplanning");
                            }
                            ?>
                            <form class="form-horizontal login_validator planningf" id="form_inline_validator" action="" method="post">
                                <div class="row">
                                    <div class="col-lg-12 input_field_sections">
                                        <div class="row">
                                            <div class="col-lg-12 input_field_sections">
                                                <div class="form-group">
                                                    <label class="control-label">Marchés *</label>
                                                    <?php
                                                    $rsg = $bdd->prepare('select * from  contratanc,tab_projet,type_projet WHERE type_projet.Id_typep=tab_projet.typeprojet and  contratanc.idmarche=tab_projet.id_projet and tab_projet.supp=0 and contratanc.supp=0 and contratanc.idmarche not in (select idcontrat from table_chronogramme where table_chronogramme.supp=0 )  ORDER by id_Contrat  ASC ');
                                                    $rsg->execute(array());
                                                    ?>
                                                    <select onchange="rechperiode();" name="marche" id="marche" class="form-control  chzn-select" required>
                                                        <option disabled selected value="0">Selectionner une tâche</option>
                                                        <?php  while ($rowt = $rsg->fetch()) { ?>
                                                            <option value="<?= $rowt['id_Contrat'] ?>"><?=    $rowt['numcc'].' -> '. $rowt['Intitule_Contrat'].' ( '.$rowt['Nom_Projet'].' )' ?></option>
                                                        <?php }  ?>
                                                    </select>
                                                    <span class="error"></span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="retourp">
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-lg-8 input_field_sections">
                                                    <div class="form-group">
                                                        <label class="control-label">Rubrique *</label>

                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="rub" placeholder="Rubrique" name="rub" >
                                                            <span class="input-group-addon"> <i class="fa fa-user text-primary"></i></span>
                                                        </div>
                                                        <span class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 input_field_sections">
                                                    <div class="form-group">
                                                        <label class="control-label">Taux Evolution *</label>

                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="trub" placeholder="Taux 0-100" name="trub" >
                                                            <span class="input-group-addon"> <i class="fa fa-user text-primary"></i></span>
                                                        </div>
                                                        <span class="error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 input_field_sections">
                                                    <div class="form-group">
                                                        <label class="control-label">Sous Rubrique</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="srub" placeholder="Sous Rubrique" name="srub" >
                                                            <span class="input-group-addon"> <i class="fa fa-user text-primary"></i></span>
                                                        </div>
                                                        <span class="error"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-lg-6 input_field_sections">
                                                            <div class="form-group">
                                                                <label class="control-label">Date début * </label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="dp1" name="dp1" onchange="" >
                                                                    <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
                                                                </div>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 input_field_sections">
                                                            <div class="form-group">
                                                                <label class="control-label">Date fin * </label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="dd-mm-yyyy" id="dp5" name="dp5" onchange="" >
                                                                    <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i></span>
                                                                </div>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 input_field_sections">
                                                    <input  class="btn btn-success mt-2" id="aj" type="button" onclick="alimente();" value="Ajouter">
                                                </div>
                                            </div>
                                            <div class="col-md-12 input_field_sections">
                                                <div class="col-lg-12 input_field_sections" id="idretour">
                                                    <div class="input-group">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-advance table-hover table_status_padding">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>
                                                                        Rubrique
                                                                    </th>
                                                                    <th>
                                                                        Taux %
                                                                    </th>
                                                                    <th>
                                                                        Sous rubrique
                                                                    </th>

                                                                    <th class="hidden-xs">
                                                                        Date début
                                                                    </th>
                                                                    <th class="hidden-xs">
                                                                        Date fin
                                                                    </th>
                                                                    <th>
                                                                        Actions
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr style="vertical-align: middle;">
                                                                    <th>-</th>
                                                                    <th>-</th>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <br />
                                <hr />
                                <div class="form-group row">
                                    <div class="col-lg-7 input_field_sections"></div>
                                    <div class="col-lg-5 push-lg-2">
                                        <button class="btn btn-primary" id="formv" type="submit" name="ok">
                                            <i class="fa fa-location-arrow" style="margin-right: 2%;"></i>
                                            Valider les Taches
                                        </button>
                                        <button class="btn btn-warning" type="reset" id="clear">
                                            <i class="fa fa-refresh" style="margin-right: 2%;"></i>
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

        <script type="text/javascript" src="js/components.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <!--Page level scripts-->
        <script type="text/javascript" src="js/form.js"></script>
        <script type="text/javascript" src="js/pages/form_validation2.js"></script>
        <script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>
    <!-- global scripts end-->
    <!-- end of global scripts-->



<script type="text/javascript">




    //fonction pour recuperer les informations temporaire
    function alimente() {
        var xhr;
        var form_data = new FormData();
        var rub = document.getElementById("rub").value;
        var taux = document.getElementById("trub").value;
        var srub = document.getElementById("srub").value;
        var datedeb_st = document.getElementById("dp1").value;
        var datefin_st = document.getElementById("dp5").value;

        //var ob =  document.getElementById("text4").value ;

            //console.log('je suis la');
            form_data.append("t", rub);
            form_data.append("taux", taux);
            form_data.append("st", srub);
            form_data.append("db1", datedeb_st);
            form_data.append("df1", datefin_st);
           // var params = "t=" + rub + "&st=" + srub  + "&db1=" + datedeb_st + "&df1=" + datefin_st;
            if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
            else if (window.ActiveXObject) xhr = new ActiveXObject('Microsoft.XMLHTTP');
            xhr.open("POST", "alimenterplanningseq.php", true);
            xhr.send(form_data);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    $('.error').val('');
                    document.getElementById("idretour").innerHTML = xhr.responseText;

                } else {
                    document.getElementById("idretour").innerHTML = '<img src="img/circle.gif" width="100" alt="">'
                }
                if (xhr.readyState == 4 && xhr.status != 200) {
                    alert("Error : returned status code " + xhr.status + " " + xhr.statusText);
                }
            }




    }
    function rechperiode() {
        var xhr;
        var form_data = new FormData();
        var marche = $('#marche').val();
        form_data.append("marche", marche);
        if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr = new ActiveXObject('Microsoft.XMLHTTP');
        xhr.open('POST', "rechperiode.php", true);
        xhr.send(form_data);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("retourp").innerHTML = this.responseText;
             //   $("#stache").trigger("chosen:updated");
            }
            if (xhr.readyState == 4 && xhr.status != 200) {
                alert("Error : returned status code " + xhr.status);
            }
        }
    }
    function vide() {
        var xhr;
        var form_data = new FormData();

        if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr = new ActiveXObject('Microsoft.XMLHTTP');
        xhr.open("POST", "videtabpseq.php", true);
        xhr.send(form_data);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("idretour").innerHTML = xhr.responseText;
            }
            if (xhr.readyState == 4 && xhr.status != 200) {
                alert("Error : returned status code " + xhr.status + " " + xhr.statusText);
            }
        }

    }

    function fctClick(obj) {
        var xhr;
        var form_data = new FormData();
        var oInput = obj.getElementsByTagName('INPUT');
        // affichage de la value du 1st
        form_data.append("id", oInput[0].value);

        if (window.XMLHttpRequest) xhr = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr = new ActiveXObject('Microsoft.XMLHTTP');
        xhr.open("POST", "suppalimpseq.php", true);
        xhr.send(form_data);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {

                document.getElementById("idretour").innerHTML = xhr.responseText;
            } else {
                document.getElementById("idretour").innerHTML = "Patienter...";
            }
        };

    }




</script>