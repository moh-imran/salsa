<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use App\User;
use App\Subscriptions;
use Carbon\Carbon;
use Log;
use Auth;
use Mail;

class SubscriptionController extends Controller {

    //
    public function create_subscription(Request $request) {

        $input = $request->all();        
        $id = Auth::id();                      
        $user = User::where('id' , $id)->first();
        
        $credit_card_token = $_POST['stripeToken'];
        //$credit_card_token = $_POST['_token'];
        
        try {
                        
            Log::info('User is trying to create subscription with user_id ', ['user_id' => $user->id]);
            
            if(!$user->subscribed(env('SUBSCRIPTION_NAME'))){            	
           // if (1) {
                $subscription_response = $user->newSubscription(env('SUBSCRIPTION_NAME'), env('SUBSCRIPTION_ID'))->create($credit_card_token, ['email' => $user->email]);
                if ($subscription_response->wasRecentlyCreated) {

                    //// saving the expiration date to db 
                    $user_subscription = Subscriptions::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();

                    $current = Carbon::now();
                    $current->addMonths(3);

                    $user_subscription->subscription_ends_at = $current->toDateTimeString();
                    $user_subscription->save();

                    Log::info('Subscription is completed with stripe id and plan', ['stripe_id' => $user_subscription->stripe_id, 'plan' => $user_subscription->stripe_plan]);
                    //return back()->with('success', 'Subscription is completed.');
                    
                    Mail::send('user.email.welcome', ['user' => $user], function ($m) use ($user) {
                        $m->from('admin@salsa.com', 'Salsa');

                        $m->to($user->email, $user->name)->subject('Välkommen till Skolguiden Premium');
                    });
                    
                    return redirect('questions')->with('success', 'You have subscribed successfully.');
                } else {
 
                    Log::info('User gets error in response from create_subscription api ', ['user_id' => $user->id]);

                    return back()->with('error', 'User could not subscribed successfully.');
                }
            } else {
                
                if ($user->subscription(env('SUBSCRIPTION_ID'))->cancelled()) {
                     //Log::info('subscription is cancelled of this user_id ', ['user_id' => $user->id]);
                     //return back()->with('error', 'your subscription has been cancelled.');
                 $subscription_response = $user->newSubscription(env('SUBSCRIPTION_NAME'), env('SUBSCRIPTION_ID'))->create($credit_card_token, ['email' => $user->email]);
                if ($subscription_response->wasRecentlyCreated) {

                    //// saving the expiration date to db 
                    $user_subscription = Subscriptions::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();

                    $current = Carbon::now();
                    $current->addMonths(3);

                    $user_subscription->subscription_ends_at = $current->toDateTimeString();
                    $user_subscription->save();

                    Log::info('Subscription is completed with stripe id and plan', ['stripe_id' => $user_subscription->stripe_id, 'plan' => $user_subscription->stripe_plan]);
                    //return back()->with('success', 'Subscription is completed.');
                    
                    Mail::send('user.email.welcome', ['user' => $user], function ($m) use ($user) {
                        $m->from('admin@salsa.com', 'Salsa');

                        $m->to($user->email, $user->name)->subject('Välkommen till Skolguiden Premium');
                    });
                    
                    return redirect('map')->with('success', 'You have subscribed successfully.');
                } else {
 
                    Log::info('User gets error in response from create_subscription api ', ['user_id' => $user->id]);

                    return back()->with('error', 'User could not subscribed successfully.');
                }
                    }
                    else{                      
                                $check_subscription = Subscriptions::where('user_id', $id)->first();                                
                                if($check_subscription->subscription_ends_at < (date('Y-m-d H:i:s'))){
                                  $flag = $user->subscription(env('SUBSCRIPTION_ID'))->cancel(); 
                                    //Log::info('subscription is cancelled of this user_id ', ['user_id' => $user->id]);
                                    //return back()->with('error', 'your subscription has been cancelled.');                                  
                                                  $subscription_response = $user->newSubscription(env('SUBSCRIPTION_NAME'), env('SUBSCRIPTION_ID'))->create($credit_card_token, ['email' => $user->email]);
                if ($subscription_response->wasRecentlyCreated) {

                    //// saving the expiration date to db 
                    $user_subscription = Subscriptions::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();

                    $current = Carbon::now();
                    $current->addMonths(3);

                    $user_subscription->subscription_ends_at = $current->toDateTimeString();
                    $user_subscription->save();

                    Log::info('Subscription is completed with stripe id and plan', ['stripe_id' => $user_subscription->stripe_id, 'plan' => $user_subscription->stripe_plan]);
                    //return back()->with('success', 'Subscription is completed.');
                    
                    Mail::send('user.email.welcome', ['user' => $user], function ($m) use ($user) {
                        $m->from('admin@salsa.com', 'Salsa');

                        $m->to($user->email, $user->name)->subject('Välkommen till Skolguiden Premium');
                    });
                    
                    return redirect('map')->with('success', 'You have subscribed successfully.');
                } else {
 
                    Log::info('User gets error in response from create_subscription api ', ['user_id' => $user->id]);

                    return back()->with('error', 'User could not subscribed successfully.');
                }
                                }
                                else{
                                     Log::info('User is already subscribed with user_id ', ['user_id' => $user->id]);
                                     return back()->with('error', 'you have already subscribed.');                    
                                }
                           }
            }
        } 
//        catch (Exception $e) {
//
//            Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
//            return back()->with('error', $e->getMessage());
//        }
         catch (\Stripe\Error\Card $e ) {
                     Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        }
        catch (\Stripe\Error\InvalidRequest $e) {
                    Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        } catch (\Stripe\Error\Authentication $e) {
                    Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        } catch (\Stripe\Error\ApiConnection $e) {
                     Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        } catch (\Stripe\Error\Base $e) {
                     Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        } catch (Exception $e) {
                     Log::info('Exception is thrown for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        }
        
    }
    
    /*
     * updating credit card of customer*
     *      */
    public function update_credit_card() {
        
        $credit_card_token = $_POST['stripeToken'];        
        
        $id = Auth::id();
        $user = User::where('id' , $id)->first();        
        
        try{                             
            Log::info('Card is being Updated for user id', ['user_id' => $user->id]);
            $response = $user->updateCard($credit_card_token);
            return redirect('/')->with('success', 'Your card has been updated successfully.');    
        }
        catch (Exception $e) {
                     Log::info('Exception is thrown while updating credit card for user_id ', ['user_id' => $user->id, 'exception-message' => $e->getMessage()]);
                     return back()->with('error', $e->getMessage());
        }
        
    }

}
