<table class="table table-bordered text-dark" style="background:rgba(241,85,108,0.1);">
	<tr>
		<th class="text-center">Row Number</th>
		<th>Errors</th>
	</tr>
	<?php foreach($errors as $row=>$error): ?>
		<tr class="alert-danger" style="background:rgba(241,85,108,0.1);">
			<td class="text-center"><?php echo $row; ?></td>
			<td><?php echo $error; ?></td>
		</tr>
	<?php endforeach; ?>
</table>