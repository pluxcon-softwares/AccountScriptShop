@extends('user.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-user"></i> Your Profile
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <form data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
            
                                <div class="item form-group">
                                    <label class="col-form-label">Registered Date</label>
                                    <input type="text" value="{{ $user->created_at->diffForHumans() }}" disabled  class="form-control">
                                </div>
            
                                <div class="item form-group">
                                    <label class="col-form-label">Username</label>
                                    <input type="text" value="{{ $user->username }}" disabled  class="form-control">
                                </div>
            
                                <div class="item form-group">
                                    <label class="col-form-label">Email</label>
                                    <input type="text" value="{{ $user->email }}" disabled  class="form-control">
                                </div>
            
                                <div class="item form-group">
                                    <label class="col-form-label">Balance</label>
                                    <input type="text" value="${{ $user->wallet ? $user->wallet : '0.00' }}" disabled  class="form-control">
                                </div>
            
                            </form>
                        </div>

                        <div class="col-6">
                            <form method="POST" action="{{ route('change.password') }}">
                                <!-- CSRF Form Field -->
                                @csrf
        
                                <div class="item form-group">
                                    <label class="col-form-label" for="old_password">Current Password <span class="required">*</span>
                                    </label>
                                    <input type="password" placeholder="Old Password" name="old_password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : ''}}">

                                        @if ($errors->has('old_password'))
                                        <span class="badge badge-danger">{{ $errors->first('old_password') }}</span>
                                        @endif
                                </div>
        
                                <div class="item form-group">
                                    <label class="col-form-label" for="new_password">New Password <span class="required">*</span>
                                    </label>
                                    <input type="password" name="new_password" placeholder="New Password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : ''}}">
                                        @if ($errors->has('new_password'))
                                        <li class="badge badge-danger">{{ $errors->first('new_password') }}</li>
                                        @endif
                                </div>
        
                                <div class="item form-group">
                                    <label class="col-form-label" for="new_password_confirmation">Confirm Password <span class="required">*</span>
                                    </label>
                                    <input type="password" name="new_password_confirmation" placeholder="Verfiy Password" class="form-control">
                                </div>
        
                                <div class="item form-group">
                                    <button type="submit" class="btn btn-success fa-pull-right">Change Password</button>
                                </div>
        
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra_script')
    <script>
        $(function(){

        });
    </script>
@endsection
