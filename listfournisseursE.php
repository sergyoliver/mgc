<!-- global styles-->

<link type="text/css" rel="stylesheet" href="vendors/select2/css/select2.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/scroller.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/colReorder.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="vendors/datatables/css/dataTables.bootstrap.min.css?d=<?php echo time() ?>" />
<link type="text/css" rel="stylesheet" href="css/pages/dataTables.bootstrap.css?d=<?php echo time() ?>" />
<!-- end of plugin styles -->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="css/pages/tables.css?d=<?php echo time() ?>" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<header class="head">
    <div class="main-bar row">
        <div class="col-sm-5 col-lg-6 skin_txt">
            <h4 class="nav_top_align">
                <i class="fa fa-table"></i>
              Liste des Fournisseurs
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
                    <a href="?page=ajoutfournisseurs">Nouveau Fourniseur</a>
                </li>
                <li class="active breadcrumb-item">Liste des Fournisseurs</li>
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
                            <i class="fa fa-table"></i> Listes des Fournisseurs
                        </div>
                        <div class="card-block m-t-35">
                            <div class="btn-group" style="margin-bottom: 10px;">    
                                        <a href="?page=ajoutfournisseursE" id="editable_table_new" class=" btn btn-default">
                                        Ajouter un Fournisseurs &nbsp;<i class="fa fa-plus" class="btn btn-primary"></i>
                                        </a>                                     
                                </div>

                            <table id="example1"  class="table2excel display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>N° DOSSIER</th>
                                    <th>Nom de l'Entreprise</th>
                                    <th>Forme Juridique</th>
                                    <th>Registre de Commerce</th>
                                    <th>NCC</th>
                                    <th>Regime d'imposition</th>
                                    <th>Type Prestation</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                              <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from fournisseurs ORDER by id_fournisseurs ASC ');
                                $rsg->execute(array());
                                while($rowg = $rsg->fetch()) {
                                ?>

                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rowg['Num_dossier']; ?></td>
                                    <td><?php echo $rowg['Name_entreprise']; ?></td>
                                    <td><?php echo $rowg['Forme_juridique']; ?></td>
                                    <td><?php echo $rowg['Num_Registre_com']; ?></td>
                                    <td><?php echo $rowg['NCC']; ?></td>
                                    <td><?php echo $rowg['Regime_lmposition']; ?></td>
                                    <td><?php echo $rowg['typefournisseurs']; ?></td>
                                    <td>

                                        
                                            <a href="?page=modiffournisseursE&id=<?php echo $rowg['id_fournisseurs']; ?>" class="todoedit">
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