<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseAuthController extends Controller
{


    public function getData(){
        $this->database->getReference('people/')
            ->set([
                'amount'=>500,
                'currency'=>'$',
                'payment_method'=>'paypal'
            ]);
    }
}
