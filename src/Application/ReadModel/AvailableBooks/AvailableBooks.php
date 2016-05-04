<?php

namespace Francken\Application\ReadModel\AvailableBooks;

use Illuminate\Database\Eloquent\Model;


final class AvailableBooks extends Model
{
    protected $table = "available_books";
    public $timestamps = false;

    protected $fillable = ["title", "content", "isbn", "price"];
}
