<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class NormalController extends Controller
{
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // Ensures the email is unique in the users table
            'phone' => 'required|numeric|unique:users,phone',
            'image' => 'required', // Ensures the commodity_id exists in the commodities table
            'office-phn-input' => 'required', // Ensures the commodity_id exists in the commodities table
            'office_address' => 'required', // Ensures the commodity_id exists in the commodities table
            'business_name' => 'required', // Ensures the commodity_id exists in the commodities table
            'ifsc-code-input' => 'required', // Ensures the commodity_id exists in the commodities table
            'account_no' => 'required', // Ensures the commodity_id exists in the commodities table
            'role' => 'required', // Ensures the commodity_id exists in the commodities table
            'pan_card' => 'required', // Ensures the commodity_id exists in the commodities table
            'aadhar_card' => 'required', // Ensures the commodity_id exists in the commodities table
            'pan-input' => 'required', // Ensures the commodity_id exists in the commodities table
            'aadhar-input' => 'required', // Ensures the commodity_id exists in the commodities table
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if ($request->hasFile('mandi_license')) {
            $file1 = $request->file('mandi_license');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('mandilicenseImage/' . $filename1);
            $user->mandi_license = $filename1;
        }


        if ($request->hasFile('gumasta')) {
            $file1 = $request->file('gumasta');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('GumastaImage/' . $filename1);
            $user->gumasta = $filename1;
        }
        if ($request->hasFile('gst_registration')) {
            $file1 = $request->file('gst_registration');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('GstImage/' . $filename1);
            $user->gst_registration = $filename1;
        }

        $user->mandi_license_no = $request->input('mandi_license_no');
        $user->gumasta_no = $request->input('gumasta_no');
        $user->gst_no = $request->input('gst_no');
        $user->aadhar = $request->input('aadhar-input');
        $user->pan = $request->input('pan-input');

        if ($request->hasFile('aadhar_card')) {
            $file1 = $request->file('aadhar_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('AdharImage/' . $request->name, $filename1);
            $user->aadhar_card = $filename1;
        }
        if ($request->hasFile('pan_card')) {
            $file1 = $request->file('pan_card');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('PancardImage/' . $request->name, $filename1);
            $user->pan_card = $filename1;
        }
        $user->role = $request->input('role');

        $user->account_no = $request->input('account_no');
        $user->ifsc_code = $request->input('ifsc-code-input');

        if ($request->hasFile('statement')) {
            $file1 = $request->file('statement');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('StatementImage/' . $request->name, $filename1);
            $user->statement = $filename1;
        }

        $user->business_name = $request->input('business_name');
        $user->office_address = $request->input('office_address');
        $user->office_phn = $request->input('office-phn-input');

        if ($request->hasFile('image')) {
            $file1 = $request->file('image');
            $ext = $file1->getClientOriginalExtension();
            $filename1 = time() . '_1.' . $ext;
            $file1->move('ShopImage/' . $request->name, $filename1);
            $user->image = $filename1;
        }

        $user->password = bcrypt($request->password);
        $user->agreement = 1;
        $user->save();
        return redirect()->route('login')->with('success', 'Registration successfull!');
        // return redirect()->route('login')->with('success', 'Registration created successfully.');
    }
}
