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
    public function destroy($id)
    {
        $movie = Movie::find($id);

        $msg = is_null($movie) ? 'Movie is not available' : $this->runDelete($movie);

        $status = is_null($movie) ? 404 : 200;

        return response()->json([
          
            'message' => $msg

        ], $status);
    }

    public function search(Request $request){
        
        $title = $request->title;
        
        $searchResults =  Movie::where('title','LIKE','%'.$title.'%')->get()->toArray();

        $msg = count($searchResults) > 0 ? $searchResults : 'Title is not available';

        $status = count($searchResults) > 0 ? 200 : 404;
    
        return response()->json([

            'message'=> $msg

        ], $status);


    }


    public function rules($type){
        
        if($type == 'update'){
            
            //if type == update cover image may not be not required
            return [
                'title' => 'required|string',
                'country_of_production'=> 'required',
                'description'=> 'required|string',
                'genre' => 'required',
                //'main_video'=> 'required|mimes:mp4|max:10000',
                'cover'=> 'file|mimes:jpeg,png,jpg|max:1024',
            ];

        }else{
            
            return [
                'title' => 'required|string',
                'country_of_production'=> 'required',
                'description'=> 'required|string',
                'genre' => 'required',
                //'main_video'=> 'required|mimes:mp4|max:10000',
                'cover'=> 'required|file|mimes:jpeg,png,jpg|max:1024',
            ];

        }
    
    }

    public function errors(){
         
        return [
            'title.required' => 'The Title field is required',
            'country_of_production.required'=> 'The country field is required',
            'description.required'=> 'The description field is required',
            'genre.required' => 'The genre is required',
            //'main_video'=> 'required|mimes:mp4|max:10000',
            'cover.required'=> 'The cover image is required',
            'cover.max' => 'The maximum file size is 1MB',
            'cover.mimes' =>'Only jpeg,png,jpg is allowed'
        ];

    }

    public function runDelete($para){

        $para->delete();

        return 'Movie has been deleted';

        
    }

    public function upload_picture($pics){

        $fileWithExt = $pics->getClientOriginalExtension();
        $fileNameToStore = uniqid().uniqid().".".$fileWithExt;
        $pics->storeAs('public/cover',  $fileNameToStore);

        return $fileNameToStore;

    }

    
    public function delete_picture($file) {

        if (file_exists(storage_path('app/cover/'.$file))) {
            
            \Storage::delete($file);
            // 2. possibility
            unlink(storage_path('app/cover/'.$file));

        }   

        return true;

    }
}
