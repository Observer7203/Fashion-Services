@extends('layouts.admin')

@section('title', 'Редактирование главной страницы')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Редактирование главной страницы</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.homepage.update') }}" method="POST">
        @csrf

        <!-- Slides -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Слайды</h2>
            <div id="slides">
                @foreach($homepage->slides ?? [] as $i => $slide)
                    <div class="slide-item border p-4 mb-4 bg-white shadow">
                        <label>Фон (URL, картинка или видео):</label>
                        <input type="text" name="slides[{{ $i }}][bg]" value="{{ $slide['bg'] ?? '' }}" class="input w-full mb-2">
                        <input type="file" onchange="uploadFile(this, 'slides[{{ $i }}][bg]')" class="mb-2">
                        <label>Заголовок:</label>
                        <input type="text" name="slides[{{ $i }}][title]" value="{{ $slide['title'] ?? '' }}" class="input w-full mb-2">
                        <label>Подзаголовок:</label>
                        <input type="text" name="slides[{{ $i }}][subtitle]" value="{{ $slide['subtitle'] ?? '' }}" class="input w-full mb-2">
                        <label>Описание:</label>
                        <textarea name="slides[{{ $i }}][description]" class="input w-full mb-2">{{ $slide['description'] ?? '' }}</textarea>
                        <label>Текст кнопки:</label>
                        <input type="text" name="slides[{{ $i }}][button_text]" value="{{ $slide['button_text'] ?? '' }}" class="input w-full mb-2">
                        <label>Ссылка кнопки:</label>
                        <input type="text" name="slides[{{ $i }}][button_url]" value="{{ $slide['button_url'] ?? '' }}" class="input w-full mb-2">
                        <button type="button" onclick="this.closest('.slide-item').remove()" class="text-red-600 hover:underline">Удалить</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addSlide()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Добавить слайд</button>
        </div>

        <!-- About -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Блок "Обо мне"</h2>
            <label>Фон (URL):</label>
            <input type="text" name="about_bg" value="{{ $homepage->about_bg }}" class="input w-full mb-2">
            <input type="file" onchange="uploadFile(this, 'about_bg')" class="mb-2">
            <label>Текст:</label>
            <textarea name="about_text" class="input w-full h-40">{{ $homepage->about_text }}</textarea>
        </div>

        <div class="flex justify-between mt-6">
            <button type="submit" class="bg-black text-white py-2 px-6 rounded hover:bg-gray-800" style="border: 1px, solid, blue; color: blue;">Сохранить</button>
        </div>
    </form>
</div>

<style>
.input {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 8px;
    margin-bottom: 10px;
}
</style>

<script>
function addSlide() {
    const index = document.querySelectorAll('#slides .slide-item').length;
    const slideHTML = `
        <div class="slide-item border p-4 mb-4 bg-white shadow">
            <label>Фон (URL):</label>
            <input type="text" name="slides[${index}][bg]" class="input w-full mb-2">
            <input type="file" onchange="uploadFile(this, 'slides[${index}][bg]')" class="mb-2">
            <label>Заголовок:</label>
            <input type="text" name="slides[${index}][title]" class="input w-full mb-2">
            <label>Подзаголовок:</label>
            <input type="text" name="slides[${index}][subtitle]" class="input w-full mb-2">
            <label>Описание:</label>
            <textarea name="slides[${index}][description]" class="input w-full mb-2"></textarea>
            <label>Текст кнопки:</label>
            <input type="text" name="slides[${index}][button_text]" class="input w-full mb-2">
            <label>Ссылка кнопки:</label>
            <input type="text" name="slides[${index}][button_url]" class="input w-full mb-2">
            <button type="button" onclick="this.closest('.slide-item').remove()" class="text-red-600 hover:underline">Удалить</button>
        </div>
    `;
    document.getElementById('slides').insertAdjacentHTML('beforeend', slideHTML);
}

function uploadFile(input, targetFieldName) {
    const file = input.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    fetch('{{ route('admin.upload') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    }).then(response => response.json())
      .then(data => {
          document.querySelector(`input[name="${targetFieldName}"]`).value = data.url;
      }).catch(error => {
          alert('Ошибка загрузки файла');
          console.error(error);
      });
}
</script>
@endsection
