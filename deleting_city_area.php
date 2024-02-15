<?php
include './connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $output = '';
    $status = '';
    $option = '';
    if ($_POST['pass'] == 'city_name') {

        //get city name from post request and search in database for that city
        $querytogetcityname = "SELECT * FROM city WHERE `city_id` = {$_POST['id']} ";
        $querytogetcitynameresult = mysqli_query($con, $querytogetcityname);
        $rowtogetcityname = mysqli_fetch_assoc($querytogetcitynameresult);
        $city_name_f =  $rowtogetcityname["city_name"];


        $delete_query = "DELETE FROM city WHERE `city_id` = {$_POST['id']} ";
        $delete_result = mysqli_query($con, $delete_query);
        if ($delete_result) {
            $city_query = "SELECT * FROM city";
            $result = mysqli_query($con, $city_query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $output .= '<div class="city-list" value="' . strtolower($row['city_name']) . '" ><span class="city-list-delete" onclick="Deletethecity(\'city_name\',' . $row['city_id'] . ')">x</span><p style="text-transform: capitalize;">' . $row['city_name'] . '</p></div>';
                    $option .= '<option value="' . strtolower($row['city_name']) . '" style="text-transform: capitalize;">' . $row['city_name'] . '</option>';
                }
                $status = 200;
            } else {
                $output = 'No Result Found';
                $status = 500;
            }
        } else {
            $output = 'Failed To Delete: Query Failed';
            $status = 500;
        }

        if ($status == 200) {
            $deletearea = "DELETE FROM area WHERE area_city_name = '$city_name_f' ";
            $resdelareasuccess = mysqli_query($con, $deletearea);
            if (!$resdelareasuccess) {
                $output = 'Failed To Delete: Query Failed';
                $status = 500;
            }
            $deletearea2 = "DELETE FROM area2 WHERE area_city_name = '$city_name_f' ";
            $resdelareasuccess2 = mysqli_query($con, $deletearea2);
            if (!$resdelareasuccess2) {
                $output = 'Failed To Delete: Query Failed';
                $status = 500;
            }
        }

        echo json_encode(['status' => $status, 'output' => $output, 'option' => $option, 'pass' => $_POST['pass']]);
    } elseif ($_POST['pass'] == 'city_area') {

        $id = $_POST['id'];
        $index = explode(',',$_POST['index']);
        $new_list ='';
        $list_of_area='';
        // 0 is index
        // 1 is area name
        // 2 is city name
        $area_query = "SELECT * FROM area2 WHERE add_id = $id";
        $area_result = mysqli_query($con, $area_query);
        if (mysqli_num_rows($area_result) > 0) {
            $row = mysqli_fetch_assoc($area_result);
            // ===========================================
            $list_of_area = json_decode($row['area_name'], true);
            unset($list_of_area[$index[0]]);
            $new_list = json_encode($list_of_area);
            
            $update_area = "UPDATE area2 SET area_name = '$new_list' WHERE  add_id= $id";
            $new_result = mysqli_query($con, $update_area);
            // ============================================
            if ($new_result) {
                $area_query2 = "SELECT * FROM area2";
                $area_result2 = mysqli_query($con, $area_query2);
                $AREA_NAME = '';
                $CITY_NAME = '';
                if (mysqli_num_rows($area_result2) > 0) {
                    while ($area_row = mysqli_fetch_array($area_result2)) {
                        $CITY_NAME = '<div class="city-list" value="' . strtolower($area_row['area_city_name']) . '" ><p style="text-transform: capitalize;">' . $area_row['area_city_name'] . '</p></div>';

                        $convertjsontoarray = json_decode($area_row['area_name'], true);
                        foreach ($convertjsontoarray as $key => $value) {
                            $list_y = "'".implode(",",[$key, $value, $area_row['area_city_name']])."'";
                            $AREA_NAME .= '<div class="city-list" value="' . strtolower($value) . '" ><span class="city-list-delete" onclick="Deletethecity(\'city_area\',' . $area_row['add_id'] . ', ' . $list_y . ')">x</span><p style="text-transform: capitalize;">' . $value . '</p></div>';
                        }

                        $output .= '<div class="list_of_all_area_with_city">
                        <div class="city_dedicated_to_areas">' . $CITY_NAME . '</div>
                        <div class="areas_dedicated_to_city list-of-all-cities">' . $AREA_NAME . '</div>
                    </div>';

                        $AREA_NAME = '';
                    }
                }
                $status = 200;
            } else {
                $status = 500;
                $output = "Failed to delete or update Area from Database.";
            }
        } else {
            $status = 500;
            $output = "No Area Data For This City.";
        }
        if($status == 200){
            $deletearea = "DELETE FROM area WHERE area_city_name = '$index[2]' AND area_name = '$index[1]' ";
            $resdelareasuccess = mysqli_query($con, $deletearea);
            if (!$resdelareasuccess) {
                $output = 'Failed To Delete: Query Failed';
                $status = 500;
            }
        }

        echo json_encode(['status' => $status, 'output' => $output, 'pass' => $_POST['pass'],'a'=>$list_of_area,'b'=>$new_list]);
    }elseif($_POST['pass'] == 'list-of-areas'){
        $output = "<option value='".strtolower('all')."'><p style='text-transform: capitalize;'>" . ucwords(strtolower('all locations')) . "</p></option>";
        $area_list = "SELECT * FROM area2 WHERE area_city_name = '{$_POST['city']}'";
        $res = mysqli_query($con, $area_list);
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_assoc($res);
            $areas = json_decode($row['area_name'],true);
            foreach($areas as $area){
                $a = '';
                foreach(explode('-',$area) as $c){
                    $a .= $c.' ';
                }
                $output .= "<option value='".strtolower($area)."'><p style='text-transform: capitalize;'>" . ucwords(strtolower($a)) . "</p></option>";
            }
        }
        echo json_encode(['output'=>$output,'status'=>200]);

    }
}
