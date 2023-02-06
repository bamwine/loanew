
<!-- Resources -->

<style>
    #chartdiv2, #chartdiv{
        width		: 100%;
        height		: 300px;
        font-size	: 11px;
    }

#brachwise_permonth{
        width		: 100%;
        height		: 500px;
        font-size	: 11px;
    }
#notice_calendar{
        width		: 100%;
        height		: 500px;
        font-size	: 11px;
    }		
    .style2 {font-size: 24px}
</style>

<!-- FullCalendar -->
<link href="assets/vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">


<?php
//$today=date('Y-m-d',strtotime("+7 days"));
$today=date('Y-m-d');


?>


<div class="row">
    <div class="col-md-7 col-sm-12 col-xs-12">    
        <div class="x_panel " data-collapsed="0">
            <div class="x_title">
                <?php echo get_phrase('LOANS AMOUNTS DISTRIBUTION FOR all branches'); ?>
            </div>
            <div class="x-content">
                <div id="chartdiv2"></div> 
            </div>
        </div>
    </div>
    <div class="col-md-5 col-sm-12 col-xs-12">    
        <div class="x_panel " data-collapsed="0">
            <div class="x_title">
                <?php echo get_phrase('Statistics of loans Amounts  from all branches '); ?>
            </div>
            <div class="x-content">
                <div id="chartdiv"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Reports </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id="notice_calendar"></div>

            </div>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Branch wise </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id="brachwise_permonth"></div>

            </div>
        </div>
    </div>
    
</div>


<script src="assets/vendors/echarts/dist/echarts.min.js"></script>

<!-- NProgress -->
<script src="assets/vendors/nprogress/nprogress.js"></script>
<!-- amchatsV4 Scripts -->
<script src="assets/vendors/amcharts4/core.js"></script>
<script src="assets/vendors/amcharts4/charts.js"></script>
<script src="assets/vendors/amcharts4/themes/animated.js"></script>
<!-- amchatsV4 Scripts -->

<script type="text/javascript">
  am4core.useTheme(am4themes_animated);

var chart = am4core.create("notice_calendar", am4charts.XYChart);
var months=	[1,2,3,4,5,6,7,8,9,10,11,12];
  <?php $months=[1,2,3,4,5,6,7,8,9,10,11,12];
  $monthsname=["Jan","Feb","Mar","Apr","May","Jun","July","Aug","Sept","Oct","Nov","Dec"]; ?>   

chart.data = [

<?php for($v=0;$v<12;$v++){ ?>
{
	"Month": '<?php echo $monthsname[$v] ?>', 
	'<?php echo get_phrase('total_loans'); ?>': '<?php echo $this->crud_model->report2_total_loans($months[$v]) ?>',
	'<?php echo get_phrase('Due_amount'); ?>':'<?php echo $this->crud_model->report2_due_amount($months[$v]) ?>',
	'<?php echo get_phrase('paid_amount'); ?>': '<?php echo $this->crud_model->report2_paid_amount($months[$v]) ?>'
},
<?php } ?>
]

chart.padding(30, 30, 10, 30);
chart.legend = new am4charts.Legend();


chart.colors.step = 2;

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "Month";
categoryAxis.renderer.minGridDistance = 60;
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.interactionsEnabled = false;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.tooltip.disabled = true;
valueAxis.renderer.grid.template.strokeOpacity = 0.05;
valueAxis.renderer.minGridDistance = 20;
valueAxis.interactionsEnabled = false;
valueAxis.min = 0;
valueAxis.renderer.minWidth = 35;

var series1 = chart.series.push(new am4charts.ColumnSeries());
series1.columns.template.width = am4core.percent(80);
series1.columns.template.tooltipText = "{name}: {valueY.value}";
series1.name = '<?php echo get_phrase('total_loans'); ?>';
series1.dataFields.categoryX = "Month";
series1.dataFields.valueY = '<?php echo get_phrase('total_loans'); ?>';
series1.stacked = true;

