<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_contents', function (Blueprint $table) {
            $table->id();

            // BASEの商品ID
            $table->unsignedBigInteger('base_item_id')->unique();

            // 商品説明（HTML想定）
            $table->longText('description')->nullable();

            // サイズ（HTML or テキスト）
            $table->text('size')->nullable();

            $table->timestamps();

            // インデックス（検索高速化）
            $table->index('base_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_contents');
    }
};
