<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.users.list', [
            'users' => $users,
        ]);
    }

    public function edit($id){
        // dd($id);
        $user = User::findOrFail($id);
        return view('admin.users.edit',[
            'user' => $user
        ]);
    }

    public function update($id,Request $request){
        $validator =  Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();
            Session()->flash('success','User information Updated Successfuly');
            return response()->json([
                'status' => true,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy(Request $request){
        $id = $request->id;

        $user = User::find($id);

        if ($user == null) {
            Session()->flash('error','User not found');
            return response()->json([
                'status' => false,
            ]);    
        }

        $user->delete();

        Session()->flash('error','User Deleted successfuly');
        return response()->json([
            'status' => true,
        ]);    
    }
}
