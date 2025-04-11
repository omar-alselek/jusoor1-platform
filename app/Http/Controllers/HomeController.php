<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Donation;
use App\Models\Volunteer;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $featuredProjects = [];
            
        return view('home', compact('featuredProjects'));
    }
    
    /**
     * Display the about page.
     */
    public function about()
    {
        return view('about');
    }
    
    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('contact');
    }
    
    /**
     * Display the admin dashboard.
     */
    public function adminDashboard()
    {
        $projectsCount = Project::count();
        $usersCount = User::count();
        $donationsSum = Donation::where('status', 'completed')->sum('amount');
        $volunteersCount = Volunteer::count();
        
        $recentProjects = Project::orderBy('created_at', 'desc')->take(5)->get();
        $recentDonations = Donation::with('user', 'project')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'projectsCount',
            'usersCount',
            'donationsSum',
            'volunteersCount',
            'recentProjects',
            'recentDonations'
        ));
    }
    
    /**
     * Display the admin users page.
     */
    public function adminUsers()
    {
        $users = User::with('roles', 'profile')->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Display the admin projects page.
     */
    public function adminProjects()
    {
        $projects = Project::with('user')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }
    
    /**
     * Display the admin donations page.
     */
    public function adminDonations()
    {
        $donations = Donation::with('user', 'project')->paginate(15);
        return view('admin.donations.index', compact('donations'));
    }
    
    /**
     * Display the admin volunteers page.
     */
    public function adminVolunteers()
    {
        $volunteers = Volunteer::with('user', 'project')->paginate(15);
        return view('admin.volunteers.index', compact('volunteers'));
    }
}
