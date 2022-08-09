@extends('admin.layouts.app', ['title' => __('Addons')])

@section('content')
    @include('admin.layouts.partials.header', [
        'title' => __('Add New Addon'),
        'class' => 'col-lg-12',
    ])
    <?php
    if (isset($addon->id) && $addon->id != 0) {
        $submit_url = route('admin:addon.update', [$addon->id ?? '']);
    } else {
        $submit_url = route('admin:addon.add');
    }
    ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Addon Form') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="question_form" method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <h6 class="heading-small text-muted mb-4">{{ __('Add New Addon') }}</h6>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 offset-md-2">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Type') }}</label>
                                            <select class="form-control" name="type" data-toggle="select" title="Addon type"
                                                data-live-search="true" data-live-search-placeholder="Search ...">
                                                <option <?php if (isset($addon->type) && $addon->type == 'size') {
                                                    echo 'selected';
                                                } else {
                                                    echo '';
                                                } ?> value="size">Size</option>
                                                <option <?php if (isset($addon->type) && $addon->type == 'stone') {
                                                    echo 'selected';
                                                } else {
                                                    echo '';
                                                } ?> value="stone">Stone</option>
                                                <option <?php if (isset($addon->type) && $addon->type == 'weight') {
                                                    echo 'selected';
                                                } else {
                                                    echo '';
                                                } ?> value="weight">Weight</option>
                                                <option <?php if (isset($addon->type) && $addon->type == 'engraving') {
                                                    echo 'selected';
                                                } else {
                                                    echo '';
                                                } ?> value="engraving">Engraving</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 ">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Addon Name') }}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $addon->title ?? '' }}" id="title" name="title">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 offset-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Addon Price') }}</label>
                                            <input class="form-control form-control-alternative" step="0.01" type="number"
                                                value="{{ $addon->price ?? '' }}" id="price" name="price">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <a class="btn btn-icon btn-success" href="{{ route('admin:addons') }}" id="back">
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
                        addon: {
                            required: true,
                        }
                    }
                });
            });
        });
    </script>
@endpush
