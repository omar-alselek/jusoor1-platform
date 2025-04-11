<?php

namespace App\Http\Controllers\ProjectManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Volunteer;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:moderator');
    }
    
    /**
     * Display the project manager dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)
                          ->orWhere('status', 'active')
                          ->count();
        
        $volunteers = Volunteer::whereHas('project', function($query) use ($user) {
                            $query->where('user_id', $user->id);
                        })->count();
        
        $donations = Donation::whereHas('project', function($query) use ($user) {
                         $query->where('user_id', $user->id);
                     })->count();
        
        $latestProjects = Project::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
        
        return view('project-manager.dashboard', compact('projects', 'volunteers', 'donations', 'latestProjects'));
    }
    
    /**
     * Display projects for the project manager.
     *
     * @return \Illuminate\Http\Response
     */
    public function projects()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        
        return view('project-manager.projects', compact('projects'));
    }
    
    /**
     * Display donations for projects managed by the project manager.
     *
     * @return \Illuminate\Http\Response
     */
    public function donations()
    {
        $user = Auth::user();
        $donations = Donation::whereHas('project', function($query) use ($user) {
                         $query->where('user_id', $user->id);
                     })
                     ->with(['user', 'project'])
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);
        
        return view('project-manager.donations', compact('donations'));
    }
    
    /**
     * Display volunteers for projects managed by the project manager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function volunteers(Request $request)
    {
        $user = Auth::user();
        $query = Volunteer::whereHas('project', function($query) use ($user) {
                     $query->where('user_id', $user->id);
                 })->with(['user', 'project']);
        
        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('skills', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->has('project') && !empty($request->project)) {
            $query->where('project_id', $request->project);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $volunteers = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('project-manager.volunteers', compact('volunteers'));
    }
    
    /**
     * Display details of a specific volunteer.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function showVolunteer(Volunteer $volunteer)
    {
        $user = Auth::user();
        
        // Check if the project belongs to the current user
        if ($volunteer->project->user_id != $user->id) {
            return redirect()->route('project-manager.volunteers')
                             ->with('error', 'لا يمكنك عرض تفاصيل هذا المتطوع');
        }
        
        return view('project-manager.volunteers.show', compact('volunteer'));
    }
    
    /**
     * Approve a volunteer application.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function approveVolunteer(Volunteer $volunteer)
    {
        $user = Auth::user();
        
        // Check if the project belongs to the current user
        if ($volunteer->project->user_id != $user->id) {
            return redirect()->route('project-manager.volunteers')
                             ->with('error', 'لا يمكنك إدارة هذا المتطوع');
        }
        
        $volunteer->status = 'approved';
        $volunteer->save();
        
        return redirect()->route('project-manager.volunteers')
                         ->with('success', 'تم قبول طلب التطوع بنجاح');
    }
    
    /**
     * Reject a volunteer application.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function rejectVolunteer(Volunteer $volunteer)
    {
        $user = Auth::user();
        
        // Check if the project belongs to the current user
        if ($volunteer->project->user_id != $user->id) {
            return redirect()->route('project-manager.volunteers')
                             ->with('error', 'لا يمكنك إدارة هذا المتطوع');
        }
        
        $volunteer->status = 'rejected';
        $volunteer->save();
        
        return redirect()->route('project-manager.volunteers')
                         ->with('success', 'تم رفض طلب التطوع');
    }
} 