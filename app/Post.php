<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\TagResource;
use Carbon\Carbon;

class Post extends Model
{
    /** プライマリキー(id)の型 */
    protected $keyType = 'string';

    protected $perPage = 6;

    protected $attributes = [
        // バリデーションでnullableにした方がいいかもしれない
        'abstract' => "",
        'thumbnail' => "",
    ];

    /** JSONに含める属性 */
    protected $visible = [
        'id', 'title', 'category_id', 'category', 'thumbnail', 'abstract', 'body', 'comments', 'tags',
        'created_at', 'updated_at'
    ];

    /**
     * リレーションシップ - categoriesテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * リレーションシップ - commentsテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    /**
     * リレーションシップ - tagsテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'tagmaps');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("Y/m/d");
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("Y/m/d");
    }
}
