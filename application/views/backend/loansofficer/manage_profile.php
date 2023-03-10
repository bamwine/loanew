<hr> 
<div class="x_panel" >
            
                <div class="x_title">
                    <div class="panel-title">
					 <?php echo get_phrase('manage_profile'); ?>
					</div>
					</div>
<div class="table-responsive">
<br>
					<?php 
                    foreach($edit_data as $row):
                        ?>
                        <?php echo form_open(base_url() . 'index.php?loansofficer/manage_profile/update_profile_info' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="email" value="<?php echo $row['email'];?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                                
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                            <img src="<?php echo $this->crud_model->get_image_url('loan_officer' , $row['teacher_id']);?>" alt="...">
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
                              <div class="col-sm-offset-3 col-sm-5">
<button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i><?php echo get_phrase('update_profile');?></button>
                              </div>
								</div>
								<br>
                        </form>
						<?php
                    endforeach;
                    ?>
                </div>
				</div>
<!--password-->
<div class="x_panel" >
            
                <div class="x_title">
                    <div class="panel-title">
					 <?php echo get_phrase('change_password'); ?>
					</div>
					</div>
<div class="table-responsive">
<br>
		
					<?php 
                    foreach($edit_data as $row):
                        ?>
                        <?php echo form_open('teacher/manage_profile/change_password' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('current_password');?></label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="password" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('new_password');?></label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="new_password" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('confirm_new_password');?></label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="confirm_new_password" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
<button type="submit" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-lock"></i><?php echo get_phrase('change_password');?></button>
                              </div>
								</div>
                        </form>
						<?php
                    endforeach;
                    ?>
               
	</div>
</div>