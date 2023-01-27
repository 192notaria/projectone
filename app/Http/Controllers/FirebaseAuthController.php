<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;

class FirebaseAuthController extends Controller
{

    public function index(){
        // $firebase = (new Factory)
        //     ->withServiceAccount(__DIR__."/firebase_credentials.json")
        //     ->withDatabaseUri('https://notaria192-158b7-default-rtdb.firebaseio.com');

        // $database = $firebase->createDatabase();
        // $postRef = $database->getReference('posts')->push("dataaaa");
        // print_r($postRef);
        // $blog = $database
        //     ->getReference('actos');

        // // echo '<pre>';
        // // print_r($blog->getvalue());
        // // echo '</pre>';
    }
}
