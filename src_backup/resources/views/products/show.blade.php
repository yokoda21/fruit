@extends('layouts.app')

@section('title', $product->name . ' - 商品詳細')

@section('content')
<div class="product-detail">
    <!-- パンくずリスト -->
    <nav class="breadcrumb" aria-label="パンくずリスト">
        <a href="{{ route('products.index') }}" class="breadcrumb-link">商品一覧</a> > <span class="breadcrumb-current">{{ $product->name }}</span>
    </nav>

    <h1 class="page-title">商品詳細</h1>

    <div class="detail-content">
        <!-- 商品画像 -->
        <div class="product-image-section">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
            @else
            <div class="no-image">画像なし</div>
            @endif
        </div>

        <!-- 商品情報表示 -->
        <div class="product-info-section">
            <div class="form-group">
                <label class="form-label">商品名</label>
                <p class="display-value">{{ $product->name }}</p>
            </div>

            <div class="form-group">
                <label class="form-label">値段</label>
                <p class="display-value">{{ $product->price }}</p>
            </div>

            <div class="form-group">
                <label class="form-label">季節</label>
                <div class="seasons-display">
                    @foreach($product->seasons as $season)
                    <span class="season-tag selected">{{ $season->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">商品説明</label>
                <p class="display-value description">{{ $product->description }}</p>
            </div>

            <!-- アクションボタン -->
            <div class="action-buttons">
                <a href="{{ route('products.index') }}" class="button button-back">戻る</a>
                <a href="{{ route('products.update', $product) }}" class="button button-update">変更を保存</a>

                <!-- 削除ボタン -->
                <form action="{{ route('products.delete', $product) }}" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button button-delete" aria-label="商品を削除">🗑</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection