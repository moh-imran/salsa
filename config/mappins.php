<?php
$con = mysqli_connect(env('DB_HOST', '127.0.0.1'),
    env('DB_USERNAME', 'root'),env('DB_PASSWORD', ''),
    env('DB_DATABASE', 'salsa'));
$con->set_charset("utf8");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "select schools.id, schools.code, schools.title, schools.street_address, schools.community_title,
            `amp_residual_value_f-b` as `amp_residual_value_f_b`, `lat`, `long` from schools
            JOIN school_salsa_values ON schools.code=school_salsa_values.school_code
            where schools.status = 1";
$result = $con->query($sql);
$all_school_of_community = array();
while ($school = $result->fetch_assoc()) {
    $all_school_of_community[] = $school;
}

    $sql = "select * from color_codes where `key` LIKE '%Residual (R=F-B)%'";
    $color = $con->query($sql);
    $colorCodes = $color->fetch_assoc();

    $pins_solors_array = array();
    $count = 0;
    foreach($all_school_of_community as $school){
//        if($school['id'] == 705){
//        
//        echo '<pre>';    
//        print_r($colorCodes);
//        print_r($school);
//        exit;
//        }
        if($colorCodes['status'] == 0) {
            $pins_solors_array[$count] = 'assets/images/marker_gray.svg';
        }elseif($colorCodes['is_reverse'] == 0) {
            $resdule_value_of_school = $school['amp_residual_value_f_b'];

            if ($resdule_value_of_school >= $colorCodes['much_higher_when_greater_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_blue.svg';
            } else if ($resdule_value_of_school >= $colorCodes['above_when_greater_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_green.svg';
            } else if ($resdule_value_of_school <= $colorCodes['much_below_when_less_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_red.svg';
            } else if ($resdule_value_of_school <= $colorCodes['below_when_less_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_orange.svg';
            } else {
                $pins_solors_array[$count] = 'assets/images/marker_yellow.svg';
            }
        } else {
            $resdule_value_of_school = $school['amp_residual_value_f_b'];

            if ($resdule_value_of_school >= $colorCodes['much_higher_when_greater_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_red.svg';
            } else if ($resdule_value_of_school >= $colorCodes['above_when_greater_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_orange.svg';
            } else if ($resdule_value_of_school <= $colorCodes['much_below_when_less_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_blue.svg';
            } else if ($resdule_value_of_school <= $colorCodes['below_when_less_than']) {
                $pins_solors_array[$count] = 'assets/images/marker_green.svg';
            } else {
                $pins_solors_array[$count] = 'assets/images/marker_yellow.svg';
            }
        }

        $count++;
    }
    return array(
        'schools_array' => $all_school_of_community,
        'schools_color_codes' => $pins_solors_array
    );