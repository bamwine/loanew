<hr> 
<div class="x_panel" >
            
                <div class="x_title">
                    <div class="panel-title">
					 <?php echo get_phrase('loan_information_page'); ?>
					</div>
					</div>
<div class="table-responsive">
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            
            <th><?php echo get_phrase('Application_date');?></th>
            <th><?php echo get_phrase('Applicant_name');?></th>
            <th><?php echo get_phrase('amount');?></th>

            <th><?php echo get_phrase('purpose');?></th>
            <th><?php echo get_phrase('loan_duration');?></th>        
			
			<th><?php echo get_phrase('guarantor_name');?></th>
            <th><?php echo get_phrase('guarantor_number');?></th>
            <th><?php echo get_phrase('created_by');?></th>
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
				
                <td><?php echo $row['amount']?></td>
				 <td><?php echo $row['purpose']?></td>
                <td><?php echo $row['l_duration']." months"; ?></td>
                
                <td><?php echo $row['g_name']?></td>
				
				 <td><?php echo $row['g_number']?></td>
                 <td><?php echo $row['creator']?></td>
                <td>
				  <span class="label label-<?php if($row['status']=='Approved')echo 'info'; elseif ($row['status']=='verifying') echo 'default'; elseif ($row['status']=='Pending') echo 'warning';?>"><?php echo $row['status'];?></span>
				
				</td>
				<td>
				
				
				<a href="#" class="btn btn-danger btn-sm btn-icon icon-left" onclick="confirm_modal('<?php echo base_url();?>index.php?loansofficer/loan_manage_approveloans/delete/<?php echo $row['loan_id'];?>');">
				<i class="entypo-trash"></i>
					<?php echo get_phrase('delete');?>
				</a>
				
				<a href="<?php echo base_url();?>index.php?loansofficer/loan_manage_approveloans_details/<?php echo $row['loan_id'];?>" 
				class="btn btn-success btn-sm btn-icon icon-left" >
				<i class="entypo-cancel"></i>
				View/ Modify
				</a>
					
					
				</td>
										
                
            </tr>
               <?php endforeach;?>
    </tbody>
</table>
</div>


</div>


<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
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