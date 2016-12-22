@extends('layouts.app')

@section('title', 'Profile settings')

@section('styles')

@endsection

@section('content')

<div class="wrapper wrapper-content">
     <div class="row">
         <div class="col-md-8 col-md-offset-2">
             <div class="panel panel-default">
                 <div class="panel-heading">Update password</div>
                 <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/profile/reset_password') }}">
                         {{ csrf_field() }}
                         {{ method_field('PUT') }}
                         @if (count($errors) > 0)
                                  <!-- Form Error List -->
                                  <div class="alert alert-danger">
                                      <strong>Whoops! Something went wrong!</strong>
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @endif

                         <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                             <label for="name" class="col-md-4 control-label">Username</label>

                             <div class="col-md-6">
                                 <input id="name" type="email" class="form-control" name="username" value="{{ Auth::user()->username }}" required>

                                 @if ($errors->has('username'))
                                     <span class="help-block">
                                         <strong>{{ $errors->first('username') }}</strong>
                                     </span>
                                 @endif
                             </div>
                         </div>


                         <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                             <label for="password" class="col-md-4 control-label">New password</label>

                             <div class="col-md-6">
                                 <input id="password" type="password" class="form-control" name="password" required>

                                 @if ($errors->has('password'))
                                     <span class="help-block">
                                         <strong>{{ $errors->first('password') }}</strong>
                                     </span>
                                 @endif
                             </div>
                         </div>

                         <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                             <label for="password-confirm" class="col-md-4 control-label">Confirm new password</label>

                             <div class="col-md-6">
                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                 @if ($errors->has('password_confirmation'))
                                     <span class="help-block">
                                         <strong>{{ $errors->first('password_confirmation') }}</strong>
                                     </span>
                                 @endif
                             </div>
                         </div>

                         <div class="form-group">
                             <div class="col-md-6 col-md-offset-4">
                                 <button type="submit" class="btn btn-primary">
                                     Update security
                                 </button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
</div>


@endsection


@section('scripts')


@endsection