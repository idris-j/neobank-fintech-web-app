@extends($theme.'layouts.user')
@section('title')
	{{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@push('style')
	<link href="{{ asset('assets/dashboard/css/stripe.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
    <div class="dashboard-wrapper">

        <div class="col-xxl-8 col-lg-10 mx-auto">
        <div class="breadcrumb-area"><h3 class="title">@yield('title')</h3></div>

                <div class="card p-0 my-2">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-3">
                                <img
                                    src="{{ getFile(optional($deposit->gateway)->driver, optional($deposit->gateway)->image) }}"
                                    class="card-img-top gateway-img">
                            </div>
                            <div class="col-md-6">
                                <h5 class="my-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
                                <form action="{{ $data->url }}" method="{{ $data->method }}">
                                    @csrf
                                    <script src="{{ $data->src }}" class="stripe-button"
                                            @foreach($data->val as $key=> $value)
                                                data-{{$key}}="{{$value}}"
                                        @endforeach>
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
    </div>
@endsection

@push('script')
	<script src="https://js.stripe.com/v3/"></script>
@endpush


