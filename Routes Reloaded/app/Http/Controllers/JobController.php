<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    //index
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    //create
    public function create()
    {
        return view('jobs.create');
    }

    //show
    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    //store
    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:5'],
            'salary' => ['required']
        ]);

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        return redirect('/jobs');
    }

    //edit
    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }

    //update
    public function update(Job $job)
    {
        request()->validate([
            'title' => ['required', 'min:5'],
            'salary' => ['required']
        ]);

        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        return redirect('jobs/' . $job->id);
    }

    //destroy
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect('/jobs');
    }
}
