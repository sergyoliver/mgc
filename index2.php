<?php

?>
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
<style>
    @media print {

        body * {
            visibility: hidden;
            -webkit-print-color-adjust: exact !important;

        }

        .head{
            display: none;
        }
        #printBtn {
            visibility: hidden;
        }

        #bloc {
            visibility: hidden;
        }
        #v,#ok2 {
            visibility: hidden;
        }

        #bloc3{  visibility: hidden;
        }
        #bloc2{  visibility: visible;
        }



    }
</style>
<header class="head">
    <div class="main-bar row">
        <div class="col-xs-6">
            <h4 class="m-t-5">
                <i class="fa fa-home"></i>
                Dashboard
            </h4>
        </div>
    </div>
</header>
<div class="outer">
    <div class="inner bg-container">
        <div class="row" id="bloc">
            <div class="col-xl-12 col-lg-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div class="bg-primary top_cards">
                            <div class="row icon_margin_left">

                                <div class="col-lg-5 icon_padd_left">
                                    <div class="float-xs-left">
                                    <span class="fa-stack fa-sm">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-braille fa-stack-1x fa-inverse text-primary sales_hover"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-lg-7 icon_padd_right">
                                    <div class="float-xs-right cards_content">
                                        <span class="number_val" id="widget_count5"><?php // echo number_format($nbtotenr) ?></span>
                                        <br>
                                        <span class="card_description">Nb.Total  Masculin</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class=" top_cards" style="background-color: #EF0D1C; color: white">
                            <div class="row icon_margin_left">
                                <div class="col-lg-5 icon_padd_left">
                                    <div class="float-xs-left">
                            <span class="fa-stack fa-sm">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-braille fa-stack-1x fa-inverse text-danger visit_icon"></i>
                            </span>
                                    </div>
                                </div>
                                <div class="col-lg-7 icon_padd_right">
                                    <div class="float-xs-right cards_content">
                                        <span class="number_val" id="visitors_count"><?php // echo number_format($nbag) ?></span>
                                        <br>
                                        <span class="card_description">Nb. Total Masculin</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="bg-primary top_cards">
                            <div class="row icon_margin_left">

                                <div class="col-lg-5 icon_padd_left">
                                    <div class="float-xs-left">
                                    <span class="fa-stack fa-sm">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-braille fa-stack-1x fa-inverse text-primary sales_hover"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-lg-7 icon_padd_right">
                                    <div class="float-xs-right cards_content">
                                        <span class="number_val" id="widget_count5"><?php // echo number_format($nbtotenr) ?></span>
                                        <br>
                                        <span class="card_description">Nb.Total Enrolés</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
       </div>
        <div class="row" id="bloc">
            <div class="col-xl-12 col-lg-12 col-xs-12">
                <div class="row">
        <div class="col-xl-12 col-lg-12 col-xs-12 stat_align">
            <div class="card  top_cards">
                <?php
                /// tout ce qui est signé

                /// les favorable
                /*
                                    $rsf = $bdd->prepare("select * from enrolement WHERE  demandem >'0' and supp=0 or demandep>'0' and supp=0");
                                    $rsf->execute();
                                    $nbf = $rsf->rowCount();
                                    $pdmdf = ($nbf*100)/40000;



                                    $rsct = $bdd->prepare('select * from enrolement WHERE  demandep = :a and demandem = :b and supp=0');
                                    $rsct->execute(array( "a"=>0, "b"=>0 ));
                                    $nbct = $rsct->rowCount();
                                    //$pct = ($nbct*100)/$nbtotenr;
                                    $pct = ($nbct*100)/60000;

                                    $rsdm = $bdd->prepare('select * from enrolement WHERE  demandem <> :b and supp=0');
                                    $rsdm->execute(array(  "b"=>0 ));
                                    $nbdm = $rsdm->rowCount();
                                    $pdm = ($nbdm*100)/$nbf;

                                    /// les non favorable

                                    $rsap = $bdd->prepare('select * from enrolement WHERE  demandep = :a and supp=0');
                                    $rsap->execute(array( "a"=>'Absence de plaque' ));
                                    $nbap = $rsap->rowCount();
                                    $pap = ($nbap*100)/$nbf;

                                    /// a redimensionner

                                    $rsdp = $bdd->prepare('select * from enrolement WHERE  demandep = :a and supp=0');
                                    $rsdp->execute(array( "a"=>'Défaut de plaque' ));
                                    $nbdp = $rsdp->rowCount();
                                    $pdp = ($nbdp*100)/$nbf;
                                    */
                ?>
                <div class="card-header bg-info">
                    Repartition des enrolés par catégorie
                </div>
                <div class="card-body">
                    <div class="task-item">

                        Adherents
                        <span class="float-xs-right text-muted progress-info"><?php //echo  $nbct." Soit ". round($pct,2)."%" ?></span>
                        <div id="progress-bar">
                            <progress class="progress progress-striped progress-primary" value="<?php //echo round($pct,2) ?>"
                                      max="100"></progress>
                        </div>
                    </div>
                    <div class="task-item">

                        Sympatisant
                        <span class="float-xs-right text-muted progress-info"><?php //echo  $nbf." Soit ". round($pdmdf,2)."%" ?></span>
                        <div id="progress-bar">
                            <progress class="progress progress-striped progress-success" value="<?php //echo round($pdmdf,2) ?>"
                                      max="100"></progress>
                        </div>
                    </div>
                    <div class="task-item">
                        Sorties
                        <span class="float-xs-right text-muted progress-primary"><?php //echo  $nbdm." Soit ". round($pdm)."%" ?></span>
                        <div id="progress-bar1">
                            <progress class="progress progress-warning" value="<?php //echo round($pdm) ?>"
                                      max="100"></progress>
                        </div>
                    </div>

                </div>
            </div>
        </div>
                </div>

            </div>
        </div>

        <!-- /.inner -->
    </div>
    <!-- /.outer -->
