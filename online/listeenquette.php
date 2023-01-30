<!-- global styles-->

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
              Liste des enquetes
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
                    <a href="?page=milieu">Nouvelle enquete</a>
                </li>
                <li class="active breadcrumb-item">Liste des enquetes</li>
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
                            <i class="fa fa-table"></i> Listes des enquetes
                        </div>
                        <div class="card-block m-t-35">
                            <table id="example2" class="display table table-stripped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Enregistré le</th>
                                    <th>Agence</th>
                                    <th>date visite</th>
                                    <th>Durée de la visite</th>
                                    <th>Periode</th>
                                    <th>Scenarii</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $i=1;
                                $rsg = $bdd->prepare('select * from table_visite,agence,periodevisite,scenarii  WHERE scenarii.idsc=table_visite.idscenari and table_visite.idperiode=periodevisite.idp and agence.id_commune=table_visite.idagence AND supp=0 and idagent =:zid ORDER by idvisite DESC ');
                                $rsg->execute(array("zid"=>$_SESSION['id']));
                                while($rowg = $rsg->fetch()) {
                                ?>

                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo format_date($rowg['dateenr']); ?></td>
                                    <td><?php echo $rowg['libelle_com']; ?></td>
                                    <td><?php echo format_date($rowg['datevisite']); ?></td>
                                    <td><?php echo $rowg['heuredb']." à ".$rowg['heurefin']; ?></td>
                                    <td><?php echo $rowg['heurev']; ?></td>
                                    <td><?php  echo $rowg['libscenarii']; ?></td>

                                    <td>
                                            <a href="?page=modifenquete&id=<?php echo $rowg['idvisite']; ?>" class="todoedit">
                                                <span class="fa fa-pencil"></span>
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