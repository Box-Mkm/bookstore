<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;

class CategoriesController extends Controller
{
    public function result(Category $category)
    {
        $books = $category->books()->paginate(12);
        $title = 'books for ' . $category->name;
        return view('gallery', compact('books', 'title'));
    }
    public function list(Category $category)
    {
        $categories = Category::all()->sortBy('name');
        $title = 'categories';
        return view('categories.index', compact('categories', 'title'));
    }
    public function search(Request $request)
    {
        $categories = Category::where('name', 'like', "%{$request->term}")->get()->sortBy('name');
        $title = 'search results for ' . $request->term;
        return view('categories.index', compact('categories', 'title'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
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
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        session()->flash('flash_message', 'category added');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
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
    public function update(Request $request, Category $category)
    {
        $this->validate($request, ['name' => 'required']);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        session()->flash('flash_message', 'category edited');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('flash_message', 'category deleted');
        return redirect(route('gallery.categories.index'));
    }
}
