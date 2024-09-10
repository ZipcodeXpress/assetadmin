<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">This Month</span>
                    <h5>Membership Income</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">$<?=$sum1; ?></h1>
                    <div class="stat-percent font-bold text-success">100% <i class="fa fa-level-up"></i>
                    </div>
                    <small>Total Charged Monthly Fee</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">This Month</span>
                    <h5>Member</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$count1; ?></h1>
                    <div class="stat-percent font-bold text-success">100% <i class="fa fa-level-up"></i>
                    </div>
                    <small>Total Post-paid</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">This Month</span>
                    <h5>Penalty Income</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">$<?=$sum2; ?></h1>
                    <div class="stat-percent font-bold text-success">100% <i class="fa fa-level-up"></i>
                    </div>
                    <small>Total Charged Penalty</small>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">This Month</span>
                    <h5>Orders</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$count2; ?></h1>
                    <div class="stat-percent font-bold text-success">100% <i class="fa fa-level-up"></i>
                    </div>
                    <small>Total Orders</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Orders By Day</h5>
                    <!--div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-white active">天</button>
                            <button type="button" class="btn btn-xs btn-white">月</button>
                            <button type="button" class="btn btn-xs btn-white">年</button>
                        </div>
                    </div-->
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-line-chart-order"></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <ul class="stat-list">
                                <li>
                                    <h2 class="no-margins"><?=$count2; ?></h2>
                                    <small>Total Orders</small>
                                    <div class="stat-percent">100% <i class="fa fa-level-up text-navy"></i>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins "><?=$lastMonthOrders; ?></h2>
                                    <small>Last Month Orders</small>
                                    <div class="stat-percent">100% <i class="fa fa-level-up text-navy"></i>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins "><?=$lastMonthIncome; ?></h2>
                                    <small>Last Month Income</small>
                                    <div class="stat-percent">100% <i class="fa fa-level-up text-navy"></i>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Order Type</h5>
                </div>
                <div class="ibox-content">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart-order-type"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Pick With</h5>
                </div>
                <div class="ibox-content">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart-pick-with"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Box Status</h5>
                </div>
                <div class="ibox-content">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart-box-status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=Html::jsFile('@web/js/plugins/flot/jquery.flot.js')?>
<?=Html::jsFile('@web/js/plugins/flot/jquery.flot.pie.js')?>
 <script>
    $(document).ready(function() {
        var linedata1 = '<?=$linedata1; ?>';
	    var data1 = JSON.parse(linedata1);
        var linedata2 = '<?=$linedata2; ?>';
	    var data2 = JSON.parse(linedata2);
	    var dataset = [{
	        label: "Orders",
	        data: data1,
	        color: "#1ab394",
	        bars: {
	            show: true,
	            align: "center",
	            barWidth: 10 * 60 * 60 * 600,
	            lineWidth: 0
	        }
	    },
	    {
	        label: "Income",
	        data: data2,
	        yaxis: 2,
	        color: "#464f88",
	        lines: {
	            lineWidth: 1,
	            show: true,
	            fill: true,
	            fillColor: {
	                colors: [{
	                    opacity: 0.2
	                },
	                {
	                    opacity: 0.2
	                }]
	            }
	        },
	        splines: {
	            show: false,
	            tension: 0.6,
	            lineWidth: 1,
	            fill: 0.1
	        },
	    }];
	    var options = {
	        xaxis: {
	            mode: "time",
	            tickSize: [1, "day"],
	            tickLength: 0,
	            axisLabel: "Date",
	            axisLabelUseCanvas: true,
	            axisLabelFontSizePixels: 12,
	            axisLabelFontFamily: "Arial",
	            axisLabelPadding: 10,
	            color: "#838383"
	        },
	        yaxes: [{
	            position: "left",
	            max: 100,
	            color: "#838383",
	            axisLabelUseCanvas: true,
	            axisLabelFontSizePixels: 12,
	            axisLabelFontFamily: "Arial",
	            axisLabelPadding: 3
	        },
	        {
	            position: "right",
	            clolor: "#838383",
	            axisLabelUseCanvas: true,
	            axisLabelFontSizePixels: 12,
	            axisLabelFontFamily: " Arial",
	            axisLabelPadding: 67
	        }],
	        legend: {
	            noColumns: 1,
	            labelBoxBorderColor: "#000000",
	            position: "nw"
	        },
	        grid: {
	            hoverable: false,
	            borderWidth: 0,
	            color: "#838383"
	        }
	    };
	    var previousPoint = null,
	    previousLabel = null;
	    $.plot($("#flot-line-chart-order"), dataset, options);

    <?php if($pie1count1 > 0 || $pie1count2 > 0) { ?>
        var e = [{
            label: "Self Store Order",
            data: <?=$pie1count1; ?>,
            color: "#1ab394"
        }, {
            label: "Deliver Order",
            data: <?=$pie1count2; ?>,
            color: "#d3d3d3"
        }];

        $.plot($("#flot-pie-chart-order-type"), e, {
            series: {
                pie: {
                    show: !0
                }
            },
            grid: {
                hoverable: !0
            },
            tooltip: !0,
            tooltipOpts: {
                content: "%p.0%, %s",
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: !1
            }
        })
    <?php } ?>

    <?php if($pie2count1 > 0 || $pie2count2 > 0) { ?>
        var e = [{
            label: "App",
            data: <?=$pie2count1; ?>,
            color: "#1ab394"
        }, {
            label: "Pick Code",
            data: <?=$pie2count2; ?>,
            color: "#d3d3d3"
        }];

        $.plot($("#flot-pie-chart-pick-with"), e, {
            series: {
                pie: {
                    show: !0
                }
            },
            grid: {
                hoverable: !0
            },
            tooltip: !0,
            tooltipOpts: {
                content: "%p.0%, %s",
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: !1
            }
        })
    <?php } ?>

    <?php if($pie3count1 > 0 || $pie3count2 > 0) { ?>
        var e = [{
            label: "Available",
            data: <?=$pie3count1; ?>,
            color: "#1ab394"
        }, {
            label: "Occupied",
            data: <?=$pie3count2; ?>,
            color: "#d3d3d3"
        }];

        $.plot($("#flot-pie-chart-box-status"), e, {
            series: {
                pie: {
                    show: !0
                }
            },
            grid: {
                hoverable: !0
            },
            tooltip: !0,
            tooltipOpts: {
                content: "%p.0%, %s",
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: !1
            }
        })
    <?php } ?>

	});
 </script>

