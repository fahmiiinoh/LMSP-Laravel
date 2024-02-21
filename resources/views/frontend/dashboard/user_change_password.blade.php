@extends('frontend.dashboard.user_dashboard')
@section('userdashboard')

<div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between mb-5">
    <div class="media media-card align-items-center">
        <div class="media-img media--img media-img-md rounded-full">
            <img class="rounded-full" src="{{  (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg')}}" alt="Student thumbnail image">
        </div>
        <div class="media-body">
            <h2 class="section__title fs-30">Howdy, {{$profileData->name}}</h2>
            <div class="rating-wrap d-flex align-items-center pt-2">
                <div class="review-stars">
                    <span class="rating-number">4.4</span>
                    <span class="la la-star"></span>
                    <span class="la la-star"></span>
                    <span class="la la-star"></span>
                    <span class="la la-star"></span>
                    <span class="la la-star-o"></span>
                </div>
                <span class="rating-total pl-1">(20,230)</span>
            </div><!-- end rating-wrap -->
        </div><!-- end media-body -->
    </div><!-- end media -->
</div><!-- end breadcrumb-content -->


                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                    <div class="setting-body">
                        <h3 class="fs-17 font-weight-semi-bold pb-4">Change Password</h3>
                        <form method="POST" class="row" action="{{route ('user.password.update')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-box col-lg-12">
                                <label class="label-text">Old Password</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('old_password') is-invalid @enderror" type="password" name="old_password" id="old_password" placeholder="Old Password">
                                    <span class="la la-lock input-icon"></span>
                                    @error('old_password')
                                        <span class="text-danger"> {{$message}} </span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->
                            <div class="input-box col-lg-12">
                                <label class="label-text">New Password</label>
                                <div class="form-group">
                                    <input class="form-control form--control @error('new_password') is-invalid @enderror" type="password" name="new_password" id="new_password" placeholder="New Password">
                                    <span class="la la-lock input-icon"></span>
                                    @error('new_password')
                                        <span class="text-danger"> {{$message}} </span>
                                    @enderror
                                </div>
                            </div><!-- end input-box -->
                            <div class="input-box col-lg-12">
                                <label class="label-text">Confirm New Password</label>
                                <div class="form-group">
                                    <input class="form-control form--control" type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm New Password">
                                    <span class="la la-lock input-icon"></span>
                                </div>
                            </div><!-- end input-box -->
                            <div class="input-box col-lg-12 py-2">
                                <button type="submit" class="btn theme-btn">Change Password</button>
                            </div><!-- end input-box -->
                        </form>
                        </div><!-- end setting-body -->
                </div><!-- end tab-pane -->
            </div><!-- end tab-content -->

        </form>

@endsection