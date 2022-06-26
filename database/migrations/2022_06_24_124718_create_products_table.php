<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->bigInteger('product_code')->index()->comment('уникальный id товара');
            $table->string('name');
            $table->json('images')->nullable();
            $table->decimal('price', $precision = 8, $scale = 2);
            $table->decimal('original_price', $precision = 8, $scale = 2);
            $table->string('state')->comment('состояние');
            $table->string('serial_number')->unique()->index()->comment('серийный номер');
            $table->string('stock')->comment('cклад');
            $table->string('active', 20)->comment('активный(yes,no)');
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
};
