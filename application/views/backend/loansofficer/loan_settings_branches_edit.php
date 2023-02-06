<?php 
	$row_data = $this->db->get_where('loan_branch' , array('branch_id' => $param2))->row();
		
$url = ($row_data->branch_id=="")?'index.php?loansofficer/loan_settings_branches/create':'index.php?loansofficer/loan_settings_branches/do_update/'.$row_data->branch_id;	
$labelname = ($row_data->branch_id=="")?'add_branch':'edit_branch';	

	//echo $url."<br/>"; 
	//echo $labelname."<br/>"; 


?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase($labelname);?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() .$url , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value="<?php echo $row_data->name;?>"/>
                        </div>
                    </div>
                                     
					
					
            		<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase($labelname);?></button>
						</div>
					</div>
        		</form>
            </div>
        </div>
    </div>
</div>



