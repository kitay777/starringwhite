<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recommend_items', function (Blueprint $table) {
            // BASEの商品ID（NULL = 全商品共通）
            $table
                ->string('base_item_id', 50)
                ->nullable()
                ->after('id')
                ->comment('BASEの商品ID。NULLは共通おすすめ');

            // 検索用インデックス（任意だが推奨）
            $table->index('base_item_id');
        });
    }

    public function down(): void
    {
        Schema::table('recommend_items', function (Blueprint $table) {
            $table->dropIndex(['base_item_id']);
            $table->dropColumn('base_item_id');
        });
    }
};
