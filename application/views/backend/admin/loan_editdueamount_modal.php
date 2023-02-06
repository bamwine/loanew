<?php 
	$edit_data = $this->db->get_where('loan' , array('loan_id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>
    <div class="row">
    <?php echo form_open(base_url() . 'index.php?admin/loan_manage_approveloans/changeamount/'. $row['loan_id'], 
       array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
        <div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('change Due amount');?>
            	</div>
            </div>
                
                <div class="panel-body">
          
		  			<div class="form-group">
                        
					<label  class="col-sm-3 control-label"><?php echo get_phrase('Amount');?></label>
                        <div class="col-sm-9">
                            <div class="">
							
                                <input type="text" name="due" class="form-control " value="<?php echo $row['due'];?>"  placeholder="value">
                            </div>
                        </div>
                    </div>
					
					
                
                
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('change');?></button>
                    </div>
                  </div>
                    <?php echo form_close();?>
                    
                </div>
            
            </div>
          

        </div>
        
        </div>
		
<?php endforeach;?>
		
