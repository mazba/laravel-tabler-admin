@extends('layouts.auth')
@section('content')
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="text-center mb-4">
                <a href="{{url('/')}}"><img src="{{asset('static/logo-small.png')}}" height="36" alt=""></a>
            </div>
            <form class="card card-md" action="{{route('login.submit')}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Login to <b>{{env('APP_NAME')}}</b></h2>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            <span class="form-label-description">
                </span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input name="password" type="password" class="form-control password" placeholder="Password" autocomplete="off">
                            <span class="input-group-text">
                              <a href="#" class="link-secondary show-password" title="Show password"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                          d="M0 0h24v24H0z"
                                                                                          fill="none"/><circle cx="12"
                                                                                                               cy="12"
                                                                                                               r="2"/><path
                                        d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                              </a>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            @if(isset ($errors) && count($errors) > 0)
                                <div class="alert alert-danger" role="alert">
                                    <ul class="list-unstyled">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('.show-password').click(function (){
                if($('.password').attr('type')=='text') {
                    $('.password').attr('type', 'password');
                    $('.show-password').attr('title','Show Password');
                }
                else{
                    $('.password').attr('type','text');
                    $('.show-password').attr('title','Hide Password');
                    setTimeout(function (){
                        $('.password').attr('type','password');
                        $('.show-password').attr('title','Show Password');
                    },5000);
                }

            });
        });
    </script>
@endsection
