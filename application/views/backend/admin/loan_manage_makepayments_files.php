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
            
            <th><?php echo get_phrase('maturity_date');?></th>
            <th><?php echo get_phrase('Applicant_name');?></th>
            <th><?php echo get_phrase('amount');?></th>

            <th><?php echo get_phrase('Expected Amount');?></th>
            <th><?php echo get_phrase('Amount Paid');?></th>
            <th><?php echo get_phrase('Balance');?></th>
			
			<th><?php echo get_phrase('Daily payment');?></th>
            <th><?php echo get_phrase('Duration');?></th>            
            <th><?php echo get_phrase('status');?></th>
			<th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>

    <tbody>
	
        <?php 
                                //$loan_approvals	=	$this->db->get('loan' )->result_array();
                                foreach($loan_approvals as $row):?>
            <tr>
               
                <td><?php echo $row['maturity_date']; ?></td>
                 <td><?php echo $this->crud_model->get_loan_client_name($row['staff_name']);?></td>
				
                <td><?php echo $row['amount']?></td>
				 <td><?php echo $row['amount_winterest']?></td>
                <td><?php echo $row['amount_winterest']-$row['due']; ?></td>
				 <td><?php echo $row['due']; ?></td>
                <td><?php echo $row['dailypay']; ?></td>
               <td><?php echo $row['l_duration']." months"; ?></td>
				
				
                <td>
								  <span class="label label-<?php if($row['status']=='finished')echo 'danger'; elseif ($row['status']=='running') echo 'success'; else echo 'warning';?>"><?php echo $row['status'];?></span>
				</td>
				<td>

				<?php if($row['status']!='finished'){?>
				<a href="<?php echo base_url();?>index.php?admin/loan_manage_makepayments_veiw/<?php echo $row['loan_id'];?>" 
				class="btn btn-danger btn-sm btn-icon icon-left" >
				<i class="entypo-cancel"></i>
				make payment
				</a>
				
				<?php }?>

<a href="<?php echo base_url();?>index.php?admin/loan_manage_approveloans_details/<?php echo $row['loan_id'];?>" 
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