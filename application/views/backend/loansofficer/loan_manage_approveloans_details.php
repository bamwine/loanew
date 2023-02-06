<?php 

foreach ( $loan_data as $row):
?>

<section class="content">



<div class="box box-widget">
<div class="box-header with-border">
<?php 	 
	$parents=$this->db->get_where('loan_clients' , array('student_id'=>$row['staff_name']))->result_array();
	foreach($parents as $row3):
		?>
	<div class="row">
<div class="col-sm-4">
<div class="user-block">
	<img class="img-circle" src="<?php echo $this->crud_model->get_image_url('loan_clients' , $row['student_id']);?>" alt="user image">
	<span class="username">
		<?php echo $row3['name'];?>
	</span>
	<span class="description" style="font-size:13px; color:#000000">
<br>
<!--a  class="btn btn-primary btn-sm btn-icon icon-left" href="../../borrowers/add_borrower_edit.html">Edit</a-->
<br><?php echo $row3['sex'];?>, <?php echo $row3['birthday'];?>
	</span>
</div><!-- /.user-block -->
<div class="btn-group-horizontal">
<a type="button" class="btn bg-blue margin" href="<?php echo base_url();?>index.php?loansofficer/loan_manage_approveloans_detailsalloans/<?php echo $row['staff_name'];?>">View All Loans</a>
<a type="button" class="btn bg-red margin  " href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?loansofficer/loan_manage_approveloans/delete/<?php echo $row['loan_id'];?>');">
<i class="entypo-trash"></i>Delete loan</a>
</div>         

</div><!-- /.col -->
<div class="col-sm-4">
<ul class="list-unstyled">
<li><b>National Id:</b> <?php echo $row3['nationalid'];?></li>
<li><b>Address:</b> <?php echo $row3['address'];?></li>
<li><b>Branch:</b> <?php echo $this->crud_model->get_branch_name_by_id($row3['branch_id']);?></li>


</ul>
</div>
<div class="col-sm-4">
<ul class="list-unstyled">
<li><b>Landline:</b> <?php echo $row3['phone'];?></li>
<li><b>Mobile:</b> <?php echo $row3['phone2'];?><div class="btn-group-horizontal">

<li><b>Email:</b> <a onClick="javascript:window.open('mailto:<?php echo $row3['email'];?>', 'mail');event.preventDefault()" href="mailto:<?php echo $row3['email'];?>"><?php echo $row3['email'];?></a><div class="btn-group-horizontal">
<a type="button" class="btn-xs bg-red" href="mailto:<?php echo $row3['email'];?>">Send Email</a></div></li>


</ul>
</div>
</div><!-- /.row -->

  <?php
endforeach;
?> 

</div> 
</div>
<!-- Main content -->
<div class="box box-warning">
<div class="box-body table-responsive no-padding">
<table class="table table-bordered table-condensed  table-hover">
<tr style="background-color: #FFF8F2">
	
	<th>Loan #</th>
	<th><b>Released</b></th>
	<th><b>Maturity</b></th>
	<th><b>Repayment</b></th>
	<th><b>Principal &#85;&#83;&#104;</b></th>
	<th>Interest</th>
	<th>Loan Duration</th>
	<th><b>Due</b></th>
	<th><b>Paid</b></th>
	<th><b>Balance</b></th>
	
	
	<th><b>Status</b></th>
	
	
</tr>
<tr>
	<td>
		
		<?php echo  h_generate_id($row['loan_id']) ?>
	</td>
	<td>
		<?php echo $row['starting_date']?>
	</td>
	<td>
		<?php echo $row['maturity_date']?>
	</td>
	<td>
		<?php echo $row['mop']?>
	</td> 
	<td>
		<?php echo $row['dailypay']?><br> Per Day
	</td>
	<td>
		<?php echo $row['interest']?>
	</td>
	<td>
		<?php echo $row['l_duration']." months"?>
	</td>
	                                
	<td><?php echo $row['due']?>
		<br><small><a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_editdueamount_modal/<?php echo $row['loan_id'];?>');">Override</a></small>
	</td>
	<td>
		<?php echo $row['amount_winterest']-$row['due']?>
	</td>
	<td>
		<b><?php echo $row['due']?></b>
	</td>
	<td>
		<span class="label label-<?php if($row['status']=='Approved')echo 'info'; elseif ($row['status']=='verifying') echo 'default'; elseif ($row['status']=='Pending') echo 'warning'; elseif($row['status']=='finished')echo 'danger'; elseif ($row['status']=='running') echo 'success';?>">
				  
			<?php echo $row['status']?>
		</span>
	</td>
