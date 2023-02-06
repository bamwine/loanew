<hr>

 <div class="panel panel-gradient" >
            
                <div class="panel-heading">
                    <div class="panel-title">
					 <?php echo get_phrase('client_information_page'); ?>
					</div>
					</div>
<div class="table-responsive">
	<br>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_client_modal/');" 
    class="btn btn-primary">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_new_client');?>
    </a>
<br>

        
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_clients');?></span>
                </a>
            </li>
       
        </ul>
        
        <div class="tab-content">
            <div class="tab-pane active" id="home">
                
						<div class="table-responsive">
<br>
<table class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
			<th width="80"><div><?php echo get_phrase('national_id');?></div></th>
            <th><div><?php echo get_phrase('name');?></div></th>
			<th><div><?php echo get_phrase('branch');?></div></th>
            <th class="span3"><div><?php echo get_phrase('address');?></div></th>
            <th><div><?php echo get_phrase('email');?></div></th>
			<th><div><?php echo get_phrase('Phone_Numbers');?></div></th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>
    <tbody>
        		<?php 
				$this->db->get('loan_types')->result_array();
				//$students	=	$this->db->get_where('loan_clients' , array('class_id'=>$class_id))->result_array();
             
                $students	=	$this->db->get('loan_clients')->result_array();
                foreach($students as $row):?>
        <tr>
            <td><img src="<?php echo $this->crud_model->get_image_url('loan_clients',$row['student_id']);?>" class="img-circle" width="30" /></td>
            <td><?php echo $row['nationalid'];?></td>
			<td><?php echo $row['name'];?></td>
			<td><?php echo $this->crud_model->get_branch_name_by_id($row['branch_id']);?></td>
            <td><?php echo $row['address'];?></td>
            <td><?php echo $row['email'];?></td>
			<td><?php echo $row['phone'];?><?php echo"  |  " ?><?php echo $row['phone2'];?></td>

			<td>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                        
                        
                        <!-- STUDENT PROFILE LINK -->
							<li>
							<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_client_profile_modal/<?php echo $row['student_id'];?>');">
							<i class="entypo-user"></i>
							<?php echo get_phrase('profile');?>
							</a>
							</li>
                        
                        <!-- STUDENT EDITING LINK -->
						<li>
						<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/loan_client_modal/<?php echo $row['student_id'];?>');">
						<i class="entypo-pencil"></i>
						<?php echo get_phrase('edit');?>
						</a>
						</li>
						
							<li>
							<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/loan_client/delete/<?php echo $row['student_id'];?>');">
							<i class="entypo-trash"></i>
							<?php echo get_phrase('delete');?>
							</a>
							</li>
                       
                    </ul>
                </div>
                
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>

</div>



				</div>
 

        </div>
        
        
    </div>

</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      
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
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0, 2, 3, 4]
					},
					{
						"sExtends": "print",
						"fnSetText"	   : "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(1, false);
							datatable.fnSetColumnVis(5, false);
							
							this.fnPrint( true, oConfig );
							
							window.print();
							
							$(window).keyup(function(e) {
								  if (e.which == 27) {
									  datatable.fnSetColumnVis(1, true);
									  datatable.fnSetColumnVis(5, true);
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