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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);
        
        $msg = is_null($movie) ? 'Movie is not available' : $movie;

        $status = is_null($movie) ? 404 : 200;

        return response()->json([
            
            'message'=> $msg,
            
        ], $status);
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if(Movie::where('id', $id)->exists()) {

           $validator = Validator::make($request->all(), $this->rules('update'), $this->errors());
        
       
           if($validator->fails())
            {
              return response()->json([
                 
                'message' => $validator->messages()->all()
    
              ],422);
            }

            $movie = Movie::find($id);
  
            if($request->hasFile('cover')) {
               
               
                $this->delete_picture($movie->cover);
                
                $fileNameToStore = $this->upload_picture($request->cover);
          
                $movie->update(
  
                  [
  
                    'title' => $request->title,
                    'genre' => is_array($request->genre) == 1 ? $request->genre : explode(" ",$request->genre),
                    'country_of_production'=> $request->country_of_production,
                    'description'=> $request->description,
                    'cover'=> $fileNameToStore
  
                  ]
  
                );
  
            }

           

            $movie->update(

                [

                    'title' => $request->title,
                    'genre' => is_array($request->genre) == 1 ? $request->genre : explode(" ",$request->genre),
                    'country_of_production'=> $request->country_of_production,
                    'description'=> $request->description,

                ]
            );

              

            return response()->json([
                 
                'message'=> 'Movie Details Has been Updated',
      
            ],200);

        }else{

            return response()->json([
                "message" => "Movie not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
