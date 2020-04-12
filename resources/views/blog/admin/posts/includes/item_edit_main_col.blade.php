<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				@if($item->is_published)
					Опубликовано
				@else
					Черновик
				@endif
			</div>
			<div class="card-body">
				<div class="card-title"></div>
				<div class="card-subtitle mb-2 text-muted"></div>
				<ul class="nav nav-tabs" role='tablist'>
					<li class="nav-item">
						<a href="#maindata" data-toggle='tab' role='tab' class="nav-link">
							Основные данные
						</a>
					</li>
					<li class="nav-item">
						<a href="#adddata" data-toggle='tab' role='tab' class="nav-link">
							Дополнительно
						</a>						
					</li>
				</ul>
				<br>
				<div class="tab-content">
					<div class="tab-pane active" id='maindata' role='tabpanel'>
						<div class="form-group">
							<label for="title">Заголовок</label>
							<input type="text" name="title" id='title' value = '{{$item->title}}'
							minlength="3" class='form-control' required>
						</div>
						<div class="form-group">
							<label for="content_raw">Статья</label>
							<textarea name="content_raw" id='content_raw' class='form-control' rows='20'>
								{{ old('content_raw', $item->content_raw) }}
							</textarea>
						</div>
					</div>
					<div class="tab-pane" id='adddata' role='tabpanel'>
						<div class="form-group">
							<label for="category_id">Категория</label>
							<select name="category_id" id="category_id"
								class='form-control'
								placeholder='Выберите категорию'
								required>
								@foreach($categoryList as $categoryOption)
									<option value="{{$categoryOption->id}}" 
										@if($categoryOption->id == $item->category_id) selected @endif>
										{{$categoryOption->id_title}}
									</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="slug">Идентификатор</label>
							<input name='slug' value='{{  old('slug') !== null ? old('slug') : $item->slug}}'
							type='text'
							id='slug'
							class='form-control'>
						</div>

						<div class="form-group">
							<label for="excerpt">Выдержка</label>
							<input name='excerpt' value='{{  old('excerpt') !== null ? old('excerpt') : $item->excerpt}}'
							type='text'
							id='excerpt'
							class='form-control'>
						</div>

						<div class="form-check">
							<input type="hidden"
								name='is_published' value='0'>

							<input type="checkbox"
								class='form-check-input'
								name='is_published'
								value='1'
								@if($item->is_published)
								checked="checked" 
								@endif
							> 
							<label for="is_published" class='form-check-label'>Опубликовано</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>