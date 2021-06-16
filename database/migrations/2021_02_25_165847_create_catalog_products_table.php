<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('catalog_categories');

            $table->text('description')->nullable();
            $table->integer('sort')->default(500);
            $table->decimal('price',11,2);
            $table->decimal('new_price',11,2)->nullable();
            $table->integer('discount')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_products');
    }
}
