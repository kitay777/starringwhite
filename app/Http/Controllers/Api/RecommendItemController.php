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

    if ($itemId) {
        // ① 商品別おすすめを最優先
        $items = RecommendItem::where('base_item_id', $itemId)
            ->orderBy('sort_order')
            ->get([
                'id',
                'base_item_id',
                'title',
                'image_url',
                'url',
            ]);

        // ② 商品別が「0件」のときだけ共通おすすめ
        if ($items->isEmpty()) {
            $items = RecommendItem::whereNull('base_item_id')
                ->orderBy('sort_order')
                ->get([
                    'id',
                    'base_item_id',
                    'title',
                    'image_url',
                    'url',
                ]);
        }
    } else {
        // item_id が無い場合（トップなど）
        $items = RecommendItem::whereNull('base_item_id')
            ->orderBy('sort_order')
            ->get([
                'id',
                'base_item_id',
                'title',
                'image_url',
                'url',
            ]);
    }

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
