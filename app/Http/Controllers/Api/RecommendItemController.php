<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecommendItem;
use Illuminate\Http\Request;

class RecommendItemController extends Controller
{
public function index(Request $r)
{
    $itemId   = $r->query('item_id');
    $callback = $r->query('callback');
    $limit    = 8; // 表示最大数（調整可）

    $items = collect();

    if ($itemId) {
        // ① 商品別おすすめ（最優先）
        $itemSpecific = RecommendItem::where('base_item_id', $itemId)
            ->orderBy('sort_order')
            ->get([
                'id',
                'base_item_id',
                'title',
                'image_url',
                'url',
            ]);

        $items = $items->concat($itemSpecific);
    }

    // ② 共通おすすめを後ろに追加
    $common = RecommendItem::whereNull('base_item_id')
        ->orderBy('sort_order')
        ->get([
            'id',
            'base_item_id',
            'title',
            'image_url',
            'url',
        ]);

    $items = $items
        ->concat($common)
        // ③ URLで重複除外（idでもOK）
        ->unique('url')
        // ④ 件数制限
        ->take($limit)
        ->values();

    $json = $items->toJson(JSON_UNESCAPED_UNICODE);

    if ($callback) {
        return response("$callback($json);")
            ->header('Content-Type', 'application/javascript; charset=utf-8');
    }

    return response($json)
        ->header('Content-Type', 'application/json; charset=utf-8');
}





    // 管理用一覧
    public function showAll()
    {
        return RecommendItem::orderBy('sort_order')->get();
    }

    // 登録
    public function store(Request $request)
    {
        $data = $request->validate([
            'base_item_id' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:500',
            'url' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $item = RecommendItem::create($data);
        return response()->json($item, 201);
    }

    // 更新
    public function update(Request $request, RecommendItem $recommend_item)
    {
        $data = $request->validate([
            'base_item_id' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:500',
            'url' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
        ]);

        $recommend_item->update($data);
        return response()->json($recommend_item);
    }

    // 削除
    public function destroy(RecommendItem $recommend_item)
    {
        $recommend_item->delete();
        return response()->noContent();
    }
}
