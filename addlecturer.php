<?php 
	ob_start();
	include("../inc/db_connect.php");

	


		$Lecturer_id = mysqli_real_escape_string($db_connect, $_POST['Lecturer_id']);
		$firstname = mysqli_real_escape_string($db_connect, $_POST['firstname']);
		$middlename = mysqli_real_escape_string($db_connect, $_POST['middlename']);
		$lastname = mysqli_real_escape_string($db_connect, $_POST['lastname']);
		$phone = mysqli_real_escape_string($db_connect, $_POST['phone']);
		$jobtype = mysqli_real_escape_string($db_connect, $_POST['jobtype']);
		$dateemployed = mysqli_real_escape_string($db_connect, $_POST['dateemployed']);
		$resaddress = mysqli_real_escape_string($db_connect, $_POST['resaddress']);
		$reslocation = mysqli_real_escape_string($db_connect, $_POST['reslocation']);
		$gpsreslocation = mysqli_real_escape_string($db_connect, $_POST['gpsreslocation']);
		$resdirection = mysqli_real_escape_string($db_connect, $_POST['resdirection']);
		$passport_photo_name = mysqli_real_escape_string($db_connect, $_POST['passport_photo_name']);
		$idnumber = mysqli_real_escape_string($db_connect, $_POST['idnumber']);
		$idtype = mysqli_real_escape_string($db_connect, $_POST['idtype']);
		$nationalID_name = mysqli_real_escape_string($db_connect, $_POST['nationalID_name']);
		$fullname = mysqli_real_escape_string($db_connect, $_POST['fullname']);
		$relationship = mysqli_real_escape_string($db_connect, $_POST['relationship']);
		$kinphone = mysqli_real_escape_string($db_connect, $_POST['kinphone']);
		$kinresaddress = mysqli_real_escape_string($db_connect, $_POST['kinresaddress']);
		$kinresdirection = mysqli_real_escape_string($db_connect, $_POST['kinresdirection']);
		$Lecstatus = mysqli_real_escape_string($db_connect, $_POST['Lecstatus']);
	
										
		//Check if user already exists
		$id_check =  mysqli_query($db_connect, "SELECT Lecturer_id FROM lecs WHERE Lecturer_id = '$Lecturer_id' ");
								
		//Count the amount of rows where username = $username
		$check_id = mysqli_num_rows($id_check);
		ob_end_clean();	
		if ($check_id == 0) {

			$query = mysqli_query($db_connect, "INSERT INTO `lecs` (`id`, `Lecturer_id`, `first_name`, `middle_name`, `last_name`, `phone`, `Lecturer_image`, `id_type`, `id_number`, `id_card_image`, `residence_address`, `residence_location`, `residence_direction`, `residence_gps`, `next_of_kin`, `relationship`, `phone_of_kin`, `kin_residence`, `kin_residence_direction`, `date_employed`, `job_type`, `status`) VALUES (NULL, '$Lecturer_id', '$firstname', '$middlename', '$lastname', '$phone', '$passport_photo_name', '$idtype', '$idnumber', '$nationalID_name', '$resaddress', '$reslocation', '$resdirection', '$gpsreslocation', '$fullname', '$relationship', '$kinphone', '$kinresaddress', '$kinresdirection', '$dateemployed', '$jobtype', '$empstatus')");
			$querycount = mysqli_num_rows($query);

			ob_end_clean();			
			if($query){

				echo json_encode(array("status" => "Success"));
				exit();			
			} else {
				echo json_encode(array("status" => "failed"));
				exit();
			}

		} else {
			echo json_encode(array("status" => "exists"));
			exit();
		}
	

?>