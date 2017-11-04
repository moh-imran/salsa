<?php

namespace App\Http\Controllers\User;

use App\ColorCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Community;
use App\School;
use App\SchoolSalsaValue;
use App\CommunitySalsaValue;
use App\Setting;

class SkolvalController extends Controller
{
    public function index()
    {
        if(is_paid_user()){
            return redirect('map');
        }
        return view('user.home');
    }
    
    public function callSkolval(){
        //print_r($communityName);
        //return redirect('skolval', $communityName);
        //return redirect()->route('skolval', $communityName);
        return view('user.skolval');
    }

    public function selectCommunity($search){
        $search = str_replace('**s**', '/', $search);
        return School::select('community_code', 'community_title')
            ->where('community_title', 'like', '%'.$search.'%')
            ->groupBy('community_title')
            ->groupBy('community_code')->get();
    }

    public function currentLocationCommunity($lat, $lng){
        $community = School::getNearBySchool($lat, $lng);
        return $this->getCommunitySchools($community->community_title, $community->community_code);
    }

    public function getCommunitySchools($community_title, $community_code=null){
        $community_title = str_replace('**s**', '/', $community_title);
        if($community_code == null){
            $community = Community::where('title', $community_title)->first();
            if(!empty($community)){
                $community_code = $community->code;
            }else{
                $response = ['success' => '', 'data' => '', 'message' => 'No community found'];
                return $response;
            }
        }
        $slider_min_value = CommunitySalsaValue::select('min_amp_residual_value', 'max_amp_residual_value', 'min_school_code', 'max_school_code')
            ->whereNotNull('min_amp_residual_value')->orderBy('min_amp_residual_value')->first();
        $slider_max_value = CommunitySalsaValue::select('max_amp_residual_value')
            ->whereNotNull('max_amp_residual_value')->orderBy('max_amp_residual_value', 'desc')->first();

        $all_school_of_community = School::select('schools.id', 'schools.code', 'schools.title', 'schools.community_title',
            'amp_residual_value_f-b as amp_residual_value_f_b', 'amp_model_calc_value_b', 'amp_actual_value_f','lat','long','school_triangles.triangle_count')
            ->where('schools.community_code', 'like', '%'.$community_code.'%')
            ->join('school_salsa_values', 'schools.code', '=', 'school_salsa_values.school_code')
            ->leftJoin('school_triangles', 'school_salsa_values.school_code', '=', 'school_triangles.school_code')
            ->orderBy('amp_residual_value_f-b')->get();

//        check if count less then 3 then add nearest community in search
        if($all_school_of_community->count() < 3){
            $all_school_of_community = $this->nearestCommunitySchools($community_code);
        }

        $difference = $slider_max_value['max_amp_residual_value'] - $slider_min_value['min_amp_residual_value'];
        $add_for_plus = 0;
        if($slider_min_value['min_amp_residual_value'] < 0){
            $add_for_plus = abs($slider_min_value['min_amp_residual_value']);
        }else{
            $add_for_plus = $slider_min_value['min_amp_residual_value'] * -1;
        }
        $colorCodes = ColorCode::where('key', 'Residual (R=F-B)')->first();
        $schoolWarning = Setting::where('key','school_warning')->first();

        foreach ($all_school_of_community as $key => $school) {
            if($key == 0){
                $amp_residual_value_f_b_class = $this->colorCodes($school['amp_residual_value_f_b'], $colorCodes);
                $all_school_of_community[$key]['amp_residual_value_f_b_class'] = $amp_residual_value_f_b_class;
            }elseif($key == $all_school_of_community->count() - 1){
                $amp_residual_value_f_b_class = $this->colorCodes($school['amp_residual_value_f_b'], $colorCodes);
                $all_school_of_community[$key]['amp_residual_value_f_b_class'] = $amp_residual_value_f_b_class;
            }else{
                $all_school_of_community[$key]['amp_residual_value_f_b_class'] = 'circle_inactive gray';
            }
            $amp_residual_value_f_b = $school->amp_residual_value_f_b + $add_for_plus;
            $left = $amp_residual_value_f_b / $difference * 96;
            $all_school_of_community[$key]['style'] = 'left:'.$left.'%';

        }
        
        
        $all_school_of_community[0]['amp_residual_value_f_b'] = number_format((float)$all_school_of_community[0]['amp_residual_value_f_b'], 1, '.', '');
        $all_school_of_community[0]['amp_actual_value_f'] = (int)($all_school_of_community[0]['amp_actual_value_f']) ;
        $all_school_of_community[0]['amp_model_calc_value_b'] = (int)($all_school_of_community[0]['amp_model_calc_value_b']);
        
        
        $all_school_of_community[((count($all_school_of_community->toArray()))-1)]['amp_residual_value_f_b'] = number_format((float)$all_school_of_community[((count($all_school_of_community->toArray()))-1)]['amp_residual_value_f_b'], 1, '.', '');
        $all_school_of_community[((count($all_school_of_community->toArray()))-1)]['amp_actual_value_f'] = (int)($all_school_of_community[((count($all_school_of_community->toArray()))-1)]['amp_actual_value_f']);
        $all_school_of_community[((count($all_school_of_community->toArray()))-1)]['amp_model_calc_value_b'] = (int)($all_school_of_community[((count($all_school_of_community->toArray()))-1)]['amp_model_calc_value_b']);

        $data['all_school_of_community'] = $all_school_of_community;
        $data['colorCodes'] = $colorCodes;
        $data['community'] = $community_title;
        $data['schoolWarningThreshold'] = $schoolWarning->value;
        $response = ['success' => 1, 'message' => 'success', 'data' => $data];
        return $response;

    }

