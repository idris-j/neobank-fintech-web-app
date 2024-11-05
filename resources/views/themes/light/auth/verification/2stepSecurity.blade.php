
@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')
    @include($theme.'partials.banner')
    <section class="login-signup-page">
        <div class="container">
            <div class="row g-lg-5 justify-content-between align-items-center">
                <div class="col-xl-5 col-md-6 order-2 order-md-1">
                    <div class="login-signup-form">
                        <form class="login-form" action="{{route('user.twoFA-Verify')}}"  method="post">
                            @csrf
                            <div class="login-signup-header">
                                <h4>@lang($page_title)</h4>
                                <div class="description">@lang('Enter Your Verification Code')</div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <input class="form-control @error('code') is-invalid @enderror"
                                           type="text" name="code" value="{{old('code')}}" placeholder="@lang('Code')"
                                           autocomplete="off" autofocus>
                                    @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                                <button type="submit" class="btn cmn-btn mt-30 w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 order-1 order-md-2 d-none d-md-block">
                    <div class="login-signup-thums">
                        <img src="{{ isset($user_verify->media->image_two)
                                ? getFile(@$user_verify->media->image_two->driver, @$user_verify->media->image_two->path)
                                : asset($themeTrue.'img/login-signup/login-signup.jpg') }}" alt="..."
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


