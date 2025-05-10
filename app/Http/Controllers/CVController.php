<?php

namespace App\Http\Controllers;

use App\Models\CV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function storeCv(Request $request){
        $request->validate([
            'file' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('cv_files', $fileName, 'public');
        } else {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }
        Cv::create([
            'file' => $path,
            'user_id' => $request->user_id,
        ]);
        return redirect()->back()->with('success', 'File uploaded.');
    }
    public function updateCV(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);
        $user = auth()->id();
        $cv = CV::where('user_id', $user)->first();
        if ($user !== $cv->user_id) {
            return redirect()->back()->with('error', 'You cannot change this file.');
        }
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'No File Uploaded.');
        }
        if ($cv->file) {
            Storage::delete($cv->file);
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('cv_files', $fileName, 'public');
        } else {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }
        $cv->update([
            'file' => $filePath,
        ]);

        return back()->with('success', 'Your CV has been updated successfully.');
    }
    public function deleteCV($id){
        $cv = CV::findOrFail($id);
        if (auth()->id() !== $cv->user_id) {
            return redirect()->back()->with('error', 'You cannot delete this file.');
        }
        $cv->delete();
        return back()->with('success', 'Your CV has been deleted successfully.');
    }
}

