<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUD_ManagentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_can_be_created()
    {
        // para que nos arroje errores apropiados
        $this->withExceptionHandling();

        // Enviar una peticion HTTP[POST] para que almacene un Tag nuevo
        $responde = $this->post('/api/task', [
            'title' => 'Tarea de Prueba',
            'description' => 'esta tarea es un prueba.'
        ]);

        // verificamos si todo esta bien
        $responde->assertOk();

        // verificamos si en realidad existe mi Tag
        $this->assertCount(1, Task::all());

        // recupero el Tag que mande a crear
        $task = Task::first();

        // verificamos si los datos de mi Tag
        // creado son iguales a los que mande
        $this->assertEquals('Tarea de Prueba', $task->title);
        $this->assertEquals('esta tarea es un prueba.', $task->description);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        // para que nos arroje errores apropiados
        $this->withExceptionHandling();

        // Datos de prueba
        $task = Task::factory()->create();

        $responde = $this->put('/api/task/' . $task->id, [
            'title' => 'Actualizado',
            'description' => $task->description
        ]);

        $responde->assertOk();

        $this->assertCount(1, Task::all());

        $task = $task->fresh();

        $this->assertEquals($task->title, 'Actualizado');
    }

    /** @test */
    public function a_task_can_be_deleted()
    {
        // para que nos arroje errores apropiados
        $this->withExceptionHandling();

        // Datos de prueba
        $tasks = Task::factory()->count(3)->create();

        $responde = $this->delete('/api/task/' . 2);

        $responde->assertOk();

        $tasks = Task::all();

        $this->assertCount(2, $tasks);

        $this->assertEquals($tasks[0]->id, 1);
        $this->assertEquals($tasks[1]->id, 3);
    }
}
