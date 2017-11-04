<?php

namespace App\Http\Controllers\User;

use App\Grade9Data;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
use App\ColorCode;
use App\Setting;
use App\SchoolSalsaValue;
use App\CommunitySalsaValue;
use Illuminate\Support\Facades\Session;
class SchoolComparisonController extends Controller
{
    public function comparison(Request $request){
        $school_code = $request->get('school_codes');
        $school_codes = explode(',', $school_code);
        
        $request->session()->put('school_codes', $school_codes);
        
        $schools =  School::whereIn('schools.code', $school_codes)
                    ->with('schoolSalsaValue', 'qualifyUpperSecData', 'schoolTriangle')->get();
        $colorCodes = ColorCode::get();
        foreach ($schools as $key => $school){
            if($school->schoolSalsaValue != null) {
                $aColorCodes = $colorCodes->where('key', 'Residual (R=F-B)')->where('is_free' , 1)->first();
                $color = $this->colorCodes($school->schoolSalsaValue['amp_residual_value_f-b'], $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_amp_residual_value_f-b'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Faktiskt värde (F)')->where('is_free' , 1)->first();
                $color = $this->colorCodes($school->schoolSalsaValue->amp_actual_value_f, $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_amp_actual_value_f'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Modell-beräknat värde (B)')->where('is_free' , 1)->first();
                $color = $this->colorCodes($school->schoolSalsaValue->amp_model_calc_value_b, $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_amp_model_calc_value_b'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Föräldrarnas genomsnittliga utb.nivå')->first();
                $color = $this->colorCodes($school->schoolSalsaValue->bg_parents_avg_level_of_education, $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_bg_parents_avg_level_of_education'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Andel (%) nyinvandrade')->first();
//                
                $color = $this->colorCodes($school->schoolSalsaValue->bg_share_of_newly_immigrated, $aColorCodes);                
                $schools[$key]['schoolSalsaValue']['color_bg_share_of_newly_immigrated'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Andel (%) pojkar')->first();
                $color = $this->colorCodes($school->schoolSalsaValue->bg_share_of_boys, $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_bg_share_of_boys'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Modellberäknat värde (B)')->where('is_free' , 0)->where('label', 'Andel (%) som uppn. kunskapskraven')->first();
                
//                echo '<pre>';
//                print_r($aColorCodes);
//                exit;
                $school->schoolSalsaValue->ga_model_calc_value_b = number_format((float)$school->schoolSalsaValue->ga_model_calc_value_b, 1, '.', ''); 
                
                $color = $this->colorCodes($school->schoolSalsaValue->ga_model_calc_value_b, $aColorCodes);                
                $schools[$key]['schoolSalsaValue']['color_ga_model_calc_value_b'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Faktiskt värde (F)')->where('is_free' , 1)->where('label', 'Andel (%) som uppn. kunskapskraven')->first();
                
                $school->schoolSalsaValue->ga_actual_value_f = number_format((float)$school->schoolSalsaValue->ga_actual_value_f, 1, '.', ''); 

                $color = $this->colorCodes($school->schoolSalsaValue->ga_actual_value_f, $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_ga_actual_value_f'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Residual (R=F-B)')->where('is_free' , 1)->where('label', 'Andel (%) som uppn. kunskapskraven')->first();
                                
                $color = $this->colorCodes($school->schoolSalsaValue['ga_residual_value_f-b'], $aColorCodes);
                $schools[$key]['schoolSalsaValue']['color_ga_residual_value_f-b'] = $color;
            }
            if($school->qualifyUpperSecData != null) {
                $aColorCodes = $colorCodes->where('key', 'Naturvetenskapligt och tekniskt program')->first();
                $color = $this->colorCodes($school->qualifyUpperSecData->share_qualify_natural_science_tech_program, $aColorCodes);
                $schools[$key]['qualifyUpperSecData']['color_share_qualify_natural_science_tech_program'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Ekonomi-, humanistiska och samhällsvetenskapsprogram')->first();
                $color = $this->colorCodes($school->qualifyUpperSecData->share_qualify_econ_philos_socialsc_program, $aColorCodes);
                $schools[$key]['qualifyUpperSecData']['color_share_qualify_econ_philos_socialsc_program'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Estetiskt program')->first();
                $color = $this->colorCodes($school->qualifyUpperSecData->share_qualify_arts_aestetichs_program, $aColorCodes);
                $schools[$key]['qualifyUpperSecData']['color_share_qualify_arts_aestetichs_program'] = $color;

                $aColorCodes = $colorCodes->where('key', 'Yrkesprogram')->first();
                $color = $this->colorCodes($school->qualifyUpperSecData->share_qualify_vocational_program, $aColorCodes);
                $schools[$key]['qualifyUpperSecData']['color_share_qualify_vocational_program'] = $color;
            }
//           amp_actual_value_f 
           $schools[$key]->schoolSalsaValue['amp_residual_value_f-b'] = number_format((float)$schools[$key]->schoolSalsaValue['amp_residual_value_f-b'], 1, '.', ''); 
           $schools[$key]->schoolSalsaValue['amp_actual_value_f'] = (int) $schools[$key]->schoolSalsaValue['amp_actual_value_f'];
           $schools[$key]->schoolSalsaValue['amp_model_calc_value_b'] = (int) $schools[$key]->schoolSalsaValue['amp_model_calc_value_b'];
           /// for komponentor
           $schools[$key]->schoolSalsaValue['bg_parents_avg_level_of_education'] = number_format((float)$schools[$key]->schoolSalsaValue['bg_parents_avg_level_of_education'], 1, '.', ''); 
           $schools[$key]->schoolSalsaValue['bg_share_of_newly_immigrated'] = number_format((float)$schools[$key]->schoolSalsaValue['bg_share_of_newly_immigrated'], 1, '.', ''); 
           $schools[$key]->schoolSalsaValue['bg_share_of_boys'] = number_format((float)$schools[$key]->schoolSalsaValue['bg_share_of_boys'], 1, '.', ''); 
        }
        $schoolWarning = Setting::where('key','school_warning')->first();
        $warning_at = $schoolWarning->value;
        
        
//        echo '<pre>';
//print_r($schools[0]->schoolSalsaValue['amp_residual_value_f-b']); exit;
      
return view('user.premium.school_comparison', compact('school_code', 'schools', 'warning_at'));
    }

    public function detailComparison(Request $request){
        $school_codes = $request->get('school_codes');
        $school_codes = explode(',', $school_codes);
        
        $community_title = School::where('code', $school_codes[0])->first(['community_title'])->toArray();
         $community_title = $community_title['community_title'];
        $schools =  School::whereIn('schools.code', $school_codes)
            ->with(['grade9Data'=> function($query){
            $query->with('subject_triangle');
        }])->with('nationalResultsData', 'schoolTriangle', 'schoolPupilTeacherStat')->get();
        $colorCodes = ColorCode::get();
        foreach ($schools as $key => $school){
            foreach ($school->grade9Data as $k => $grade9_data){
                $gColorCodes = $colorCodes->where('subject_id', $grade9_data->subject_id);
                $i = 1;
                foreach ($gColorCodes as $colorCode){
                    if($i == 2 && $grade9_data->share_ae != null){
                        $color = $this->colorCodes($grade9_data->share_ae, $colorCode);
//                        print_r(json_encode($grade9_data));
//                        print_r('\n');
//                        print_r(json_encode($colorCode));
                        $schools[$key]['grade9Data'][$k]['color_share_ae'] = $color;
                    }elseif ($i == 1 && $grade9_data->merit_points != null){
                        $color = $this->colorCodes($grade9_data->merit_points, $colorCode);
                        $schools[$key]['grade9Data'][$k]['color_merit_points'] = $color;
                    }
                    $i++;
                }
            }
            foreach ($school->nationalResultsData as $k => $national_results_data){
                $nColorCodes = $colorCodes->where('subject_id', $national_results_data->subject_id);
                $i = 1;
                foreach ($nColorCodes as $colorCode){
                    if($i == 4 && $national_results_data->share_participated != null){
                        $color = $this->colorCodes($national_results_data->share_participated, $colorCode);
                        $schools[$key]['nationalResultsData'][$k]['color_share_participated'] = $color;
                    }elseif ($i == 3 && $national_results_data->merit_points != null){
                        $color = $this->colorCodes($national_results_data->merit_points, $colorCode);
                        $schools[$key]['nationalResultsData'][$k]['color_merit_points'] = $color;
                    }
                    $i++;
                }
            }
            if($school->schoolPupilTeacherStat != null) {
                $sColorCodes = $colorCodes->where('key', 'Elever per lärare')->first();
                $color = $this->colorCodes($school->schoolPupilTeacherStat->students_per_teacher, $sColorCodes);
                $schools[$key]['schoolPupilTeacherStat']['color_students_per_teacher'] = $color;


                $tColorCodes = $colorCodes->where('key', 'Andel med pedagogisk högskoleexamen')->first();
                $color = $this->colorCodes($school->schoolPupilTeacherStat->percent_teacher_pedagogical_degree, $tColorCodes);
                $schools[$key]['schoolPupilTeacherStat']['color_percent_teacher_pedagogical_degree'] = $color;
            }
        }
        $schoolWarning = Setting::where('key','school_warning')->first();
        $warning_at = $schoolWarning->value;
//        return $schools;
        $subjects = Subject::orderBy('title')->get();
        return view('user.premium.detail_comparison', compact('schools', 'subjects', 'warning_at', 'community_title'));
    }

    private function colorCodes($value, $conditions){
        
        $color = '';
        if($conditions['status'] == 0 || $value == null || empty($value)) {
            $color = CLASS_NO_COLOR;
        }elseif ($conditions['is_reverse'] === 0) {
            if ($value >= $conditions['much_higher_when_greater_than']) {
                
//               if ($conditions['id'] == 10) {
//                    print_r($value);
//                    echo CLASS_COLOR_MUCH_HIGHER;
//                    exit;
//                }                
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
    
    
    ///// bar for premium section /////
    public function premium_bar(Request $request){
        
        $saved_school_codes = $request->session()->get('school_codes');
        //print_r($data);
        
        $slider_min_value = CommunitySalsaValue::select('min_amp_residual_value', 'max_amp_residual_value', 'min_school_code', 'max_school_code')->whereNotNull('min_amp_residual_value')->orderBy('min_amp_residual_value')->first();
        $slider_max_value = CommunitySalsaValue::select('max_amp_residual_value')->whereNotNull('max_amp_residual_value')->orderBy('max_amp_residual_value', 'desc')->first();
        
        $all_school_of_community = School::select('schools.id', 'schools.code', 'schools.title', 'schools.community_title',
            'amp_residual_value_f-b as amp_residual_value_f_b', 'amp_model_calc_value_b', 'amp_actual_value_f','lat','long','school_triangles.triangle_count')
            ->whereIN('schools.code', $saved_school_codes)
            ->join('school_salsa_values', 'schools.code', '=', 'school_salsa_values.school_code')
            ->leftJoin('school_triangles', 'school_salsa_values.school_code', '=', 'school_triangles.school_code')
            ->orderBy('amp_residual_value_f-b')->get();
        
        $difference = $slider_max_value['max_amp_residual_value'] - $slider_min_value['min_amp_residual_value'];
        $add_for_plus = 0;
        if($slider_min_value['min_amp_residual_value'] < 0){
            $add_for_plus = abs($slider_min_value['min_amp_residual_value']);
        }else{
            $add_for_plus = $slider_min_value['min_amp_residual_value'] * -1;
        }
        $colorCodes = ColorCode::where('key', 'Residual (R=F-B)')->first();
        
        
       foreach ($all_school_of_community as $key => $school) {
            
            $amp_residual_value_f_b_class = $this->colorCodes($school['amp_residual_value_f_b'], $colorCodes);
            $all_school_of_community[$key]['amp_residual_value_f_b_class'] = $amp_residual_value_f_b_class;
            
            $amp_residual_value_f_b = $school->amp_residual_value_f_b + $add_for_plus;
            $left = $amp_residual_value_f_b / $difference * 96;
            $all_school_of_community[$key]['style'] = 'left:'.$left.'%';

        }
        
        $data['all_school_of_community'] = $all_school_of_community;
        $data['colorCodes'] = $colorCodes;       
        //$data['schoolWarningThreshold'] = $schoolWarning->value;
        $response = ['success' => 1, 'message' => 'success', 'data' => $data];
        return $response;
        
    }
}
