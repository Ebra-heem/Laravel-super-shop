<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('p_name');
            $table->string('p_code')->unique();
            $table->string('p_price');
            $table->string('p_sku');
            $table->string('p_unit')->default('kg')->nullable();
            $table->string('p_photo')->default('profile.png')->nullable();
            $table->mediumText('p_detail')->nullable();
            $table->tinyInteger('p_status');
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
        Schema::dropIfExists('products');
    }
}
