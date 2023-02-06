

<div class="panel panel-gradient">
<div class="panel-heading">
<div class="panel-title">
 <?php echo get_phrase('Payment_Information_Page');?></div>
</div>
<div class="table-responsive">
<br>
<ul class="nav nav-tabs bordered">
<li class="active">
<a href="#unpaid" data-toggle="tab">
<span class="hidden-xs"><?php echo get_phrase('Loan_Payment_Invoice ');?></span>
</a>
</li>

</ul>
<?php 
	
	foreach ($loan_data as $row):
?>

<div class="tab-content">
<div class="tab-pane active" id="unpaid">

<form action="index.php?loansofficer/loan_manage_makepayments/create" class="form-horizontal form-groups-bordered validate" target="_top" method="post" accept-charset="utf-8" novalidate="novalidate">
<div class="row">
<div class="col-md-6">
<div class="panel panel-success panel-shadow" data-collapsed="0">
<div class="panel-heading">
<div class="panel-title"><?php echo get_phrase('Client loan Details');?></div>
</div>
<div class="panel-body">
<div class="form-group">
<label class="col-sm-3 control-label"><?php echo get_phrase('Loan_type');?></label>
<div class="col-sm-9">
<select name="class_id" class="form-control" >
  <option value=""><?php echo get_phrase('select');?></option>
						 <?php 
					$parents = $this->db->get('loan_types')->result_array();
					foreach($parents as $row3):
						?>
						<option value="<?php echo $row3['class_id'];?>"
							<?php if($row['loantype'] == $row3['class_id'])echo 'selected';?>>
									<?php echo $row3['name'];?>
								</option>
					<?php
					endforeach;
				  ?>
</select>
</div>
</div>

<div class="form-group">
	  <label  class="col-sm-3 control-label"><?php echo get_phrase('Client_name');?></label>
	  <div class="col-sm-9">
		<select name="staff_name" class="form-control select2" style="width:100%;" required>
						  <option value=""><?php echo get_phrase('select');?></option>
						<?php 
					
					$parents = $this->db->get_where('loan_clients' , array('student_id' => $row['staff_name']))->result_array();
					foreach($parents as $row3):
						?>
						<option value="<?php echo $row3['student_id'];?>"
							<?php if($row['staff_name'] == $row3['student_id'])echo 'selected';?>>
									<?php echo $row3['name'];?>
								</option>
					<?php
					endforeach;
				  ?>
					</select>                              
	  </div>
  </div>
				  


<input type="hidden" class="form-control" name="loan_id" value="<?php echo $row['loan_id'];?>">


	
<div class="form-group">
<label class="col-sm-3 control-label">title</label>
<div class="col-sm-9">
<input type="text" class="form-control" name="title">
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">description</label>
<div class="col-sm-9">
<input type="text" class="form-control" name="description">
</div>
</div>

 <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Branch');?></label>
                        
						<div class="col-sm-9">
							<select name="branch_id" class="form-control select2">
                              
							   <?php 
										$teachers = $this->db->get_where('loan_clients' , array('student_id' => $row['staff_name']))->result_array();
								foreach($teachers as $rows):
										?>
                                          
                                    		<option value="<?php echo $rows['branch_id'];?>"><?php echo $this->crud_model->get_branch_name_by_id($rows['branch_id']);?></option>
                                        <?php
										endforeach;
										?>
							 
                          </select>
						</div> 
					</div>




</div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-success panel-shadow" data-collapsed="0">
<div class="panel-heading">
<div class="panel-title"><?php echo get_phrase('Payment Informations');?></div>
</div>
<div class="panel-body">

<div class="form-group">
<label class="col-sm-3 control-label">date</label>
<div class="col-sm-9">
<input type="text" class="datepicker form-control" name="date" data-format="yyyy-mm-dd" required>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">Due Amount</label>
<div class="col-sm-9">
<input type="number" class="form-control" name="amount" value="<?php echo $row['due'];?>" readonly>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">payment</label>
<div class="col-sm-9">
<input type="number" class="form-control" name="amount_paid" placeholder="Enter Payment Amount" required>
</div>
</div>


<div class="form-group">
<label  class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
<div class="col-sm-9">
<select name="status" class="form-control" required>


<?php 
			$parents = $this->db->get('loan_status')->result_array();
			foreach($parents as $row3):
				?>
				<option value="<?php echo $row3['name'];?>"
					<?php if($row['status'] == $row3['name'])echo 'selected';?>>
							<?php echo $row3['name'];?>
						</option>
			<?php
			endforeach;
		  ?>


</select>  
		
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">Method</label>
<div class="col-sm-9">
<select name="method" class="form-control">
<option value="1">Cash</option>
<option value="2">Cheque</option>
 <option value="3">Card</option>
 <option value="4">mobile Money</option>
</select>
</div>
</div>
</div>
</div>
<div class="form-group">
<div class="col-sm-5">
<button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-plus"></i>add payment</button>
</div>
</div>
</div>
</div>
</form>

</div>

</div>

<?php endforeach;?>

</div>
</div>



