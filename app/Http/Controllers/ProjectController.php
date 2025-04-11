<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Volunteer;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $project = new Project($validated);
        $project->user_id = auth()->id();
        $project->status = 'pending';
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $project->image = $path;
        }
        
        $project->save();
        
        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully and is pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['user.profile', 'donations', 'volunteers']);
        
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:2048',
        ]);
        
        $project->fill($validated);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $project->image = $path;
        }
        
        $project->save();
        
        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();
        
        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
    
    /**
     * Show the volunteer form for a project.
     */
    public function volunteerForm(Project $project)
    {
        return view('projects.volunteer', compact('project'));
    }
    
    /**
     * Submit a volunteer application for a project.
     */
    public function volunteer(Request $request, Project $project)
    {
        $validated = $request->validate([
            'skills' => 'required|string|max:255',
            'availability' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        // Check if user already volunteered
        $existingVolunteer = Volunteer::where('user_id', auth()->id())
            ->where('project_id', $project->id)
            ->first();
            
        if ($existingVolunteer) {
            return redirect()->route('projects.show', $project)
                ->with('error', 'You have already volunteered for this project.');
        }
        
        $volunteer = new Volunteer($validated);
        $volunteer->user_id = auth()->id();
        $volunteer->project_id = $project->id;
        $volunteer->status = 'pending';
        $volunteer->save();
        
        return redirect()->route('projects.show', $project)
            ->with('success', 'Thank you for volunteering! Your application is being reviewed.');
    }
}
