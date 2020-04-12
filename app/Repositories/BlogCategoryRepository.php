<?php 


namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;


/**
*
*	Class BlogCategoryRepository
*	@package App\Repositories;
*
*/
class BlogCategoryRepository extends CoreRepository
{

	/**
	*	@return string
	*/
	protected function getModelClass() //реализация абстрактного метода из CoreRepository
	{
		return Model::class; //Model - для универсальности и быстрого переноса кода в другие классы
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
	*	Возвращает список категорий для вывода в выпадающем списке
	*	@return Collection
	*/
	public function getForComboBox()
	{
		//return $this->startConditions()->all();

		$columns = implode(', ', [
			'id',
			'CONCAT (id, ". ", title) AS id_title',
		]);

		//Разные варианты
		//$result[] = $this->startConditions()->all(); //избыточно
		//$result[] = $this->startConditions()->select('blog_categories.*',
		//	\DB::raw('CONCAT (id, ". ", title) AS id_title'))
		//	->toBase() //если мы это уберём, то получим коллекцию
		//	->get();

		$result = $this->startConditions()->selectRaw($columns)->toBase()->get();

		return $result;

	}


	/**
	*	Возвращает категории для вывода пагинатором
	*	@param int | null $perPage
	*	@return Illuminate\Contracts\Pagination\LengthAwarePaginator
	*/
	public function getAllWithPaginate($perPage = null) {
		$columns = ['id', 'title', 'parent_id'];

		$result = $this->startConditions()
					->select($columns)
					->with(['parentCategory:id,title'])
					->paginate($perPage/*columns можно было передать и сюда*/);

		return $result;
	}
}




?>