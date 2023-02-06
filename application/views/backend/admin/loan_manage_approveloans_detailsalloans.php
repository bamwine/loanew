<?php 

foreach ( $loan_data as $row):
?>

<section class="content">



<div class="box box-widget">
<div class="box-header with-border">
<?php 	 
	$parents=$this->db->get_where('loan_clients' , array('student_id'=>$row['student_id']))->result_array();
	foreach($parents as $row3):
		?>
	<div class="row">
<div class="col-sm-4">
<div class="user-block">
	<img class="img-circle" src="<?php echo $this->crud_model->get_image_url('loan_clients' , $row['student_id']);?>" width="100" height="100" alt="user image">
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
<br/>
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

<?php 
	//$loan_approvals	=	$this->db->get('loan' )->result_array();
	$loan_approvals	=	$this->db->get_where('loan', array('staff_name' => $row['student_id']))->result_array();
	$i=1;
	foreach($loan_approvals as $row2):?>

<tr>
	<td>
		<?php echo $i++?>
		<?php //echo  h_generate_id($row2['loan_id']) ?>
	</td>
	<td>
		<?php echo $row2['starting_date']?>
	</td>
	<td>
		<?php echo $row2['maturity_date']?>
	</td>
	<td>
		<?php echo $row2['mop']?>
	</td> 
	<td>
		<?php echo $row2['dailypay']?><br> Per Day
	</td>
	<td>
		<?php echo $row2['interest']?>
	</td>
	<td>
		<?php echo $row2['l_duration']." months"?>
	</td>
	                                
	<td><?php echo $row2['due']?> </td>
	<td>
		<?php echo $row2['amount_winterest']-$row2['due']?>
	</td>
	<td>
		<b><?php echo $row2['due']?></b>
	</td>
	<td>
		<span class="label label-<?php if($row2['status']=='Approved')echo 'info'; elseif ($row2['status']=='verifying') echo 'default'; elseif ($row2['status']=='Pending') echo 'warning'; elseif($row2['status']=='finished')echo 'danger'; elseif ($row2['status']=='running') echo 'success';?>">
				  
			<?php echo $row2['status']?>
		</span>
	</td>
	
	<td>
		<a href="<?php echo base_url();?>index.php?admin/loan_manage_approveloans_details/<?php echo $row2['loan_id'];?>" 
				class="btn btn-success btn-sm btn-icon icon-left" >
				<i class="entypo-cancel"></i>
				View/ Modify
				</a>
		
	</td>
</tr>

 <?php endforeach;?>

</table>

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