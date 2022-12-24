<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\MyClass\Calendar;
use App\Models\Project;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function tasks(Calendar $calendar)
    {
        request()->validate([
            'date' => ['bail', 'nullable', 'date'],
            'from' => ['bail', 'nullable', 'date'],
            'to' => ['bail', 'nullable', 'date'],
            ]);

        $activityForThisDay = carbon(request()->date)->toDateString();

        $activities = Task::with('project')->when(request()->from and request()->to, function($query){
            $query->whereDateBetween('created_at', request()->from, request()->to);
        })
        ->when(request()->date, function($query){
            $query->whereDate('created_at', request()->date);
        })
        ->when(request()->project, function($query){
            $query->where('project_id', request()->project);
        })
        ->when(request()->deadline, function($query){
            $query->whereDate('deadline', request()->deadline);
        })
        ->where("user_id", request()->user()->id)
        ->orderBy('priority', 'asc')->paginate(50);

        return view('tasks', [
            'activities'=>$activities,
            'date'=>$activityForThisDay,
            'calendar'=>$calendar,
            'projects'=>Project::where('user_id', request()->user()->id)->get()
        ]);
    }

    public function createTaskForm()
    {
        return view('snippet.task-form', [
            'activity'=>Task::where('id', request()->id)->first(),
            'projects'=>Project::where('user_id', request()->user()->id)->get()
        ]);
    }

    public function createTaskFormSubmit()
    {
        request()->validate([
            'name' => ['bail', 'required', 'string'],
            'deadline' => ['bail', 'required', 'date'],
            'priority' => ['bail', 'nullable', 'numeric'],
            'description' => ['bail', 'nullable', 'string'],
            'id' => ['bail', 'nullable', 'string', 'exists:tasks'],
            'project_id' => ['bail', 'nullable', 'string', Rule::exists('projects', 'id')->where(function ($query) {
                return $query->where('user_id', request()->user()->id);
               })],
            ]);

        Task::updateOrCreate(
                ['id' => request()->id],
                ['name' => request()->name, 'description' => request()->description, 'user_id' => request()->user()->id, 'priority' => request()->priority ?? 1, 'deadline' => request()->deadline, 'project_id' => request()->project_id]
            );

        return response("Task has been created successfully");
    }

    public function delete()
    {
        Task::where('id', request()->id)->delete();

        return back()->with('status', "Task was successfully deleted");
    }

    public function reorder()
    {
        request()->validate([
            'id' => ['bail', 'required', 'array'],
            'order' => ['bail', 'array', 'required']
           ]);
        
        if(count(request()->id) != count(request()->order))
        {
            return response("Something is not right", 422);
        }

        Task::where('user_id', request()->user()->id)->chunkById(100, function ($users) {
            foreach ($users as $user) {
                for($i=0;$i<count(request()->order);$i++){
                    if((!empty(request()->order[$i])) and (!empty(request()->id[$i]))){
                                $user->where('id', request()->id[$i])->update(['priority' => request()->order[$i]]);
                        }
                    }
            }
        });

        return response("Re-ordering was successful. Thank you for using our app");
    }
}
