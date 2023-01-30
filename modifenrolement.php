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
        <div class="col-lg-6 col-md-4 col-sm-4">
            <h4 class="nav_top_align">
                <i class="fa fa-th"></i>
                ENROLEMENT
            </h4>
        </div>
        <div class="col-lg-6 col-md-8 col-sm-8">
            <ol class="breadcrumb float-xs-right nav_breadcrumb_top_align">
                <li class="breadcrumb-item">
                    <a href="?page=milieu">
                        <i class="fa fa-home" data-pack="default" data-tags=""></i>
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="?page=listeenrole">Liste des enrolés</a>
                </li>
                <li class="breadcrumb-item active">Modifier enrolement</li>
            </ol>
        </div>
    </div>
</header>

<div class="outer">
    <div class="inner bg-container forms">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                       Modifier Enrolement
                    </div>
                    <div class="card-block">
                        <?php

                        if (isset($_GET['id'])){
                            $id =$_GET['id'];
                        $rsg = $bdd->prepare('select * from enrolement  WHERE idenrolement =:zid  ');
                        $rsg->execute(array("zid"=>$_GET['id']));
                        $rowg = $rsg->fetch();
                        }
                        if (isset($_POST['ok'])){

                         $photop = $_FILES['photop']['name'];
                         $photopl = $_FILES['photopl']['name'];

                            //echo $nom = $_POST['nom'];
                            /// renomme le img
//                            require('connexion/function.php');
                           // require ('connexion/connectpg.php');
                                try {
                                    //                            $rs3 = $bdd->prepare('INSERT INTO tab_histoconnexion(ipaddress,user_email , datecon, statconn) VALUES(:ipadress, :log, :datc, :statc)');
                                    //                            $rs3->execute(array('ipadress' => get_ip(), 'log' => $log ,'datc' => gmdate("Y-m-d H:i:s"), 'statc' => 1));


                               /// le numero d'ordre
                                    $numplaq=$rowg['numplaque'];
                                    $rsg = $bdd->prepare("select * from enrolement WHERE numplaque =:np and numplaque <>'$numplaq'");
                                    $rsg->execute(array('np'=>$_POST['numplaque']));
                                    $nb = $rsg->rowCount();
                                    $identite = $_POST['nom']." ".$_POST['pnom'];
if ($nb==0){
    if(!empty($photop)) {
        $tab = explode(".", $photop);
        $ph1 = ajoutitret($tab[0]);
        $ph2 = $tab[1];
        $photor = $ph1 . "_" . pwd_aleatoire(4) . "." . $ph2;
        $content_dir = 'img/pieceid/'; // dossier o� sera d�plac� le fichier
        $tmp_ph = $_FILES['photop']['tmp_name'];
        move_uploaded_file($tmp_ph, 'img/pieceid/'.$photor);
    }else{
        if (empty($rowg['photop'])){
            $photor='';
        }else{
            $photor=$rowg['photop'];
        }

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
        if (empty($rowg['photoplaque'])){
            $photor2='';
        }else{
            $photor2=$rowg['photoplaque'];
        }

    }
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

        //$dat = date("Y-m-d H:i:s");
        $rsql1 = $bdd->prepare('UPDATE  enrolement SET  idcom = :idcom,  idpays = :idpays, typep = :typep, 
                            numpiece = :numpiece,  photop = :photop, nom = :nom,  pnom = :pnom,  datenaiss = :datenaiss,dateenrole = :dateenrole,   telp = :telp, tels = :tels
                            ,numplaque = :numplaque,  photoplaque = :photoplaque, demandem = :demandem,  demandep = :demandep,  idagencecgi = :idagencecgi,   daterdvcgi = :daterdvcgi, 
                            autrerdv = :autrerdv,lieuplaque = :lieuplaque,datemodif = :datemodif,idmodif = :idmodif
                               WHERE idenrolement = :id ');
        //  print_r($rsql1);
        $tab = $rsql1->execute(array('idcom' => $_POST['zoneid'],  'idpays' => $_POST['paysn'], 'typep' => $_POST['typep'], 'numpiece' => $_POST['nump'], 'photop' => $photor,
            'nom' => $_POST['nom'], 'pnom' => $_POST['pnom'], 'datenaiss' => formatinv_date($_POST['datenaiss']), 'dateenrole' => formatinv_date($_POST['datenrol']), 'telp' => $_POST['telp'], 'tels' => $_POST['tels'], 'numplaque' => $_POST['numplaque'],
            'photoplaque' => $photor2, 'demandem' => $_POST['dm'], 'demandep' => $_POST['dp'], 'idagencecgi' => $_POST['cgi'], 'daterdvcgi' => $dtrdvcgi,
            'autrerdv' => $dtautre, 'lieuplaque' => $_POST['lieup'], 'datemodif' => gmdate("Y-m-d H:i:s"),'idmodif' => $_SESSION['id'], 'id' =>$id ));

    } catch (Exception $e) {
        die("Erreur ! " . $e->getMessage());
    }
    header("location:?page=listeenrole");
}else{

    echo ' <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">× </button><strong> Accès erroné : </strong>
       Numéro de la plaque numérologique doit etre uniques ! </div>';
}

                                } catch (Exception $e) {

                                    echo 'Erreur : ' . $e->getMessage() . '<br />';

                                    echo 'N° : ' . $e->getCode();

                                }



                        }

                        ?>
                        <form class="form-horizontal login_validator" id="form_inline_validator" action=""  method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Date Enrolement </h5>
                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp1" name="datenrol" value="<?php if(isset($rowg['dateenrole'])){ echo format_date($rowg['dateenrole']) ;}  ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Zone Enrolement </h5>
                                    <div class="input-group">
                                        <select class="form-control chzn-select" name="zoneid" >
                                            <option selected disabled>Choisir le zone</option>
                                            <?php
                                            $i=1;
                                            $rsz = $bdd->prepare('select * from zone  ORDER by libelle_com asc ');
                                            $rsz->execute();
                                            while($rowz = $rsz->fetch()) {
                                                ?>
                                                <option value="<?php echo $rowz['id_commune'] ?>" <?php if(isset($rowg['idcom']) && $rowg['idcom']==$rowz['id_commune']){ echo "selected";} ?>><?php echo $rowz['libelle_com'] ?></option>

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
                                           <option value="CNI"  <?php if(isset($rowg['typep']) && $rowg['typep']=="CNI"){ echo "selected";} ?>>CNI</option>
                                           <option value="PASSPORT"  <?php if(isset($rowg['typep']) && $rowg['typep']=="PASSPORT"){ echo "selected";} ?>>PASSPORT</option>
                                           <option value="PERMIS DE CONDUIRE"  <?php if(isset($rowg['typep']) && $rowg['typep']=="PERMIS DE CONDUIRE"){ echo "selected";} ?>>PERMIS DE CONDUIRE</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numéro  du document</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nump" value="<?php if(isset($rowg['numpiece'])){ echo $rowg['numpiece'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-2 input_field_sections">
                                    <h5>Photo  du document</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-4" name="photop" type="file"  class="file-loading" <?php if (empty($rowg['photop'])) { ?>required<?php }?> style="display: block">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 input_field_sections">

                                    <div class="input-group">
                                        <div class="input-group">
                                            <div class="file-preview-frame" id="preview-1631103769724-0" data-fileindex="0" data-template="image"><div class="kv-file-content">
                                                    <img src="img/pieceid/<?php echo $rowg['photop']; ?>"   class="kv-preview-data file-preview-image" title="<?php echo $rowg['photop']; ?>" alt="fondmoisson.jpg" style="width:100px;height:110px;">
                                                </div><div class="file-thumbnail-footer">
                                                    <div class="file-footer-caption" title="fondmoisson.jpg"></div>
                                                    <div class="file-actions">
                                                        <div class="file-upload-indicator" title="Not uploaded yet"></div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Nom</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="nom" value="<?php if(isset($rowg['nom'])){ echo $rowg['nom'] ;}  ?>"  required>
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Prénoms</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="pnom" required value="<?php if(isset($rowg['pnom'])){ echo $rowg['pnom'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-4 input_field_sections">
                                    <h5>Date de naissance</h5>
                                    <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                        <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp3" name="datenaiss" value="<?php if(isset($rowg['datenaiss'])){ echo format_date($rowg['datenaiss']);}  ?>">
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
                                                <option value="<?php echo $rowp['idpays'] ?>"  <?php if(isset($rowg['idpays']) && $rowg['idpays']==$rowp['idpays']){ echo "selected";} ?>><?php echo $rowp['labelp'] ?></option>

                                            <?php }  ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numero de telephone</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="telp"  name="telp" value="<?php if(isset($rowg['telp'])){ echo $rowg['telp'] ;}  ?>" required>
                                        <span class="input-group-addon"> <i class="fa fa-phone text-primary"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numero de telephone 2</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="tels" required value="<?php if(isset($rowg['tels'])){ echo $rowg['tels'] ;}  ?>">
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


                                <div class="col-lg-4 input_field_sections">
                                    <h5>Numéro de la plaque d'immatriculation</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="numplaque" value="<?php if(isset($rowg['numplaque'])){ echo $rowg['numplaque'] ;}  ?>">
                                        <span class="input-group-addon"> <i class="fa fa-file text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">
                                    <h5>Photo de la plaque d'immatriculation</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <input id="input-41" name="photopl" type="file"  class="file-loading"  style="display: block">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 input_field_sections">

                                    <div class="input-group">
                                        <div class="input-group">
                                            <div class="file-preview-frame" id="preview-1631103769724-0" data-fileindex="0" data-template="image"><div class="kv-file-content">
                                                    <img src="img/plaque/<?php echo $rowg['photoplaque']; ?>"   class="kv-preview-data file-preview-image" title="<?php echo $rowg['photoplaque']; ?>" alt="<?php echo $rowg['photoplaque']; ?>" style="width:100px;height:110px;">
                                                </div><div class="file-thumbnail-footer">
                                                    <div class="file-footer-caption" title="<?php echo $rowg['photoplaque']; ?>"></div>
                                                    <div class="file-actions">
                                                        <div class="file-upload-indicator" title="Not uploaded yet"></div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                    <option selected value="0"  <?php if(isset($rowg['demandem']) && $rowg['demandem']=="0"){ echo "selected";} ?>>Aucune demande</option>
                                                    <option value="Mutation Classique"  <?php if(isset($rowg['demandem']) && $rowg['demandem']=="Mutation Classique"){ echo "selected";} ?>>Mutation Classique</option>
                                                    <option value="Mutation  ORM" <?php if(isset($rowg['demandem']) && $rowg['demandem']=="Mutation  ORM"){ echo "selected";} ?>>Mutation  ORM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="retourgrise"  <?php if ($rowg['demandem']=='0'){ ?> style="display: none"<?php  } ?>>
                                        <div class="col-lg-6 input_field_sections">
                                            <h5>CGI</h5>
                                            <div class="input-group">
                                                <select class="form-control chzn-select" name="cgi" id="cgi" >

                                                    <option  selected value="0" >Choisir CGI</option>
                                                    <?php
                                                    $i=1;
                                                    if ($rowg['demandem']!='Mutation Classique'){
                                                       $sqlcgi = 'select * from agencecgi WHERE type=0 ORDER by nomcgi asc ';
                                                    }else{
                                                    if ($rowg['demandem']!='Mutation  ORM'){
                                                        $sqlcgi = "select * from agencecgi WHERE type='orm' ORDER by nomcgi asc ";
                                                    }
                                                    }
                                                    $rscgi = $bdd->prepare($sqlcgi);
                                                    $rscgi->execute();
                                                    while($rowcgi = $rscgi->fetch()) {
                                                        ?>
                                                        <option value="<?php echo $rowcgi['idcgi'] ?>"  <?php if(isset($rowg['idagencecgi']) && $rowg['idagencecgi']==$rowcgi['idcgi']){ echo "selected";} ?>><?php echo $rowcgi['nomcgi'] ?></option>

                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 input_field_sections">
                                            <h5>Date RDV</h5>
                                            <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                            </span>
                                                <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp4" name="daterdvcgi" value="<?php if(isset($rowg['daterdvcgi'])){ echo format_date($rowg['daterdvcgi']) ;}  ?>">
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
                                            <option value="0" <?php if(isset($rowg['demandep']) && $rowg['demandep']=="0"){ echo "selected";} ?> >Aucune demande</option>
                                            <option value="Absence de plaque" <?php if(isset($rowg['demandep']) && $rowg['demandep']=="Absence de plaque"){ echo "selected";} ?>>Absence de plaque</option>
                                            <option value="Défaut de plaque" <?php if(isset($rowg['demandep']) && $rowg['demandep']=="Défaut de plaque"){ echo "selected";} ?>>Défaut de plaque</option>
                                        </select>
                                    </div>
                                    </div>
                                        <div id="plaq" <?php if ($rowg['demandep']=='0'){ ?> style="display: none"<?php  } ?>>
                                            <div class="col-lg-6 input_field_sections" >
                                                <h5>Date RDV</h5>
                                                <div class="input-group">
                                                <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i>
                                                </span>
                                                    <input autocomplete="off" type="text" class="form-control" placeholder="jj-mm-aaaa" id="dp6" name="dtrdvpl"  value="<?php if(isset($rowg['autrerdv'])){ echo format_date($rowg['autrerdv']) ;}  ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 input_field_sections" id="retourplaque">
                                                <h5>-</h5>
                                                <div class="input-group"> <span class="input-group-addon"> <i class="fa fa-calendar text-primary"></i> </span>
                                                    <input autocomplete="off" type="text" class="form-control" value="<?php if(isset($rowg['lieuplaque'])){ echo $rowg['lieuplaque'] ;}  ?>" placeholder=""  readonly name="lieup">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </div>
                            </div>
                            <br>


                            <br>
                            <hr />
                            <div class="form-group row">
                                <div class="col-lg-7 input_field_sections"></div>
                                <div class="col-lg-5 push-lg-2">
                                    <button class="btn btn-primary" type="submit" name="ok">
                                        <i class="fa fa-user"></i>
                                        Valider l’enrôlement
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
        form_data2.append("tel", tel);

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
                }else {
                    document.getElementById("retoursms").innerHTML ='Sms echoué !'
                }

                //                document.getElementById("retourajprix").innerHTML = this.responseText;
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }
    }



</script>