<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class ReportController extends Controller
{
    public function index(){
        $reports = Report::with('user', 'post', 'admin' )->orderBy('created_at', 'desc')->get();
        return Inertia::render('Reports', [
            'reports' => $reports
        ]);
    }

    public function store(Request $request){

        $userId = Auth::id();

        $request->validate([
            'post_id' => 'required',
            'description' => 'required',
        ]);
        $post = Post::findOrFail($request->post_id);

        if ($post->user_id === $userId) {
            return redirect()->back()->with('error', 'You cannot report your own post.');
        }

        $existingReport = Report::where('user_id', $userId)
            ->where('post_id', $request->post_id)
            ->first();

        if ($existingReport) {
            return redirect()->back()->with('error', 'You have already reported this post.');
        }

        $report = Report::create([
            'user_id' => $userId,
            'post_id' => $request->post_id,
            'description' => $request->description,
            'status' => 'pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);


        $mongoData = [
            'sql_id' => $report->id,
            'user_id' => $userId,
            'post_id' => $request->post_id,
            'description' => $request->description,
            'status' => 'pending',
            'reviewed_by' => null,
            'reviewed_at' => null,
        ];

        $mongoDb = DB::connection('mongodb')->getMongoDB();
        $collection = $mongoDb->selectCollection('mongo_reports');
        $collection->insertOne($mongoData);

        return redirect()->back()->with('success', 'Report Sent Successfully');
    }

    public function dismissed($id){
        $report = Report::findOrFail($id);
        $report->update([
            'status' => 'dismissed',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            ]);

        $mongoDb = DB::connection('mongodb')->getMongoDB();
        $collection = $mongoDb->selectCollection('mongo_reports');

        $collection->updateOne(
            ['sql_id' => $report->id],
            [
                '$set' => [
                    'status' => 'dismissed',
                    'reviewed_by' => $report->reviewed_by,
                    'reviewed_at' => new \MongoDB\BSON\UTCDateTime($report->reviewed_at->valueOf()),
                ]
            ]
        );

        return redirect()->back()->with('success', 'Report Dismissed');
    }

    public function reviewed($id){
        $report = Report::findOrFail($id);
        $report->update([
            'status' => 'reviewed',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            ]);

        $mongoDb = DB::connection('mongodb')->getMongoDB();
        $collection = $mongoDb->selectCollection('mongo_reports');

        $collection->updateOne(
            ['sql_id' => $report->id],
            [
                '$set' => [
                    'status' => 'reviewed',
                    'reviewed_by' => $report->reviewed_by,
                    'reviewed_at' => new \MongoDB\BSON\UTCDateTime($report->reviewed_at->valueOf()),
                ]
            ]
        );

        return redirect()->back()->with('success', 'Report Reviewed');
    }

}
