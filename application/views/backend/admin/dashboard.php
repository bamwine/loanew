
<!-- Resources -->

<style>
    #chartdiv2, #chartdiv {
        width		: 100%;
        height		: 300px;
        font-size	: 11px;
    }					
    .style2 {font-size: 24px}
</style>

<!-- FullCalendar -->
<link href="assets/vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">

<?php $count_all = $this->db->count_all('loan_clients') + $this->db->count_all('loan_officer') ?>
<?php
//$today=date('Y-m-d',strtotime("+7 days"));
$today=date('Y-m-d');
$activeclientswithloans =$this->db->query('SELECT count(distinct(staff_name))as active FROM loan where status="running"')->row()->active;
$activeclientsaccount =$this->db->query('SELECT COUNT(*) as number FROM loan_clients where status="active"')->num_rows();
$amountcollectedtodays =$this->db->query('SELECT sum(amount) as madetoday FROM loan_payment WHERE timestamp = "'.$today.'" ')->row()->madetoday;
$amountcollectedtoday =($amountcollectedtodays=="")?0:$amountcollectedtodays ;
$amountforapprovedloansd =$this->db->query('SELECT sum(amount) as needed FROM loan WHERE status="Approved"')->row()->needed;
$amountforapprovedloans =($amountforapprovedloansd=="")?0:$amountforapprovedloansd ;

$this->crud_model->report_paid_amount();
$this->crud_model->report_total_loans();
$this->crud_model->report_due_amount();

?>
<div class="row">
    <div class="col-md-12" role="main">
        <div class="row tile_count">
            <div class="col-md-2 col-sm-3 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="fa fa-group"></i>  <?php echo get_phrase('clients with loans'); ?></span>
                <div class="count"><?php echo $activeclientswithloans; ?></div>
                <span class="count_bottom"><i class="green"><?php echo intval($activeclientswithloans * 100 / $activeclientsaccount) ?>% </i> From all Branches</span>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="entypo-user"></i> Total <?php echo get_phrase('Loan Officers'); ?></span>
                <div class="count"><?php echo $this->db->count_all('loan_officer'); ?></div>
                <span class="count_bottom"><i class="green"><?php echo intval($this->db->count_all('loan_officer') * 100 / $count_all) ?>% </i> From all Account</span>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="entypo-users"></i> Total <?php echo get_phrase('Administrators'); ?></span>
                <div class="count"><?php echo $this->db->count_all('admin'); ?></div>
                <span class="count_bottom"><i class="green"><?php echo intval($this->db->count_all('admin') * 100 / $count_all) ?>% </i> From all Account</span>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="entypo-book"></i> Total <?php echo get_phrase('collected today'); ?></span>
                <div class="count"><?php echo $amountcollectedtoday; ?></div>
                <span class="count_bottom"><i class="green"> </i> Amount collected today</span>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 tile_stats_count">
                <span class="count_top"><i class="entypo-user-add"></i>Required Money</span>
                <div class="count"><?php echo $amountforapprovedloans; ?></div>
                <span class="count_bottom"><i class="green"> </i> Approved Loans</span>
            </div>
            
           
        </div>
    </div>
 <div class="col-md-12" role="main">
        <div class="row">
            <div class="col-md-3">
                <ul class="site-stats">
                    <li><a href=""><h3><div class="col-md-3 stats-left" style="background-color:#4e7d2a"><i class="">O</i></div>  <div class="col-md-8 stats-right  text-left"> <?php echo get_phrase('Open Loans'); ?> : <strong><?php echo $this->crud_model->report_open_loans(); ?></strong></div></h3></a> </li>
                    
                </ul>
            </div>
           <div class="col-md-3">
                <ul class="site-stats">
                    <li><a href=""><h3><div class="col-md-3 stats-left" style="background-color:#4e7d2a"><i class="">F</i></div>  <div class="col-md-8 stats-right  text-left">  <?php echo get_phrase('FULLY PAID '); ?> : <strong><?php echo $this->crud_model->report_completed_loans(); ?></strong></div></h3></a> </li>
                    
                </ul>
            </div>
			 <div class="col-md-3">
                <ul class="site-stats">
                    <li><a href=""><h3><div class="col-md-3 stats-left" style="background-color:#dd4b39"><i class="fa fa-money"></i></div>  <div class="col-md-8 stats-right  text-right">  <?php echo get_phrase('Total loans'); ?> : <strong><?php echo $this->crud_model->report_total_loans(); ?></strong></div></h3></a> </li>
                    
                </ul>
            </div>
			
			 <div class="col-md-3">
                <ul class="site-stats">
                    <li><a href=""><h3><div class="col-md-3 stats-left" style="background-color:#3c8dbc"><i class="fa fa-money"></i></div>  <div class="col-md-8 stats-right  text-right">  <?php echo get_phrase('Total paid'); ?> : <strong><?php echo $this->crud_model->report_paid_amount(); ?></strong></div></h3></a> </li>
                    
                </ul>
            </div>
			
        </div>
    </div>
