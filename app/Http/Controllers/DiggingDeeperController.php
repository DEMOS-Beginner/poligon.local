<?php 


namespace App\Http\Controllers;

use App\Models\BlogPost;


class DiggingDeeperController extends Controller
{

	/**
	* Коллекции - наборы данных, реализуют базовые методы для работы с ними.
	*/
	public function collections()
	{
		$result = [];

		$eloquentCollection = BlogPost::withTrashed()->get();
		dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

	}

}

?>