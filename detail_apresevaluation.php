<?php
session_start();
error_reporting(0);
include "connexion/connectpg.php";
include "connexion/function.php";

?>
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
    $id = $_POST['str'];
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


    $db = format_date2($rowseq['date_debut']);
    $df = format_date2($rowseq['date_fin']);
    $i = 1;
    $reqdt = $bdd->prepare('select max(date_fin) as df, min(date_debut) as db, stat,tache,codepl from table_detailseqchrono where id_pl=:ids and supp=0  GROUP BY tache order by tache ASC');
    $reqdt->execute(array('ids' => $id));
    while ($rowg = $reqdt->fetch()) {
        $reqt = $bdd->prepare('select * from  table_detailseqchrono t2 where t2.supp=0 and  t2.tache=:idt and id_pl=:ids ORDER BY tache ASC');
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
            <td><?php echo strtoupper($rowt['tauxrep']).'%'; ?></td>
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
        $recupst = $bdd->prepare('select * from table_detailseqchrono ds WHERE   ds.tache=:idt and ds.supp=0  and id_pl=:ids   order by id_dseq DESC');
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


            <?php } $i++;} } ?>

    </tbody>
</table>