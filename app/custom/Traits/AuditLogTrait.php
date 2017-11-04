<?php

namespace App\custom\Traits;
use Auth;
use App\AuditLog;
trait AuditLogTrait
{
    public static function bootAuditLogTrait()
    {
        static::updating(function($model)
        {
            $model->updated_by = (Auth::user())? Auth::user()->id: '1';
            $table_name = $model->getTable();
            $record_id = '';
            $com_row = array();
            if($table_name == 'communities'){
                $record_id = $model->code;
                $com_row['code'] = $model->code;
                $com_row['title'] = $model->title;
            }elseif ($table_name == 'schools'){
                $record_id = $model->code;
                $com_row['is_public'] = $model->is_public;
                $com_row['community_code'] = $model->community_code;
                $com_row['community_title'] = $model->community_title;
                $com_row['code'] = $model->code;
                $com_row['title'] = $model->title;
                $com_row['street_address'] = $model->street_address;
                $com_row['post_number'] = $model->post_number;
            }elseif ($table_name == 'school_salsa_values'){
                $record_id = $model->school_code;
                $com_row['school_code'] = $model->school_code;
                $com_row['community_title'] = $model->school->community_title;
                $com_row['community_code'] = $model->school->community_code;
                $com_row['school_title'] = $model->school->title;
                $com_row['bg_parents_avg_level_of_education'] = $model->bg_parents_avg_level_of_education;
                $com_row['bg_share_of_newly_immigrated'] = $model->bg_share_of_newly_immigrated;
                $com_row['bg_share_of_born_abroad'] = $model->bg_share_of_foreign_background;
                $com_row['bg_share_of_boys'] = $model->bg_share_of_boys;
                $com_row['ga_actual_value_f'] = $model->ga_actual_value_f;
                $com_row['ga_model_calc_value_b'] = $model->ga_model_calc_value_b;
                $com_row['ga_residual_value_f-b'] = $model['ga_residual_value_f-b'];
                $com_row['amp_actual_value_f'] = $model->amp_actual_value_f;
                $com_row['amp_model_calc_value_b'] = $model->amp_model_calc_value_b;
                $com_row['amp_residual_value_f-b'] = $model['amp_residual_value_f-b'];
            }elseif ($table_name == 'grade9_datas'){
                $record_id = $model->school_code . '-'. $model->subject->title;
                $com_row['subject'] = $model->subject->title;
                $com_row['school_code'] = $model->school_code;
                $com_row['students_enrolled'] = $model->students_enrolled;
                $com_row['merit_points'] = $model->merit_points;
                $com_row['share_ae'] = $model->share_ae;
            }elseif ($table_name == 'national_results_datas'){
                $record_id = $model->school_code . '-'. $model->subject->title;
                $com_row['subject'] = $model->subject->title;
                $com_row['school_code'] = $model->school_code;
                $com_row['students_participated'] = $model->students_participated;
                $com_row['merit_points'] = $model->merit_points;
                $com_row['share_ae'] = $model->share_ae;
            }elseif ($table_name == 'school_pupil_teacher_stats'){
                $record_id = $model->school_code;
                $com_row['community_code'] = $model->school->community_code;
                $com_row['community_title'] = $model->school->community_title;
                $com_row['school_code'] = $model->school_code;
                $com_row['school_title'] = $model->school->school_title;
                $com_row['students_grade1'] = $model->students_grade1;
                $com_row['students_grade2'] = $model->students_grade2;
                $com_row['students_grade3'] = $model->students_grade3;
                $com_row['students_grade4'] = $model->students_grade4;
                $com_row['students_grade5'] = $model->students_grade5;
                $com_row['students_grade6'] = $model->students_grade6;
                $com_row['students_grade7'] = $model->students_grade7;
                $com_row['students_grade8'] = $model->students_grade8;
                $com_row['students_grade9'] = $model->students_grade9;
                $com_row['teachers_count'] = $model->teachers_count;
                $com_row['students_per_teacher'] = $model->students_per_teacher;
                $com_row['percent_teacher_pedagogical_degree'] = $model->percent_teacher_pedagogical_degree;
            }elseif ($table_name == 'qualify_upper_sec_datas'){
                $record_id = $model->school_code;
                $com_row['school_code'] = $model->school_code;
                $com_row['share_qualify_vocational_program'] = $model->share_qualify_vocational_program;
                $com_row['share_qualify_arts_aestetichs_program'] = $model->share_qualify_arts_aestetichs_program;
                $com_row['share_qualify_econ_philos_socialsc_program'] = $model->share_qualify_econ_philos_socialsc_program;
                $com_row['share_qualify_natural_science_tech_program'] = $model->share_qualify_natural_science_tech_program;
                $com_row['share_not_qualified'] = $model->share_not_qualified;

            }
            $audit_log = array();
            foreach ($com_row as $key => $row){
                if($row != 'null' && $row != ''){
                    $audit_log[$key] = $row;
                }
            }
            $new_current_version = serialize($audit_log);
////            check if update record is change
//            $AuditLog = AuditLog::where('table_name', $table_name)
//                ->where('record_id', $record_id)
//                ->where('current_version', $new_current_version)
//                ->orderBy('id', 'desc')
//                ->take(1)->first();

//            last audit log value
            $lastAuditLog = AuditLog::where('table_name', $table_name)
                ->where('record_id', $record_id)
                ->orderBy('id', 'desc')
                ->take(1)->first();

            $sync_version = (isset($lastAuditLog->sync_version)) ? $lastAuditLog->sync_version : $new_current_version;
            $last_version = (isset($lastAuditLog->current_version)) ? $lastAuditLog->current_version : $new_current_version;

            AuditLog::create([
                'record_id' => $record_id,
                'table_name' => $table_name,
                'sync_version' => $sync_version,
                'last_version' => $last_version,
                'current_version' => $new_current_version
            ]);

        });
    }
}