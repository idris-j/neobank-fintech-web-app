@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection


@section('content')

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>

    <div class="dashboard-wrapper">
        <div class="col-xxl-8 col-lg-10 mx-auto">
        <div class="breadcrumb-area"><h3 class="title">@yield('title')</h3></div>
            <div class="card">
                <div class="card-body ">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="card">
                                <img
                                    src="{{getFile(optional($deposit->gateway)->driver, optional($deposit->gateway)->image)}}"
                                    class="card-img-top gateway-img" alt="..">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <h4 class="my-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h4>
                            <h4 class="">@lang('To Get') {{getAmount($deposit->amount)}}  {{ $deposit->payment_method_currency }}</h4>

                            <br><br>
                            <div class="sdk">
                                <button class="btn btn-rounded btn-primary btn-block text-start"
                                        onclick="checkout()">@lang('Pay Now')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function checkout() {
            CinetPay.setConfig({
                apikey: '{{optional($deposit->gateway)->parameters->apiKey}}',//   YOUR APIKEY
                site_id: '{{optional($deposit->gateway)->parameters->site_id}}',//YOUR_SITE_ID
                notify_url: '{{route('ipn', [$deposit->gateway->code, $deposit->trx_id])}}',
                return_url: '{{route('success')}}',
                mode: 'PRODUCTION'
                // mode: 'SANDBOX'
            });
            CinetPay.getCheckout({
                transaction_id: '{{$deposit->trx_id}}', // YOUR TRANSACTION ID
                amount: {{(int) $deposit->payable_amount}},
                currency: '{{optional($deposit->gateway)->currency}}',
                channels: 'ALL',
                description: 'Test de paiement',
                //Fournir ces variables pour le paiements par carte bancaire
                customer_name: "{{optional($deposit->user)->username ?? 'abc'}}",//Le nom du client
                customer_surname: "{{optional($deposit->user)->username ?? 'abc'}}",//Le prenom du client
                customer_email: "{{optional($deposit->user)->email ?? 'abc'}}",//l'email du client
                customer_phone_number: "{{optional($deposit->user)->phone ?? 'abc'}}",//l'email du client
                customer_address: "BP 0024",//addresse du client
                customer_city: "Antananarivo",// La ville du client
                customer_country: "CM",// le code ISO du pays
                customer_state: "CM",// le code ISO l'état
                customer_zip_code: "06510", // code postal

            });
            CinetPay.waitResponse(function (data) {
                if (data.status == "REFUSED") {
                    if (alert("Votre paiement a échoué")) {
                        window.location.reload();
                    }
                } else if (data.status == "ACCEPTED") {
                    if (alert("Votre paiement a été effectué avec succès")) {
                        window.location.reload();
                    }
                }
            });
            CinetPay.onError(function (data) {
                console.log(data);
            });
        }
    </script>
@endpush



