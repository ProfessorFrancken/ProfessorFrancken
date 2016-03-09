<?php

namespace App\ReadModel\MemberList;

use Illuminate\Database\Eloquent\Model;

final class MemberList extends Model
{
    protected $table = "members";
    public $timestamps = false;
    public $incrementing = false; 
}
