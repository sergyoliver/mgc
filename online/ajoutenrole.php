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


<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        Nouveau Enrolement
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_POST['ok'])){

                            $photop = $_FILES['photop']['name'];
                            $photopl = $_FILES['photopl']['name'];
                            if(!empty($photop)) {
                                $tab = explode(".", $photop);
                                $ph1 = ajoutitret($tab[0]);
                                $ph2 = $tab[1];
                                $photor = $ph1 . "_" . pwd_aleatoire(4) . "." . $ph2;
                                $content_dir = 'img/produit/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph = $_FILES['photop']['tmp_name'];
                                move_uploaded_file($tmp_ph, 'img/pieceid/'.$photor);
                            }else{
                                $photor='';
                            }
                            if(!empty($photopl)) {
                                $tab2 = explode(".", $photopl);
                                $ph12 = ajoutitret($tab2[0]);
                                $ph22 = $tab2[1];
                                $photor2 = $ph12 . "_" . pwd_aleatoire(4) . "." . $ph22;
                                $content_dir2 = 'img/plaque/'; // dossier o� sera d�plac� le fichier
                                $tmp_ph2 = $_FILES['photopl']['tmp_name'];
                                move_uploaded_file($tmp_ph2, 'img/plaque/'.$photor2);
                            }else{
                                $photor2='';
                            }
                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                            // require ('connexion/connectpg.php');
                            try {
                                //                            $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , datecon, statconn) VALUES(:ipadress, :log, :datc, :statc)');
                                //                            $rs3->execute(array('ipadress' => get_ip(), 'log' => $log ,'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));


                                /// le numero d'ordre
                                if (empty($_POST['numplaque'])){
                                    $nb=0;
                                }else{
                                    $rsg = $bdd->prepare('select * from enrolement WHERE numplaque =:np');
                                    $rsg->execute(array('np'=>$_POST['numplaque']));
                                    $nb = $rsg->rowCount();
                                }

                                $identite = $_POST['nom']." ".$_POST['pnom'];
                                if ($nb==0 && !empty($_POST['cordy']) && !empty($_POST['cordx'])){
                                    if (empty($_POST['daterdvcgi'])){
                                        $dtrdvcgi="0000-00-00";
                                    }else{
                                        $dtrdvcgi=formatinv_date($_POST['daterdvcgi']);
                                    }
                                    if (empty($_POST['dtrdvpl'])){
                                        $dtautre="0000-00-00";
                                    }else{
                                        $dtautre=formatinv_date($_POST['dtrdvpl']);
                                    }
                                    try {
                                        $nomtab10 = "enrolement";
                                        $tab10 = array('idcom' => $_POST['zoneid'], 'idagent' => $_SESSION['id'], 'idpays' => $_POST['paysn'], 'typep' => $_POST['typep'], 'numpiece' => $_POST['nump'], 'photop' => $photor,
                                            'nom' => $_POST['nom'], 'pnom' => $_POST['pnom'], 'datenaiss' => formatinv_date($_POST['datenaiss']), 'dateenrole' => formatinv_date($_POST['datenrol']), 'telp' => $_POST['telp'], 'tels' => $_POST['tels'], 'numplaque' => $_POST['numplaque'],
                                            'photoplaque' => $photor2, 'demandem' => $_POST['dm'], 'demandep' => $_POST['dp'], 'idagencecgi' => $_POST['cgi'], 'daterdvcgi' => $dtrdvcgi, 'autrerdv' => $dtautre
                                        , 'certifier' => $_POST['activate'],'lieuplaque' => $_POST['lieup'],'cord_x' => $_POST['cordx'],'cord_y' => $_POST['cordy'], 'dateenr' => gmdate("Y-m-d H:i:s"));
                                       // var_dump($tab10);
                                        $sql = insert_tab($nomtab10, $tab10);
                                        $sql->execute($tab10);
                                    } catch (Exception $e) {
                                        die("Erreur ! " . $e->getMessage());
                                    }


                                    header("location:?page=listeenrole");
                                }else{
                                    $pb="";
                                    if ($nb>0){
                                        $pb ="La plaque existe deja";
                                    }
                                    if (empty($_POST['cordy']) && empty($_POST['cordx'])){
                                        $pb ="GPS non autorisé ou non actif";
                                    }
                                    // on trace l info
                                    $loog = "Num plaque ".$_POST['numplaque']." - Cord : ".$_POST['cordx']." ".$_POST['cordy'];
                                    $chemin = 'admin/log_action/';
                                    $act = "Echec validation formulaire:" . $loog." par : ".$_SESSION['identite']. " PB ".$pb;
                                    trace_echec($chemin, get_ip(), $act);

                                    echo ' <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">× </button><strong> Accès erroné : </strong>
       Numéro de la plaque numérologique doit etre uniques et le GPS doit être actif ! </div>';
                                }

                            } catch (Exception $e) {

                                echo 'Erreur : ' . $e->getMessage() . '<br />';

                                echo 'N° : ' . $e->getCode();

                            }



                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">

                            <div class="row" hidden>
                                <div class="col-lg-6 input_field_sections">

                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-subscript text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control"  id="x" name="cordx"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">

                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-subscript text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control"  id="y" name="cordy"  required>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Date Enrolement </h5>
                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="datenrol" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Zone Enrolement </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="zoneid" >
                                            <option selected disabled>Choisir le zone</option>
                                            <?php
                                            $i=1;
                                            $rsz = $bdd->prepare("select * from zone where libelle_com <>'SIEGE' ORDER by libelle_com asc ");
                                            $rsz->execute();
                                            while($rowz = $rsz->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowz['id_commune'] ?>"><?php echo $rowz['libelle_com'] ?></option>

                                            <?php }  ?>

                                        </select>
                                    </div>
                                </div>

                            </div>

                            <br>

                            <h4 style="margin-top: 5px; margin-bottom: 10px">DONNEES DU DEMANDEUR</h4>
                            <hr>

                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Type de document</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="typep"  >
                                            <option selected disabled>Choisir le type de document</option>
                                            <option value="CNI">CNI</option>
<!--                                            <option value="PASSPORT">PASSPORT</option>-->
                                            <option value="PERMIS DE CONDUIRE">PERMIS DE CONDUIRE</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numéro  du document</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nump" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Photo  du document</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="photop" type="file"  class="file-loading" required style="display: block">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Nom</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="nom"  required>
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Prénoms</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="pnom" required>
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-4 input_field_sections">
                                    <h5>Date de naissance</h5>
                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="datenaiss">
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Pays de naissance</h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="paysn" required >
                                            <option value="0" selected disabled>Choisir le pays</option>
                                            <?php
                                            $i=1;
                                            $rsp = $bdd->prepare('select * from pays  ORDER by labelp asc ');
                                            $rsp->execute();
                                            while($rowp = $rsp->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowp['idpays'] ?>"><?php echo $rowp['labelp'] ?></option>

                                            <?php }  ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numero de telephone</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="telp"  name="telp" required>
                                        <span class="input-group-addon"> <i class="fa fa-phone text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numero de telephone 2</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="tels" >
                                        <span class="input-group-addon"> <i class="fa fa-phone text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group ">
                                    <div class="col-lg-4 input_field_sections"></div>
                                    <div class="col-lg-5 ">
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="verifiersms()">
                                            <i class="fa fa-user"></i>
                                            Envoi SMS d’authentification
                                        </a>

                                    </div>
                                    <div id="retoursms" style="color: green"></div>
                                </div>
                            </div>
                            <br>
                            <h4 style="margin-top: 5px; margin-bottom: 10px">INFORMATION VEHICULE</h4>
                            <hr>

                            <div class="row">


                                <div class="col-lg-6 input_field_sections">
                                    <h5>Numéro de la plaque d'immatriculation</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="numplaque" >
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <h5>Photo de la plaque d'immatriculation</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-41" name="photopl" type="file"  class="file-loading"  style="display: block">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <h4 style="margin-top: 5px; margin-bottom: 10px">TYPE DE DEMANDE</h4>
                            <hr>

                            <div class="row">


                                <div class="col-lg-6 input_field_sections">
                                    <div class="row">
                                        <div class="col-lg-12 input_field_sections">
                                            <h5>Demande de Mutation</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" name="dm" onchange="cartegrise(this.value)" >
                                                    <option selected value="0">Aucune demande</option>
                                                    <option value="Mutation Classique">Mutation Classique</option>
                                                    <option value="Mutation  ORM">Mutation  ORM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="retourgrise" style="display: none">
                                        <div class="col-lg-6 input_field_sections">
                                            <h5>CGI</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" name="cgi" id="cgi" >

                                                    <option  selected value="0" >Choisir CGI</option>
                                                    <?php
                                                    $i=1;
                                                    $rscgi = $bdd->prepare('select * from agencecgi  ORDER by nomcgi asc ');
                                                    $rscgi->execute();
                                                    while($rowcgi = $rscgi->fetch()) {
                                                        ?>
                                                        <option value="<?php echo $rowcgi['idcgi'] ?>"><?php echo $rowcgi['nomcgi'] ?></option>

                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 input_field_sections">
                                            <h5>Date RDV</h5>
                                            <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                                <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp4" name="daterdvcgi">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6 input_field_sections">
                                    <div class="row">
                                        <div class="col-lg-12 input_field_sections">
                                            <h5>Demande de Plaques</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" name="dp" onchange="plaque(this.value)">
                                                    <option value="0" selected >Aucune demande</option>
                                                    <option value="Absence de plaque">Absence de plaque</option>
                                                    <option value="Défaut de plaque">Défaut de plaque</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="plaq" style="display: none">
                                            <div class="col-lg-6 input_field_sections" >
                                                <h5>Date RDV</h5>
                                                <div class="input-group">
                                                <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                                </span>
                                                    <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp6" name="dtrdvpl">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 input_field_sections" id="retourplaque"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-8 ">
                                    <label class="custom-control custom-checkbox error_color">
                                        <input type="checkbox" class="custom-control-input" name="activate" required  value="1">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Je déclare sur l'honneur que les informations fournies sont exactes.</span>
                                        <br></label>
                                </div>
                            </div>

                            <br>
                            <hr />
                            <div class="form-group row">
                                <div class="col-lg-7 input_field_sections"></div>
                                <div class="col-lg-5 push-lg-2">
                                    <button class="btn btn-primary" type="submit" id="ok" name="ok">
                                        <i class="fa fa-user"></i>
                                        Valider l’enrôlement
                                    </button>

                                </div>
                            </div>

                            <input type="hidden" id="ag" value="<?php echo $_SESSION['id'] ?>">

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
<script type="text/javascript" src="js/pages/form_validation2.js?d=<?php echo time() ?>"></script>
<script type="text/javascript" src="js/pluginjs/jasny-bootstrap.js"></script>
<script>
    $(document).ready(function(){
        //Dès qu'on clique sur #b1, on applique hide() au titre
        $("#ok").hide();
        //Dès qu'on clique sur #b1, on applique show() au titre
        $('#form_inline_validator').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    });

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
        var ag=$('#ag').val();
        form_data2.append("tel", tel);
        form_data2.append("ag", ag);

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
                    $("#ok").show();
                }else if(r=='oui1') {
                    document.getElementById("retoursms").innerHTML ='Numéro déja Authentifié !'
                    $("#ok").show();
                }else{
                    document.getElementById("retoursms").innerHTML ='Sms echoué !'
                    $("#ok").hide();
                }

                //                document.getElementById("retourajprix").innerHTML = this.responseText;
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }
    }



    function maPosition(position) {
//        var infopos = "Position déterminée :\n";
//        infopos += "Latitude : "+position.coords.latitude +"\n";
//        infopos += "Longitude: "+position.coords.longitude+"\n";
//        infopos += "Altitude : "+position.coords.altitude +"\n";
//        //document.getElementById("infoposition").innerHTML = infopos;

        $('#x').val(position.coords.latitude );
        $('#y').val(position.coords.longitude )
    }

    if(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(maPosition);

</script>