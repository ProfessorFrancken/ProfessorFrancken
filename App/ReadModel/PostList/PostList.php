<?php

namespace App\ReadModel\PostList;

use Illuminate\Database\Eloquent\Model;

final class PostList extends Model
{
    protected $table = "posts";
    public $timestamps = false;

    protected $fillable = [
        "uuid",
        "title",
        "content",
        "type",
        "author_id",
        "published_at"
    ];

    protected $dates = [
        "published_at"
    ];

    public function scopeBlog($query)
    {
        return $query->where("type", "blog");
    }

    public function scopeNews($query)
    {
        return $query->where("type", "news");
    }

    public function scopePublished($query)
    {
        return $query->where("published_at", "<=", \Carbon::now());
    }
}
