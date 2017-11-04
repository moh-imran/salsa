<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Community;
use App\School;
use App\ColorCode;
use App\Setting;


class MapController extends Controller
{
    //
    public function getCommunitySchools($community_title, $community_code=null){

        
        $community_title = str_replace('**s**', '/', $community_title);
        $community = Community::where('title', $community_title)->first(['code','lat','long']);
        if(!empty($community)){
            $community_code = $community->code;
        }else{
            $response = ['success' => '', 'data' => '', 'message' => 'No community found'];
            return $response;
        }

        $setting = Setting::where('key', 'selected_community')->first();

        if($setting->status == 1){
            $all_school_of_community = School::select('schools.id', 'schools.code', 'schools.title', 'schools.street_address', 'schools.community_title',
            'amp_residual_value_f-b as amp_residual_value_f_b','lat','long')
                ->where('schools.community_code', 'like', '%'.$community_code.'%')
                ->join('school_salsa_values', 'schools.code', '=', 'school_salsa_values.school_code')
                ->orderBy('amp_residual_value_f-b')->get();
                $color_codes_array = $this->getPinColor($all_school_of_community);
                $response_data_arr = ['schools_array'=>$all_school_of_community, 'schools_color_codes'=>$color_codes_array, 'com_lat'=>$community->lat, 'com_long'=>$community->long];
                $response = ['status' => 'success', 'data' => $response_data_arr, 'message' => 'all schools of a community'];
                
                return $response;
        }
        else{
                    $schools = config('mappins.schools_array');        
        $colors = config('mappins.schools_color_codes');
//        print_r($colors);exit;
        $response_data_arr = [
            'schools_array'=>$schools,
            'schools_color_codes'=>$colors,
            'com_lat'=>$community->lat,
            'com_long'=>$community->long
        ];
        $response = ['status' => 'success', 'data' => $response_data_arr, 'message' => 'all schools of a community'];
            return $response;
       }

            
        
    }
    
    public function getPinColor($schools){
        
        $all_school_of_community = $schools->toArray();

        //$colorCodes = ColorCode::where('key','LIKE', '%Salsa scale%')->first()->toArray();
        $colorCodes = ColorCode::first()->toArray();
        
        $pins_solors_array = array();
        $count = 0;
        foreach($all_school_of_community as $school){
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

        //print_r($pins_solors_array);   
         return  $pins_solors_array;  
        
    }
    
    public function currentLocationCommunity($lat, $lng){
        $community = School::getNearBySchool($lat, $lng);
        $data['com_title'] = $community->community_title;
        $data['com_code'] = $community->community_code;
        $response = ['success' => '', 'data' => $data, 'message' => 'community found'];
        return $response;
    }

        public function schoolsData(Request $request){
        echo '<pre>';
        print_r($request->all());
        
    }
    
    public function singleSchoolsData($single_school_code){
        echo '<pre>';
        print_r($single_school_code);
        
    }
}
