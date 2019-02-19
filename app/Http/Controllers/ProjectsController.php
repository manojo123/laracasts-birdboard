<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{

    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }
    /**
     * @param  Project
     * @return [type]
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project){
        return view('projects.edit', compact('project'));
    }

    /**
     * @param  UpdateProjectRequest
     * @param  Project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $form){
        return redirect($form->save()->path());
    }

    public function destroy(Project $project){
        $this->authorize('update', $project);

        $project->delete();

        return redirect('/projects');
    }

    protected function validateRequest(){
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable',
        ]);
    }

}
