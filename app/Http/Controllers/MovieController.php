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
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
               
        $validator = Validator::make($request->all(), $this->rules('create'), $this->errors());
        
       
           if($validator->fails())
            {
              return response()->json([
                 
                'message' => $validator->messages()->all()
    
              ],422);
            }

          
          
            $fileNameToStore = $this->upload_picture($request->cover);
          
            Movie::create([

                'title' => $request->title,
                'genre' => is_array($request->genre) == 1 ? $request->genre : explode(" ",$request->genre),
                'country_of_production'=> $request->country_of_production,
                'description'=> $request->description,
                //'main_video'=> 'required|mimes:mp4|max:10000',
                'cover'=> $fileNameToStore


            ]);

            return response()->json([
                
                'message'=> 'Your Movie Has been Uploaded',
      
            ],200);

            
    
    }

  
}