var series2 = chart.series.push(new am4charts.ColumnSeries());
series2.columns.template.width = am4core.percent(80);
series2.columns.template.tooltipText = "{name}: {valueY.value}";
series2.name = '<?php echo get_phrase('Due_amount'); ?>';
series2.dataFields.categoryX = "Month";
series2.dataFields.valueY = '<?php echo get_phrase('Due_amount'); ?>';
series2.stacked = true;

var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.columns.template.width = am4core.percent(80);
series3.columns.template.tooltipText = "{name}: {valueY.value}";
series3.name = '<?php echo get_phrase('paid_amount'); ?>';
series3.dataFields.categoryX = "Month";
series3.dataFields.valueY = '<?php echo get_phrase('paid_amount'); ?>';
series3.stacked = true;



chart.scrollbarX = new am4core.Scrollbar();
// Enable export
chart.exporting.menu = new am4core.ExportMenu();

// Add chart title
var title = chart.titles.create();
title.text = "Monthly Collections AS OF <?php echo date("d/m/Y");?>";
title.fontSize = 25;
title.marginBottom = 5;

// Add bottom label
var label = chart.chartContainer.createChild(am4core.Label);
label.text = "Months";
label.align = "center";
  </script>




<script type="text/javascript">
  am4core.useTheme(am4themes_animated);

 var chart = am4core.create("brachwise_permonth", am4charts.XYChart); 
 // Add data 
 chart.data = [ { "region": "Central", "state": "North Dakota", "sales": 920 },
 { "region": "Central", "state": "South Dakota", "sales": 1317 },
 { "region": "Central", "state": "Kansas", "sales": 2916 },
 { "region": "Central", "state": "Iowa", "sales": 4577 }, 
 { "region": "Central", "state": "Nebraska", "sales": 7464 },
 { "region": "Central", "state": "Oklahoma", "sales": 19686 },
 { "region": "Central", "state": "Missouri", "sales": 22207 },
 { "region": "Central", "state": "Minnesota", "sales": 29865 },
 { "region": "Central", "state": "Wisconsin", "sales": 32125 },
 { "region": "Central", "state": "Indiana", "sales": 53549 },
 { "region": "Central", "state": "Michigan", "sales": 76281 }, 
 { "region": "Central", "state": "Illinois", "sales": 80162 }, 
 { "region": "Central", "state": "Texas", "sales": 170187 },
 { "region": "East", "state": "West Virginia", "sales": 1209 },
 { "region": "East", "state": "Maine", "sales": 1270 }, 
 { "region": "East", "state": "District of Columbia", "sales": 2866 }, 
 { "region": "East", "state": "New Hampshire", "sales": 7294 }, 
 { "region": "East", "state": "Vermont", "sales": 8929 },
 { "region": "East", "state": "Connecticut", "sales": 13386 }, 
 { "region": "East", "state": "Rhode Island", "sales": 22629 },
 { "region": "East", "state": "Maryland", "sales": 23707 },
 { "region": "East", "state": "Delaware", "sales": 27453 }, 
 { "region": "East", "state": "Massachusetts", "sales": 28639 },
 { "region": "East", "state": "New Jersey", "sales": 35763 }, 
 { "region": "East", "state": "Ohio", "sales": 78253 },
 { "region": "East", "state": "Pennsylvania", "sales": 116522 },
 { "region": "East", "state": "New York", "sales": 310914 }, 
 { "region": "South", "state": "South Carolina", "sales": 8483 }, 
 { "region": "South", "state": "Louisiana", "sales": 9219 }, 
 { "region": "South", "state": "Mississippi", "sales": 10772 },
 { "region": "South", "state": "Arkansas", "sales": 11678 }, 
 { "region": "South", "state": "Alabama", "sales": 19511 },
 { "region": "South", "state": "Tennessee", "sales": 30662 }, 
 { "region": "South", "state": "Kentucky", "sales": 36598 }, 
 { "region": "South", "state": "Georgia", "sales": 49103 },
 { "region": "South", "state": "North Carolina", "sales": 55604 },
 { "region": "South", "state": "Virginia", "sales": 70641 }, 
 { "region": "South", "state": "Florida", "sales": 89479 }, 
 { "region": "West", "state": "Wyoming", "sales": 1603 },
 { "region": "West", "state": "Idaho", "sales": 4380 }, 
 { "region": "West", "state": "New Mexico", "sales": 4779 },
 { "region": "West", "state": "Montana", "sales": 5589 }, 
 { "region": "West", "state": "Utah", "sales": 11223 },
 { "region": "West", "state": "Nevada", "sales": 16729 },
 { "region": "West", "state": "Oregon", "sales": 17431 },
 { "region": "West", "state": "Colorado", "sales": 32110 }, 
 { "region": "West", "state": "Arizona", "sales": 35283 },
 { "region": "West", "state": "Washington", "sales": 138656 }, 
 { "region": "West", "state": "California", "sales": 457731 }
 ]; 
 // Create axes 
 var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());
 yAxis.dataFields.category = "state";
 yAxis.renderer.grid.template.location = 0;
 yAxis.renderer.labels.template.fontSize = 10;
 yAxis.renderer.minGridDistance = 10;
 var xAxis = chart.xAxes.push(new am4charts.ValueAxis());
 // Create series
 var series = chart.series.push(new am4charts.ColumnSeries()); 
 series.dataFields.valueX = "sales"; 
 series.dataFields.categoryY = "state";
 series.columns.template.tooltipText = "{categoryY}: [bold]{valueX}[/]";
 series.columns.template.strokeWidth = 0;
 series.columns.template.adapter.add("fill", 
 function(fill, target) { if (target.dataItem) 
 { 
 switch(target.dataItem.dataContext.region) {
 case "Central": return chart.colors.getIndex(0); break;
 case "East": return chart.colors.getIndex(1); break; 
 case "South": return chart.colors.getIndex(2); break; 
 case "West": return chart.colors.getIndex(3); break; } } 
 return fill; }); 
 // Add ranges 
 function addRange(label, start, end, color) 
 { var range = yAxis.axisRanges.create();
 range.category = start; 
 range.endCategory = end;
 range.label.text = label;
 range.label.disabled = false; 
 range.label.fill = color;
 range.label.location = 0; 
 range.label.dx = -130; 
 range.label.dy = 12;
 range.label.fontWeight = "bold"; 
 range.label.fontSize = 12; 
 range.label.horizontalCenter = "left" range.label.inside = true;
 range.grid.stroke = am4core.color("#396478");
 range.grid.strokeOpacity = 1;
 range.tick.length = 200; range.tick.disabled = false;
 range.tick.strokeOpacity = 0.6; 
 range.tick.stroke = am4core.color("#396478");
 range.tick.location = 0; range.locations.category = 1; 
 } 
 addRange("Central", "Texas", "North Dakota", chart.colors.getIndex(0));
 addRange("East", "New York", "West Virginia", chart.colors.getIndex(1));
 addRange("South", "Florida", "South Carolina", chart.colors.getIndex(2));
 addRange("West", "California", "Wyoming", chart.colors.getIndex(3));
 chart.cursor = new am4charts.XYCursor(); 
  </script>


