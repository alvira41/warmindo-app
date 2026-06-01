<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }
    public function destroy($id)
    {
        Category::destroy($id);
        return back()->with('success', 'Kategori berhasil dihapus');
    }
    public function create()
    {
        $categories = Category::all(); // 🔥 ini wajib
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
        return redirect()->route('admin.category.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }
}
