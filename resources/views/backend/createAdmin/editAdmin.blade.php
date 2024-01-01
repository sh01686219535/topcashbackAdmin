@extends('backend.layouts.app')
@section('title')
Edit Admin
@endsection
@section('content')
<div class="container customer-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-head mx-5 my-3 customer-card">
                    <div class="left">
                        <h3>Admin Edit</h3>
                    </div>
                    <div class="search">
                        <a href="{{ route('adminList') }}" class="btn btn-primary" title="Add Category">
                        <i class="fa-sharp fa-solid fa-list"></i>
                        Admin List</a>
                    </div>
                </div>
            </div>
            @include('error')
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-8">
                        <form action="{{ route('editAdmin',$test->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name"><strong>Name</strong></label>
                                <input type="text" id="name" name="name" value="{{ $test->name }}" class="form-control my-2">
                            </div>
                            <div class="form-group">
                                <label for="name"><strong>Email</strong></label>
                                <input type="text" id="email" name="email" value="{{ $test->email }}" class="form-control my-2">
                            </div>
                            <div class="form-group">
                                <label for="mobile"><strong>Mobile</strong></label>
                                <input type="text" id="mobile" value="{{ $test->phone }}" name="phone" class=" form-control my-2">
                            </div>
                            <div class="form-group">
                                <label for="name"><strong>Password</strong></label>
                                <input type="password" value="{{ $test->password }}" id="password" name="password" class="form-control my-2">
                            </div>
                            <div class="form-group">
                                <label for="image"><strong>Image</strong></label>
                                <input type="file" id="image" value="{{ $test->image }}" name="image" class="form-control my-2">
                            </div>
                            <label for="roles">Choose a Role:</label>
                            <select id="roles" name="user_role" class="form-control">
                                @foreach($adminCreate as $roles)
                                <option value="{{ $roles->id }}">
                                    {{ $roles->role_name }}
                                </option>

                            @endforeach

                            </select>
                            <input type="submit" value="Update" class="btn btn-primary my-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
