<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 6件ずつ表示する定数
    private const ITEMS_PER_PAGE = 6;

    /**
     * 商品一覧画面
     * URL: GET /products
     */
    public function index(Request $request)
    {
        $productsQuery = Product::with('seasons');

        // 6件ずつページネーション
        $products = $productsQuery->paginate(self::ITEMS_PER_PAGE);

        return view('products.index', compact('products'));
    }

    /**
     * 商品検索・並び替え機能
     * URL: GET /products/search
     */
    public function search(Request $request)
    {
        $productsQuery = Product::with('seasons');
        $searchTerm = $request->input('search');
        $sortOrder = $request->input('sort_order');

        // 商品名での部分一致検索
        if ($searchTerm) {
            $productsQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        // 価格での並び替え
        if ($sortOrder === 'high_to_low') {
            $productsQuery->orderBy('price', 'desc');
        } elseif ($sortOrder === 'low_to_high') {
            $productsQuery->orderBy('price', 'asc');
        }

        // 6件ずつページネーション
        $products = $productsQuery->paginate(self::ITEMS_PER_PAGE);

        // 検索パラメータをページネーションに追加
        $products->appends($request->query());

        return view('products.index', compact('products', 'searchTerm', 'sortOrder'));
    }

    /**
     * 商品詳細画面
     * URL: GET /products/{product}
     */
    public function show(Product $product)
    {
        $product->load('seasons');
        return view('products.show', compact('product'));
    }

    /**
     * 商品登録画面表示
     * URL: GET /products/register
     */
    public function register()
    {
        $allSeasons = Season::all();
        return view('products.register', compact('allSeasons'));
    }

    /**
     * 商品登録処理
     * URL: POST /products/register
     */
    public function store(ProductStoreRequest $request)
    {
        $newProduct = new Product($request->only(['name', 'price', 'description']));

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $newProduct->image = $imagePath;
        }

        $newProduct->save();

        // 季節の関連付け
        if ($request->has('seasons')) {
            $newProduct->seasons()->attach($request->seasons);
        }

        return redirect()->route('products.index')->with('success', '商品が登録されました');
    }

    /**
     * 商品更新画面表示
     * URL: GET /products/{product}/update
     */
    public function update(Product $product)
    {
        $allSeasons = Season::all();
        $product->load('seasons');
        return view('products.update', compact('product', 'allSeasons'));
    }

    /**
     * 商品更新処理
     * URL: PUT /products/{product}/update
     */
    public function updateStore(ProductUpdateRequest $request, Product $product)
    {
        // 画像アップロード処理
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update($request->only(['name', 'price', 'description']));

        // 季節の関連付け更新
        $product->seasons()->sync($request->seasons ?? []);

        return redirect()->route('products.index')->with('success', '商品が更新されました');
    }

    /**
     * 商品削除処理
     * URL: DELETE /products/{product}/delete
     */
    public function delete(Product $product)
    {
        // 画像削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', '商品が削除されました');
    }
}
