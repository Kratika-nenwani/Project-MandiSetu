<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email', 
            'phone' => 'required|regex:/^[0-9]{10}$/|unique:users,phone', 
            'aadhar' => 'required|regex:/^[0-9]{12}$/', 
            'pan' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', 
            'role' => 'required',
            'account_no' => 'required|numeric', 
            'ifsc_code' => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'statement' => 'required',
            'business_name' => 'required',
            'office_address' => 'required',
            'office_phn' => 'required|regex:/^[0-9]{10}$/', 
            'agreement' => 'required|in:1',
            // 'password' => 'require',
            
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        if (!$request->hasFile('mandi_license') && !$request->hasFile('gumasta') && !$request->hasFile('gst_registration')) {
            return response()->json(['errors' => 'At least one of GST Registration, Gumasta, or Mandi License must be provided.'], 422);
        }
        
        if (!$request->mandi_license_no && !$request->gumasta_no && !$request->gst_no) {
            return response()->json(['errors' => 'Provide Document Number'], 422);
        }
        


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->hasFile('mandi_license')) {
            $file1 = $request->file('mandi_license');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->mandi_license = $filename1;
        }
        if ($request->hasFile('gumasta')) {
            $file1 = $request->file('gumasta');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->gumasta = $filename1;
        }
        if ($request->hasFile('gst_registration')) {
            $file1 = $request->file('gst_registration');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->gst_registration = $filename1;
        }
        $user->mandi_license_no = $request->mandi_license_no;
        $user->gumasta_no = $request->gumasta_no;
        $user->gst_no = $request->gst_no;
        $user->aadhar = $request->aadhar;
        $user->pan = $request->pan;
        if ($request->hasFile('aadhar_card')) {
            $file1 = $request->file('aadhar_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->aadhar_card = $filename1;
        }
        if ($request->hasFile('pan_card')) {
            $file1 = $request->file('pan_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->pan_card = $filename1;
        }
        $user->role = $request->role;
        
        $user->account_no = $request->account_no;
        $user->ifsc_code = $request->ifsc_code;
        if ($request->hasFile('statement')) {
            $file1 = $request->file('statement');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->statement = $filename1;
        }
        
        $user->business_name = $request->business_name;
        $user->office_address = $request->office_address;
        $user->office_phn = $request->office_phn;
        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('Documents/'.$request->name, $filename1);
            $user->image = $filename1;
        }
        if($request->password)
        {
            $user->password = bcrypt($request->password);
        }
        else
        {
            $user->password = bcrypt('12345678');
        }
        $user->agreement=1;
        $user->save();

        return response()->json(['message' => 'Register Successful, Access to the application is granted once an administrator assigns your role and department. Please reach out to the admin to expedite the process and start using the app as soon as possible. Thank you!', 'user'=> $user], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Response(['message' => $validator->errors()], 401);
        }
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $token = $user->createToken('mandisetu')->plainTextToken;
            $user->token = $token;
            $user->save();
            return response(['user' => $user], 200);
        }
        return response(['message' => 'email or password wrong'], 401);
    }
    public function logout()
    {
        $user = Auth::user();
        $user->token = null;
        $user->currentAccessToken()->delete();
        $user->save();

        return Response(['data' => 'User Logout successfully.'], 200);
    }
}
