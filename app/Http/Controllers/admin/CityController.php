<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::latest()->get();
        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
        ]);

         //Store Background Image
        $path = 'images/city/';
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 755, true);
        }
        $image = $request->background_image;
        $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
        Image::make(file_get_contents($image))->resize(400, 450)->save($path . $image_name);

        $city = new City();
        $city->name = $request->name;
        $city->slug = $request->slug;
        $city->is_major = $request->is_major ?? 0;
        $city->population = $request->population;
        $city->background_image = $path . $image_name;
        $city->meta = json_encode([
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);
        $city->save();

        Toastr::success('City Successfully Saved :)', 'Success');
        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $city = City::findOrFail($request->city_id);
        $city->name = $request->name;
        $city->slug = $request->slug;
        $city->is_major = $request->is_major ?? 0;
        $city->population = $request->population;
        $city->meta = json_encode([
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        //Update Background Image
        if ($request->hasFile('background_image')) {
           if (file_exists(public_path($request->old_image))) {
                unlink(public_path($request->old_image));
            }
            $path = 'images/city/';
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 755, true);
            }
            $image = $request->background_image;
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            Image::make(file_get_contents($image))->resize(400, 450)->save($path . $image_name);
            $city->background_image = $path . $image_name;
        }
        $city->update();

        Toastr::success('City Successfully Updated :)', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        if (file_exists($city->background_image)) {
            unlink($city->background_image);
        }
        $city->delete();
        Toastr::success('City Successfully Deleted :)', 'Success');
        return redirect()->back();
    }
}