    private function nearestCommunitySchools($community_code, $offset = 1){
        $community = Community::select('lat', 'long')->where('code', $community_code)->whereNotNull('lat')->first();
        $count = 0;
        $nearest_community = array();
        $all_school_of_community = '';
        while ($count < 3) {
            $nearest_community[] = Community::getNearByCommunity($community->lat, $community->long, $offset);

            $all_school_of_community = School::select('schools.id', 'schools.code', 'schools.title', 'schools.community_title',
                'amp_residual_value_f-b as amp_residual_value_f_b', 'amp_model_calc_value_b', 'amp_actual_value_f','school_triangles.triangle_count')
                ->where('schools.community_code', 'like', '%' . $community_code . '%');

                foreach ($nearest_community as $key => $n_community) {
                    $all_school_of_community->orWhere('schools.community_code', 'like', '%' . $n_community['code'] . '%');
                }
            $all_school_of_community->join('school_salsa_values', 'schools.code', '=', 'school_salsa_values.school_code')
                ->leftJoin('school_triangles', 'school_salsa_values.school_code', '=', 'school_triangles.school_code')
                ->orderBy('amp_residual_value_f-b');
            $all_school_of_community = $all_school_of_community->get();
            $offset++;
            $count = $all_school_of_community->count();
        }
        return $all_school_of_community;
    }
    private function colorCodes($value, $conditions){
        $color = '';
        if($conditions['status'] == 0) {
            $color = CLASS_NO_COLOR;
        }elseif ($conditions['is_reverse'] == 0) {
            if ($value >= $conditions['much_higher_when_greater_than']) {
                $color = CLASS_COLOR_MUCH_HIGHER;
            } elseif ($value >= $conditions['above_when_greater_than']) {
                $color = CLASS_COLOR_ABOVE;
            } elseif ($value <= $conditions['much_below_when_less_than']) {
                $color = CLASS_COLOR_MUCH_BELOW;
            } elseif ($value <= $conditions['below_when_less_than']) {
                $color = CLASS_COLOR_BELOW;
            } else {
                $color = CLASS_COLOR_AVERAGE;
            }
        }else{
            if ($value >= $conditions['much_higher_when_greater_than']) {
                $color = CLASS_COLOR_MUCH_BELOW;
            } elseif ($value >= $conditions['above_when_greater_than']) {
                $color = CLASS_COLOR_BELOW;
            } elseif ($value <= $conditions['much_below_when_less_than']) {
                $color = CLASS_COLOR_MUCH_HIGHER;
            } elseif ($value <= $conditions['below_when_less_than']) {
                $color = CLASS_COLOR_ABOVE;
            } else {
                $color = CLASS_COLOR_AVERAGE;
            }
        }
        return $color;
    }
}
