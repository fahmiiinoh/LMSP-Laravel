<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    //Category Section
    public function AllCategory(){

        $category = Category::latest()->get();
        return view('admin.backend.category.all_category',compact('category'));

    } //End Method
    
    public function AddCategory(){
        return view('admin.backend.category.add_category');
    }

    //add function
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
                'message' => 'Category Updated without image successfully',
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

    //SubCategory Section
    public function AllSubCategory(){

        $subcategory = SubCategory::latest()->get();
        return view('admin.backend.subcategory.all_sub_category',compact('subcategory'));

    } //End Method

    public function AddSubCategory(){

        $category = Category::latest()->get();
        return view('admin.backend.subcategory.add_sub_category', compact('category'));

    } //End Method

    public function StoreSubCategory(Request $request){

        SubCategory::insert([

            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
            'sub_category_slug' => strtolower(str_replace(' ','-',$request->sub_category_name)), 

        ]);

        $notification = array(
            'message' => 'SubCategory Inserted successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.sub.category')->with($notification);

    }

    public function EditSubCategory($id){
        $category = Category::latest()->get();
        $subcategory = SubCategory::find($id);
        return view('admin.backend.subcategory.edit_sub_category',compact('category','subcategory'));
    }

    public function UpdateSubCategory(Request $request){

        $subcat_id = $request->id;
        SubCategory::find($subcat_id)->update([
            'category_id' => $request->category_id,
            'sub_category_name' => $request->sub_category_name,
            'sub_category_slug' => strtolower(str_replace(' ','-',$request->sub_category_name)), 
        ]);

        $notification = array(
            'message' => 'SubCategory Updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.sub.category')->with($notification);
    }

    public function DeleteSubCategory($id){

        SubCategory::find($id)->delete();

        $notification = array(
            'message' => 'SubCategory Delete successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}
