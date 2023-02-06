<?php 

 $edit_data = $this->db->get_where('loan' , array('loan_id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>
    <div class="row">
    <?php echo form_open(base_url() . 'index.php?loansofficer/loan_manage_approveloans/do_update/'. $row['loan_id'], 
       array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
        <div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('loan_applicant');?>
            	</div>
            </div>
                
                <div class="panel-body">
          
		  			<div class="form-group">
                        
					<label  class="col-sm-3 control-label"><?php echo get_phrase('creation_date');?></label>
                        <div class="col-sm-9">
                            <div class="">
							<!--data-format="D, dd MM yyyy"-->
                                <input type="text" name="date" data-format="yyyy-mm-dd" class="form-control datepicker" value="<?php echo $row['date'];?>"  placeholder="date here">
                            </div>
                        </div>
                    </div>
					
					
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Applicant_name');?></label>
                      <div class="col-sm-9">
 										<select name="staff_name" class="form-control select2" style="width:100%;" required>
                                    	  <option value=""><?php echo get_phrase('select');?></option>
										<?php 
									$parents = $this->db->get('loan_clients')->result_array();
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
				  
				  <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Branch');?></label>
                        
						<div class="col-sm-9">
							<select name="branch_id" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$parents = $this->db->get('loan_branch')->result_array();
									foreach($parents as $row3):
										?>
                                		<option value="<?php echo $row3['branch_id'];?>"
                                        	<?php if($row['branch_id'] == $row3['branch_id'])echo 'selected';?>>
													<?php echo $row3['name'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                          </select>
						</div> 
					</div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Loan_type');?></label>
                      <div class="col-sm-9">
 										<select name="loantype" class="form-control select2" style="width:100%;" required>
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
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('purpose');?></label>
                      <div class="col-sm-9">
                          <textarea type="text" class="form-control"  name="purpose" required><?php echo $row['purpose'];?></textarea>                      
				   </div>
                  </div>
				  
				  
				  
<div class="form-group">
	
<label  class="col-sm-3 control-label"><?php echo get_phrase('starting_date');?></label>
	<div class="col-sm-9">
		<div class="">
		<!--data-format="D, dd MM yyyy"-->
			<input type="text" name="starting_date" data-format="yyyy-mm-dd" class="form-control datepicker" value="<?php echo $row['starting_date'];?>" required placeholder="date here">
		</div>
	</div>
</div>


<div class="form-group">
	
<label  class="col-sm-3 control-label"><?php echo get_phrase('maturity_date');?></label>
	<div class="col-sm-9">
		<div class="">
		<!--data-format="D, dd MM yyyy"-->
			<input type="text" name="maturity_date" data-format="yyyy-mm-dd" class="form-control datepicker" value="<?php echo $row['maturity_date'];?>" required placeholder="date here">
		</div>
	</div>
</div>

					
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('loan_amount');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" value="<?php echo $row['amount'];?>" name="amount" id="original" onchange="loanamount()" required>
                      </div>
                  </div>
                    
                 
                    
                     <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Loan Intereset(%)');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="intereset" id="interest" value="<?php echo $row['interest'];?>" onchange="loanamount()"   required>
                      </div>
                  </div>
				  
				  							                            
<div class="form-group">
<label  class="col-sm-3 control-label"><?php echo get_phrase('loan_duration');?></label>
                                       
<div class="col-sm-9">
		 <div class="col-sm-3">

						<select name="l_duration" class="form-control" required onchange="loanamount()" id="payment_term">
				  <option value="1">One </option>
				  <option value="2">Two </option>
				  <option value="3">Three </option>
				  <option value="4">Four </option>
				   <option value="5">Five </option>
				  <option value="6">Six </option>
				  <option value="7">Seven </option>
				  <option value="8">Eight </option>
				  <option value="9">Nine </option>				 
				   <option value="10">Ten </option>
				  <option value="11">Eleven </option>
				  
				 
				  </select>
					                  
                      </div>
<label class="col-sm-2 control-label"><?php echo get_phrase('Duration_type');?></label>

<div class="col-md-3">

<select name="duration_type" class="form-control selectboxit visible" style="display: none;" id="duration_type" onchange="loanamount()">
<option value="1" <?php if($row['l_duration'] <12)echo 'selected';?>>Month</option>
<option value="12"<?php if($row['l_duration'] >12)echo 'selected';?>>Year</option>

</select>

</div>

<label class="col-sm-2 control-label"><?php echo get_phrase('Extra_Months');?></label>

<div class="col-md-2">

<input type="number" class="form-control" name="extramonths" id="extramonths"  onchange="loanamount()"   >
                     

</div>

</div>

</div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Total_(With_Interest)');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" id="total_paid" value="<?php echo $row['amount_winterest'];?>" name="total_paid" readonly required>
                      </div>
                  </div>
				  
				   
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Total Duration (Months)');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" value="<?php echo $row['l_duration'];?>" id="totalmonths" name="totalmonths" value="" onchange="loanamount()" readonly required>
                      </div>
                  </div>
				  
				  
                <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('payment_mode');?></label>
                      <div class="col-sm-9">

						<select name="mop" class="form-control" required id="paymentmodes" onchange="loanamount()" >
				  

							  
							  <option value="1" <?php if($row['mop'] =='Daily')echo 'selected';?>>Daily</option>
								<option value="7.5" <?php if($row['mop'] =='weekly')echo 'selected';?>>weekly</option>							  
                                            
							  
				  </select>                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Daily_payment');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" id="emi_per_month" name="emi_per_month" readonly value="<?php echo $row['dailypay'];?>" required>
                      </div>
                  </div>
<hr>	
<div class="alert-danger">&nbsp;GUARANTOR'S INFORMATION</div>
<hr>
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guarantor_name');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_name"  value="<?php echo $row['g_name'];?>" required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('relationship');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_relationship"  value="<?php echo $row['g_relationship'];?>" required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guarantor_number');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_number"  value="<?php echo $row['g_number'];?>" required>
                              
                      </div>
                  </div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guarantor_address');?></label>
                      <div class="col-sm-9">
                          <textarea type="text" class="form-control" name="g_address" required><?php echo $row['g_address'];?></textarea>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guanrator_country');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_country" value="<?php echo $row['g_country'];?>" required>
                              
                      </div>
                  </div>

				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('loan_status');?></label>
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
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('update_loan');?></button>
                    </div>
                  </div>
                    <?php echo form_close();?>
                    
                </div>
            
            </div>
          

        </div>
        
        </div>
		
<?php endforeach;?>
		
		
<script type="text/javascript">
		function loanamount()
		{
		paymentmodes	
		var paymentmodes=document.getElementById("paymentmodes").value;	
		
		var original=document.getElementById("original").value;	
		var interest=document.getElementById("interest").value;	
		var payment_term=document.getElementById("payment_term").value;	
		
		var duration_type=document.getElementById("duration_type").value;
		var extramonths=document.getElementById("extramonths").value;
		var year=(Number(payment_term)*Number(duration_type)+Number(extramonths));	
		var interest1=(Number(original)*Number(interest)*Number(year))/100;
		var total=Number(original)+Number(interest1);
		//var dailypay=Number(total/30);
		var dailypay=Number(total/(30*year));
		var finalpayplan=Number(dailypay*Number(paymentmodes));
		//alert(dailypay);
		document.getElementById("totalmonths").value=year;
		
		var emi=total/(year*12);
		document.getElementById("total_paid").value=total;
		document.getElementById("emi_per_month").value=finalpayplan;
		
		}
	</script>
		<script src="assets/js/bootstrap-datepicker.js"></script>	