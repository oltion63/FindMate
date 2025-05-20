<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function create(){

        return Inertia::render('jobs/CreateCompany', [
            'authUser' => auth()->id(),
        ]);
    }
    public function store(Request $request){
        $user = auth()->user();
        if ($user->role === 'employee'){
            return redirect()->back()->with('error', 'You are registered as an Employee');
        }
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'image' => 'required|max:10420',
            'description' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'website' => 'required',
            'email' => 'required',
        ]);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $request->file('image')->store('company', 'public');
        } else {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }
        $company = Company::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'image' => $path,
            'description' => $request->description,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
            'email' => $request->email,
        ]);

        $employer = $company->user_id;
        $message = 'Your Company '. $company->name  .' has been created!';

        return redirect(route('profilePage'))->with('success', 'Company created.');
    }
    public function edit(){
        $company = Company::where('user_id', auth()->id())->first();
        return Inertia::render('settings/Company', [
            'authUser' => auth()->id(),
            'company' => $company,
        ]);
    }

    public function update(Request $request, $id){
        $company = Company::where('user_id', auth()->id())->find($id);
        $request->validate([
            'name' => 'sometimes|required',
            'description' => 'required',
            'phone' => 'sometimes|required',
            'address' => 'required',
            'website' => 'required',
            'email' => 'required',
        ]);
        $company->update($request->except('user_id'));
        return redirect(route('profilePage'))->with('success', 'Company information updated.');
    }
    public function updateImage(Request $request, $id)
{
    // Validate that an image file is provided and meets the requirements
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    // Retrieve the company by ID
    $company = Company::findOrFail($id);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $imagePath = $file->storeAs('company', $imageName, 'public');
        if ($company->image && Storage::disk('public')->exists($company->image)) {
            Storage::disk('public')->delete($company->image);
        }
        $company->update(['image' => $imagePath]);

        return Redirect::route('profilePage')->with('success', 'Company image updated.');
    }

    return back()->with('error', 'No image was uploaded!');

}
public function deleteCompany($id)
{
    $company = Company::where('user_id', auth()->id())->find($id);
    if (auth()->id() !== $company->user_id) {
        return redirect()->back()->with('error', 'You are not allowed to delete this company.');
    }
    $company->delete();
    return Redirect::route('profilePage')->with('success', 'Company has been deleted.');
}



}
