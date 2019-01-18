@extends('layouts.app')

@section('content')

	<form method="POST" action="{{ url('projects') }}" class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow">
		<h1 class="text-2xl font-normal mb-10 text-center">Let’s start something new</h1>
		
		@csrf

		<div class="field mb-6">
            <label class="label text-sm mb-2 block" for="title">Title</label>
			<input type="text" id="title" name="title" class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" placeholder="">
		</div>

		<div class="field mb-6">
            <label class="label text-sm mb-2 block" for="description">Description</label>
			<textarea name="description" rows="10" class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full" placeholder="I should start learning piano."></textarea>
		</div>
		
		<button type="submit" id="submit" name="submit" class="button is-link mr-2">Create Project</button>
		<a href="{{ url('/projects') }}">Cancel</a>
	</form>

@endsection