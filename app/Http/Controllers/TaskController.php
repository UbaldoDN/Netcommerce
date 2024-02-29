<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Task::with(['user', 'company'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $user = User::find($request->user_id);
        if ($user->tasks()->where('is_completed', false)->count() >= 5) {
            return response(["message" => "No es posible crear más tareas, el máximo es de 5."], Response::HTTP_CONFLICT);
        }

        $request->request->add([
            'started_at' => now(),
            'expired_at' => now()->addDays(3),
        ]);

        return response()->json(Task::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task = Task::with(['user', 'company'])->find($task->id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());
        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (!$task->is_completed) {
            return response(["message" => "No es posible eliminar la tarea, no está completada."], Response::HTTP_CONFLICT);
        }

        $task->delete();
        return response()->json(null, 204);
    }
}
