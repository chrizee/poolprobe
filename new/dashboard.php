<?php
require_once "setup.php";
use setup\DB;
use setup\Config;

$waterTemp = DB::getInstance()->query("SELECT * FROM sensors order by timestamp desc limit 10;")->results();
$Wassertemperatur = DB::KPI($waterTemp, 'atlas_temp');
$waterPH = DB::KPI($waterTemp, 'ph');

$orp = DB::KPI(DB::getInstance()->query("SELECT * FROM sensors LIMIT 10;")->results(), 'orp');
$ausTemp = DB::KPI(DB::getInstance()->query("SELECT * FROM temp_tb LIMIT 10;")->results(),'wert');

//graph
$values = DB::getInstance()->query("SELECT atlas_temp, timestamp FROM sensors order by timestamp desc limit 10;")->results();
$line = DB::lineGraphFromat($values);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PoolProbe | Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="images/icons/favicon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="styles/animate.css">
    <link type="text/css" rel="stylesheet" href="styles/all.css">
    <link type="text/css" rel="stylesheet" href="styles/main.css">
    <link type="text/css" rel="stylesheet" href="styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="styles/pace.css">
    <style type="text/css">
        body {
            color: #e4e4e4;
        }
        h4, div.caption {
            color: #ffce54;
        }
        .panel, .portlet > .portlet-header, .portlet .portlet-body {
            background: #383838;
        }
        .page-title-breadcrumb {
            background-color: #505050;
        }
    </style>
    <script src="script/dashboard.min.js"></script>
