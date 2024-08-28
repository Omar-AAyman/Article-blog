<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\TemporaryImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        //Get product's data from DB
        $articles = Article::with('images')->get();
        $imagesCount = 0;
        foreach ($articles as $article) {
            foreach ($article->images as $image) {
                $imagesCount++;
            }
        }
        return view('index', compact('articles', 'imagesCount'));
    }
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'articleContent' => 'required'
        ]);

        $temporaryImages = TemporaryImage::all();
        if ($validator->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect(route('articles.create'))->withErrors($validator)->withInput();
        }

        $article = Article::create($validator->validated());
        foreach ($temporaryImages as $temporaryImage) {
            Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file);
            Image::create([
                'article_id' => $article->id,
                'name' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }
        return redirect(route('articles.index'));
    }

    public function edit(Request $request, $id)
    {
        $article = Article::with('images')->find($id);        // $images = $article->images; // Access the related images

        return view('edit', compact('article'));
    }


    public function update(Request $request, $id)
    {



        // Validation
        $data = $request->validate(
            [
                'title' => ['required', 'string', 'max:32', 'unique:articles,title'],
                'articleContent' => ['required', 'string', 'max:255'],
            ]
        );

        $data = $request->only('title', 'article', 'image');

        DB::table('articles')->where('id', $id)->update($data);

        return redirect()->route('articles.index');
    }

    public function destroy(Request $request, $id)
    {




        $articles = Article::with('images')->get();        // $images = $article->images; // Access the related images
        // Then, delete the article


        foreach ($articles as $article) {
            foreach ($article->images as $image) {

                if ($image && file_exists(public_path('storage/images/' . $image->path))) {
                    unlink(public_path('storage/images/' . $image->path));
                    Storage::deleteDirectory('images/tmp/' . $image->path);
                }
            }
        }


        $article = Article::with('images')->find($id)->delete();
        return redirect()->route('articles.index');
    }
}
