@extends('layouts.app')

@section('title', "List of Tasks")

@section('content')
    <nav class="mb-4">
        <a href="{{ route('tasks.create') }}" class="btn">Add Task!</a>
    </nav>

    <div class="bg-white p-6 rounded shadow-md border border-gray-200">
        @forelse ($tasks as $task)
            <li class="mb-3">
                <a href="{{ route('tasks.show', ['task' => $task->id])}}" @class(['line-through' => $task->completed])>
                    {{ $task -> title}}
                </a>
            </li>
        @empty
        <div>There are no tasks!</div>
        @endforelse

    </div>
    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection

