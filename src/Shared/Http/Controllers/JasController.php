<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers;

use DB;

final class JasController
{
    public function index()
    {
        return DB::table('jas_events')->get();
    }

    public function store()
    {
        $id = request()->input('id');
        $name = request()->input('name');
        $payload = request()->input('payload');
        $date = request()->input('date');

        DB::table('jas_events')->insert([
            'uuid' => $id,
            'name' => $name,
            'date' => $date,
            'payload' => json_encode($payload)
        ]);

        return response()->json([
            'created' => true
        ]);
    }
}
