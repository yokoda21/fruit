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

            <!-- 画像アップロード（画像下に配置） -->
            <div class="image-upload">
                <a href="{{ route('products.update', $product) }}" class="file-select-btn">ファイルを選択</a>
                <span class="filename">image01.jpeg</span>
            </div>
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
                <div class="seasons-selection">
                    @php
                    $productSeasons = $product->seasons->pluck('name')->toArray();
                    $allSeasons = ['春', '夏', '秋', '冬'];
                    @endphp
                    @foreach($allSeasons as $season)
                    <label class="season-checkbox">
                        <input type="checkbox" name="seasons[]" value="{{ $season }}"
                            {{ in_array($season, $productSeasons) ? 'checked' : '' }} disabled>
                        <span class="season-label">{{ $season }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 商品説明（下部に独立配置） -->
    <div class="product-description-section">
        <div class="form-group">
            <label class="form-label">商品説明</label>
            <div class="description-box">
                <p class="display-value description">{{ $product->description }}</p>
            </div>
        </div>
    </div>

    <!-- アクションボタン -->
    <div class="action-buttons">
        <a href="{{ route('products.index') }}" class="button button-back">戻る</a>
        <a href="{{ route('products.update', $product) }}" class="button button-update">変更を保存</a>

        <!-- 削除ボタン -->
        <form action="{{ route('products.delete', $product) }}" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？')">
            @csrf
            @method('DELETE')
            <button type="submit" class="button button-delete" aria-label="商品を削除">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 9.33325H22.6667V7.99992C22.6667 6.52792 21.472 5.33325 20 5.33325H10.6667C9.19471 5.33325 8.00004 6.52792 8.00004 7.99992V9.33325H6.66671C5.93071 9.33325 5.33337 9.93058 5.33337 10.6666C5.33337 11.4026 5.93071 11.9999 6.66671 11.9999V22.6666C6.66671 25.6079 9.05871 27.9999 12 27.9999H18.6667C21.608 27.9999 24 25.6079 24 22.6666V11.9999C24.736 11.9999 25.3334 11.4026 25.3334 10.6666C25.3334 9.93058 24.736 9.33325 24 9.33325ZM10.6667 7.99992H20V9.33325H10.6667V7.99992ZM21.3334 22.6666C21.3334 24.1386 20.1387 25.3333 18.6667 25.3333H12C10.528 25.3333 9.33337 24.1386 9.33337 22.6666V11.9999H21.3334V22.6666ZM11.3334 13.9999C10.9667 13.9999 10.6667 14.2999 10.6667 14.6666V22.6666C10.6667 23.0333 10.9667 23.3333 11.3334 23.3333C11.7 23.3333 12 23.0333 12 22.6666V14.6666C12 14.2999 11.7 13.9999 11.3334 13.9999ZM14 13.9999C13.6334 13.9999 13.3334 14.2999 13.3334 14.6666V22.6666C13.3334 23.0333 13.6334 23.3333 14 23.3333C14.3667 23.3333 14.6667 23.0333 14.6667 22.6666V14.6666C14.6667 14.2999 14.3667 13.9999 14 13.9999ZM16.6667 13.9999C16.3 13.9999 16 14.2999 16 14.6666V22.6666C16 23.0333 16.3 23.3333 16.6667 23.3333C17.0334 23.3333 17.3334 23.0333 17.3334 22.6666V14.6666C17.3334 14.2999 17.0334 13.9999 16.6667 13.9999ZM19.3334 13.9999C18.9667 13.9999 18.6667 14.2999 18.6667 14.6666V22.6666C18.6667 23.0333 18.9667 23.3333 19.3334 23.3333C19.7 23.3333 20 23.0333 20 22.6666V14.6666C20 14.2999 19.7 13.9999 19.3334 13.9999Z" fill="#FD0707" />
                </svg>
            </button>


        </form>
    </div>
</div>
@endsection