<div class="panel panel-gradient">
<div class="panel-heading">
<div class="panel-title">
loan payment Information Page </div>
</div>
<div class="table-responsive">
<ul class="nav nav-tabs bordered">
<li class="active">
<a href="#unpaid" data-toggle="tab">
<span class="hidden-xs">Uncleared loans</span>
</a>
</li>
<li class="">
<a href="#paid" data-toggle="tab">
<span class="hidden-xs">Payment vochers</span>
</a>
</li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="unpaid">
<div class="table-responsive">
<table class="table table-bordered table-striped datatable" id="table-1">
    <thead>
        <tr>
            
            <th><?php echo get_phrase('Application_date');?></th>
            <th><?php echo get_phrase('Client_name');?></th>
            <th><?php echo get_phrase('Expected_amount');?></th>

            <th><?php echo get_phrase('paid_back');?></th>
            <th><?php echo get_phrase('loan_duration');?></th>
            <th><?php echo get_phrase('mode_of_payment');?></th>
			
			
            <th><?php echo get_phrase('status');?></th>
			<th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>

    <tbody>
	
        <?php 
                                //$loan_approvals	=	$this->db->get('loan' )->result_array();
                                foreach($loan_approvals as $row):?>
            <tr>
               
                <td><?php echo $row['date']; ?></td>
                 <td><?php echo $this->crud_model->get_loan_client_name($row['staff_name']);?></td>
				
                <td><?php echo $row['amount_winterest']?></td>
				 <td><?php echo $row['amount_winterest']-$row['due']?></td>
                <td><?php echo $row['l_duration']." months"; ?></td>
                <td><?php echo $row['mop']?></td>
                
                <td>
				  <span class="label label-<?php if($row['status']=='Approved')echo 'info'; elseif ($row['status']=='verifying') echo 'default'; elseif ($row['status']=='Pending') echo 'warning'; elseif($row['status']=='finished')echo 'danger'; elseif ($row['status']=='running') echo 'success';?>">
				  
				  <?php echo $row['status'];?></span>
				
				</td>
				<td>
								
				
				  <a href="#" 
				 onclick="showAjaxModal('index.php?modal/popup/loan_manage_historypayments_details/<?php echo $row['loan_id']?>');"
				class="btn btn-primary btn-sm btn-icon icon-left" >
				<i class="entypo-edit"></i>
				payment Details
				</a>

				
				
					
					
				</td>
										
                
            </tr>
               <?php endforeach;?>
    </tbody>
</table>
</div>

</div>



<div class="tab-pane" id="paid">
<table class="table table-bordered datatable" id="table_export">

<thead>
<tr>
<th><div>#</div></th>
<th><div>Client Name</div></th>
<th><div>Method</div></th>
<th><div>amount</div></th>
<th><div>date</div></th>
<th></th>
</tr>
</thead>
<tbody>

<?php  $i=1;$parents = $this->db->get('loan_payment')->result_array();
 foreach($parents as $row):?>
<tr>
<td><?php echo $i++?></td>
<td><?php echo $this->crud_model->get_loan_client_name($row['student_id']);?></td>
<td><?php if($row['method'] == '1'){echo 'Cash';} else if($row['method'] == '2'){echo 'Cheque';} else{echo 'Card';} ?> </td>
<td><?php echo $row['amount']?></td>
<td><?php echo date("jS F, Y", strtotime($row['timestamp'])); ?></td>
<td align="center">
<a href="#" 
				 onclick="showAjaxModal('index.php?modal/popup/loan_manage_historypayments_details/<?php echo $row['loan_id']?>');"
				class="btn btn-primary btn-sm btn-icon icon-left" >
				<i class="entypo-edit"></i>
				payment Details
				</a>
				<a type="button" class="btn bg-red margin  " href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/loan_manage_historypayments/delete/<?php echo $row['invoice_id'];?>');">
<i class="entypo-trash"></i>Delete </a>

</td>
</tr>

<?php endforeach;?>


</tbody>
</table>
</div>
</div>
</div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        

        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    
                    {
                        "sExtends": "xls",
                       "mColumns": [1,2,3,4,5,6,7]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2,3,4,5,6,7]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"    : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(6, false);
                            
                            this.fnPrint( true, oConfig );
                            
                            window.print();
                            
                            $(window).keyup(function(e) {
                                  if (e.which == 27) {
                                      datatable.fnSetColumnVis(6, true);
                                  }
                            });
                        },
                        
                    },
                ]
            },
            
        });
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
        
</script>


<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-1").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>