</tr>
</table>

</div> 
</div>


<div class="box no-border" style="background: #FFFFFF;">

<div class="table-responsive ">
<br>
<ul class="nav nav-tabs bordered">
	<li class="active">
	<a href="#payments" data-toggle="tab" >
	<span class="hidden-xs" ><?php echo get_phrase('Repayments');?></span>
	</a>
	</li>

	<li>
	<a href="#lnterest" data-toggle="tab">
	<span class="hidden-xs"><?php echo get_phrase('Loan_Terms');?></span>
	</a>
	</li>
	
	<li>
	<a href="#loan" data-toggle="tab">
	<span class="hidden-xs"><?php echo get_phrase('guarantor_details');?></span>
	</a>
	</li>
	
	<li>
	<a href="#loanpay" data-toggle="tab">
	<span class="hidden-xs"><?php echo get_phrase('Loan_collateral');?></span>
	</a>
	</li>
	
	<li>
	<a href="#loanpaycond" data-toggle="tab">
	<span class="hidden-xs"><?php echo get_phrase('Loan_files');?></span>
	</a>
	</li>

</ul>
<div class="tab-content">
<div class="tab-pane active" id="payments">
<br>
<a href="<?php echo base_url();?>index.php?loansofficer/loan_manage_makepayments_veiw/<?php echo $row['loan_id'];?>" 
            	class="btn btn-primary ">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('add_Repayment');?>
                </a> 
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
		
		
				
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('payments_made');?>
                    	</a></li>
			
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
					<tr>

						<th>collection date</th>
						<th>amount</th>
						<th>Method</th>
						<th>Officer collected</th>
					</tr>
					</thead>
                    <tbody>
                    	<?php 	 
	$pay=$this->db->get_where('loan_payment' , array('loan_id'=>$row['loan_id']))->result_array();
	foreach($pay as $rowp):
		?>
<tr>
<td><?php echo date("jS F, Y", strtotime($rowp['timestamp']));?></td>
<td><?php echo $rowp['amount'];?></td>
<td><?php if($rowp['method'] == 1){echo 'Cash';}else if($rowp['method'] == 2){echo 'Cheque';}else {echo 'Card';}?> </td>
<td><?php echo $rowp['creator'];?></td>
</tr>

<?php
	endforeach;
  ?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			
		</div>
	</div>
</div>

</div>
<div class="tab-pane" id="lnterest">
<br>
<div class="row">
	<div class="col-md-12">
    
    <div class="box no-border">
    <div class="loan_tabs">
		<div>
			<div class="tab_content">
				<div class="btn-group-horizontal">
					<a type="button" class="btn bg-green  btn btn-primary " href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_manage_approveloans_edit/<?php echo $row['loan_id'];?>');">
					<i class="entypo-pencil"></i>Edit loan</a>

					
				</div>
			</div>
		</div>
            <div>
                <div class="tab_content">
                
                
            <div class="box-body no-padding">
              
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <td colspan="2" class="bg-blue disabled color-palette">Loan Terms
                        </td>
                    </tr>
                    
  
                    <tr>
                        <td><b>Released</b></td>
                        <td><?php echo $row['starting_date']?>
                        </td>
                    </tr>                         
                    <tr>
                        <td><b>Maturity</b></td>
                        <td>
                            <?php echo $row['maturity_date']?>
                        </td>
                    </tr>
                
                    <tr>
                        <td><b>Repayment Cycle</b></td>
                        <td>
                        <?php echo $row['mop']?>
                        </td>
                    </tr>
             
                    <tr>
                        <td style="width:340px"><b>Interest</b></td>
                        <td>
                        <?php echo $row['interest']?>%
                        </td>
                    </tr>
                  <tr>
                        <td><b>Loan Duration</b></td>
                        <td>
                        <?php echo $row['l_duration']." months"?>
                        </td>
                    </tr>
					
					<tr>
                        <td><b>Due Amount</b></td>
                        <td>
                        <?php echo $row['due']?>
                        </td>
                    </tr>
					
					<tr>
                        <td><b>Daily Payment</b></td>
                        <td>
                        <?php echo $row['dailypay']?>
                        </td>
                    </tr>
					
					<tr>
                        <td><b>Number of Repayments</b></td>
                        <td>
                        <?php echo $activeclientsaccount =$this->db->query('SELECT COUNT(*) as number FROM loan_payment where loan_id="'.$row['loan_id'].'"')->row()->number;?>
                        </td>
                    </tr>
                    
                </tbody>  
            </table>
        </div>
                </div>
            </div>
             
           
		</div>   
    </div>

 
	</div>
