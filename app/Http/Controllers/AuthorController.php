<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::latest()->paginate(10);
        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'required|image|max:2048',
            'is_popular' => 'nullable'
        ]);

        $data = $request->only('name', 'is_popular');
        $data['is_popular'] = $request->has('is_popular') ? true : false;
        
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $destination = public_path('uploads/authors');

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $filename);
            $data['profile_photo'] = 'uploads/authors/'.$filename;
        }

        Author::create($data);

        return redirect()->route('admin.authors.index')->with('success', 'Author created successfully.');
    }

    public function show(Author $author)
    {
        return view('admin.authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
            'is_popular' => 'nullable'
        ]);

        $data = $request->only('name', 'is_popular');
        $data['is_popular'] = $request->has('is_popular') ? true : false;

        if ($request->hasFile('profile_photo')) {
            if ($author->profile_photo && file_exists(public_path($author->profile_photo))) {
                unlink(public_path($author->profile_photo));
            }

            $file = $request->file('profile_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $destination = public_path('uploads/authors');

            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $filename);
            $data['profile_photo'] = 'uploads/authors/'.$filename;
        }


        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        if ($author->profile_photo && file_exists(public_path($author->profile_photo))) {
            unlink(public_path($author->profile_photo));
        }
        $author->delete();


        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully.');
    }
}