</head>
<body>
<div>
    <!--BEGIN BACK TO TOP-->
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
    <!--END BACK TO TOP-->
    <!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <a id="logo" href="dashboard.php" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">PoolProbe</span><span style="display: none" class="logo-text-icon">µ</span></a></div>
            <div class="topbar-main">

                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <!--<li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-bell fa-fw"></i><span class="badge badge-green">3</span></a>

                    </li>
                    <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-envelope fa-fw"></i><span class="badge badge-orange">7</span></a>

                    </li>
                    <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-tasks fa-fw"></i><span class="badge badge-yellow">8</span></a>

                    </li>-->
                    <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="images/avatar/48.jpg" alt="" class="img-responsive img-circle"/>&nbsp;<span class="hidden-xs">Admin</span>&nbsp;<!--<span class="caret"></span>--></a>
                        <!--<ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="#"><i class="fa fa-user"></i>My Profile</a></li>
                            <li><a href="#"><i class="fa fa-calendar"></i>My Calendar</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i>My Inbox<span class="badge badge-danger">3</span></a></li>
                            <li><a href="#"><i class="fa fa-tasks"></i>My Tasks<span class="badge badge-success">7</span></a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-lock"></i>Lock Screen</a></li>
                            <li><a href="#"><i class="fa fa-key"></i>Log Out</a></li>
                        </ul>-->
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!--END TOPBAR-->
    <div id="wrapper">
        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            <!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">
                        Dashboard</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Dashboard</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE-->
            <!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="tab-general">
                    <div id="sum_box" class="row mbl">
                        <div class="col-sm-6 col-md-3">
                            <div class="panel ph db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-flask"></i>
                                    </p>
                                    <h4 class="value">
                                            <span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0">
                                            </span></h4>
                                    <p class="description">
                                        PH Wert Wasser</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="panel Wassertemperatur db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-eyedropper"></i>
                                    </p>
                                    <h4 class="value">
                                        <span>215</span><span>&deg;c</span></h4>
                                    <p class="description">
                                        Wassertemperatur</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="panel orp db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-signal"></i>
                                    </p>
                                    <h4 class="value">
                                        <span>215</span></h4>
                                    <p class="description">
                                        ORP Wert Wasser</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="panel austemp db mbm">
                                <div class="panel-body">
                                    <p class="icon">
                                        <i class="icon fa fa-eyedropper"></i>
                                    </p>
                                    <h4 class="value">
                                        <span>128</span><span>&deg;c</span></h4>
                                    <p class="description">
                                        Aussentemperatur</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mbl">
                        <div class="col-lg-8 col-md-8">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="mbs">
                                                Temperaturverlauf</h4>
                                            <div id="area-chart-spline" style="width: 100%; height: 300px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="portlet box">
                                <div class="portlet-header">
                                    <div class="caption">
                                        Temps</div>
                                </div>
                                <div class="portlet-body">
                                    <div class="chayt-scroller">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            Aussentemperatur vertical guage
                                            <canvas title="<?php echo $ausTemp; ?> &deg;c" data-type="linear-gauge"
                                                    data-width="120"
                                                    data-height="400"
                                                    data-units="<?php echo $ausTemp; ?> °C"
                                                    data-min-value="0"
                                                    data-start-angle="90"
                                                    data-ticks-angle="180"
                                                    data-value-box="false"
                                                    data-max-value="220"
                                                    data-major-ticks="0,20,40,60,80,100,120,140,160,180,200,220"
                                                    data-minor-ticks="2"
                                                    data-stroke-ticks="true"
                                                    data-highlights='[ {"from": 100, "to": 220, "color": "rgba(200, 50, 50, .75)"} ]'
                                                    data-color-plate="#fff"
                                                    data-border-shadow-width="3"
                                                    data-borders="false"
                                                    data-needle-type="arrow"
                                                    data-needle-width="5"
                                                    data-needle-circle-size="7"
                                                    data-needle-circle-outer="true"
                                                    data-needle-circle-inner="false"
                                                    data-animation-duration="1500"
                                                    data-animation-rule="linear"
                                                    data-bar-width="20"
                                                    data-value="<?php echo $ausTemp; ?>"
                                            ></canvas>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            Wassertemperatur vertical guage
                                            <canvas title="<?php echo $Wassertemperatur; ?> &deg;c" data-type="linear-gauge"
                                                    data-width="120"
                                                    data-height="400"
                                                    data-units="<?php echo $Wassertemperatur; ?> °C"
                                                    data-min-value="0"
                                                    data-start-angle="90"
                                                    data-ticks-angle="180"
                                                    data-value-box="false"
                                                    data-max-value="220"
                                                    data-major-ticks="0,20,40,60,80,100,120,140,160,180,200,220"
                                                    data-minor-ticks="2"
                                                    data-stroke-ticks="true"
                                                    data-highlights='[ {"from": 100, "to": 220, "color": "rgba(200, 50, 50, .75)"} ]'
                                                    data-color-plate="#fff"
                                                    data-border-shadow-width="3"
                                                    data-borders="false"
                                                    data-needle-type="arrow"
                                                    data-needle-width="5"
                                                    data-needle-circle-size="7"
                                                    data-needle-circle-outer="true"
                                                    data-needle-circle-inner="false"
                                                    data-animation-duration="1500"
                                                    data-animation-rule="linear"
                                                    data-bar-width="20"
                                                    data-value="<?php echo $Wassertemperatur; ?>"
                                            ></canvas>
                                        </div>
                                    </div>
                                    <div class="chat-form">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mbl">
                        <div class="col-lg-12">
                            <div class="panel">
                                <div class="panel-body">

                                    <div id="col1" ><!-- chart will be drawn inside this DIV --></div><script>(function(){
                                            window.PLOTLYENV={};

                                            var gd = document.getElementById("col1")
                                            var resizeDebounce = null;

                                            function resizePlot() {
                                                var bb = gd.getBoundingClientRect();
                                                Plotly.relayout(gd, {
                                                    width: bb.width,
                                                    height: bb.height
                                                });
                                            }


                                            window.addEventListener("resize", function() {
                                                if (resizeDebounce) {
                                                    window.clearTimeout(resizeDebounce);
                                                }
                                                resizeDebounce = window.setTimeout(resizePlot, 100);
                                            });



                                            var trace1 = {

                                                x: <?php echo $line['x'];?>,
                                                y: <?php echo $line['y'];?>,
                                                line: {shape: "spline"},
                                                type: 'line'
                                            };
                                            var data = [trace1,];

                                            var layout = {
                                                title: false,
                                                height: 180*2,
                                                xaxis: {
                                                    title: 'Zeit',
                                                    showticklabels:true,
                                                    showgrid: true,
                                                    showline: true					  },
                                                yaxis: {
                                                    title: 'Temp',
                                                    showticklabels:true,
                                                    showgrid: true,
                                                    showline: true					  },
                                                margin: {
                                                    l: 50,
                                                    r: 20,
                                                    b: 50,
                                                    t: 5,
                                                    pad: 0
                                                },
                                                showlegend:false,					  barmode: 'group'
                                            };

                                            var modeBarManage = {
                                                modeBarButtonsToRemove: ["sendDataToCloud"],
                                                displaylogo: false};

                                            Plotly.plot(gd, data, layout, modeBarManage);
                                        }());
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END CONTENT-->
            <!--BEGIN FOOTER-->
            <div id="footer">
                <div class="copyright">
                    <a href="http://themifycloud.com"><?php echo date("Y"); ?> ©<?php echo Config::get('app/copyright')?></a></div>
            </div>
            <!--END FOOTER-->
        </div>
        <!--END PAGE WRAPPER-->
    </div>
