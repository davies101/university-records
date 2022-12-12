<?php

    //Include pagination class file
    include('../phpclasses/pagination.php');

    include('../inc/header.php');

    $action = mysqli_real_escape_String($db_connect, $_POST['action']);
    $limit = 10;

    if($action == "allemployee"){    
        $start = !empty($_POST['page'])?$_POST['page']:0;
        

        //set conditions for search
        $whereSQL = $orderSQL = '';
        $keywords = $_POST['keywords'];
        $sortBy = $_POST['sortBy'];
        if(!empty($keywords)){
            $whereSQL = "WHERE first_name LIKE '%".$keywords."%' OR last_name LIKE '%".$keywords."%' OR middle_name LIKE '%".$keywords."%'";
        }
        if(!empty($sortBy)){
            $orderSQL = " ORDER BY id ".$sortBy;
        }else{
            $orderSQL = " ORDER BY id ASC ";
        }

        //get number of rows
        $queryNum = $db_connect->query("SELECT COUNT(*) as postNum FROM lecs ".$whereSQL.$orderSQL);
        $resultNum = $queryNum->fetch_assoc();
        $rowCount = $resultNum['postNum'];

        //initialize pagination class
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);


        //get rows
        $queryNum = mysqli_query($db_connect, "SELECT * FROM lecs $whereSQL $orderSQL LIMIT $start, $limit");
        $queryNumcount = mysqli_num_rows($queryNum);
       
        if($queryNumcount >= 1 ){
                                while($fetch = mysqli_fetch_assoc($queryNum)){
                                    $id = $fetch['id'];
                                    $Lecturer_id = $fetch['Lecturer_id'];
                                    $first_name = $fetch['first_name'];
                                    $middle_name = $fetch['middle_name'];
                                    $last_name = $fetch['last_name'];
                                    $date_employed = $fetch['date_employed'];
                                    $job_type = $fetch['job_type'];
                                    $status = $fetch['status'];

                                    $date_employed = date("jS F Y", strtotime($date_employed));

                                    if($middle_name == ""){
                                        if($usertype == "Admin"){
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                            <li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
                                                            <li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        } else {
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';                                          
                                        }
                                    } else {
                                        if($usertype == "Admin"){
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                            <li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
                                                            <li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        } else {

                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
                                                    <div class="Lecturer_column">'.$date_employed.'</div>
                                                    <div class="Lecturer_column">'.$job_type.'</div>
                                                    <div class="Lecturer_column Lecturer_status">'.$status.'</div>
                                                    <div class="Lecture_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        }
                                    }
                                }
            echo $pagination->createLinks();
        } else {
            echo '<li class="emp_item"> No Lecturer record found </li>';
        }
    }

    if($action == "currentlecturers"){
        $start = !empty($_POST['page'])?$_POST['page']:0;        

        //set conditions for search
        $whereSQL = $orderSQL = '';
        $keywords = $_POST['keywords'];
        $sortBy = $_POST['sortBy'];
        if(!empty($keywords)){
            $whereSQL = "WHERE (`middle_name` LIKE '%".$keywords."%' OR `last_name` LIKE '%".$keywords."%' OR `first_name` LIKE '%".$keywords."%') AND `status` = 'Lecturer'";
        } else {
            $whereSQL = "WHERE status = 'Lecture'";
        }
        if(!empty($sortBy)){
            $orderSQL = " ORDER BY id ".$sortBy;
        }else{
            $orderSQL = " ORDER BY id ASC ";
        }

        //get number of rows
        $queryNum = $db_connect->query("SELECT COUNT(*) as postNum FROM lecs ".$whereSQL.$orderSQL);
        $resultNum = $queryNum->fetch_assoc();
        $rowCount = $resultNum['postNum'];

        //initialize pagination class
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'currsearchFilter'
        );
        $pagination =  new Pagination($pagConfig);


        //get rows
        $queryNum = mysqli_query($db_connect, "SELECT * FROM lecs $whereSQL $orderSQL LIMIT $start, $limit");
        $queryNumcount = mysqli_num_rows($queryNum);
       
        if($queryNumcount >= 1 ){
                                while($fetch = mysqli_fetch_assoc($queryNum)){
                                    $id = $fetch['id'];
                                    $Lecturer = $fetch['Lecturer_id'];
                                    $first_name = $fetch['first_name'];
                                    $middle_name = $fetch['middle_name'];
                                    $last_name = $fetch['last_name'];
                                    $date_employed = $fetch['date_employed'];
                                    $job_type = $fetch['job_type'];
                                    $status = $fetch['status'];

                                    $date_employed = date("jS F Y", strtotime($date_employed));

                                    if($middle_name == ""){
                                        if($usertype == "Admin"){
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                            <li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
                                                            <li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        } else {
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';                                          
                                        }
                                    } else {
                                        if($usertype == "Admin"){
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                            <li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
                                                            <li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        } else {

                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        }
                                    }
                                }
            echo $pagination->createLinks();
        } else {
            echo '<li class="emp_item"> No Lecturer record found </li>';
        }
    }

    if($action == "fomerLecturers"){
        $start = !empty($_POST['page'])?$_POST['page']:0;        

        //set conditions for search
        $whereSQL = $orderSQL = '';
        $keywords = $_POST['keywords'];
        $sortBy = $_POST['sortBy'];
        if(!empty($keywords)){
            $whereSQL = "WHERE (`middle_name` LIKE '%".$keywords."%' OR `last_name` LIKE '%".$keywords."%' OR `first_name` LIKE '%".$keywords."%') AND `status` = 'former'";
        } else {
            $whereSQL = "WHERE status = 'former'";
        }
        if(!empty($sortBy)){
            $orderSQL = " ORDER BY id ".$sortBy;
        }else{
            $orderSQL = " ORDER BY id ASC ";
        }

        //get number of rows
        $queryNum = $db_connect->query("SELECT COUNT(*) as postNum FROM lecs ".$whereSQL.$orderSQL);
        $resultNum = $queryNum->fetch_assoc();
        $rowCount = $resultNum['postNum'];

        //initialize pagination class
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'pastsearchFilter'
        );
        $pagination =  new Pagination($pagConfig);


        //get rows
        $queryNum = mysqli_query($db_connect, "SELECT * FROM lecs $whereSQL $orderSQL LIMIT $start, $limit");
        $queryNumcount = mysqli_num_rows($queryNum);
       
        if($queryNumcount >= 1 ){
                                while($fetch = mysqli_fetch_assoc($queryNum)){
                                    $id = $fetch['id'];
                                    $Lecturer_id = $fetch['Lecturer_id'];
                                    $first_name = $fetch['first_name'];
                                    $middle_name = $fetch['middle_name'];
                                    $last_name = $fetch['last_name'];
                                    $date_employed = $fetch['date_employed'];
                                    $job_type = $fetch['job_type'];
                                    $status = $fetch['status'];

                                    $date_employed = date("jS F Y", strtotime($date_employed));

                                    if($middle_name == ""){
                                        if($usertype == "Admin"){
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column Lecturer">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                            <li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
                                                            <li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        } else {
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';                                          
                                        }
                                    } else {
                                        if($usertype == "Admin"){
                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                            <li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
                                                            <li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        } else {

                                            echo '                                      
                                                <li class="emp_item">
                                                    <div class="emp_column emp_id">'.$Lecturer_id.'</div>
                                                    <div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
                                                    <div class="emp_column">'.$date_employed.'</div>
                                                    <div class="emp_column">'.$job_type.'</div>
                                                    <div class="emp_column emp_status">'.$status.'</div>
                                                    <div class="emp_column">
                                                        <ul class="action_list">
                                                            <li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            ';
                                        }
                                    }
                                }
            echo $pagination->createLinks();
        } else {
            echo '<li class="emp_item"> No Lecturer record found </li>';
        }
    }

?>