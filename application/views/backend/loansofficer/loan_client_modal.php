<?php 
$row_data = $this->db->get_where('loan_clients' , array('student_id' => $param2))->row();
		
$url = ($row_data->student_id=="")?'index.php?loansofficer/loan_client/create':'index.php?loansofficer/loan_client/do_update/'.$row_data->student_id;	
$labelname = ($row_data->student_id=="")?'Register':'edit_details';	

//echo $url."<br/>"; 
//echo $labelname."<br/>"; 

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="x_title">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo "  ";?><?php echo $row_data->name;?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() .  $url , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                
                	
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url('loan_clients' , $row_data->student_id);?>" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?php echo $row_data->name;?>">
						</div>
					</div>

					
					
					

					
						
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('National_Id');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="nationalid" value="<?php echo $row_data->nationalid;?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Branch');?></label>
                        
						<div class="col-sm-5">
							<select name="branch_id" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$parents = $this->db->get('loan_branch')->result_array();
									foreach($parents as $row3):
										?>
                                		<option value="<?php echo $row3['branch_id'];?>"
                                        	<?php if($row_data->branch_id == $row3['branch_id'])echo 'selected';?>>
													<?php echo $row3['name'];?>
                                                </option>
	                                <?php
									endforeach;
								  ?>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" data-format="yyyy-mm-dd" name="birthday" value="<?php echo $row_data->birthday;?>" data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male" <?php if($row_data->sex == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                              <option value="female"<?php if($row_data->sex == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="<?php echo $row_data->address;?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone_1');?></label>
                        
						<div class="col-sm-5">
							<input type="number" class="form-control" name="phone" value="<?php echo $row_data->phone;?>" >
						</div> 
					</div>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone_2');?></label>
                        
						<div class="col-sm-5">
							<input type="number" class="form-control" name="phone2" value="<?php echo $row_data->phone2;?>" >
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" value="<?php echo $row_data->email;?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="password" value="<?php echo $row_data->password;?>">
						</div> 
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase($labelname);?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>index.php?loansofficer/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }

    var class_id = $("#class_id").val();
    
    	$.ajax({
            url: '<?php echo base_url();?>index.php?loansofficer/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });


</script>

<script src="assets/js/bootstrap-datepicker.js"></script>	