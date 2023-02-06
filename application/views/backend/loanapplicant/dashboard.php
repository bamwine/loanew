
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

<?php $count_all = $this->db->count_all('loan_clients') + $this->db->count_all('loan_officer'); ?>

<!--div class="row">
    <div class="col-md-12" role="main">
        <div class="row">
            <div class="col-md-4">
                <ul class="site-stats">
                    <li><a href="<?php echo site_url('items'); ?>"><h3><div class="col-md-4 stats-left" style="background-color:#4e7d2a"><i class="fa fa-group"></i></div>  <div class="col-md-8 stats-right  text-right"> Total <?php echo get_phrase('student'); ?> : <strong><?php echo $this->db->count_all('loan_clients'); ?></strong></div></h3></a> </li>
                    <li><a href="<?php echo site_url('item_kits'); ?>"><h3> <div class="col-md-4 stats-left" style="background-color:#489ee7"><i class="entypo-user"></i></div>  <div class="col-md-8 stats-right  text-right">  Total <?php echo get_phrase('teacher'); ?>  :  <strong><?php echo $this->db->count_all('loan_officer'); ?></strong></div></h3></a></li>

                </ul>
            </div>
           
        </div>
    </div>

</div-->


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
                <h2><?php echo get_phrase('New_Messages'); ?></h2>
                <div class="clearfix"></div>
            </div>
            <ul class="list-unstyled top_profiles scroll-view">
                <?php
                $messages = $this->db->get_where('message', array('message_thread_code' => $current_message_thread_code))->result_array();
				foreach ($messages as $row):

					$sender = explode('-', $row['sender']);
					$sender_account_type = $sender[0];
					$sender_id = $sender[1];
					?>
                    <li class="media event">
                        <a class="pull-left border-aero profile_thumb" style="background-image:url('<?php echo $this->crud_model->get_image_url($sender_account_type, $sender_id); ?>');">
                        </a>
                        <div class="media-body">
                            
                            <p><small>Message: <?php echo $row['message']; ?></small> </p>
                            <p> <small>sender: <?php echo $this->db->get_where($sender_account_type, array($sender_account_type . '_id' => $sender_id))->row()->name; ?></small>
                                <strong>Date: <?php echo date("d M, Y", $row['timestamp']); ?> </strong>
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