</div>



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
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Calendar Events <small>Sessions</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id='calendar'></div>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo get_phrase('New_Loan_Applications'); ?></h2>
                <div class="clearfix"></div>
            </div>
            <ul class="list-unstyled top_profiles scroll-view">
                <?php
                $new_students_list = $this->crud_model->new_loan_client_list();
                foreach ($new_students_list as $student):
                    ?>
                    <li class="media event">
                        <a class="pull-left border-aero profile_thumb" style="background-image:url('<?php echo $student['face_file'] ?>');">
                        </a>
                        <div class="media-body">
                            <a class="title" href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type')?>/loan_client_information"><?php echo $student['name'] ?></a>
                            <p><strong><?php echo $student['birthday'] ?>. </strong> <?php echo $student['sex'] ?> </p>
                            <p> <small>Phone: <?php echo $student['phone'] ?>,</small>
                                <strong>Email: <?php echo $student['email'] ?></strong>
                            </p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>


<script src="assets/vendors/echarts/dist/echarts.min.js"></script>

<!-- NProgress -->
<script src="assets/vendors/nprogress/nprogress.js"></script>
<!-- FullCalendar -->
<script src="assets/vendors/moment/min/moment.min.js"></script>
<script src="assets/vendors/fullcalendar/dist/fullcalendar.min.js"></script>
<script>
    $(function () {
        init_calendar();
    });
	
    function  init_calendar() {

        if (typeof ($.fn.fullCalendar) === 'undefined') {
            return;
        }
        console.log('init_calendar');
        var date = new Date(),
                d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear(),
                started,
                categoryClass;
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                $('#fc_create').click();
                started = start;
                ended = end;
                $(".antosubmit").on("click", function () {
                    var title = $("#title").val();
                    if (end) {
                        ended = end;
                    }

                    categoryClass = $("#event_type").val();
                    if (title) {
                        calendar.fullCalendar('renderEvent', {
                            title: title,
                            start: started,
                            end: end,
                            allDay: allDay
                        },
                                true // make the event "stick"
                                );
                    }

                    $('#title').val('');
                    calendar.fullCalendar('unselect');
                    $('.antoclose').click();
                    return false;
                });
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#fc_edit').click();
                $('#title2').val(calEvent.title);
                categoryClass = $("#event_type").val();
                $(".antosubmit2").on("click", function () {
                    calEvent.title = $("#title2").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    $('.antoclose2').click();
                });
                calendar.fullCalendar('unselect');
            },
            editable: true,
            events: [<?php
                $notices = $this->db->get('noticeboard')->result_array();
                foreach ($notices as $row):
                    ?>
                    {
                        title: "<?php echo $row['notice_title']; ?>",
                        start: new Date(<?php echo date('Y', $row['create_timestamp']); ?>, <?php echo date('m', $row['create_timestamp']) - 1; ?>, <?php echo date('d', $row['create_timestamp']); ?>),
                        end: new Date(<?php echo date('Y', $row['create_timestamp']); ?>, <?php echo date('m', $row['create_timestamp']) - 1; ?>, <?php echo date('d', $row['create_timestamp']); ?>)
                    },
    <?php
endforeach
?>
            ]
        });
    }
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

