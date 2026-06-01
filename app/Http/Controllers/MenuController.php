<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\StockLog;

class MenuController extends Controller
{
    // =========================
    // USER MENU
    // =========================
    public function index()
    {
        $menus = Menu::with('category')->get();
        $categories = Category::all();

        return view('menu.index', compact('menus', 'categories'));
    }

    // =========================
    // ADMIN MENU LIST
    // =========================
    public function adminIndex()
    {
        $menus = Menu::with('category')->get();

        return view('admin.menu', compact('menus'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        $categories = Category::all();

        return view('admin.menu.create', compact('categories'));
    }

    // =========================
    // STORE MENU
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imageName = null;

        // upload image
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $file->extension();

            $file->move(public_path('image'), $imageName);
        }

        // simpan menu
        $menu = Menu::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'harga_beli' => $validated['harga_beli'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'image' => $imageName ?? 'default.png',
        ]);

        // LOG AKTIVITAS
        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => $validated['stock'],
            'type' => 'in',
            'note' => 'Tambah Menu'
        ]);

        return redirect()
            ->route('admin.menu')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    // =========================
    // EDIT FORM
    // =========================
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        $categories = Category::all();

        return view('admin.menu.edit', compact(
            'menu',
            'categories'
        ));
    }

    // =========================
    // UPDATE MENU
    // =========================
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // update image
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $file->extension();

            $file->move(public_path('image'), $imageName);

            $menu->image = $imageName;
            $menu->save();
        }

        // update data
        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'harga_beli' => $request->harga_beli,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        // LOG AKTIVITAS
        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => $request->stock,
            'type' => 'in',
            'note' => 'Update Menu'
        ]);

        return redirect()
            ->route('admin.menu')
            ->with('success', 'Menu berhasil diupdate');
    }

    // =========================
    // DELETE MENU
    // =========================
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // LOG AKTIVITAS
        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => $menu->stock,
            'type' => 'out',
            'note' => 'Hapus Menu'
        ]);

        $menu->delete();

        return back()->with(
            'success',
            'Menu berhasil dihapus'
        );
    }

    // =========================
    // FILTER CATEGORY
    // =========================
    public function byCategory($id)
    {
        $menus = Menu::with('category')
            ->where('category_id', $id)
            ->get();

        $categories = Category::all();

        return view('menu.index', compact(
            'menus',
            'categories'
        ));
    }

    // =========================
    // EDIT IMAGE
    // =========================
    public function editImage()
    {
        $menus = Menu::all();

        return view('admin.menu.image', compact('menus'));
    }
    // =========================
    // UPDATE IMAGE
    // =========================
    public function updateImage(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {

            // hapus gambar lama
            if (
                $menu->image &&
                $menu->image != 'default.png' &&
                file_exists(public_path('image/' . $menu->image))
            ) {
                unlink(public_path('image/' . $menu->image));
            }

            $file = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('image'), $imageName);

            $menu->update([
                'image' => $imageName
            ]);
        }

        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => 0,
            'type' => 'in',
            'note' => 'Update Gambar Produk'
        ]);

        return back()->with(
            'success',
            'Gambar berhasil diupdate'
        );
    }

    // =========================
    // EDIT NAME
    // =========================
    public function editName()
    {
        $menus = Menu::all();

        return view('admin.menu.name', compact('menus'));
    }

    // =========================
    // UPDATE NAME
    // =========================
    public function updateName(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string'
        ]);

        $menu->name = $request->name;

        $menu->save();

        // LOG AKTIVITAS
        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => 0,
            'type' => 'in',
            'note' => 'Update Nama Produk'
        ]);

        return back()->with(
            'success',
            'Nama berhasil diupdate'
        );
    }

    // =========================
    // EDIT PRICE PAGE
    // =========================
    public function editPrice()
    {
        $menus = Menu::all();

        return view('admin.menu.price', compact('menus'));
    }

    // =========================
    // UPDATE PRICE
    // =========================
    public function updatePrice(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'price' => 'required|numeric'
        ]);

        $menu->price = $request->price;

        $menu->save();

        // LOG AKTIVITAS
        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => 0,
            'type' => 'in',
            'note' => 'Update Harga Jual'
        ]);

        return back()->with(
            'success',
            'Harga berhasil diupdate'
        );
    }

    // =========================
    // HALAMAN EDIT HARGA BELI
    // =========================
    public function editHargaBeli()
    {
        $menus = Menu::all();

        return view('admin.menu.harga_beli', compact('menus'));
    }

    // =========================
    // UPDATE HARGA BELI
    // =========================
    public function updateHargaBeli(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'harga_beli' => 'required|numeric|min:0'
        ]);

        $menu->update([
            'harga_beli' => $request->harga_beli
        ]);

        // LOG AKTIVITAS
        StockLog::create([
            'menu_id' => $menu->id,
            'qty' => 0,
            'type' => 'in',
            'note' => 'Update Harga Beli'
        ]);

        return back()->with(
            'success',
            'Harga beli berhasil diupdate'
        );
    }
    // =========================
    // VIEW CART
    // =========================
    public function viewCart()
    {
        // ambil cart dari session
        $cart = session()->get('cart', []);

        // hitung total
        $total = 0;

        foreach ($cart as $item) {

            $total += $item['price'] * $item['qty'];
        }

        // kirim ke view
        return view('cart.index', compact(
            'cart',
            'total'
        ));
    }
}
