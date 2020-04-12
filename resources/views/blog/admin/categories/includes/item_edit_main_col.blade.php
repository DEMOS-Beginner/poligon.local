@php
	/** @var \App\Models\BlogCategory $item */
@endphp
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="card-title"></div>
				<ul class="nav nav-tabs" role='tablelist'>
					<li class="nav-item">
						<a class="nav-link active" data-toggle='tab' href='#maindata' role='tab'>Основные данные</a>
					</li>
				</ul>

				<br>
				<div class="tab-content">

					<div class="tab-pane active" id ='maindata' role='tabpanel'>
						<div class="form-group">
							<label for="title">Заголовок</label>
							<input type="text" name="title" id='title' value='{{ old('title') !== null ? old('title') : $item->title}}'
							 class="form-control"
							 minlength="3"
							 required>
						</div>

						<div class="form-group">
							<label for="slug">Идентификатор</label>
							<input name='slug' value='{{  old('slug') !== null ? old('slug') : $item->slug}}'
							type='text'
							id='slug'
							class='form-control'>
						</div>

						<div class="form-group">
							<label for="parent_id">Родитель</label>
							<select name="parent_id"
							id="parent_id"
							class='form-control'
							placeholder='Выберите категорию'
							required>
								@foreach($categoriesList as $categoryOption)
									<option value="{{  old('parent_id') !== null ? old('parent_id') : $categoryOption->id}}"
										@if ($categoryOption->id == $item->parent_id) selected @endif>
										{{$categoryOption->id_title}}
									</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="description">Описание</label>
							<textarea name='description' id='description' class='form-control' rows='3'>{{old('description') !== null ? old('description') : $item->description}}
							</textarea>

						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>