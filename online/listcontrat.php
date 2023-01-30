<!-- global styles-->

<link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/scroller.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/colReorder.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/dataTables.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="css/pages/dataTables.bootstrap.css?d=<?php echo time() ?>" />
<!-- end of plugin styles -->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="css/pages/tables.css?d=<?php echo time() ?>" />
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->


<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-table"></i>
              Liste des Contrats
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
                    <a href="?page=ajoutcontrat">Nouveau Contrat</a>
                </li>
                <li class="active breadcrumb-item">Liste des Contrats</li>
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
                            <i class="fa fa-table"></i> Listes des Contrats
                        </div>
                        <div class="card-block m-t-35">
                             <div class="btn-group" style="margin-bottom: 10px;">    
                                        <a href="?page=creercontrat" id="editable_table_new" class=" btn btn-default">
                                        Générer un contrat &nbsp;<i class="fa fa-plus" class="btn btn-primary"></i>
                                        </a>                                     
                                </div>
                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                   
                                    <th>N°contrat</th> 
                                    <th>Projet</th>
                                    <th>Fournisseurs</th>
                                    <th>Date Signature</th>
                                    <th>Date fin contrat</th>         
                                    <th>Montant du contrat (FCFA)</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                 <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from  contratanc ORDER by id_Contrat  ASC ');
                                $rsg->execute(array());
                                while($rowg = $rsg->fetch()) {
                                ?>
                                <tr>
                                   
                                    <td><?php echo $rowg['numcc']; ?></td>
                                    <?php
                                $i=1;
                                $idp =$rowg['Id_Projet'];
                                $rsa = $bdd->prepare("select * from  type_projet  WHERE Id_typep  = :zid");
                                $rsa->execute(array("zid"=>$idp));
                                //$rowp = $rsa->fetch();
                                while($rowp = $rsa->fetch()) {
                                ?>
                                    <td><?php echo $rowp['Nom_Projet']; ?></td>
                                <?php }?>
                                <?php
                                $i=1;
                                $idf =$rowg['id_fournisseurs'];
                                $rsf = $bdd->prepare("select * from  fournisseurs  WHERE id_fournisseurs  = :zid");
                                $rsf->execute(array("zid"=>$idf));
                                while($rowf = $rsf->fetch()) {
                                ?>
                                    <td><?php echo $rowf['Name_entreprise']; ?></td>
                                <?php }?>
                                    <td><?php echo format_date($rowg['Date_signature_C']); ?></td>
                                    <td><?php echo format_date($rowg['Date_achevement']); ?></td>
                                    <td><?php echo $rowg['mtn_contrat']; ?></td>
                                    <td>

                                        <div class="dropdown no-bg">
                                            <button class="btn btn-warning dropdown-toggle"
                                                    type="button" id="up1" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="up1">
                                                <a class="dropdown-item" href="?page=detailreservation_com&id=<?php //echo $rowg['idres']; ?>" target="_blank"><i class="fa fa-sign-out"></i>
                                                    Paiement
                                                </a>
                                                <a class="dropdown-item" target="_blank" href="?page=ajoutfacture&idv=<?php //echo $rowg['idres']; ?>&idop=<?php echo $idop; ?>"><i class="fa fa-sign-out"></i>
                                                    Facture
                                                </a>

                                                    <a class="dropdown-item" target="_blank" href="?page=plandesituationm1&id=<?php //echo $rowg['idres']; ?>&amp;idop=<?php// echo $rowg['idop']; ?>"><i class="fa fa-sign-out"></i>
                                                        Plan de Situation
                                                    </a>


                                            </div>
                                        </div>
                                            <a href="?page=modifcontrat&id=<?php echo $rowg['id_Contrat']; ?>" class="todoedit">
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
