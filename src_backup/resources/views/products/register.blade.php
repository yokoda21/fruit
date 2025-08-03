@extends('layouts.app')

@section('title', '商品登録 - mogitate')

@section('content')
<div class="product-register">
    <h1 class="page-title">商品登録</h1>

    <div class="form-content">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="register-form">
            @csrf

            <!-- 商品名 -->
            <div class="form-group">
                <label for="name" class="form-label">商品名 <span class="required-indicator">必須</span></label>
                <input type="text" name="name" id="name" class="form-input" placeholder="商品名を入力" value="{{ old('name') }}">
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 値段 -->
            <div class="form-group">
                <label for="price" class="form-label">値段 <span class="required-indicator">必須</span></label>
                <input type="number" name="price" id="price" class="form-input" placeholder="値段を入力" value="{{ old('price') }}">
                @error('price')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品画像 -->
            <div class="form-group">
                <label for="image" class="form-label">商品画像 <span class="required-indicator">必須</span></label>
                <div class="image-upload-section">
                    <!-- 画像プレビュー -->
                    <div class="image-preview" id="imagePreview">
                        <div class="no-image">画像を選択してください</div>
                    </div>

                    <!-- ファイル選択 -->
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" class="file-input" accept="image/png,image/jpeg,image/jpg" onchange="previewImage(this)">
                        <label for="image" class="file-label">ファイルを選択</label>
                        <span class="filename"></span>
                    </div>
                </div>
                @error('image')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 季節 -->
            <div class="form-group">
                <label class="form-label">季節 <span class="required-indicator">必須</span> <span class="multiple-note">複数選択可</span></label>
                <div class="seasons-group">
                    @foreach($allSeasons as $season)
                    <label class="season-option">
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}" class="season-checkbox"
                            {{ (collect(old('seasons'))->contains($season->id)) ? 'checked' : '' }}>
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
                <label for="description" class="form-label">商品説明 <span class="required-indicator">必須</span></label>
                <textarea name="description" id="description" rows="5" class="form-textarea" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                <div class="character-count">
                    <span id="charCount">0</span>/120文字
                </div>
                @error('description')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- アクションボタン -->
            <div class="action-buttons">
                <a href="{{ route('products.index') }}" class="button button-back">戻る</a>
                <button type="submit" class="button button-register">登録</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 画像プレビュー機能
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = `<img src="${e.target.result}" alt="プレビュー" class="preview-image">`;
            }
            reader.readAsDataURL(input.files[0]);

            // ファイル名表示
            document.querySelector('.filename').textContent = input.files[0].name;
        }
    }

    // 文字数カウント機能
    document.getElementById('description').addEventListener('input', function() {
        const charCount = this.value.length;
        document.getElementById('charCount').textContent = charCount;

        // 120文字を超えた場合は警告色に
        const countElement = document.getElementById('charCount');
        if (charCount > 120) {
            countElement.style.color = 'red';
        } else {
            countElement.countElement.style.color = 'inherit';
        }
    });
</script>
@endsection