<script>

    $(function () {
 
        init_echarts1();
    });
    function init_echarts1() {
        if (typeof (echarts) === 'undefined') {
            return;
        }
        console.log('init_echarts');
        var theme = {
            color: [
                '#dd4b39', '#3c8dbc', '#00a65a', '#759c6a', '#bfd3b7'
            ],
            textStyle: {
                fontFamily: 'Arial, Verdana, sans-serif'
            }
        };
		
       	if ($('#chartdiv').length) {

            var echartPie = echarts.init(document.getElementById('chartdiv'), theme);
            echartPie.setOption({
				 title: {
                    text: 'LOANS AMOUNTS FROM ALL BRANCHES \n AS OF <?php echo date("m/d/Y");?>',
                                     
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    x: 'center',
                    y: 'bottom',
                    data: ['<?php echo get_phrase('total_loans'); ?>', '<?php echo get_phrase('paid_amount'); ?>', '<?php echo get_phrase('Due_amount'); ?>']
                },
                toolbox: {
                    show: true,
                    feature: {
                        magicType: {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 1548
                                }
                            }
                        },
                        restore: {
                            show: true,
                            title: "Restore"
                        },
                        saveAsImage: {
                            show: true,
                            title: "Save Image"
                        }
                    }
                },
                calculable: true,
                series: [{
                        name: 'Current Status',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '48%'],
                        data: [{
                                value: <?php echo $this->crud_model->report_total_loans(); ?>,
                                name: '<?php echo get_phrase('total_loans'); ?>'
                            }, {
                                value: <?php echo $this->crud_model->report_paid_amount(); ?>,
                                name: '<?php echo get_phrase('paid_amount'); ?>'
                            }, {
                                value: <?php echo $this->crud_model->report_due_amount(); ?>,
                                name: '<?php echo get_phrase('Due_amount'); ?>'
                            }]
                    }]
            });
            var dataStyle = {
                normal: {
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                }
            };
            var placeHolderStyle = {
                normal: {
                    color: 'rgba(0,0,0,0)',
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    }
                },
                emphasis: {
                    color: 'rgba(0,0,0,0)'
                }
            };
        }
    
	
	 if ($('#chartdiv2').length) {
		
	 var arry=	['<?php echo get_phrase('Total_loans'); ?>', '<?php echo get_phrase('paid_amount'); ?>', '<?php echo get_phrase('Due_amount'); ?>']
     var count = 0; 
	 var value = 0; 
	 
            var echartLine = echarts.init(document.getElementById('chartdiv2'), theme);
            echartLine.setOption({
                title: {
                    text: 'LOANS AMOUNTS DISTRIBUTION FROM ALL \n BRANCHES  AS OF <?php echo date("m/d/Y");?>',
                    
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    x: 220,
                    y: 40,
                      data: [
							<?php
								$notices = $this->db->get('loan_branch')->result_array();
								foreach ($notices as $row):
									?>	  
								   
								   '<?php echo $row['name']; ?>', 
								   
								<?php
							endforeach
							?>   

					]   },
                toolbox: {
                    show: true,
                    feature: {
                        magicType: {
                            show: true,
                            title: {
                                line: 'Line',
                                bar: 'Bar',
                                stack: 'Stack',
                                tiled: 'Tiled'
                            },
                            type: ['line', 'bar', 'stack', 'tiled']
                        },
                        restore: {
                            show: true,
                            title: "Restore"
                        },
                        saveAsImage: {
                            show: true,
                            title: "Save Image"
                        }
                    }
                },
                calculable: true,
                xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                       data: ['<?php echo get_phrase('Total_loans'); ?>', '<?php echo get_phrase('paid_amount'); ?>', '<?php echo get_phrase('Due_amount'); ?>']
                    }],
                yAxis: [{
                        type: 'value'
                    }],
                series: [
		
				

					<?php
					$notices = $this->db->get('loan_branch')->result_array();
					foreach ($notices as $row):
					
					?>	  
													   
						{
									 
						name: '<?php echo $row['name']; ?>' ,
						type: 'line',
						smooth: true,
						itemStyle: {
							normal: {
								areaStyle: {
									type: 'default'
								}
							}
						},
						data: [<?php echo $this->crud_model->report_total_loans($row['branch_id']); ?>,<?php echo $this->crud_model->report_paid_amount($row['branch_id']); ?>,<?php echo $this->crud_model->report_due_amount($row['branch_id']); ?>]
						},
								   
					<?php
					endforeach
					?>
						
					]
            });
        }
     
	
	}
</script>

