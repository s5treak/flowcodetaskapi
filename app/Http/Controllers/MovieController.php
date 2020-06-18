<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use Validator;
use File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
    public function index()
    {
        $movies = Movie::all()->toArray();

        $msg = count($movies) > 0 ? $movies : 'No movie is available';

        $status = count($movies) > 0 ? 200 : 404;
    
        return response()->json([

            'message'=> $msg

        ], $status);


    }
 
 
    
}
