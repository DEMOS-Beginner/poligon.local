@if ($errors->any())
	<div class="row justify-content-center">
		<div class="col-md-11">
			<div class="alert alert-danger" role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>x</span>
				</button>
				<ul>
					@foreach($errors->all() as $errorTxt)
						<li> {{$errorTxt}} </li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endif
@if (session('success'))
	<div class="row justify-content-center">
		<div class="col-md-11">
			<div class="alert alert-success" role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>x</span>
				</button>
				{{ session()->get('success') }}
			</div>
		</div>
	</div>
@endif
@if(session('restore'))
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card card-block">
				<div class="alert alert-danger">
 <a href="{{route('post_restore', session()->get('restore'))}}" type="submit"
                       class="btn btn-warning">Восстановить</a>
				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
@endif