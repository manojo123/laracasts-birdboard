<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/** @test */
	public function guests_cannot_add_tasks_to_projects(){
		$project = ProjectFactory::create();

		$this->post($project->path().'/tasks')->assertRedirect('login');
	}

	/** @test */
	public function only_the_owner_of_a_project_may_add_tasks(){
		$this->signIn();

		$project = ProjectFactory::create();

		$body = $this->faker->sentence;
		$this->post($project->path().'/tasks', ['body' => $body])
		->assertStatus(403);

		$this->assertDatabaseMissing('tasks', ['body' => $body]);
	}

	/** @test */
	public function only_the_owner_of_a_project_may_update_a_task(){
		$this->signIn();

		$project = ProjectFactory::withTasks(1)->create();

		$updatedBody = $this->faker->sentence;

		$this->patch($project->tasks[0]->path(), ['body' => $updatedBody])
		->assertStatus(403);

		$this->assertDatabaseMissing('tasks', ['body' => $updatedBody]);
	}

	/** @test */
	public function a_project_can_have_tasks(){
		$project = ProjectFactory::create();
		
		$body = $this->faker->sentence;
		$this->actingAs($project->owner)
		->post($project->path().'/tasks', ['body' => $body])
		->assertRedirect($project->path());

		$this->get($project->path())->assertSee($body);
	}

	/** @test */
	public function a_task_requires_a_body(){
		$project = ProjectFactory::create();

		$attributes = factory('App\Task')->raw(['body' => '']);

		$this->actingAs($project->owner)
		->post($project->path().'/tasks', $attributes)
		->assertSessionHasErrors('body');
	}

	/** @test */
	public function a_task_can_be_updated(){

		$project = ProjectFactory::withTasks(1)->create();

		$body = $this->faker->sentence;

		$this->actingAs($project->owner)
		->patch($project->tasks[0]->path(), compact('body'));

		$this->assertDatabaseHas('tasks', compact('body'));
	}

	/** @test */
	public function a_task_can_be_completed(){
		$project = ProjectFactory::withTasks(1)->create();

		$updatedBody = $this->faker->sentence;

		$this->actingAs($project->owner)
		->patch($project->tasks[0]->path(), [
			'body' => $updatedBody,
			'completed' => true
		])->assertRedirect($project->path());

		$this->assertDatabaseHas('tasks', [
			'body' => $updatedBody,
			'completed' => true
		]);
	}

	/** @test */
	public function a_task_can_be_marked_as_incomplete(){

		$this->withoutExceptionHandling();	

		$project = ProjectFactory::withTasks(1)->create();

		$updatedBody = $this->faker->sentence;

		$this->actingAs($project->owner)
		->patch($project->tasks[0]->path(), [
			'body' => $updatedBody,
			'completed' => true
		])->assertRedirect($project->path());

		$this->actingAs($project->owner)
		->patch($project->tasks[0]->path(), [
			'body' => $updatedBody,
			'completed' => false
		])->assertRedirect($project->path());

		$this->assertDatabaseHas('tasks', [
			'body' => $updatedBody,
			'completed' => false
		]);	
	}
}
