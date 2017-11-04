<?php
use Illuminate\Support\Facades\DB;
/**
 * Created by PhpStorm.
 * User: shahid
 * Date: 12/7/2016
 * Time: 1:51 PM
 */

/**
 * @param $value
 * @return float
 * The FILTER_SANITIZE_NUMBER_FLOAT filter removes all illegal characters from a float number.
 * This filter allows digits and + - by default
 */
function getFloatValue($value)
{
    $float = (float) filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
    return number_format($float, 2, '.', '');
}

function places($location){
    $loc = urlencode($location);
    $api_key = "&key=AIzaSyA8QdA8lqqibLD2Ms1hQ_epDPqe2xzgK70";
//    $api_key = "&key=AIzaSyDxuV6BQxxlvY7BdsqYb_hsE45n_z-CZdI"; // my key for test 
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=". $loc ."&components=country:SE".$api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_REFERER, 'http://www.Skolguiden.nu/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $json_api_address = curl_exec($ch);
    curl_close($ch);
    DB::table('location_logs')->insert(['url'=>$url, 'location'=>$json_api_address]);
    $place = json_decode($json_api_address, TRUE);
    $address = array('city'=>'','state'=>'','zip'=>'','country'=>'','county'=>'','community'=>'',
                    'street_number'=>'','route'=>'','lat'=>'','lng'=>'', 'url');
    if($place['status'] == "OK") {
        $address_components = $place['results'][0]['address_components'];
        $lat = $place['results'][0]['geometry']['location']['lat'];
        $lng = $place['results'][0]['geometry']['location']['lng'];
        $address['lat'] = $lat;
        $address['lng'] = $lng;
        foreach($address_components as $key => $component) {
            $type = $component['types'][0];
            switch($type) {
                case 'neighborhood':
                    //if city does not already set by locality
                    if(empty($address['city'])) {
                        $address['city'] = $component['short_name'];
                    }
                    $address['community'] = $component['short_name'];
                    break;
                case 'street_number':
                    //if city does not already set by locality
                    if(empty($address['city'])) {
                        $address['city'] = $component['short_name'];
                    }
                    $address['street_number'] = $component['short_name'];
                    break;
                case 'route':
                    //if city does not already set by locality
                    if(empty($address['city'])) {
                        $address['city'] = $component['short_name'];
                    }
                    $address['route'] = $component['short_name'];
                    break;
                case 'locality':
                    $address['city'] = $component['short_name'];
                    break;
                case 'administrative_area_level_2':
                    $address['county'] = $component['short_name'];
                    //if this is county then set city name as county as well
                    if(empty($address['city'])) {
                        $address['city'] = $component['short_name'];
                    }
                    break;
                case 'administrative_area_level_1':
                    $address['state'] = $component['short_name'];
                    break;
                case 'country':
                    $address['country'] = $component['short_name'];
                    break;
                case 'postal_code':
                    $address['zip'] = $component['short_name'];
                    break;
                default:
                    //if city does not already set by neighborhood
                    if(empty($address['city'])) {
                        $address['city'] = $component['short_name'];
                    }
                    break;
            }
        }
    }
    $address['url'] = $url;
    return $address;
}
function array_avg($values)
{
    //ignore empty/null values
    $values = array_filter($values, 'strlen' );
    if(count($values) > 0)
    {
        return array_sum($values) / count($values);
    }
    return NULL;
}

function is_paid_user()
{
    if(Auth::check()) {
        $user_roles = Auth::user()->roles()->get();
        $super_admin = $user_roles->where('title', 'super admin');
        $admin = $user_roles->where('title', 'admin');
        if (!$admin->isEmpty() || !$super_admin->isEmpty()) {
            return true;
        }
//  check client subscription
        $subscription = Auth::user()->user_subscription()->get();
        if ($subscription->isEmpty()) {
            return false;
        }
        date_default_timezone_set("Europe/Stockholm");
        $date = date('Y-m-d H:i:s');
        $subscription_end = $subscription[0]->subscription_ends_at;
        if (strtotime($subscription_end) <= strtotime($date)) {
            return false;
        }
        return true;
    }
    return false;
}