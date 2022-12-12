<?php 

if(isset($_POST)){

	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   	$rand_dir_name = substr(str_shuffle($chars), 0, 15);

 	$Lecturer_ID = $_FILES['Lecturer_ID'];
 	$Lecturer_photo_name = $Lecturer_photo["name"];

	echo json_encode(array("upload_filename" => $rand_dir_name."_".str_replace(array(" ", "(", ")", "--", "-(", ")-", "-",), "-", $employee_photo_name), "selected_filename" => $employee_photo_name ));
		

	move_uploaded_file($Lecturer_photo["tmp_name"], "../uploads/employees_ids/".$rand_dir_name."_".str_replace(array(" ", "(", ")", "--", "-(", ")-", "-",), "-", $employee_photo_name));

}

?>