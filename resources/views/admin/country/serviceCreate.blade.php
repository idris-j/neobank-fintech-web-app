@extends('admin.layouts.app')
@section('page_title', __('Add Services'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">@yield('page_title')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="{{ route('admin.dashboard') }}">@lang("Dashboard")</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Services')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row payment_method">
            <div class="col-lg-12">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h2 class="card-title mt-2 h4">@lang('Add New Service')</h2>
                            <a href="{{route('admin.service.index')}}" class="btn btn-sm btn-info">
                                <i class="bi-arrow-left"></i> @lang('Back')
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.service.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4 d-flex align-items-center">

                                    <div class="col-md-6">
                                        <label for="name" class="form-label">@lang('Service Name')</label>
                                        <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                               name="name" id="name" placeholder="@lang("Bank Transfer")" aria-label="name"
                                               autocomplete="off" value="{{ old('name') }}">
                                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="row form-check form-switch mt-3" for="service_status">
                                            <span class="col-4 col-sm-9 ms-0 ">
                                                <span class="d-block text-dark">@lang("Service Status")</span>
                                                <span class="d-block fs-5">@lang("Click on this Switch for change the status.")</span>
                                            </span>

                                            <span class="col-2 col-sm-3 text-end">
                                                <input type='hidden' value='0' name='status'>
                                                <input class="form-check-input @error('status') is-invalid @enderror"
                                                       type="checkbox" name="status" id="service_status" value="1" checked>
                                                <label class="form-check-label text-center" for="service_status"></label>
                                            </span>
                                            @error('status')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start mt-4">
                                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection





