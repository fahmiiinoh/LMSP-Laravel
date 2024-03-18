@extends ('instructor.instructor_dashboard')
@section('instructor') 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add Course</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->

                <div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Add Course</h5>
								<form class="row g-3" action="{{route('store.category')}}" method="post" id="categoryForm" enctype="multipart/form-data">
                                    @csrf
									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Name</label>
										<input type="text" class="form-control" name="course_name" id="course_name" >
									</div>

									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Title</label>
										<input type="text" class="form-control" name="course_title" id="course_title" >
									</div>

									<div class="form-group col-md-6">
										<label for="input2" class="form-label">Course Image</label>
										<input type="file" class="form-control" name="course_image" id="course_image" >
									</div>

                                    <div class="col-md-6">
                                    <img id="showImage" src="{{url('upload/no_image.jpg')}}" alt="" class="rounded-circle p-1 bg-primary" width="100">
                                    </div>

                                    <div class="form-group col-md-6">
										<label for="input2" class="form-label">Course Introduction Video</label>
										<input type="file" class="form-control" name="video" id="video" accept="video/mp4, video/webm">
									</div>

                                    <div class="form-group col-md-6">
                                    </div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Category</label>
                                        <select class="form-select mb-3" name="category_id" aria-label="Default select example">
                                        <option selected="" disabled>Select a category</option>
                                        @foreach ( $categories as $catlist )
                                        <option value="{{$catlist->id}}">{{$catlist->category_name}}</option>
                                        @endforeach

                                        </select>

									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Sub Category</label>
                                        <select class="form-select mb-3" name="sub_category_id" aria-label="Default select example">
                                        <option></option>
                                        </select>

									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Certificate</label>
                                        <select class="form-select mb-3" name="certificate" aria-label="Default select example">
                                        <option selected="" disabled>Choose yes or no</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                        </select>
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Label</label>
                                        <select class="form-select mb-3" name="label" aria-label="Default select example">
                                        <option selected="" disabled>Choose yes or no</option>
                                        <option value="Beginner">Beginner-level</option>
                                        <option value="Intermediate">Intermediate-level</option>
                                        <option value="Advanced">Advanced-level</option>
                                        </select>
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Course Price</label>
										<input type="text" class="form-control" name="selling_price" id="selling_price" >
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Discount Price</label>
										<input type="text" class="form-control" name="discount_price" id="discount_price" >
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Duration</label>
										<input type="text" class="form-control" name="duration" id="duration" >
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Resources</label>
										<input type="text" class="form-control" name="resources" id="resources" >
									</div>

                                    <div class="form-group col-md-12">
										<label for="input1" class="form-label">Course Pre-requisite</label>
										<textarea class="form-control" name="prerequisites" id="prerequisites" rows="3"></textarea>
									</div>

                                    <div class="form-group col-md-12">
										<label for="input1" class="form-label">Description</label>
										<textarea class="form-control" name="description" id="myeditorinstance" ></textarea>
									</div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="bestseller" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Best Seller</label>
							            	</div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="featured" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Featured</label>
							            	</div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="highestrated" value="1" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">Highest Rated</label>
							            	</div>
                                        </div>

                                    </div>
			
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
						</div>

			</div>

            <script type="text/javascript">
    $(document).ready(function (){
        $('#categoryForm').validate({
            rules: {
                category_name: {
                    required : true,
                }, 
                category_image: {
                    required : true,
                }, 
                
            },
            messages :{
                category_name: {
                    required : 'Please Enter Course Name',
                }, 
                category_image: {
                    required : 'Please Enter Course Image',
                }, 
                 

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $('#category_image').change(function(e){
                        var reader = new FileReader();
                        reader.onload = function(e){
                            $('#showImage').attr('src',e.target.result);
                        }
                        reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

<script type="text/javascript">
        
        $(document).ready(function(){
            $('select[name="category_id"]').on('change', function(){
                var category_id = $(this).val();
                if (category_id) {
                    $.ajax({
                        url: "{{ url('/subcategory/ajax') }}/"+category_id,
                        type: "GET",
                        dataType:"json",
                        success:function(data){
                            $('select[name="sub_category_id"]').html('');
                            var d =$('select[name="sub_category_id"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="sub_category_id"]').append('<option value="'+ value.id + '">' + value.sub_category_name + '</option>');
                            });
                        },

                    });
                } else {
                    alert('danger');
                }
            });
        });

  </script>



@endsection