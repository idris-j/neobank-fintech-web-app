@extends('admin.layouts.app')
@section('page_title', __('Blogs'))
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">@yield('page_title')</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('Manage Blog')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('Blog')</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title m-0">@lang('Blogs List')</h4>
            <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">@lang('Add Blogs')</a>

                <div class="dropdown px-2">
                    <button type="button" class="btn btn-secondary btn-md w-100" data-bs-auto-close="false"
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="bi-filter me-1"></i> @lang('Filter')
                    </button>

                    <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered filter_dropdown">
                        <div class="card">
                            <div class="card-header card-header-content-between">
                                <h5 class="card-header-title">@lang('Filter')</h5>
                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2" id="filter_close_btn">
                                    <i class="bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="card-body">
                                <form action="" method="get" id="filter_form">
                                    <div class="mb-4">
                                        <span class="text-cap text-body">@lang('Search by anything')</span>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" name="search" class="form-control" id="name"
                                                       value="{{ old('search', request()->search) }}" autocomplete="off"
                                                       placeholder="category, title, author_name, description">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 mb-4">
                                            <span class="text-cap text-body">@lang('Date Range')</span>
                                            <div class="input-group mb-3 custom">
                                                <input type="text" id="filter_date_range" name="date"
                                                       class="js-flatpickr form-control" placeholder="Select dates"
                                                       data-hs-flatpickr-options='{
                                                             "dateFormat": "Y/m/d",
                                                             "mode": "range"
                                                           }' aria-describedby="flatpickr_filter_date_range">
                                                <span class="input-group-text" id="flatpickr_filter_date_range">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row gx-2">
                                        <div class="col">
                                            <div class="d-grid">
                                                <button type="button" id="clear_filter" class="btn btn-white">@lang('Clear Filters')</button>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary" id="filter_button">
                                                    <i class="bi-search"></i> @lang('Apply')</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                <thead class="thead-light">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('Title')</th>
                    <th>@lang('Status')</th>
                    <th class="text-center">
                        @foreach($allLanguage as $language)
                            <img class="avatar avatar-xss avatar-square me-2"
                                 src="{{ getFile($language->flag_driver, $language->flag) }}"
                                 alt="{{ $language->name }} Flag">
                        @endforeach
                    </th>
                    <th>@lang('Action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($blogs as $key => $blog)
                    <tr>
                        <td>@serial</td>
                        <td>
                            @lang(optional($blog->details)->title)
                        </td>
                        <td>
                            {!! $blog->statusMessage !!}
                        </td>
                        <td class="text-center">
                            @foreach($allLanguage as $language)
                                <a href="{{ route('admin.blog.edit', [$blog->id, $language->id]) }}"
                                   class="btn btn-white btn-icon btn-sm flag-btn"
                                   target="_blank">
                                    <i class="bi {{ $blog->getLanguageEditClass($blog->id, $language->id) }}"></i>
                                </a>
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-white btn-sm" href="{{ route('admin.blog.edit', [$blog->id, $defaultLanguage->id]) }}">
                                    <i class="bi-pencil-fill me-1"></i> Edit
                                </a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="productsEditDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="productsEditDropdown1">
                                        <a class="dropdown-item"
                                           href="{{ route("admin.blog.seo", $blog->id) }}">
                                            <i class="fa-light fa-magnifying-glass dropdown-item-icon"></i>
                                            @lang("SEO")
                                        </a>
                                        <a class="dropdown-item deleteBtn text-danger"
                                           href="javascript:void(0)"
                                           data-route="{{ route("admin.blogs.destroy", $blog->id) }}"
                                           data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi-trash dropdown-item-icon text-danger"></i> @lang("Delete")
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    {!! renderNoData() !!}
                @endforelse
                </tbody>
            </table>
            <div class="card-footer">
                {{ $blogs->appends($_GET)->links($theme.'partials.pagination') }}
            </div>
        </div>
    </div>
</div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel"><i class="bi bi-check2-square"></i> @lang("Confirmation")</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="setRoute">
                    @csrf
                    @method("delete")
                    <div class="modal-body">
                        <p>@lang("Do you want to delete this blog")</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->

@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}">
@endpush


@push('js-lib')
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
@endpush


@push('script')
    <script>
        "use script";
        $(document).ready(function () {
            $('.deleteBtn').on('click', function () {
                let route = $(this).data('route');
                $('.setRoute').attr('action', route);
            })
            HSCore.components.HSFlatpickr.init('.js-flatpickr')
        })
    </script>


@endpush



