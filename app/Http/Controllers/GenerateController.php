<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Random;
use App\Models\Breakdown;
use Carbon\Carbon;

class GenerateController extends Controller
{

    public function index()
    {  
        //creating random integer with a range of 5 to 10
        $rand =  rand(5,10);
        
        // looping random integer 
        $carbon = new Carbon;

        $check = Random::all();

        if($check->isEmpty()){
       
            for($i=0; $i < $rand; $i++){
            
                // saving data
                
                $random = new Random;
                $random->values = $this->generate_random_name();
                $random->flag = 'flag-'.$carbon->toDateString();
                $random->save();
    
                //creating random integer with a range of 5 to 10
                $rand_break =  rand(5,10);
    
                // another loop for breakdowns
                for($x=0; $x < $rand_break; $x++){
                    
                    $breakdown = new Breakdown;
                    $breakdown->values = $this->generate_breakdown_values();
                    $breakdown->save();
                    $random->breakdowns()->save($breakdown);
                }
            }

        }
       

        // get all data from random table

        $random_data = Random::with('breakdowns')->get();

        return $random_data;

        //
    }

    // function for generating a random name
    public function generate_random_name ($length = 7){
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generate_breakdown_values ($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
