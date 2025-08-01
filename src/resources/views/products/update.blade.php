@extends('layouts.app')

@section('title', '商品更新 - ' . $product->name)

@section('content')
<div class="product-update">
    <!-- パンくずリスト -->
    <nav class="breadcrumb" aria-label="パンくずリスト">
        <a href="{{ route('products.index') }}" class="breadcrumb-link">商品一覧</a> > <span class="breadcrumb-current">{{ $product->name }}</span>
    </nav>

    <h1 class="page-title">商品更新</h1>

    <div class="form-content">
        <!-- 商品画像プレビュー -->
        <div class="image-section">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="current-image" id="imagePreview">
            @else
            <div class="no-image" id="imagePreview">画像なし</div>
            @endif

            <div class="image-upload">
                <input type="file" name="image" id="imageInput" class="file-input" accept="image/png,image/jpeg,image/jpg" onchange="previewImage(this)">
                <label for="imageInput" class="file-label">ファイルを選択</label>
                <span class="filename">{{ $product->image ? basename($product->image) : '' }}</span>
            </div>
            @error('image')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品情報フォーム -->
        <div class="form-section">
            <form action="{{ route('products.update.store', $product) }}" method="POST" enctype="multipart/form-data" class="update-form">
                @csrf
                @method('PUT')

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
                    <div class="seasons-group">
                        @foreach($allSeasons as $season)
                        <label class="season-option">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}" class="season-checkbox"
                                {{ (collect(old('seasons', $product->seasons->pluck('id')))->contains($season->id)) ? 'checked' : '' }}>
                            <span class="season-label">{{ $season->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('seasons')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 商品説明 -->
                <div class="form-group">
                    <label for="description" class="form-label">商品説明</label>
                    <textarea name="description" id="description" rows="5" class="form-textarea">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 画像アップロード（hiddenで送信） -->
                <input type="file" name="image" id="hiddenImageInput" class="hidden-input">

                <!-- アクションボタン -->
                <div class="action-buttons">
                    <a href="{{ route('products.show', $product) }}" class="button button-back">戻る</a>
                    <button type="submit" class="button button-update">変更を保存</button>

                    <!-- 削除ボタン -->
                    <button type="button" class="button button-delete" onclick="deleteProduct()" aria-label="商品を削除">🗑</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 削除用フォーム -->
<form id="deleteForm" action="{{ route('products.delete', $product) }}" method="POST" class="hidden-form">
    @csrf
    @method('DELETE')
</form>

<script>
    // 画像プレビュー機能
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = `<img src="${e.target.result}" alt="プレビュー" class="current-image">`;
            }
            reader.readAsDataURL(input.files[0]);

            // hiddenの方にも同じファイルを設定  
            document.getElementById('hiddenImageInput').files = input.files;

            // ファイル名表示
            document.querySelector('.filename').textContent = input.files[0].name;
        }
    }

    // 削除機能
    function deleteProduct() {
        if (confirm('本当に削除しますか？')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection