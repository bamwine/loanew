<?php 
	$row_data = $this->db->get_where('loan_collateral' , array('collateral_id' => $param2))->row();
	$client_ido = $this->db->get_where('loan' , array('loan_id' => $param3))->row()->staff_name;
		
	
$labedata = ($row_data->loan_id=="")?"Add collateral ":"Update Data";	
$loan_id = ($row_data->loan_id=="")?$param3:$row_data->loan_id;	
$actiondata = ($row_data->collateral_id=="")?0:$row_data->collateral_id;	
$client_id = ($row_data->collateral_id=="")?$client_ido:$row_data->client_id;

/*  	echo $labedata."<br/>";
	echo $loan_id."<br/>";
	echo $actiondata."<br/>";
	echo $client_id */
?>


    <div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/loan_manage_approveloans_details/save_collateral/', 
       array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
        <div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('loan_colateral');?>
            	</div>
            </div>
                
                <div class="panel-body">
				
				<input type="hidden" name="loan_id" class="form-control " value="<?php echo $loan_id;?>"  placeholder="date here">
                <input type="hidden" name="action" class="form-control " value="<?php echo $actiondata;?>"  placeholder="date here">
                         
		           
		  
		  
		  			<div class="form-group">
                        
					<label  class="col-sm-3 control-label"><?php echo get_phrase('collection_date');?></label>
                        <div class="col-sm-9">
                            <div class="">
							<!--data-format="D, dd MM yyyy"-->
                                <input type="text" name="date" data-format="yyyy-mm-dd" class="form-control datepicker" value="<?php echo $row_data->date;?>"  placeholder="date here">
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
                                        	<?php if($client_id == $row3['student_id'])echo 'selected';?>>
													<?php echo $row3['name'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                                    </select>                              
                      </div>
                  </div>
				  
                    


				
<hr>	
<div class="alert-danger">&nbsp;COLLATERAL INFORMATION</div>
<hr>
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_name');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="c_name"  value="<?php echo $row_data->c_name;?>" required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_type');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="c_type" value="<?php echo $row_data->c_type;?>"  required>
                              
                      </div>
                  </div>
				  
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_model');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="model" value="<?php echo $row_data->model;?>" required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collaral_make');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="make"  value="<?php echo $row_data->make;?>" required>
                              
                      </div>
                  </div>
				  
				   <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('serial_number');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="serial_number" value="<?php echo $row_data->serial_number;?>" required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('collateral_value');?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="value"  value="<?php echo $row_data->value;?>"placeholder= "How Much Does it Worth" /required>
                              
                      </div>
                  </div>
				  
				  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('condition');?></label>
                      <div class="col-sm-9">
				  <select name="condition" class="form-control" required>
				  <?php 
	$parents = $this->db->get('loan_property_conditions')->result_array();
	foreach($parents as $row3):
		?>
		<option value="<?php echo $row3['name'];?>"
			<?php if($row_data->condition == $row3['name'])echo 'selected';?>>
					<?php echo $row3['name'];?>
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
									$parents = $this->db->get('loan_status')->result_array();
									foreach($parents as $row3):
										?>
                                		<option value="<?php echo $row3['name'];?>"
                                        	<?php if($row_data->status == $row3['name'])echo 'selected';?>>
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
                        <button type="submit" class="btn btn-info"><?php echo $labedata;?></button>
                    </div>
                  </div>
                    <?php echo form_close();?>
                    
                </div>
            
            </div>
          

        </div>
        
        </div>