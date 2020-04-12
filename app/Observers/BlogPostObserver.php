<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{

    /**
     * Обработка ПЕРЕД созданием записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);        
        $this->setHtml($blogPost);
        $this->setUser($blogPost);
    }

    /**
     * Обработка ПОСЛЕ созданием записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    /**
     * Обработка ПЕРЕД обновлением записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {

//       $test[] = $blogPost->isDirty(); - Изменялась ли модель или нет
//       $test[] = $blogPost->isDirty('is_published'); - Изменялась ли нужное поле

//       $test[] = $blogPost->getAttribute('is_published'); - получить значение атрибута
//       $test[] = $blogPost->is_published; - получить значение атрибута
//       $test[] = $blogPost->getOriginal('is_published'); - получить старое значение

        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }

    /**
    * Если запись опубликована впервые, то устанавливаем дату на текущую
    *
    * @param BlogPost $blogPost
    */
    protected function setPublishedAt($blogPost) {
        if (empty($blogPost->published_at) && $blogPost->is_published) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
    * Если user_id не указан, то ставим значение по умолчанию
    *
    * @param BlogPost $blogPost
    */
    protected function setUser($blogPost) {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
    }

    /**
    * Установка значения полю content_html относительно content_raw
    *
    * @param BlogPost $blogPost
    */
    protected function setHtml($blogPost) {
        if ($blogPost->isDirty('content_raw')) {
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
    * Если слаг не указан, то генерируем новый
    *
    * @param BlogPost $blogPost
    */
    protected function setSlug(BlogPost $blogPost) {
        if (empty($blogPost->slug)) {
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }

    /**
     * Обработка ПОСЛЕ обновлением записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {
        //
    }

    /**
     * Обработка ПОСЛЕ мягким удалением записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Обработка ПОСЛЕ удалением записи
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
