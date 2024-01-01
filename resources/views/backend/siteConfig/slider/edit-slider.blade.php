@extends('backend.layouts.app')
@section('title')
    Edit Slider
@endsection
@section('content')

    <div class="container customer-container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2">
                    <div class="card-head mx-5 my-3 customer-card">
                        <div class="left">
                            <h3>Slider Update</h3>
                        </div>
                        <div class="search">
                            <a href="{{route('slider')}}" class="btn btn-primary" title="Add Category" >
                                <i class="fa-sharp fa-solid fa-list"></i>
                                Slider List</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-8">
                            <form action="{{route('update.slider')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="slider_id" value="{{$slider->id}}">
                                <div class="form-group">
                                    <label for="position"><strong>Position</strong></label>
                                    <input type="text" id="position" name="position" value="{{$slider->position}}" placeholder="Position will be here..(1,2,3)" class="form-control my-2">
                                </div>
                                <div class="form-group">
                                    <label for="image"><strong>Image</strong></label>
                                    <input type="file" class="form-control my-2" name="image" id="image"/>
                                    <img id="showImage" src="{{asset($slider->image)}}" alt="" class="image-style mb-3">
                                </div>
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush




