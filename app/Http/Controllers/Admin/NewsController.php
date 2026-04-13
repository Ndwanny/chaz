<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.form', ['news' => null, 'action' => route('admin.news.store')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'tag'          => 'required|string|max:100',
            'author'       => 'required|string|max:150',
            'excerpt'      => 'required|string|max:500',
            'content'      => 'required|string',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data['slug'] = Str::slug($data['title']);
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        News::create($data);
        return redirect()->route('admin.news.index')->with('success', 'News article created successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.form', ['news' => $news, 'action' => route('admin.news.update', $news)]);
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'tag'          => 'required|string|max:100',
            'author'       => 'required|string|max:150',
            'excerpt'      => 'required|string|max:500',
            'content'      => 'required|string',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        if ($data['status'] === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News article deleted.');
    }
}
