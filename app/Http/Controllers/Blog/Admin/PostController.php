<?php

namespace App\Http\Controllers\Blog\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Blog\Admin\BaseController;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use Illuminate\Support\Str;
use App\Models\BlogPost;

class PostController extends BaseController
{


    /**
    * @var blogPostRepository
    */
    private $blogPostRepository;

    /**
    * @var blogCategoryRepository
    */
    private $blogCategoryRepository;

    /**
    * PostController constructor
    */
    public function __construct() {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
        $this->blogPostRepository = app(BlogPostRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate(25);
        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->all();
        $item = (new BlogPost())->create($data);
        if ($item) {
            return redirect()->route('blog.admin.posts.edit', [$item->id])->with(['success'=>'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg'=>"Ошибка сохранения"])->withInput();           
        }       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\BlogPostUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return back()->withErrors(['msg'=>"Запись с id = $id не найдена"])->withInput();
        }

        $data = $request->all();

/*    УШЛО В OBSERVER
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($item->published_at) && $data['is_published']) {
            $data['published_at'] = \Carbon\Carbon::now();
        }*/

        $result = $item->update($data);
        if ($result) {
            return redirect()->route('blog.admin.posts.edit', $item->id)->with(['success'=>'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg'=>"Ошибка сохранения"])->withInput();           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //софт-удаление
        $result = BlogPost::destroy($id);

        //Полное удаление
        //$result = BlogPost::find($id)->forceDelete();

        if ($result) {
            return redirect()->route('blog.admin.posts.index')->with(['success'=>"Запись $id удалена", 'restore'=>$id]);
        return back()->withErrors(['msg'=>'Ошибка удаления']);
    }

    /**
     * Restore the specified resource to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {

        $item = $this->blogPostRepository->getTrashedPost($id);
        $result = $item->restore();

        if ($result) {
            return redirect()->route('blog.admin.posts.index')->with(['success'=>"Запись $id восстановлена"]);
        return back()->withErrors(['msg'=>'Ошибка удаления']);
    }
}
