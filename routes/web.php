<?php

use \App\Http\Requests\TaskRequest;
use \App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return redirect()-> route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index', [
        'tasks' => Task::latest()->paginate(5)
    ]);
})->name('tasks.index');


Route::view('/tasks/create', 'create')->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', ['task' => $task]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function (Task $task) {
    return view('show', ['task' => $task]);
})->name('tasks.show');

Route::put('/tasks/{task}', function(Task $task, TaskRequest $request) {
    // $data = ;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->completed = false;
    // $task->save();
    $data = $request->validated();
    $data['completed'] = false;
    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'This task was updated');
})->name('tasks.update');;

Route::post('/tasks', function(TaskRequest $request) {
    //$data = $request->validated();

    // $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->completed = false;

    $data = $request->validated();
    $data['completed'] = false;
    $task = Task::create($data);


    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'A new task was created');
})->name('tasks.store');;

Route::delete('/tasks/{task}', function (Task $task){
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');

Route::put('tasks/{task}/toggle-complete', function(Task $task){
    $task->toggleComplete();
    $task->save();

    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');

Route::fallback(function () {
    return 'fallback route';
});

