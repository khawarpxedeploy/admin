@extends('admin.layouts.app', ['title' => __('Categories')])

@section('content')
    @include('admin.layouts.partials.header', [
    'title' => __('Add New Category'),
    'class' => 'col-lg-12',
    ])
    <?php
    if (isset($category->id) && $category->id != 0) {
        $submit_url = route('admin:category.update', [$category->id ?? '']);
    } else {
        $submit_url = route('admin:category.add');
    }
    ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Category Form') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="question_form" method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <h6 class="heading-small text-muted mb-4">{{ __('Add New Category') }}</h6>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 offset-md-2">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">* </span>{{__('Category Name')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $category->name ?? '' }}" id="name" name="name">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <a class="btn btn-icon btn-success" href="{{ route('admin:categories') }}" id="back">
                                        <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                                        <span class="btn-inner--text">{{ __('Back') }}</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 offset-lg-8">
                                    <button class="btn btn-icon btn-success" type="submit" id="save">
                                        <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                                        <span class="btn-inner--text">{{ __('Save') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/js/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#save").on('click', function() {
                $("#question_form").validate({
                    rules: {
                        category: {
                            required: true,
                        }
                    }
                });
            });
        });
    </script>
@endpush
