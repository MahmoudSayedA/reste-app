<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        // Get and store the uploaded file from the request
        $imagePath = $request->file('image')->store('uploads/categories', 'public');

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return to_route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        // get the old image
        $image = $category->image;
        // check if new image added
        if ($request->hasFile('image')) {
            //delete the old
            File::delete($image);
            //save the new
            $image = $request->file('image')->store('uploads/categories', 'public');
        }
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
        ]);
        return to_route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Retrieve the category with the specified ID
        $category = Category::findOrFail($id);

        // Get the absolute path to the image file
        $imagePath = public_path('storage/' . $category->image);

        // Delete the image file from storage
        $cond = File::delete($imagePath);

        // delete record
        $category->delete();

        // Redirect back to the index page
        return to_route('admin.categories.index');
    }
}
