<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
        ]);

        //Store Background Image
        $path = 'images/category/';
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 755, true);
        }
        $image = $request->background_image;
        $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
        Image::make(file_get_contents($image))->resize(400, 450)->save($path . $image_name);

        //Store Other info
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->icon = $request->icon;
        $category->background = $request->background;
        $category->background_image = $path . $image_name;
        $category->meta = json_encode([
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);
        $category->save();

        Toastr::success('Category added successfully :)', 'Success');
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
        ]);

        //Store Background Image
        $path = 'images/category/';
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 755, true);
        }


        //Store Other info
        $category = Category::findOrFail($request->category_id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->icon = $request->icon;
        $category->background = $request->background;
        $category->meta = json_encode([
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        // Update Background Image
        $image = $request->background_image;
        if ($image) {
            if (file_exists(public_path($request->old_image))) {
                unlink(public_path($request->old_image));
            }
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            Image::make(file_get_contents($image))->resize(400, 450)->save($path . $image_name);
            $category->background_image = $path . $image_name;
        }
        $category->update();
        Toastr::success('Category Updated successfully :)', 'Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if (file_exists(public_path($category->background_image))) {
            unlink($category->background_image);
        }
        $category->delete();
        Toastr::success('Category deleted successfully :)', 'Success');
        return redirect()->route('admin.category.index');
    }
}
