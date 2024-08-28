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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries">
    </script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />

</head>

<body class="font-sans antialiased ">
    <div class="container">

        <table class="table table-striped">

            <thead>
                <th>ID</th>
                <th>Article Title</th>
                <th>Article Content</th>
                <th>Images Count</th>
                <th>Actions</th>
            </thead>
            @forelse ($articles as $article)
            <tbody>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->articleContent }}</td>
                    <td>{{ $imagesCount }}</td>
                    <td>
                        <a href="{{ route('articles.edit', ['id' => $article->id]) }}"
                            class="btn btn-outline-warning btn-sm btn-rounded">Edit</a>

                        <form action="{{ route('articles.delete', ['id' => $article->id]) }}" class="d-inline"
                            method="post">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-outline-danger btn-sm btn-rounded"> Delete</button>

                        </form>
                    </td>


            </tbody>

            @empty
            <tr class="bg-danger"> {{ 'There are no items here!' }} </tr>
            @endforelse

        </table>


        <a href="{{ route('articles.create') }}" class="btn btn-success btn-sm btn-rounded">Create an Article</a>
    </div>

    {{--
    <?php dd($articles) ?> --}}
</body>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

</html>
