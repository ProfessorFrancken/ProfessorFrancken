<?php

namespace Francken\Application\Books;

use Illuminate\Database\Eloquent\Model;


final class AvailableBooks extends Model
{
    protected $table = "all_books";

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ["id", "title", "authors", "price", "isbn", "path_to_cover", "price", "state"];
 
    public function scopeAvailable($query)
    {
        return $query->where("state", "available");
    }

    public function scopePending($query)
    {
        return $query->where("state", "available");
    }
}
