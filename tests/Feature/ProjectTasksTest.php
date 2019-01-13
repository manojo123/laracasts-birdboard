<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;

	/** @test */
	public function a_project_can_have_tasks(){
		$this->signIn();

		$project = factory(Project::class)->create(['owner_id' => auth()->id()]);
		$body = $this->faker->sentence;

		$this->post($project->path().'/tasks', ['body' => $body]);

		$this->get($project->path())->assertSee($body);
	}

	/** @test */
	public function a_task_requires_a_body(){
		$this->signIn();

		$project = factory(Project::class)->create(['owner_id' => auth()->id()]);

		$attributes = factory('App\Task')->raw(['body' => '']);

		$this->post($project->path().'/tasks', $attributes)->assertSessionHasErrors('body');
	}
}
