<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function AllCategory(){

        $category = Category::latest()->get();
        return view('admin.backend.category.all_category',compact('category'));

    } //End Method

    public function AddCategory(){
        return view('admin.backend.category.add_category');
    }

    public function StoreCategory(Request $request){

        if($request->file('category_image')){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('category_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('category_image'));
            $img = $img->resize(370,246);

            $img->toJpeg(80)->save(base_path('public/upload/category/'.$name_gen));
            $save_url = 'upload/category/'.$name_gen;

            Category::insert([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
                'image' =>$save_url,
            ]);

        }

        $notification = array(
            'message' => 'Category inserted successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.category')->with($notification);

    }
}
