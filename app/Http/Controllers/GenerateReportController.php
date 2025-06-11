<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;
use App\Models\Application;

class GenerateReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'users');
        $interval = $request->input('interval', 'weekly');

        $now = Carbon::now();

        $startDate = match ($interval) {
            'weekly' => $now->copy()->subWeeks(10)->startOfWeek(),
            'monthly' => $now->copy()->subMonths(12)->startOfMonth(),
            'yearly' => $now->copy()->subYears(5)->startOfYear(),
            default => $now->copy()->subYears(1),
        };

        $dateFormat = match ($interval) {
            'weekly' => '%Y-%u',
            'monthly' => '%Y-%m',
            'yearly' => '%Y',
            default => '%Y-%m',
        };

        switch ($type) {
            case 'users':
                $query = User::selectRaw("name, email, phone, address, created_at, DATE_FORMAT(created_at, '$dateFormat') as period")
                    ->whereDate('created_at', '>=', $startDate);
                $data = $query->get()->groupBy('period')->map(function($group) {
                    return $group->map(fn($user) => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'address' => $user->address,
                        'phone' => $user->phone,
                        'created_at' => $user->created_at->format('Y-m-d H:i'),
                    ]);
                });
                break;

            case 'jobs':
                $query = Post::selectRaw("tittle, description, type, created_at, DATE_FORMAT(created_at, '$dateFormat') as period")
                    ->whereDate('created_at', '>=', $startDate);
                $data = $query->get()->groupBy('period')->map(function($group) {
                    return $group->map(fn($post) => [
                        'tittle' => $post->tittle,
                        'description' => $post->description,
                        'type' => $post->type,
                        'created_at' => $post->created_at->format('Y-m-d H:i'),
                    ]);
                });
                break;

            case 'applications':
                $query = Application::with('user:name,id', 'post:tittle,id')
                    ->selectRaw("id, user_id, post_id, status, created_at, DATE_FORMAT(created_at, '$dateFormat') as period")
                    ->whereDate('created_at', '>=', $startDate);

                $data = $query->get()->groupBy('period')->map(function($group) {
                    return $group->map(fn($app) => [
                        'applicant' => $app->user->name,
                        'job' => $app->post->tittle,
                        'status' => $app->status,
                        'applied_at' => $app->created_at->format('Y-m-d H:i'),
                    ]);
                });
                break;

            case 'applications_per_job':
                $query = Post::withCount(['applications as applications_count' => function ($q) use ($startDate) {
                    $q->whereDate('created_at', '>=', $startDate);
                }]);
                $data = $query->orderByDesc('applications_count')
                    ->take(10)
                    ->get()
                    ->map(fn($post) => [
                        'job' => $post->tittle,
                        'count' => $post->applications_count,
                    ]);
                break;

            case 'accepted_applications':
                $query = Post::withCount(['applications as accepted_applicants_count' => function ($q) use ($startDate) {
                    $q->where('status', 'accepted')
                        ->whereDate('created_at', '>=', $startDate);
                }])
                    ->whereHas('applications', function ($q) use ($startDate) {
                        $q->where('status', 'accepted')
                            ->whereDate('created_at', '>=', $startDate);
                    })
                    ->selectRaw("tittle, created_at, DATE_FORMAT(created_at, '$dateFormat') as period");

                $data = $query->get()->groupBy('period')->map(function($group) {
                    return $group->map(fn($post) => [
                        'tittle' => $post->tittle,
                        'created_at' => $post->created_at->format('Y-m-d H:i'),
                        'accepted_applicants' => $post->accepted_applicants_count,
                    ]);
                });
                break;
            default:
                $data = collect();
        }

        return response()->json($data);
    }
}
