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

    public function EditCategory($id){

        $category = Category::find($id);
        return view('admin.backend.category.edit_category',compact('category'));

    }

    public function UpdateCategory(Request $request){

        $cat_id = $request->id;
        if($request->file('category_image')){

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('category_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('category_image'));
            $img = $img->resize(370,246);

            $img->toJpeg(80)->save(base_path('public/upload/category/'.$name_gen));
            $save_url = 'upload/category/'.$name_gen;

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
                'image' =>$save_url,
            ]);

            $notification = array(
                'message' => 'Category Updated with image successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.category')->with($notification);

        }else{

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)), 
            ]);

            $notification = array(
                'message' => 'Category Updated without successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.category')->with($notification);

        }

    }

    public function DeleteCategory($id){

        $rowitem = Category::find($id);
        $image = $rowitem->image;
        unlink($image);

        Category::find($id)->delete();

        $notification = array(
            'message' => 'Category Delete successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}
