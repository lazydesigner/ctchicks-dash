<?php
include './connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (hash_equals($_SESSION['csrf_token'], $_POST['token'])) {
        $output = '';
        $report = '<tr><th style="background-color: black;padding:.1% 1%">Report</th></tr>';
        $option = '';
        // 

        if ($_POST['pass'] == 'city_name') {

            // $cities = htmlspecialchars($_POST['value'], ENT_QUOTES, 'UTF-8'); add single qoutes around the string
            $list_of_cities = preg_split("/[' , \"]+/", $_POST['value'], -1, PREG_SPLIT_NO_EMPTY);

            foreach ($list_of_cities as $i => $city) {
                if ($city == '') {
                } else {
                    $check_if_city_exist = "SELECT * FROM city WHERE city_name = '$city'";
                    $check_if_city_exist_result = mysqli_query($con, $check_if_city_exist);
                    if (mysqli_num_rows($check_if_city_exist_result) > 0) {
                        $report .= '<tr><td style="padding:.1% 1%;border:1px solid grey;color:tomato;background:white"><p style="text-transform: capitalize;">' . $city . ' City Already Exist In Database</p></td></tr>';
                    } else {
                        $city_query = "INSERT INTO city(`city_name`) VALUE ('$city')";
                        $result = mysqli_query($con, $city_query);
                        if ($result) {
                            $output .= '<div class="city-list new-city-added" value="' . strtolower($city) . '" ><span class="city-list-delete" onclick="Deletethecity(\'city_name\','.mysqli_insert_id($con).')">x</span><p style="text-transform: capitalize;">' . $city . '</p></div>';
                            $report .= '<tr><td style="padding:.1% 1%;border:1px solid grey;color:green;background:white"><p style="text-transform: capitalize;">' . $city . ' Added To  Database Successfully.</p></td></tr>';
                            $option .= '<option value="' . strtolower($city) . '" style="text-transform: capitalize;">' . $city . '</option>';
                        } else {
                            $report .= '<tr><td style="padding:.1% 1%;border:1px solid grey;color:tomato;background:white"><p>While Insserting This ' . $city . ' Something Went Wrong</p></td></tr>';
                        }
                    }
                }
            }
            echo json_encode(['output' => $output, 'report' => $report, 'option' => $option, 'id' => $_POST['pass']]);
        } elseif ($_POST['pass'] == 'city_area') {  
            $CITY_NAME = '';         
            $AREA_NAME = '';
            $list_of_cities_area = preg_split("/[' , \"]+/", $_POST['value'], -1, PREG_SPLIT_NO_EMPTY);

            $querytocheckifcitypresentinarea2 = "SELECT * FROM area2 WHERE area_city_name = '{$_POST['_city_name_']}' ";
            $querytocheckifcitypresentinarea2result = mysqli_query($con, $querytocheckifcitypresentinarea2);
            if(mysqli_num_rows($querytocheckifcitypresentinarea2result)>0){
                $row_row2 = mysqli_fetch_assoc($querytocheckifcitypresentinarea2result);
                $old_area2_name = json_decode($row_row2['area_name'], true); 
                // $new_area2_name = $old_area2_name + $list_of_cities_area;
                foreach ($list_of_cities_area as $i => $city_area) {
                    array_push($old_area2_name,$city_area);
                }
                $new_fuck = json_encode($old_area2_name);
                $updatearea2 = "UPDATE area2 SET area_name = '$new_fuck' WHERE area_city_name = '{$_POST['_city_name_']}'";
                $updatearea2result = mysqli_query($con, $updatearea2);     
                if(!$updatearea2result){
                    die(mysqli_error($con));
                }      
            }else{
            // =========================================
            $fuck = json_encode($list_of_cities_area);
            $city_area_query2 = "INSERT INTO area2(`area_name`, `area_city_name`) VALUE ('$fuck', '{$_POST['_city_name_']}')";
            $result2 = mysqli_query($con, $city_area_query2);
            if(!$result2){
                die(mysqli_error($con));
            }}
            // =========================================
            foreach ($list_of_cities_area as $i => $city_area) {
                $check_if_city_area_exist = "SELECT * FROM area WHERE area_name = '$city_area' AND  area_city_name = '{$_POST['_city_name_']}' ";
                $check_if_city_area_exist_result = mysqli_query($con, $check_if_city_area_exist);
                if (mysqli_num_rows($check_if_city_area_exist_result) > 0) {
                    $report .= '<tr><td style="padding:.1% 1%;border:1px solid grey;color:tomato;background:white"><p>' . $city_area . ' In This '.$_POST['_city_name_'].' Already Exist</p></td></tr>';
                }else{

                    $geting_city_id = "SELECT `city_id` FROM city WHERE city_name = '{$_POST['_city_name_']}'";
                    $city_id_ = mysqli_query($con, $geting_city_id);
                    $row_ = mysqli_fetch_assoc($city_id_);

                    $city_area_query = "INSERT INTO area(`area_name`, `area_city_name`, `city_area_id`) VALUE ('$city_area', '{$_POST['_city_name_']}', {$row_['city_id']})";
                    $result = mysqli_query($con, $city_area_query);
                    if ($result) {
                        $CITY_NAME = '<div class="city-list new-city-added" value="'.strtolower($_POST['_city_name_']).'" ><p style="text-transform: capitalize;">'.$_POST['_city_name_'].'</p></div>';
                        $AREA_NAME .= '<div class="city-list" value="'.strtolower($city_area).'" ><span class="city-list-delete" onclick="Deletethecity(\'city_area\','.mysqli_insert_id($con).')">x</span><p style="text-transform: capitalize;">'.$city_area.'</p></div>';
                        $output = '<div class="list_of_all_area_with_city">
                        <div class="city_dedicated_to_areas">'.$CITY_NAME.'</div>
                        <div class="areas_dedicated_to_city list-of-all-cities">'.$AREA_NAME.'</div>
                    </div>';

                        $report .= '<tr><td style="padding:.1% 1%;border:1px solid grey;color:green;background:white"><p>' . $city_area . ' Added To '.$_POST['_city_name_'].' City .</p></td></tr>';
                    } else {
                        $report .= '<tr><td style="padding:.1% 1%;border:1px solid grey;color:tomato;background:white"><p>While Insserting This ' . $city_area . ' Something Went Wrong</p></td></tr>';
                    }
                }
            }
            echo json_encode(['output' => $output, 'report' => $report, 'id' => $_POST['pass']]);
            mysqli_close($con);
        }
    }
}


?>
<?php


?>