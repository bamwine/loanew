<?php
	$row_data = $this->db->get_where('loan_officer' , array('teacher_id' => $param2))->row();
		
$url = ($row_data->teacher_id=="")?'index.php?admin/loan_officer/create':'index.php?admin/loan_officer/do_update/'.$row_data->teacher_id;	
$labelname = ($row_data->teacher_id=="")?'save':'update';	

	//echo $url."<br/>"; 
	//echo $labelname."<br/>"; 

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('loan_officer');?>
            	</div>
            </div>
			<div class="panel-body">
                    <?php echo form_open(base_url() . $url , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                        		
                                <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                                
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                            <img src="<?php echo $this->crud_model->get_image_url('loan_officer' , $row_data->teacher_id);?>" alt="...">
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
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="<?php echo $row_data->name;?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class=" form-control datepicker" data-format="yyyy-mm-dd" name="birthday" value="<?php echo $row_data->birthday;?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('sex');?></label>
                                <div class="col-sm-5">
                                    <select name="sex" class="form-control selectboxit">
                                    	<option value="male" <?php if($row_data->sex == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                                    	<option value="female" <?php if($row_data->sex == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                                    </select>
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
                                <label class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="address" value="<?php echo $row_data->address;?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" name="phone" value="<?php echo $row_data->phone;?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="email" value="<?php echo $row_data->email;?>"/>
                                </div>
                            </div>
							
							<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                        
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" value="" >
						</div> 
					</div>
                            
                            
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info"><?php echo $labelname;?></button>
                            </div>
                        </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

	<script src="assets/js/bootstrap-datepicker.js"></script>	