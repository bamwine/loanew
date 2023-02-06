<hr> 
<div class="x_panel" >
            
                <div class="x_title">
                    <div class="panel-title">
					 <?php echo get_phrase('Applicant_information_page'); ?>
					</div>
					</div>
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
			<th><div><?php echo get_phrase('Account_status');?></div></th>
            <th><div><?php echo get_phrase('options');?></div></th>
        </tr>
    </thead>
    <tbody>
        		<?php 
                $students	=	$this->db->get_where('loan_clients' , array('student_id'=>$this->session->userdata('student_id')))->result_array();
                foreach($students as $row):?>
        <tr>
            
            <td><img src="<?php echo $this->crud_model->get_image_url('loan_clients',$row['student_id']);?>" class="img-circle" width="30" /></td>
            <td><?php echo $row['nationalid'];?></td>
			<td><?php echo $row['name'];?></td>
			<td><?php echo $this->crud_model->get_branch_name_by_id($row['branch_id']);?></td>
            <td><?php echo $row['address'];?></td>
            <td><?php echo $row['email'];?></td>
			<td><?php echo $row['phone'];?><?php echo"  |  " ?><?php echo $row['phone2'];?></td>
			 <td><?php echo $row['status'];?></td>
            <td>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                        
                        
                        <!-- STUDENT PROFILE LINK -->
                        <li>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_student_profile/<?php echo $row['student_id'];?>');">
                                <i class="entypo-user"></i>
                                    <?php echo get_phrase('profile');?>
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