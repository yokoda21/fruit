@extends('layouts.app')

@section('title', '商品更新 - ' . $product->name)

@section('content')
<div class="product-detail">
    <!-- パンくずリスト -->
    <nav class="breadcrumb" aria-label="パンくずリスト">
        <a href="{{ route('products.index') }}" class="breadcrumb-link">商品一覧</a> > <span class="breadcrumb-current">{{ $product->name }}</span>
    </nav>

    <h1 class="page-title">商品更新</h1>

    <form action="{{ route('products.update.store', $product) }}" method="POST" enctype="multipart/form-data" class="update-form">
        @csrf
        @method('PUT')

        <div class="detail-content">
            <!-- 商品画像セクション -->
            <div class="product-image-section">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image" id="imagePreview">
                @else
                <div class="no-image" id="imagePreview">画像なし</div>
                @endif

                <!-- 画像アップロード -->
                <div class="image-upload">
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <label for="image" class="file-select-btn">ファイルを選択</label>
                    <span class="filename">{{ $product->image ? basename($product->image) : '画像なし' }}</span>
                </div>
                @error('image')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品情報セクション -->
            <div class="product-info-section">
                <!-- 商品名 -->
                <div class="form-group">
                    <label for="name" class="form-label">商品名</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $product->name) }}">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 値段 -->
                <div class="form-group">
                    <label for="price" class="form-label">値段</label>
                    <input type="number" name="price" id="price" class="form-input" value="{{ old('price', $product->price) }}">
                    @error('price')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 季節 -->
                <div class="form-group">
                    <label class="form-label">季節</label>
                    <div class="seasons-selection">
                        @foreach($allSeasons as $season)
                        <label class="season-checkbox">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                {{ (collect(old('seasons', $product->seasons->pluck('id')))->contains($season->id)) ? 'checked' : '' }}>
                            <span class="season-label">{{ $season->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('seasons')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- 商品説明（下部に独立配置） -->
        <div class="product-description-section">
            <div class="form-group">
                <label for="description" class="form-label">商品説明</label>
                <div class="description-box">
                    <textarea name="description" id="description" rows="5" class="form-textarea">{{ old('description', $product->description) }}</textarea>
                </div>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- アクションボタン（削除ボタンを削除） -->
        <div class="action-buttons">
            <a href="{{ route('products.show', $product) }}" class="button button-back">戻る</a>
            <button type="submit" class="button button-update">変更を保存</button>
        </div>
    </form>
</div>

<script>
    // 画像プレビュー機能
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー" class="product-image">`;
            }
            reader.readAsDataURL(input.files[0]);

            // ファイル名表示
            document.querySelector('.filename').textContent = input.files[0].name;
        }
    }
</script>
@endsection