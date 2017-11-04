<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;
use Log;

class WebhookController extends CashierController
{
  //
   public function handleInvoicePaymentSucceeded(array $payload)
    {
        // Handle The Event
        //Log::info('User is trying to create subscription with user_id ', ['payload' => $payload]);
        echo 'getting into invoice payment succeed  ';
        return new Response('Webhook Handled', 200);
        
    } 
}
