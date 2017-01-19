
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form name="formName" method="post" enctype="multipart/form-data"" action="sk_margin_test.php">
	<input type="file" name="selectfile">
	<select name="carrier">
		<option value="sk">sk</option>
		<option value="kt">kt</option>
		<option value="lg">lg</option>
	</select>
	<input type="submit" value="Submit">
	</form>
<style>
table, tr, th {
border-collapse: collapse;
}
</style>
</body>
</html>

<!-- 
<?php if($arr): ?>
 	<table border="1" style="width:100%">
 		<tr>
 			<th></th>
		 	<th colspan="9">support</th>
		 	<th colspan="9">selectPlan</th>
	 	</tr>

 		<tr>
 			<th></th>
 			<th colspan="3">0,1,2,3</th>
 			<th colspan="3">4</th>
 			<th colspan="3">5678</th>
 			<th colspan="3">0,1,2,3</th>
 			<th colspan="3">4</th>
 			<th colspan="3">5678</th>
 		</tr>

 		<tr>
 			<th></th>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>

 		</tr>


		
 		<?php foreach($arr as $dvKey => $arrDiscountType) :?>
 			<tr>
 				<td><?php echo $dvKey?></td>
 				<?php foreach($arrDiscountType as $arrPlan) :?>
 					<?php foreach($arrPlan as $arrApplyType) :?>
 						<?php foreach($arrApplyType as $point) :?>
 						<td><?php echo $point['rpPoint']?></td>
 						<?php endforeach ?>
 					<?php endforeach ?>
 				<?php endforeach ?>
 			</tr>
 		<?php endforeach ?>
 	</table>
<?php endif; ?>
 -->
