@extends('layouts.app')

@section('content')
	<h1>{{ $project->title }}</h1>
	<div>{{ $project->description }}</div>
	<a href="{{ url('/projects') }}" class="btn btn-link">Go Back</a>
@endsection