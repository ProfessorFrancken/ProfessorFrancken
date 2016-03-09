<?php

namespace App\ReadModel\CommitteesList;

use Illuminate\Database\Eloquent\Model;

final class CommitteesList extends Model
{
    protected $table = "committees_list";
    protected $casts = [
    	'committee_members' => 'array'
    ];

    protected $appends =['committee_members'];

    public $timestamps = false;
}
