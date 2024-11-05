@extends('admin.layouts.app')
@section('page_title', __('Exchange Api Settings'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="{{ route('admin.dashboard')  }}">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Settings')</li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang('Exchange Api Setting')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Exchange Api Setting')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                @include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.settings'), 'suffix' => 'Settings'])
            </div>
            <div class="col-lg-6 seo-setting">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title h4">@lang('Exchange Api Setting')</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.currency.exchange.api.config.update') }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <h2 class="card-title h5  border-bottom pb-3 ">@lang('CurrencyLayer Api Config (Fiat Currency)')</h2>
                                <div class="row mb-4 mt-5">
                                    <label for="currency_layer_access_key"
                                           class="col-sm-4 col-form-label form-label">@lang("Access Key")<i
                                            class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            aria-label="@lang("Currency Layer Access Key.")"
                                            data-bs-original-title="@lang("Currency Layer Access Key.")"></i></label>
                                    <div class="col-sm-8">
                                        <div class="input-group input-group-merge">
                                            <input type="password"
                                                   class="js-toggle-password form-control  @error('currency_layer_access_key') is-invalid @enderror"
                                                   name="currency_layer_access_key" id="currency_layer_access_key"
                                                   autocomplete="off"
                                                   placeholder="currency_layer_access_key"
                                                   value="{{ old('currency_layer_access_key',  $basicControl->currency_layer_access_key) }}"
                                               data-hs-toggle-password-options='{
                                                   "target": ".js-password-toggle-show-target",
                                                   "show": false,
                                                   "defaultClass": "bi-eye-slash",
                                                   "showClass": "bi-eye",
                                                   "classChangeTarget": "#changePasswordShowIcon"
                                                 }'>
                                            <a class="js-password-toggle-show-target input-group-append input-group-text" href="javascript:;">
                                                <i id="changePasswordShowIcon"></i>
                                            </a>
                                        </div>
                                        @error('currency_layer_access_key')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="currency_layer_auto_update_at"
                                           class="col-sm-4 col-form-label form-label">@lang("Select Update Time")</label>
                                    <div class="col-sm-8">
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select"
                                                    name="currency_layer_auto_update_at" autocomplete="off"
                                                    data-hs-tom-select-options='{
                                                              "placeholder": "Select a schedule",
                                                              "hideSearch": true
                                                            }'>
                                                @foreach($scheduleList as $key => $schedule)
                                                    <option
                                                        value="{{$key}}" {{ $key == old('currency_layer_auto_update_at',$basicControl->currency_layer_auto_update_at) ? 'selected' : '' }}>@lang($schedule)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('currency_layer_auto_update_at')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <label class="row form-check form-switch mb-4" for="currency_layer_auto_update">
                                        <span class="col-8 col-sm-9 ms-0">
                                          <span class="d-block text-dark">@lang("Update Currency Rate")</span>
                                          <span
                                              class="d-block fs-5">@lang("Auto update your site currency rate.")</span>
                                        </span>
                                    <span class="col-4 col-sm-3 text-end">
                                           <input type='hidden' value='0' name='currency_layer_auto_update'>
                                            <input type="checkbox"
                                                class="form-check-input @error('currency_layer_auto_update') is-invalid @enderror"
                                                name="currency_layer_auto_update"
                                                id="currency_layer_auto_update"
                                                value="1" {{ $basicControl->currency_layer_auto_update == 1 ? 'checked' : '' }}>
                                    </span>
                                    @error('currency_layer_auto_update')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </label>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">@lang('Save changes')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div id="emailSection" class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h2 class="card-title h4 mt-2">@lang('Currency Layer Instructions')</h2>
                    </div>
                    <div class="card-body">
                        <p> @lang('Currency layer provides a simple REST API with real-time and historical exchange rates for 168 world currencies, delivering currency pairs in universally usable JSON format - compatible with any of your applications.')</p>
                        <p>@lang("Spot exchange rate data is retrieved from several major forex data providers in real-time, validated, processed and delivered hourly, Every 10 minutes, or even within the 60-second market window.")</p>
                        <a href="https://currencylayer.com/product" target="_blank">@lang('Create an account') <i class="fas fa-external-link-alt"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-toggle-password.js')}}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        (function () {
            HSCore.components.HSTomSelect.init('.js-select')
            new HSTogglePassword('.js-toggle-password')
        })();
    </script>
@endpush


