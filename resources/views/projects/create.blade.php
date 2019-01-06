<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<form class="container" method="POST" action="{{ url('projects') }}">
		<h1>Create a Project</h1>
		
		@csrf

		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" id="title" name="title" class="form-control" placeholder="">
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea id="description" name="description" placeholder="" class="form-control"></textarea>
		</div>
		
		<button type="submit" id="submit" name="submit" class="btn btn-primary">Create Project</button>
	</form>

</body>
</html>