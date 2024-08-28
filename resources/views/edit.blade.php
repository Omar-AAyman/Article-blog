<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries">
    </script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
</head>

<body class="font-sans antialiased ">

    {{-- <div class="container">
        <h1>{{ $article->title }}</h1>
        <h1>{{ $article->article }}</h1>
        <div>
            @foreach($article->images as $image)
            <img src="{{ asset('storage/images/' . $image->path) }}" alt="Article Image">
            @endforeach
        </div>
    </div> --}}

    <div class="max-w-md mx-auto bg-slate-100 rounded-lg p-4 mt-12">
        <form action="{{ route('articles.update', ['id' => $article->id]) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="mb-6">
                <label for="messa   ge" class="block mb-2 text-l font-medium text-gray-900 ">Article Title</label>

                <input type="text" name="title" value="{{ $article->title }}"
                    class="bg-gray-50 border w-full border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 ">

                @error('title')
                <div class=" text-red-500 rounded-l	">{{ $message }}</div>
                @enderror

            </div>
            <div class="mb-6">
                <label for="message" class="block mb-2 text-l font-medium text-gray-900 ">
                    Article</label>
                <textarea id="message" rows="4" name="articleContent"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 "
                    placeholder="Write your article here.. But be creative when writing!">{{ $article->articleContent }}</textarea>
                @error('articleContent')
                <div class=" text-red-500  rounded-l ">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div>

                <input type="file" class="filepond" name="image" multiple credits="false" src="" />
                @error('image')
                <div class="	 text-red-500  rounded-l">{{ $message }}
                </div>
                @enderror
            </div>

            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                Submit
            </button>
            <a href="{{ route('articles.index') }}"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">Cancel</a>





            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js">
            </script>
            <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

            <script>
                FilePond.registerPlugin(FilePondPluginImagePreview);
                // Get a reference to the file input element
                const inputElement = document.querySelector('input[type="file"]');

                // Create a FilePond instance
                const pond = FilePond.create(inputElement);

                FilePond.setOptions({
                    server: {
                    process: '/upload',
                    revert: './delete',
                    headers: {
                    'x-CSRF-TOKEN': '{{ csrf_token() }}'}
                    },
                    });
            </script>
</body>

</html>
