<hr />

    <div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/loan_manage_newapplication/create' , 
      array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
        <div class="col-md-12">
            
            <div class="x_panel" >
            
                <div class="x_title">
                    <div class="panel-title">
                        <?php echo get_phrase('loan_applicant');?>
                    </div>
                </div>
                
                <div class="panel-body">
          
		  			<div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>

                        <div class="col-sm-9">
                            <div class="">
							<!--data-format="D, dd MM yyyy"-->
                                <input type="text" name="date" class="form-control datepicker" data-format="yyyy-mm-dd" placeholder="date here">
                            </div>
                        </div>
                    </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Applicant_name');?></label>
                      <div class="col-sm-9">
 										<select name="staff_name" class="form-control select2" style="width:100%;" required>
                                    	  <option value=""><?php echo get_phrase('select');?></option>
										<?php 
										$teachers = $this->db->get('loan_clients')->result_array();										
										foreach($teachers as $row):
										?>
                                          
                                    		<option value="<?php echo $row['student_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>                              
                      </div>
                  </div>
				  
				  <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Branch');?></label>
                        
						<div class="col-sm-9">
							<select name="branch_id" class="form-control select2">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$parents = $this->db->get('loan_branch')->result_array();
								foreach($parents as $row):
									?>
                            		<option value="<?php echo $row['branch_id'];?>">
										<?php echo $row['name'];?>
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
								$classes = $this->db->get('loan_types')->result_array();
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['class_id'];?>">
											<?php echo $row['name'];?>
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
                          <textarea type="text" class="form-control" name="purpose" required></textarea>                      
				   </div>
                  </div>
					
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('loan_amount');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="amount" id="original" onchange="loanamount()" required>
                      </div>
                  </div>
                    
                 
                    
                     <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Loan Intereset(%)');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="intereset" id="interest" value="<?php echo $this->crud_model->get_interest_name_by_id(1);?>" onchange="loanamount()"  readonly required>
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
<option value="1">Month</option>
<option value="12">Year</option>

</select>

</div>

<label class="col-sm-2 control-label"><?php echo get_phrase('Extra_Months');?></label>

<div class="col-md-2">

<input type="number" class="form-control" name="extramonths" id="extramonths"  onchange="loanamount()"   >
                     

</div>

</div>

</div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Total_Paid(With Interest)');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" id="total_paid" name="total_paid" readonly required>
                      </div>
                  </div>
				  
				   
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Total Duration (Months)');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" id="totalmonths" name="totalmonths" value="" onchange="loanamount()" readonly required>
                      </div>
                  </div>
				  
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('payment_mode');?></label>
                      <div class="col-sm-9">

						<select name="mop" class="form-control" required id="paymentmodes" onchange="loanamount()" >
				  
								<!--		
<option value=""><?php echo get_phrase('select');?></option>
								<?php 
								$classes = $this->db->get('loan_paymentmodes')->result_array();
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['name'];?>">
											<?php echo $row['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>
							  -->
							  
							  <option value="1">Daily</option>
								<option value="7.5">weekly</option>							  
                                            
							  
				  </select>                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('Daily_payment');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" id="emi_per_month" name="emi_per_month" readonly required>
                      </div>
                  </div>
				  
<hr>	
<div class="alert-danger">&nbsp;GUARANTOR'S INFORMATION</div>
<hr>
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guarantor_name');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_name"  / required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('relationship');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_relationship"  / required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guarantor_number');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="g_number"  /required>
                              
                      </div>
                  </div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guarantor_address');?></label>
                      <div class="col-sm-9">
                          <textarea type="text" class="form-control" name="g_address" required></textarea>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('guanrator_country');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="g_country"  /required>
                              
                      </div>
                  </div>
<hr>	
<div class="alert-danger">&nbsp;COLLATERAL INFORMATION</div>
<hr>
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_name');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="c_name"  /required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_type');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="c_type"  /required>
                              
                      </div>
                  </div>
				  
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_model');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="model"  /required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_make');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="make"  /required>
                              
                      </div>
                  </div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('serial_number');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="serial_number"  /required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collateral_value');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="value" placeholder= "How Much Does it Worth" /required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('condition');?></label>
                      <div class="col-sm-9">
				  <select name="condition" class="form-control" required>
				  <option value=""><?php echo get_phrase('select');?></option>
										 <?php 
								$classes = $this->db->get('loan_property_conditions')->result_array();
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['name'];?>">
											<?php echo $row['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>
				  </select>                              
                      </div>
                  </div>
				  
				    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('collateral_documents'); ?></label>
                        <div class="col-sm-5">
                        <input type="file" name="file_name" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> Browse" />
						<div style="color:#FF0000">Note that you are to submit hardcopy the adminstrattive officer for proper verifications.<br>
												   You can upload zip files here, so zip all the documents and upload here.</div>

                    </div>
                    </div>
				  
				   <div class="form-group">
	  <label  class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
	  <div class="col-sm-9">
		   <select name="status" class="form-control" required>

	
							<?php 
								$loanst = $this->db->get('loan_status')->result_array();
								foreach($loanst as $row):
									?>
                            		<option value="<?php echo $row['name'];?>">
											<?php echo $row['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>


	</select>    
	  </div>
</div>
                
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('apply_now');?></button>
                    </div>
                  </div>
                    <?php echo form_close();?>
                    
                </div>
            
            </div>
          

        </div>
        
        </div>
		

		
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
		