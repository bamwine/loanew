<?php 
$edit_data		=	$this->db->get_where('loan' , array('loan_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>


<div class="panel panel-gradient">

<center>
<a onclick="PrintElem('#invoice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
Print Invoice
<i class="entypo-print"></i>
</a>
</center>
<br><br>

<div id="invoice_print">
<table width="100%" border="0">
<tbody><tr>
<td align="right">
<h5>Creation Date : <?php echo date("jS F, Y", strtotime( $row['date'])) ;?></h5>
<h5>purpose : <?php echo $row['purpose']?></h5>
<h5>status : <?php echo $row['status']?></h5>
</td>
</tr>
</tbody></table>
<hr>
<table width="100%" border="0">
<tbody><tr>
<td align="left"><h4>Client Details </h4></td>

</tr>
<tr>
<td align="left" valign="top">
<?php 	 
	$parents=$this->db->get_where('loan_clients' , array('student_id'=>$row['staff_name']))->result_array();
	foreach($parents as $row3):
		?>				
Name -<?php echo $row3['name'];?><br>
National Id <?php echo $row3['nationalid'];?><br>
Adddres - <?php echo $row3['address'];?><br>
Branch - <?php echo $this->crud_model->get_branch_name_by_id($row3['branch_id']);?><br>
Phone Numbers - <?php echo $row3['phone'];?><?php echo"  |  " ?><?php echo $row3['phone2'];?><br>

<?php
	endforeach;
  ?>
</td>
<td align="right" valign="top">

<div class="col-sm-3">
			
			<a href="#" class="profile-picture">
				<img src="<?php echo $this->crud_model->get_image_url('loan_clients' , $row['student_id']);?>" 
                	class="img-responsive img-circle" />
			</a>
			
		</div>
</td>
</tr>
</tbody></table>
<hr>
<table width="100%" border="0">
<tbody><tr>
<td align="right" width="80%">Expected Amount :</td>
<td align="right"><?php echo $row['amount_winterest']?></td>
</tr>
<tr>
<td align="right" width="80%"><h4>Paid Amount :</h4></td>
<td align="right"><h4><?php echo $row['amount_winterest']-$row['due']?></h4></td>
</tr>
</tbody></table>
<hr>

<h4>Payment History</h4>
<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
<thead>
<tr>
<th>date</th>
<th>amount</th>
<th>Method</th>
<th>Officer</th>
</tr>
</thead>
<tbody>
<?php 	 
	$pay=$this->db->get_where('loan_payment' , array('loan_id'=>$row['loan_id']))->result_array();
	foreach($pay as $rowp):
		?>
<tr>
<td><?php echo date("jS F, Y", strtotime($rowp['timestamp']));?></td>
<td><?php echo $rowp['amount'];?></td>
<td><?php if($rowp['method'] == 1){echo 'Cash';}else if($rowp['method'] == 2){echo 'Cheque';}else {echo 'Card';}?> </td>
<td><?php echo $rowp['creator'];?></td>
</tr>

<?php
	endforeach;
  ?>


</tbody>
<tbody>
</tbody></table>
</div>


<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>

</div>

<?php
endforeach;
?>

