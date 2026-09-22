<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('categoryId');
            $table->unsignedBigInteger('subcategoryid')->default(0);
            $table->string('categoryname')->nullable();
            $table->string('slugname')->nullable();
            $table->string('photo')->nullable();
            $table->integer('strSequence')->default(0);
            $table->string('strGST')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('strIP')->nullable();
            $table->tinyInteger('iStatus')->default(1);
            $table->tinyInteger('isDelete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