</div>
<script src="script/jquery-1.10.2.min.js"></script>
<script src="script/jquery-migrate-1.2.1.min.js"></script>
<script src="script/jquery-ui.js"></script>
<script src="script/bootstrap.min.js"></script>
<script src="script/bootstrap-hover-dropdown.js"></script>
<script src="script/respond.min.js"></script>
<script src="script/jquery.metisMenu.js"></script>
<script src="script/jquery.slimscroll.js"></script>
<script src="script/jquery.cookie.js"></script>
<script src="script/icheck.min.js"></script>
<script src="script/custom.min.js"></script>
<script src="script/jquery.menu.js"></script>
<script src="script/pace.min.js"></script>
<script src="script/holder.js"></script>
<script src="script/responsive-tabs.js"></script>
<script src="script/jquery.flot.js"></script>
<script src="script/jquery.flot.categories.js"></script>
<script src="script/jquery.flot.pie.js"></script>
<script src="script/jquery.flot.tooltip.js"></script>
<script src="script/jquery.flot.resize.js"></script>
<script src="script/jquery.flot.fillbetween.js"></script>
<script src="script/jquery.flot.stack.js"></script>
<script src="script/jquery.flot.spline.js"></script>
<script src="script/index.js"></script>
<!--LOADING SCRIPTS FOR CHARTS-->
<script src="script/data.js"></script>
<script src="script/gauge.min.js"></script>
<!--CORE JAVASCRIPT-->
<script src="script/main.js"></script>
<script>        (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-145464-12', 'auto');
    ga('send', 'pageview');

    //BEGIN COUNTER FOR SUMMARY BOX
    counterNum($(".ph h4 span:first-child"), 0, <?php echo $waterPH; ?>, 0.1, 30);
    counterNum($(".Wassertemperatur h4 span:first-child"), 10, <?php echo $Wassertemperatur; ?>, 1, 50);
    counterNum($(".orp h4 span:first-child"), 100, <?php echo $orp ?> , 1, 30);
    counterNum($(".austemp h4 span:first-child"), 10, <?php echo $ausTemp; ?>, 1, 500);
    function counterNum(obj, start, end, step, duration) {
        $(obj).html(start);
        setInterval(function(){
            var val = Number($(obj).html());
            if (val < end) {
                $(obj).html((val+step).toFixed(2));
            } else {
                $(obj).html(end);
                clearInterval();
            }
        },duration);
    }
    //END COUNTER FOR SUMMARY BOX
    //BEGIN AREA CHART SPLINE
    var d6_1 = <?php echo DB::areaGraphFromat($values); ?>;
    //var d6_2 = [["Jan", 59],["Feb", 49],["Mar", 45],["Apr", 94],["May", 76],["Jun", 22],["Jul", 31]];
    $.plot("#area-chart-spline", [{
        data: d6_1,
        label: "atlas_temp",
        color: "#ffce54"
    }], {
        series: {
            lines: {
                show: !1
            },
            splines: {
                show: !0,
                tension: .4,
                lineWidth: 2,
                fill: .8
            },
            points: {
                show: !0,
                radius: 4
            }
        },
        grid: {
            borderColor: "#fafafa",
            borderWidth: 1,
            hoverable: !0
        },
        tooltip: !0,
        tooltipOpts: {
            content: "%x : %y",
            defaultTheme: true
        },
        xaxis: {
            tickColor: "#fafafa",
            mode: "categories"
        },
        yaxis: {
            tickColor: "#fafafa"
        },
        shadowSize: 0
    });
    //END AREA CHART SPLINE

    var gauge = new LinearGauge({
        renderTo: 'canvas-id',
        width: 120,
        height: 400,
        units: "°C",
        minValue: 0,
        startAngle: 90,
        ticksAngle: 180,
        valueBox: false,
        maxValue: 220,
        majorTicks: [
            "0",
            "20",
            "40",
            "60",
            "80",
            "100",
            "120",
            "140",
            "160",
            "180",
            "200",
            "220"
        ],
        minorTicks: 2,
        strokeTicks: true,
        highlights: [
            {
                "from": 100,
                "to": 220,
                "color": "rgba(200, 50, 50, .75)"
            }
        ],
        colorPlate: "#fff",
        borderShadowWidth: 0,
        borders: false,
        needleType: "arrow",
        needleWidth: 2,
        needleCircleSize: 7,
        needleCircleOuter: true,
        needleCircleInner: false,
        animationDuration: 1500,
        animationRule: "linear",
        barWidth: 10,
        value: 35
    }).draw();


</script>
</body>
</html>
