<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductenExtrasLegacyTable extends Migration
{
	protected $connection = 'francken-legacy';

	/**
	 * Run the migrations.
	 */
	public function up() : void
	{
		if (Schema::connection('francken-legacy')->hasTable('producten_extras')) {
			return;
		}

		Schema::connection('francken-legacy')->create('producten_extras', function (Blueprint $table) : void {
			$table->integer('product_id')->primary();
			$table->string('splash_afbeelding')->nullable();
			$table->string('kleur', 9)->nullable()->comment('kleur in hexcode');
		});
	}
}
