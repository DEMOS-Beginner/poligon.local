<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
    * @var BlogCategoryRepository;
    */
    private $blogCategoryRepository;

    public function __construct() {
        parent::__construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
        //$paginator = BlogCategory::paginate(5); //получаем объекта пагинатора
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);


        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory(); // exists = false
        $categoriesList = $this->blogCategoryRepository->getForComboBox();

        //Стоит сделать отдельную вьюху
        return view('blog.admin.categories.edit', compact('item', 'categoriesList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input(); //input для разнообразия, можно использовать all

/*      Ушло в обсервер
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }*/

        //Создаст новый объект, но не добавит его в бд
        //$item = new BlogCategory($data);
        //dd($item);
        //$item->save();

        //Создаст и добавит в БД
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])->with(['success'=>'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    { 
        //$item = BlogCategory::findOrFail($id);
        //$categoriesList = BlogCategory::all();

        //Ларавел сделал сам:
        //либо $categoryRepository = new BlogCategoryRepository();
        //либо $categoryRepository = app(BlogCategoryRepository::class); - аналог того, что лара сделает сам
        //но теперь мы заменили это свойством класса



        $item = $this->blogCategoryRepository->getEdit($id); //получить запись для редактирования
        if (empty($item)) {
            abort(404);
        }

        $categoriesList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item', 'categoriesList'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {

        //$validatedData = $this->validate($request, $rules);
        //$validatedData = $request->validate($rules);

        //есть способ вручную породить класс Validator, тогда можно получить больше настроек


        //dd($validatedData);

        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return back()->withErrors(['msg'=>"Запись c id = $id не найдена"])->withInput();
        }

        $data = $request->all();
/* Ушло в обсервер       if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }*/

        $result = $item->fill($data)->save(); //МОЖНО ПРОСТО $ITEM->UPDATE($DATA);

        if ($result) {
            return redirect()->route('blog.admin.categories.edit', $item->id)->with(['success'=>'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg'=>"Ошибка сохранения"])->withInput();           
        }
    }


}
