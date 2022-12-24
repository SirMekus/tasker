<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function projects()
    {
        request()->validate([
            'date' => ['bail', 'nullable', 'date'],
            'from' => ['bail', 'nullable', 'date'],
            'to' => ['bail', 'nullable', 'date'],
            ]);

        $activityForThisDay = carbon(request()->date)->toDateString();

        $activities = Project::when(request()->from and request()->to, function($query){
            $query->whereDateBetween('created_at', request()->from, request()->to);
        })
        ->when(request()->date, function($query){
            $query->whereDate('created_at', request()->date);
        })
        ->when(request()->id, function($query){
            $query->where('id', request()->id);
        })
        ->when(request()->deadline, function($query){
            $query->whereDate('deadline', request()->deadline);
        })
        ->where("user_id", request()->user()->id)
        ->orderBy('created_at', 'desc')->paginate(50);

        return view('projects', [
            'activities'=>$activities,
            'date'=>$activityForThisDay,
        ]);
    }

    public function createProjectForm()
    {
        return view('snippet.project-form', [
            'activity'=>Project::where('id', request()->id)->first(),
        ]);
    }

    public function createProjectFormSubmit()
    {
        request()->validate([
            'name' => ['bail', 'required', 'string'],
            'deadline' => ['bail', 'required', 'date'],
            'description' => ['bail', 'nullable', 'string'],
            'id' => ['bail', 'nullable', 'string', 'exists:projects'],
            ]);

        Project::updateOrCreate(
                ['id' => request()->id],
                ['name' => request()->name, 'description' => request()->description, 'user_id' => request()->user()->id, 'deadline' => request()->deadline]
            );

        return response("Project has been created successfully");
    }

    public function delete()
    {
        Project::where('id', request()->id)->delete();

        return back()->with('status', "Project was successfully deleted");
    }
}
