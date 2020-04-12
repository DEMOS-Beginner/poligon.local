<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BlogCategory extends Model
{

	use SoftDeletes;
	const ROOT = 1;

    protected $fillable = [
    	'title',
    	'slug',
    	'parent_id',
    	'description'
    ];

    /**
    * Возвращает родительскую категорию
    */
    public function parentCategory() {
    	//Эта категория принадлежит родительской id = parent_id
    	return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
    * Возвращает название родительской категории
    */
    public function getParentTitleAttribute() {
    	$title = $this->parentCategory->title ?? ($this->isRoot() ? 'Корень' : '??');

    	return $title;
    }

    public function isRoot() {
    	return $this->id === BlogCategory::ROOT;
    }

}
