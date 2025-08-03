@extends('layouts.app')
@section('title', '商品一覧 - mogitate')
@section('content')
<div class="products-index">
    <div class="page-header">
        <h1 class="page-title">
            @if(isset($searchTerm) && $searchTerm)
            "{{ $searchTerm }}"の商品一覧
            @else
            商品一覧
            @endif
        </h1>
        <a href="{{ route('products.register') }}" class="add-product-button">+ 商品を追加</a>
    </div>

    <div class="main-layout">
        <!-- 左側：検索コントロール -->
        <div class="search-controls">
            <form action="{{ route('products.search') }}" method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="商品名で検索" value="{{ $searchTerm ?? '' }}">
                <button type="submit" class="search-button">検索</button>

                <!-- 並び替え -->
                <div class="sort-controls">
                    <label for="sort_order" class="sort-label">価格順で表示</label>
                    <select name="sort_order" id="sort_order" class="sort-select" onchange="this.form.submit()">
                        <option value="">選択してください</option>
                        <option value="high_to_low" {{ (isset($sortOrder) && $sortOrder=== 'high_to_low') ? 'selected' : '' }}>高い順に表示</option>
                        <option value="low_to_high" {{ (isset($sortOrder) && $sortOrder=== 'low_to_high') ? 'selected' : '' }}>低い順に表示</option>
                    </select>
                </div>
            </form>

            <!-- 並び替えタグ表示 -->
            @if(isset($sortOrder) && $sortOrder)
            <div class="sort-tags">
                @if($sortOrder === 'high_to_low')
                <span class="sort-tag">高い順に表示
                    <a href="{{ route('products.search', ['search' => $searchTerm ?? '']) }}" class="tag-remove">×</a>
                </span>
                @elseif($sortOrder === 'low_to_high')
                <span class="sort-tag">低い順に表示
                    <a href="{{ route('products.search', ['search' => $searchTerm ?? '']) }}" class="tag-remove">×</a>
                </span>
                @endif
            </div>
            @endif
        </div>

        <!-- 右側：商品グリッド -->
        <div class="products-grid">
            @forelse($products as $product)
            <article class="product-card">
                <a href="{{ route('products.show', $product) }}" class="product-link">
                    <div class="product-image">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-img">
                        @else
                        <div class="no-image">画像なし</div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="product-price">¥{{ ($product->price) }}</p>
                    </div>
                </a>
            </article>
            @empty
            <p class="no-products-message">商品が見つかりませんでした。</p>
            @endforelse
        </div>
    </div>

    <!-- ページネーション -->
    @if($products->hasPages())
    <div class="pagination-wrapper">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection