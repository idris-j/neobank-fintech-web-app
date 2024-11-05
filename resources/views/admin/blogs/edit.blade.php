@extends('admin.layouts.app')
@section('page_title', __('Edit Blog'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <h1 class="page-header-title">@yield('page_title')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="{{ route('admin.dashboard') }}">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@yield('page_title')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="alert alert-soft-dark mb-5" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img class="avatar avatar-xl alert_image" src="{{ asset('assets/admin/img/oc-megaphone.svg') }}"
                         alt="Announce" data-hs-theme-appearance="default">
                    <img class="avatar avatar-xl alert_image" src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                         alt="Announce" data-hs-theme-appearance="dark">
                </div>

                <div class="flex-grow-1 ms-3">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">@lang("You are editing blog for `$pageEditableLanguage->name` version.")</p>
                    </div>
                </div>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-info float-end" ><i class="bi bi-arrow-left"></i> @lang('Back')</a>
            </div>
        </div>

        <form action="{{ route("admin.blog.update", [$blog->id, $pageEditableLanguage->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="d-grid gap-3 gap-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang("Edit Blog")</h2>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="language_id" value="{{ $pageEditableLanguage->id }}">
                                <div class="row mb-4">

                                    <div class="col-md-6">
                                        <label for="author_name" class="form-label">@lang("Author Name")</label>
                                        <div class="input-group input-group-sm-vertical">
                                            <input type="text" class="form-control " name="author_name" id="author_name"
                                                   value="{{ old("author_name", optional($blogDetails)->author_name) }}"
                                                   placeholder="@lang("John Doe")">
                                        </div>
                                        @error("author_name")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="author_title" class="form-label">@lang("Author Title")</label>
                                        <div class="input-group input-group-sm-vertical">
                                            <input type="text" class="form-control " name="author_title" id="author_title"
                                                   value="{{ old("author_title", optional($blogDetails)->author_title) }}"
                                                   placeholder="@lang("Enter The Author Title")">
                                        </div>
                                        @error("author_title")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="title" class="form-label">@lang("Title")</label>
                                        <div class="input-group input-group-sm-vertical">
                                            <input type="text" class="form-control change_name_input" name="title"
                                                   id="title" value="@lang(old("title", optional($blogDetails)->title))  "
                                                   placeholder="@lang("blog title")" autocomplete="off">
                                        </div>
                                        @error("title")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="NameLabel" class="form-label">@lang("Category")</label>
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" autocomplete="off" name="category_id"
                                                    data-hs-tom-select-options='{
                                                      "placeholder": "@lang('select a category')",
                                                      "hideSearch": true
                                                    }'>
                                                <option value="">@lang('Select a category')</option>
                                                @foreach($blogCategory as $category)
                                                    <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}> @lang($category->name) </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="firstShowSlug">

                                            <label for="permalinkLabel" class="form-label">@lang("Permalink:")</label>
                                            <div class="d-inline-block">
                                            <span class="default-slug">{{ url('/') . '/blog-details' }}/
                                                <span id="editable-post-name">{{ optional($blogDetails)->slug }}</span>
                                            </span>
                                                <span id="edit-slug-buttons">
                                               <button class="btn btn-white btn-sm ms-1" id="change_slug" type="button">@lang('Edit')</button>
                                           </span>
                                            </div>
                                            @error("slug")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="laterShowSlug d-none">
                                            <label for="permalinkLabel" class="form-label">@lang("Permalink")</label>
                                            <div class="d-inline-flex">
                                                <div class="default-slug d-flex justify-content-end align-items-center">
                                                    <span class="ps-3">{{ url('/') .'/blog-details' }}</span>
                                                    <input type="text" class="form-control" name="slug" id="newSlug"
                                                           value="{{ optional($blogDetails)->slug }}" placeholder="@lang("Slug")">
                                                </div>
                                                <button class="save btn btn-white btn-sm ms-1" id="btn-ok"
                                                        type="button">
                                                    @lang("OK")
                                                </button>
                                                <button class="cancel btn btn-white btn-sm ms-1" id="btn-cancel"
                                                        type="button">
                                                    @lang("Cancel")
                                                </button>
                                            </div>
                                        </div>
                                        @error("slug")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <span class="newSlug"></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="" class="form-label">@lang("Description")</label>
                                        <textarea class="form-control" name="description" id="summernote"
                                                  rows="20">{{ old("description", optional($blogDetails)->description) }}</textarea>
                                        @error("description")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label for="" class="form-label">@lang("Blog Image")</label>
                                        <label class="form-check form-check-dashed" for="ImageUploader">
                                            <img id="BlogImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($blog->blog_image_driver, $blog->blog_image, true) }}"
                                                 alt="@lang("Blog Image")"
                                                 data-hs-theme-appearance="default">

                                            <img id="BlogImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($blog->blog_image_driver, $blog->blog_image, true) }}"
                                                 alt="@lang("Breadcrumb Image")" data-hs-theme-appearance="dark">
                                            <span class="d-block">@lang("Browse your file here")</span>
                                            <input type="file" class="js-file-attach form-check-input"
                                                   name="blog_image" id="ImageUploader"
                                                   data-hs-file-attach-options='{
                                                  "textTarget": "#BlogImg",
                                                  "mode": "image",
                                                  "targetAttr": "src",
                                                  "allowTypes": [".png", ".jpeg", ".jpg"]
                                           }'>
                                        </label>
                                        @error("blog_image")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label for="" class="form-label">@lang("Author Image")</label>
                                        <label class="form-check form-check-dashed" for="imageAuthor">
                                            <img id="AuthorImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($blog->author_image_driver, $blog->author_image, true) }}"
                                                 alt="@lang("Author Image")" data-hs-theme-appearance="default">
                                            <img id="AuthorImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($blog->author_image_driver, $blog->author_image, true) }}"
                                                 alt="@lang("Author Image")" data-hs-theme-appearance="dark">
                                            <span class="d-block">@lang("Browse your file here")</span>
                                            <input type="file" class="js-file-attach form-check-input"
                                                   name="author_image" id="imageAuthor"
                                                   data-hs-file-attach-options='{
                                                  "textTarget": "#AuthorImg",
                                                  "mode": "image",
                                                  "targetAttr": "src",
                                                  "allowTypes": [".png", ".jpeg", ".jpg"]
                                           }'>
                                        </label>
                                        @error("author_image")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-grid gap-3 gap-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang("Publish")</h2>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary" name="status"
                                            value="1">@lang("Save & Publish")</button>
                                    <button type="submit" class="btn btn-info" name="status"
                                            value="0">@lang("Save & Draft")</button>
                                </div>
                            </div>
                        </div>

                        <div class="card language_card">
                            <div class="card-header">
                                <h4 class="card-title">@lang("Language")</h4>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush list-group-no-gutters">
                                    @foreach($allLanguage as $language)
                                        @if($pageEditableLanguage->name !==  $language->name)
                                            <div class="list-group-item custom-list">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img class="avatar avatar-xss avatar-square me-2"
                                                             src="{{ getFile($language->flag_driver, $language->flag) }}"
                                                             alt="{{ ucwords($language->name) }} Flag">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm mb-2 mb-sm-0">
                                                                <h5 class="mb-0">@lang($language->name)</h5>
                                                            </div>
                                                            <div class="col-sm-auto">
                                                                <a class="text-secondary"
                                                                   href="{{ route('admin.blog.edit', [$blog->id, $language->id]) }}"><i
                                                                        class="bi bi-pencil-square"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang("Blog Status")</h2>
                            </div>
                            <div class="card-body">
                                <label class="row form-check form-switch" for="BlogSwitch">
                                    <span class="col-8 col-sm-9 ms-0">
                                      <span class="text-dark">@lang("Blog Status")
                                          <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                             data-bs-placement="top"
                                             aria-label="@lang("Enable status for page publish")"
                                             data-bs-original-title="@lang("Status")"></i></span>
                                    </span>
                                    <span class="col-4 col-sm-3 text-end">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="form-check-input" name="status"
                                               id="blog" value="1" {{ $blog->status == 1 ? 'checked' : '' }}>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang("Breadcrumb Status")</h2>
                            </div>
                            <div class="card-body">
                                <label class="row form-check form-switch" for="breadcrumbSwitch">
                                    <span class="col-8 col-sm-9 ms-0">
                                      <span class="text-dark">@lang("Breadcrumb Status")
                                          <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                             data-bs-placement="top"
                                             aria-label="@lang("Enable status for page publish")"
                                             data-bs-original-title="@lang("Enable breadcrumb image this page")"></i></span>
                                    </span>
                                    <span class="col-4 col-sm-3 text-end">
                                        <input type="hidden" name="breadcrumb_status" value="0">
                                        <input type="checkbox" class="form-check-input" name="breadcrumb_status"
                                               id="breadcrumb" value="1" {{ $blog->breadcrumb_status == 1 ? 'checked' : '' }}>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang("Breadcrumb Image")</h2>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-8 mb-3 mb-md-0">
                                        <label class="form-check form-check-dashed" for="logoUploader">
                                            <img id="logoImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($blog->breadcrumb_image_driver, $blog->breadcrumb_image, true) }}"
                                                 alt="@lang("Breadcrumb Image")"
                                                 data-hs-theme-appearance="default">

                                            <img id="logoImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile($blog->breadcrumb_image_driver, $blog->breadcrumb_image, true) }}"
                                                 alt="@lang("Breadcrumb Image")" data-hs-theme-appearance="dark">
                                            <span class="d-block">@lang("Browse your file here")</span>
                                            <input type="file" class="js-file-attach form-check-input"
                                                   name="breadcrumb_image" id="logoUploader"
                                                   data-hs-file-attach-options='{
                                                  "textTarget": "#logoImg",
                                                  "mode": "image",
                                                  "targetAttr": "src",
                                                  "allowTypes": [".png", ".jpeg", ".jpg"]
                                           }'>
                                        </label>
                                        @error("breadcrumb_image")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            HSCore.components.HSTomSelect.init('.js-select');
            new HSFileAttach('.js-file-attach')

            var slug = "{{ optional($blogDetails)->slug }}";
            $(document).on("click", "#change_slug", function () {
                $('#newSlug').val(slug)
                $('.firstShowSlug').addClass('d-none');
                $('.laterShowSlug').removeClass('d-none');
            });
            $(document).on("click", "#btn-ok", function () {
                let newSlug = $('#newSlug').val();
                $('#editable-post-name').text(newSlug);
                $('.laterShowSlug').addClass('d-none');
                $('.firstShowSlug').removeClass('d-none');

                let blogId = "{{ $blog->id }}";

                $.ajax({
                    url: "{{ route('admin.slug.update') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        blogId,
                        newSlug
                    },
                    success: function (response) {
                        if (response.errors) {
                            for (let item in response.errors) {
                                $('.newSlug').removeClass('text-success');
                                $('.newSlug').addClass('text-danger');
                                $('.newSlug').text(response.errors[item][0])
                            }
                            setTimeout(function () {
                                $('.newSlug').text('')
                            }, 3000)
                            return 0;
                        }
                        $('.newSlug').text('')
                        slug = response.slug
                    },
                    error: function (error) {
                    }
                });
            });
            $(document).on("click", "#btn-cancel", function () {
                $('.laterShowSlug').addClass('d-none');
                $('.firstShowSlug').removeClass('d-none');
            });

            $('#summernote').summernote({
                placeholder: 'Describe The Blog.',
                height: 160,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                },
            });
        });
    </script>
@endpush