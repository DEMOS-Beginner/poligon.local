<?php 


namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;


/**
*
*	Class BlogPostRepository
*	@package App\Repositories;
*
*/
class BlogPostRepository extends CoreRepository
{

	/**
	*	@return string
	*/
	protected function getModelClass() //реализация абстрактного метода из CoreRepository
	{
		return Model::class; //Model - для универсальности и быстрого переноса кода в другие классы
	}


	/**
	*	Возвращает gjcns для вывода пагинатором
	*	@param int | null $perPage
	*	@return Illuminate\Contracts\Pagination\LengthAwarePaginator
	*/
	public function getAllWithPaginate($perPage = null) {
		$columns = ['id', 'title', 'slug',
					'is_published', 'published_at',
					'user_id', 'category_id'];

		//$result = $this->startConditions()->select($columns)->orderBy('id', 'DESC')->paginate($perPage/*columns можно было передать и сюда*/);

		$result = $this->startConditions()
			->select($columns)
			->orderBy('id', 'DESC')
			//->with(['category', 'user'])
			->with(['category' => function ($query) {
						$query->select('id', 'title');
					},
					'user'     => function ($query) {
						$query->select('id', 'name');
					}
					//можно сделать так 'user:id,name'
			])
			->paginate($perPage);

		return $result;
	}

	/**
	*	Возвращает модель для редактирования в админке
	*	@param int $id
	*	@return Model
	*/
	public function getEdit($id)
	{
		return $this->startConditions()->find($id);
	}

	/**
	* Возвращает удаленную запись
	* @param int $id
	* @return Model
	*/
	public function getTrashedPost($id)
	{
		return $this->startConditions()->withTrashed()->find($id);
	}

}




?>