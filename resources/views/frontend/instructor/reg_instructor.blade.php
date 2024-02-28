@extends('frontend.master')
@section('home')

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area section-padding img-bg-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between">
            <div class="section-heading">
                <h2 class="section__title text-white">Become An Instructor</h2>
            </div>
            <ul class="generic-list-item generic-list-item-white generic-list-item-arrow d-flex flex-wrap align-items-center">
                <li><a href="index.html">Home</a></li>
                <li>Pages</li>
                <li>Become An Instructor</li>
            </ul>
        </div><!-- end breadcrumb-content -->
    </div><!-- end container -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<div class="section-block"></div>

<!--======================================
        START REGISTER AREA
======================================-->
<section class="register-area section--padding dot-bg overflow-hidden">
    <div class="container">
        <div class="register-heading-content-wrap text-center">
            <div class="section-heading">
                <h2 class="section__title">Fill Up this Form to Join with Us</h2>
            </div><!-- end section-heading -->
        </div>
        <div class="row pt-50px">
            <div class="col-lg-10 mx-auto">
                <div class="card card-item">
                    <div class="card-body">


                        <form method="post" action="{{route('instructor.register')}}" enctype="multipart/form-data" class="row">
                            @csrf

                            <div class="input-box col-lg-6">
                                <label class="label-text">Name</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('name') is invalid @enderror" type="text" name="name" placeholder="e.g. Louis">
                                    <span class="la la-user input-icon"></span>
                                    @error('name') 
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->

                            <div class="input-box col-lg-6">
                                <label class="label-text">User Name</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('username') is invalid @enderror" type="text" name="username" placeholder="e.g. LouisH">
                                    <span class="la la-user input-icon"></span>
                                    @error('username') 
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->

                            <div class="input-box col-lg-6">
                                <label class="label-text">Email Address</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('email') is invalid @enderror" type="email" name="email" placeholder="e.g. alexsmith@gmail.com">
                                    <span class="la la-envelope input-icon"></span>
                                    @error('email') 
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->

                            <div class="input-box col-lg-6">
                                <label class="label-text">Phone</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('phone') is invalid @enderror" type="text" name="phone" placeholder="123456789">
                                    <span class="la la-phone input-icon"></span>
                                    @error('phone') 
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->


                            <div class="input-box col-lg-12">
                                <label class="label-text">Address</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('address') is invalid @enderror" type="text" name="address" placeholder="e.g. 12345 East Los Santos">
                                    <span class="la la-map-marker input-icon"></span>
                                    @error('address') 
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->

                            <div class="input-box col-lg-12">
                                <label class="label-text">Password</label>
                                <div class="form-group">
                                    <input class="form-control form--control" type="password" name="password">
                                    <span class="la la-lock input-icon"></span>
                                </div>
                            </div><!-- end input-box -->


                            <div class="btn-box col-lg-12">
                                <div class="custom-control custom-checkbox mb-4 fs-15">
                                    <input type="checkbox" class="custom-control-input" id="agreeCheckbox" required>
                                    <label class="custom-control-label custom--control-label" for="agreeCheckbox">by signing i agree to the
                                        <a href="terms-and-conditions.html" class="text-color hover-underline">terms and conditions</a> and
                                        <a href="privacy-policy.html" class="text-color hover-underline">privacy policy</a>
                                    </label>
                                </div><!-- end custom-control -->
                                <button class="btn theme-btn" type="submit">Apply Now <i class="la la-arrow-right icon ml-1"></i></button>
                            </div><!-- end btn-box -->
                        </form>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col-lg-10 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end register-area -->
<!--======================================
        END REGISTER AREA
======================================-->


@endsection