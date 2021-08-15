<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_category')->unsigned();
            $table->string('name');
            $table->string('price');
            $table->string('description')->nullable();
            $table->integer('stock');
            $table->double('discount')->nullable();
            $table->string('name_img');
            $table->string('url_img');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('id_category')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
