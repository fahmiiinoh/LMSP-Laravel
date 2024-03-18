<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal; 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function AllCourse(){
        $id = Auth::user()->id;
        $courses = Course::where('instructor_id',$id)->orderBy('id','desc')->get();

        return view('instructor.courses.all_courses',compact('courses'));
    }

    public function AddCourse(){
        $categories = Category::latest()->get();

        return view('instructor.courses.add_courses',compact('categories'));
    }

    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('sub_category_name','ASC')->get();
        return json_encode($subcat);
    }
}