</div>


</div>


<div class="tab-pane" id="loan">
<br>
<div class="row">
	<div class="col-md-12">
    
    	 <div class="box no-border">
    <div class="loan_tabs">
		<div>
			<div class="tab_content">
				<div class="btn-group-horizontal">
					<a type="button" class="btn bg-green  btn btn-primary " href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_manage_approveloans_edit/<?php echo $row['loan_id'];?>');">
					<i class="entypo-pencil"></i>Edit Guarantor</a>

					
				</div>
			</div>
		</div>
            <div>
                <div class="tab_content">
                
                
            <div class="box-body no-padding">
              
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <td colspan="2" class="bg-blue disabled color-palette">GUARANTOR'S INFORMATION
                        </td>
                    </tr>
                    
  
                    <tr>
                        <td><b>Guarantor Name</b></td>
                        <td><?php echo $row['g_name']?>
                        </td>
                    </tr>                         
                    <tr>
                        <td><b>Relationship</b></td>
                        <td>
                            <?php echo $row['g_relationship']?>
                        </td>
                    </tr>
                
                    <tr>
                        <td><b>Guarantor Number</b></td>
                        <td>
                        <?php echo $row['g_number']?>
                        </td>
                    </tr>
             
                    <tr>
                        <td style="width:340px"><b>Guarantor Address</b></td>
                        <td>
                        <?php echo $row['g_address']?>
                        </td>
                    </tr>
                  <tr>
                        <td><b>Guanrator Country</b></td>
                        <td>
                        <?php echo $row['g_country']." months"?>
                        </td>
                    </tr>
					
					
                    
                </tbody>  
            </table>
        </div>
                </div>
            </div>
             
           
		</div>   
    </div>
		
	</div>
</div>

</div>

<div class="tab-pane" id="loanpay">
<br>
<div class="btn-group-horizontal">
					<a type="button" class="btn bg-green  btn btn-primary " href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_colateral_modal/work/<?php echo $row['loan_id'];?>');">
					<i class="entypo-pencil"></i>Add collateral</a>

					
				</div>
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#listpay" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('Available_collateral');?>
                    	</a></li>
			
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="listpay">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('collateral_name');?></div></th>
							<th><div><?php echo get_phrase('collateral_value');?></div></th> 
							<th><div><?php echo get_phrase('collateral_mode');?></div></th>
							<th><div><?php echo get_phrase('collateral_serial_Number');?></div></th>
							<th><div><?php echo get_phrase('collateral_condition');?></div></th>                      		
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;foreach($collateral_data as $rows):?> 
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $rows['c_name'];?></td>
							<td><?php echo $rows['value'];?> </td>
							<td><?php echo $rows['model'];?></td>
							<td><?php echo $rows['serial_number']?></td>
							<td><?php echo $rows['condition'];?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a type="button" class="btn bg-green  btn btn-primary " href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_colateral_modal/<?php echo $rows['collateral_id'];?>');">
					     <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?loansofficer/loan_manage_approveloans_details/delete/collateral/<?php echo $rows['collateral_id'];?>/<?php echo $row['loan_id'];?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			
		</div>
	</div>
</div>

</div>


<div class="tab-pane" id="loanpaycond">
<br>

<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#listprop" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('Available_loan_files');?>
                    	</a></li>
			
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="listprop">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('File Name');?></div></th>                    		
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
					<?php $count = 1;foreach($collateral_files as $rows):?> 
                    	 <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $rows['file_name'];?></td>
							<td>
                            <a href="<?php echo base_url()?>uploads/loan_applicant/<?php echo $rows['file_name'];?>" class="btn btn-blue btn-icon icon-left">
							<i class="entypo-download"></i>
							Download
							</a>
							
							<a onclick="confirm_modal('<?php echo base_url();?>index.php?loansofficer/loan_manage_approveloans_details/delete/removefile/<?php echo $rows['collateral_id'];?>/<?php echo $row['loan_id'];?>');"
				class="btn btn-danger btn-sm btn-icon icon-left" >
				 <i class="entypo-trash"></i>
				remove
				</a>
							</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			
			<!----CREATION FORM ENDS-->
		</div>
	</div>
</div>


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
                        "mColumns": [1,2,3]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2,3]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"    : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(4, false);
                            
                            this.fnPrint( true, oConfig );
                            
                            window.print();
                            
                            $(window).keyup(function(e) {
                                  if (e.which == 27) {
                                      datatable.fnSetColumnVis(4, true);
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



</section>

<?php
endforeach;
?> 