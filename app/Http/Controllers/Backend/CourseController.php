<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use Carbon\Carbon;
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

    public function EditCourse($id){
        $course = Course::find($id);
        $goals = Course_goal::where('course_id', $id)->get();
        $cat = Category::latest()->get();
        $subcat = SubCategory::latest()->get();
        return view('instructor.courses.edit_courses',compact('course','cat','subcat', 'goals'));
    }

    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('sub_category_name','ASC')->get();
        return json_encode($subcat);
    }

    public function StoreCourse(Request $request){

        $request ->validate([
            'video' => 'required|mimes:mp4|max:10000',
        ]);

        //save image 
        if($request->file('course_image')){
        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$request->file('course_image')->getClientOriginalExtension();
        $img = $manager->read($request->file('course_image'));
        $img = $img->resize(370,246);

        $img->toJpeg(80)->save(base_path('public/upload/course/thumbnail/'.$name_gen));
        $save_url = 'upload/course/thumbnail/'.$name_gen;
        }

        //save video 
        $video = $request ->file('video');
        $videoName = time().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('upload/course/video/'),$videoName);
        $save_video = 'upload/course/video/'.$videoName;

        $course_id = Course::insertGetId([

                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'instructor_id' => Auth::user()->id,
                'course_title' => $request->course_title,
                'course_name' => $request->course_name,
                'course_name_slug' => strtolower(str_replace(' ','-', $request->course_name)),
                'description' => $request->description,
                'video' => $save_video,
                'course_image' => $save_url,

                'label' => $request->label,
                'duration' => $request->duration,
                'resources' => $request->resources,
                'certificate' => $request->certificate,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'prerequisites' => $request->prerequisites,

                'bestseller' => $request->bestseller,
                'featured' => $request->featured,
                'highestrated' => $request->highestrated,
                'status' => 1,
                'created_at' => Carbon::now(),

        ]);

        //Course Goals function
        $goals = Count($request->course_goals);
        if($goals != NULL){
            for ($i=0; $i < $goals; $i++) { 
                $gcount = new Course_goal();
                $gcount->course_id = $course_id;
                $gcount->goal_name = $request->course_goals[$i];
                $gcount->save();
            }
        }

        $notification = array(
            'message' => 'Course inserted successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.course')->with($notification);

    }

    public function UpdateCourse(Request $request){
   
                $course_id = $request->course_id;
                Course::find($course_id)->update([

                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'instructor_id' => Auth::user()->id,
                'course_title' => $request->course_title,
                'course_name' => $request->course_name,
                'course_name_slug' => strtolower(str_replace(' ','-', $request->course_name)),
                'description' => $request->description,


                'label' => $request->label,
                'duration' => $request->duration,
                'resources' => $request->resources,
                'certificate' => $request->certificate,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'prerequisites' => $request->prerequisites,

                'bestseller' => $request->bestseller,
                'featured' => $request->featured,
                'highestrated' => $request->highestrated,
                'updated_at' => Carbon::now(),

        ]);


        $notification = array(
            'message' => 'Course updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.course')->with($notification);

    }
    
    public function UpdateImageCourse(Request $request){
        $course_id = $request->cid;
        $oldImage = $request->old_img;

               //save image 
               if($request->file('course_image')){
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$request->file('course_image')->getClientOriginalExtension();
                $img = $manager->read($request->file('course_image'));
                $img = $img->resize(370,246);
        
                $img->toJpeg(80)->save(base_path('public/upload/course/thumbnail/'.$name_gen));
                $save_url = 'upload/course/thumbnail/'.$name_gen;
                }

                if(file_exists($oldImage)){
                    unlink($oldImage);
                }

                Course::find($course_id)->update([
                    'course_image' => $save_url,
                    'updated_at' => Carbon::now(),
                ]);

                $notification = array(
                    'message' => 'Course Image updated successfully',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);

    }

    public function UpdateVideoCourse(Request $request){
        $course_id = $request->cid;
        $oldVideo = $request->old_video;

        $request ->validate([
            'video' => 'required|mimes:mp4|max:10000',
        ]);

        //save video 
        $video = $request ->file('video');
        $videoName = time().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('upload/course/video/'),$videoName);
        $save_video = 'upload/course/video/'.$videoName;

        if(file_exists($oldVideo)){
            unlink($oldVideo);
        }

        Course::find($course_id)->update([
            'video' => $save_video,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Course video updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function UpdateGoalCourse(Request $request){
        $course_id = $request->cid;
        
        if ($request->course_goals == NULL) {
            return redirect()->back();
        } else {

                 Course_goal::where('course_id', $course_id)->delete();

                    //Course Goals function
                    $goals = Count($request->course_goals);     
                        for ($i=0; $i < $goals; $i++) { 
                            $gcount = new Course_goal();
                            $gcount->course_id = $course_id;
                            $gcount->goal_name = $request->course_goals[$i];
                            $gcount->save();
                        }
        }
        $notification = array(
            'message' => 'Course goals updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteCourse($id){
        $citem = Course::find($id);
        unlink($citem->course_image);
        unlink($citem->video);

        Course::find($id)->delete();

        $goalsData = Course_goal::where('course_id',$id)->get();
        foreach ($goalsData as $item) {
            $item->goal_name;
            Course_goal::where('course_id',$id)->delete();
        }

        $notification = array(
            'message' => 'Course Delete successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