</div>
<!--<script src="assets/js/jquery-3.3.1.min.js"></script>-->

<!--<script src="js/jspdft.min.js?v1632756685"></script>-->
<!--<script src="js/jspdf.plugin.autotable.js?v1632756685"></script>-->



<script>
    // add in your javaScript

    function onClick() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.canvas.height = 72 * 11;
        pdf.canvas.width = 72 * 8.5;
        canvg('canvas', $("#chart2").html().trim());
        var img = canvas.toDataURL("image/png");
        doc.addImage(img, 'PNG', 15, 40, 180, 60);
        source = $('#test')[0];
        //alert($('#test')[0]);
        specialElementHandlers = {
            '#bypassme': function(element, renderer){
                return true
            }
        };
        margins = {
            top: 10,
            left: 10,
            width: 30
        };

        pdf.fromHTML(
            source // HTML string or DOM elem ref.
            , margins.left // x coord
            , margins.top // y coord
            , {
                'width': 30 // max width of content on PDF
                , 'elementHandlers': specialElementHandlers
            },
            function (dispose) {


                pdf.save('Plan de situation Lot 38.pdf');
            });

    }



    function printDocument() {
        window.printDocument();
        var doc = document.getElementById("print");

        //Wait until PDF is ready to print
        if (typeof doc.print === 'undefined') {
            setTimeout(function(){printDocument("print");}, 1000);
        } else {
            doc.print();
        }
    }
    //    new CountUp("widget_count1", 0, 2436, 0, 2.5, options).start();
    function remplirtab(){

        var xhr2;
        var form_data2 = new FormData();

        form_data2.append("z", $('#zone').val());
        form_data2.append("dt", $('#dp1').val());
        form_data2.append("ag", $('#ag').val());

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "tablostat.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
                var json = $.parseJSON(this.responseText);
                // console.log(json.simple);
                document.getElementById("simple").innerHTML =json.simple;
                document.getElementById("dp").innerHTML =json.dp;
                document.getElementById("ap").innerHTML =json.ap;
                document.getElementById("cgc").innerHTML =json.cgc;
                document.getElementById("orm").innerHTML =json.orm;
                $('#simple1').val(json.simple);

                //                document.getElementById("retourajprix").innerHTML = this.responseText;
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }

    }

    function affiche() {
        var xhr2;
        var form_data2 = new FormData();

        form_data2.append("z", $('#zone').val());
        form_data2.append("dt", $('#dp1').val());
        form_data2.append("dt2", $('#dp2').val());
        form_data2.append("ag", $('#ag').val());

        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "tablostat.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
                var json = $.parseJSON(this.responseText);
                // console.log(json.simple);
                document.getElementById("simple").innerHTML =json.simple;
                document.getElementById("dp").innerHTML =json.dp;
                document.getElementById("ap").innerHTML =json.ap;
                document.getElementById("cgc").innerHTML =json.cgc;
                document.getElementById("orm").innerHTML =json.orm;
//               $('#simple1').val(json.simple);

                // Donut chart
                var chart1 = c3.generate({
                    bindto: '#chart1',
                    data: {
                        columns: [
                            ['data1', 10],
                            ['data2', 130]
                        ],
                        type: 'donut'
                    },
                    donut: {
                        title: "Repartition "
                    },
                    color: {
                        pattern: ['#D23DF2', '#0fb0c0', '#13B631', '#ffb300', '#d1a47a']
                    }
                });

                setTimeout(function () {
                    chart1.load({
                        columns: [
                            ["Simple contact", json.simple],
                            ["Mutation Classique", json.cgc],
                            ["Mutation ORM", json.orm],
                            ["Absence de plaque", json.ap],
                            ["Défaut de plaque", json.dp]
                        ]
                    });
                }, 1500);

                setTimeout(function () {
                    chart1.unload({
                        ids: 'data1'
                    });
                    chart1.unload({
                        ids: 'data2'
                    });
                }, 2500);
                //                document.getElementById("retourajprix").innerHTML = this.responseText;
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }

    }
    function visualiser() {
        var xhr2;
        var form_data2 = new FormData();
        var t="";

        form_data2.append("dtdb", $('#dp3').val());
        form_data2.append("dtfin", $('#dp4').val());


        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "affichenb.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
                var json = $.parseJSON(this.responseText);
                // console.log(json.simple);
//               document.getElementById("simple").innerHTML =json.simple;
//               document.getElementById("dp").innerHTML =json.dp;
//               document.getElementById("ap").innerHTML =json.ap;
//               document.getElementById("cgc").innerHTML =json.cgc;
//               document.getElementById("orm").innerHTML =json.orm;
//               $('#simple1').val(json.simple);

                if ($('#dp3').val()===$('#dp4').val()){
                    t = 'Ce jour : '+$('#dp3').val();
                }else{
                    t = 'durant la période du : '+$('#dp3').val()+' au '+$('#dp4').val();
                }
                document.getElementById("infonb").innerHTML ='<div class="bg-warning top_cards">'
                    +'<div class="row icon_margin_left"> <div class="col-lg-2 icon_padd_left"> <div class="float-xs-left">'
                    +'<span class="fa-stack fa-sm"> <i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-braille fa-stack-1x fa-inverse text-warning revenue_icon"></i>'
                    +'</span> </div> </div> <div class="col-lg-10 icon_padd_right"> <div class="float-xs-right cards_content" >'
                    +'<span class="number_val" id="revenue_count">'+this.responseText+'</span><i class="fa fa-bell fa-2x"></i> <br> <span class="card_description">Personnes enrolés '+ t +'</span></div> </div> </div> </div>' ;
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }

    }
    function affichep() {
        var xhr2;
        var form_data2 = new FormData();
        var t="";

        form_data2.append("dtdb", $('#dp5').val());
        form_data2.append("dtfin", $('#dp6').val());
        form_data2.append("zid", $('#zoneid').val());


        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "affichenbperiode.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {

                document.getElementById("retourperiode").innerHTML =this.responseText;
                courbe();
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }

    }
    function courbe() {
        // stacked area chart


        var xhr2;
        var form_data2 = new FormData();
        var t="";

        form_data2.append("dtdb", $('#dp5').val());
        form_data2.append("dtfin", $('#dp6').val());
        form_data2.append("zid", $('#zoneid').val());


        if (window.XMLHttpRequest) xhr2 = new XMLHttpRequest();
        else if (window.ActiveXObject) xhr2 = new ActiveXObject('Microsoft.XMLHTTP');
        xhr2.open('POST', "tabloevolution.php", true);
        xhr2.send(form_data2);
        xhr2.onreadystatechange = function() {
            if (xhr2.readyState == 4 && xhr2.status == 200) {

                document.getElementById('entete').innerHTML='<i class="fa fa-table"></i> EVOLUTION HEBDOMADAIRE DU '+$('#dp5').val()+' AU '+$('#dp6').val() ;

                var json2 = $.parseJSON(this.responseText);
                // console.log(json2[0]);
                var chart = c3.generate({
                    bindto: '#chart2',
                    label: "Vitesse journalière",
                    data: {

                        columns: [

                            json2[1],
                            json2[2],
                            json2[3],
                            json2[4],
                            json2[5]
                        ],
                        type: 'spline',
                        colors: {
                            data1: '#ff1000',
                            data2: '#efc410',
                            data3: '#0c04ff',
                            data4: '#3f6718',
                            data5: '#00c0ef',
                            data6: '#d1a47a'
                        },

                        color: function(color, d) {
                            return d.id && d.id === 'data6' ? d3.rgb(color) : color;
                        }
                    },
                    axis: {
                        x: {
                            type: 'category',
                            categories: json2[0]
                        }
                    }
                });
            }
            if (xhr2.readyState == 4 && xhr2.status != 200) {
                alert("Error : returned status code " + xhr2.status);
            }
        }

//        setTimeout(function() {
//            chart.transform('area-spline');
//        }, 4000);
        // End of stacked area chart
    }

</script>
<script type="text/javascript" src="vendors/raphael/js/raphael-min.js"></script>
<script type="text/javascript" src="vendors/justgage/js/justgage.js"></script>
<script type="text/javascript" src="vendors/d3/js/d3.min.js"></script>
<script type="text/javascript" src="vendors/c3/js/c3.min.js"></script>
<!-- end of plugin script -->
<!--<script type="text/javascript" src="js/pages/advanced_charts.js"></script>-->