<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct(){
    //     $this->middleware('auth:api');
    // }
    
    
    public function index(Request $request)
    {
        if(Gate::allows("isAdmin")){
            return User::latest()->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::allows("isAdmin")){
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required|string|email|max:255|unique:users',
                'password'=>'required|string|min:8',
            ]);
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>$request->role,
            ]);

            return response(["message"=>"User was created Successfully"],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    

    public function update(Request $request,$id)
    {
        if(Gate::allows("isAdmin")){
            //return $request->photo;
            $user = User::findOrFail($id);
            $this->validate($request,[
                'name'=>'required',
                'email'=>'required|string|email|max:255',
                'role'=>'required|string',
            ]);


            if($request->file("photo")){
                $upload_path = public_path('upload');
                $file_name = $request->file('photo')->getClientOriginalName();
                $generated_new_name = time().'.'.$request->file('photo')->getClientOriginalName();
                $request->photo->move($upload_path,$generated_new_name);

            
                $prev_profile  = public_path('upload/').$user->photo;
                if(file_exists($prev_profile)){
                    @unlink($prev_profile);
                }
                
                $user->photo = $generated_new_name;
            }

            // $title = $file_name;

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            $user->save();
            
            return response(["message"=>"Your info was updated successfully"],200);
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
        if(Gate::allows("isAdmin")){
            $user = User::findOrFail($id);
            $user->delete();
        }
    }

    public function profile(){
        return auth()->user();
    }

    public function search(Request $request){
        if($request->q != null || !(empty($request->q))){
            if(Gate::allows("isAdmin")){
                $users = User::where("name","LIKE","%$request->q%")->orWhere('email','LIKE',"%$request->q%")->orWhere('role','LIKE',"%$request->q%")->get();
            }
        }else{
            $users = $this->index($request);
        }
        // if($search = \Request::get('q')){
        //     $users = User::where(function($query) use ($search){
        //         $query->where("name","LIKE","%$search%")->orWhere('email','LIKE',"%$search%")->paginate(20);
        //     });
        // }
        return response($users);
    }
    
    public function upload(Request $request,$id){
        // return auth()->user();
        return $request->photo;
        return $id;

        // $upload_path = public_path('upload');
        // // $file_name = $request->file('photo')->getClientOriginalName();
        // $generated_new_name = time().'.'.$request->file('photo')->getClentOriginalExtension();
        // $$request->photo->move($upload_path,$generated_new_name);

        // // $title = $file_name;

        // $user = User::find($id);
        // $user->photo = $generated_new_name;
        // $user->save();
        // return response(["Success"=>"Profile Picture Uploaded Successfully"]);

    }
}
