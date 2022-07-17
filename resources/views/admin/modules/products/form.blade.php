@extends('admin.layouts.app', ['title' => __('Products')])

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    @include('admin.layouts.partials.header', [
        'title' => __('Add New Product'),
        'class' => 'col-lg-12',
    ])
    <?php
    if (isset($product->id) && $product->id != 0) {
        $submit_url = route('admin:product.update', [$product->id ?? '']);
    } else {
        $submit_url = route('admin:product.add');
    }
    ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Product Form') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="product_form" method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <h6 class="heading-small text-muted mb-4">{{ __('Add New Product') }}</h6>
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 offset-md-1">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                @php
                                                    $checked = '';
                                                    if (isset($product) && $product->fonts_enabled) {
                                                        $checked = 'checked';
                                                    }
                                                @endphp
                                                <input {{ $checked }} type="checkbox" class="custom-control-input"
                                                    name="fonts_enabled" id="fonts_enabled">
                                                <label class="custom-control-label" for="fonts_enabled">Enable Fonts</label>
                                            </div>
                                            <small class="text-muted ml-4"><strong>When selected fonts will be visible in
                                                    products</strong></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 offset-md-1">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                @php
                                                    $checked = '';
                                                    if (isset($product) && $product->symbols_enabled) {
                                                        $checked = 'checked';
                                                    }
                                                @endphp
                                                <input {{ $checked }} type="checkbox" class="custom-control-input"
                                                    name="symbols_enabled" id="symbols_enabled">
                                                <label class="custom-control-label" for="symbols_enabled">Enable
                                                    Symbols</label>
                                            </div>
                                            <small class="text-muted ml-4"><strong>When selected symbols will be visible in
                                                    products</strong></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-5 col-md-5 offset-md-1">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Name') }}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $product->name ?? '' }}" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Price') }}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $product->price ?? '' }}" id="price" name="price">
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-10 offset-md-1">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Description') }}</label>
                                            <textarea class="form-control form-control-alternative" name="description" id="description" cols="30"
                                                rows="8">{{ $product->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 offset-md-1">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{ __('Image') }}</label>
                                            <input type="file" class="dropify" name="image"
                                                data-allowed-file-extensions="jpg png jpeg gif" data-max-file-size="2M"
                                                data-default-file="{{ $product->image ?? '' }}" />
                                        </div>
                                    </div>

                                </div>
                                @php
                                    $selected = json_decode($product->questions ?? '');
                                @endphp
                                <div class="row mt-3 mb-5">
                                    <div class="col-lg-5 col-md-5 offset-md-1 mt-3">
                                        <label class="form-control-label"><span class="required-icon">*
                                            </span>Questions</label>
                                        <select class="form-control form-control-alternative multiple_questions"
                                            name="questions[]" data-toggle="select" multiple
                                            data-placeholder="Select questions">
                                            @if (isset($questions) & !empty($questions))
                                                @foreach ($questions as $key => $value)
                                                    @if (isset($selected) & !empty($selected))
                                                        <option value="{{ $value->id }}"
                                                            {{ in_array($value->id, $selected) ? 'selected' : '' }}>
                                                            {{ $value->question }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->question }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        $selected_filters = json_decode($product->filters ?? '');
                                    @endphp
                                    <div class="col-lg-5 col-md-5 mt-3">
                                        <label class="form-control-label"><span class="required-icon">*
                                            </span>Filters</label>
                                        <select class="form-control form-control-alternative multiple_questions"
                                            name="filters[]" data-toggle="select" multiple
                                            data-placeholder="Select questions">
                                            @if (isset($filters) & !empty($filters))
                                                @foreach ($filters as $key => $value)
                                                    @if (isset($selected_filters) & !empty($selected_filters))
                                                        <option value="{{ $value->id }}"
                                                            {{ in_array($value->id, $selected_filters) ? 'selected' : '' }}>
                                                            {{ $value->title }}</option>
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        $selected_sizes = $product->addons ?? '';
                                        // dd($selected_sizes);
                                    @endphp
                                    <div class="col-lg-5 col-md-5 offset-md-1 mt-3">
                                        <label class="form-control-label"><span class="required-icon">*
                                            </span>Sizes</label>
                                        <select class="form-control form-control-alternative multiple_questions"
                                            name="sizes[]" data-toggle="select" multiple data-placeholder="Select sizes">
                                            @if (isset($sizes) & !empty($sizes))
                                                @foreach ($sizes as $key => $value)
                                                    @if (isset($selected_sizes) & !empty($selected_sizes))
                                                        @foreach ($selected_sizes as $slcz)
                                                            <option value="{{ $slcz->addon_id }}" <?php if ($value->id == $slcz->addon_id) {
                                                                echo 'selected';
                                                            } else {
                                                                echo '';
                                                            } ?>>
                                                                {{ $value->title }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        $selected_stones = $product->addons ?? '';
                                    @endphp
                                    <div class="col-lg-5 col-md-5 mt-3">
                                        <label class="form-control-label"><span class="required-icon">*
                                            </span>Stones</label>
                                        <select class="form-control form-control-alternative multiple_questions"
                                            name="stones[]" data-toggle="select" multiple
                                            data-placeholder="Select stones">
                                            @if (isset($stones) & !empty($stones))
                                                @foreach ($stones as $key => $value)
                                                    @if (isset($selected_stones) & !empty($selected_stones))
                                                        @foreach ($selected_stones as $slcs)
                                                            <option value="{{ $slcs->addon_id }}" <?php if ($value->id == $slcs->addon_id) {
                                                                echo 'selected';
                                                            } else {
                                                                echo '';
                                                            } ?>>
                                                                {{ $value->title }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        $selected_weights = $product->addons ?? '';
                                    @endphp
                                    <div class="col-lg-5 col-md-5 offset-md-1 mt-3">
                                        <label class="form-control-label"><span class="required-icon">*
                                            </span>Weights</label>
                                        <select class="form-control form-control-alternative multiple_questions"
                                            name="weights[]" data-toggle="select" multiple
                                            data-placeholder="Select weights">
                                            @if (isset($weights) & !empty($weights))
                                                @foreach ($weights as $key => $value)
                                                    @if (isset($selected_weights) & !empty($selected_weights))
                                                        @foreach ($selected_weights as $slcw)
                                                            <option value="{{ $slcw->addon_id }}" <?php if ($value->id == $slcw->addon_id) {
                                                                echo 'selected';
                                                            } else {
                                                                echo '';
                                                            } ?>>
                                                                {{ $value->title }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        $selected_engraving = $product->addons ?? '';
                                    @endphp
                                    <div class="col-lg-5 col-md-5 mt-3">
                                        <label class="form-control-label"><span class="required-icon">*
                                            </span>Engravings</label>
                                        <select class="form-control form-control-alternative multiple_questions"
                                            name="engravings[]" data-toggle="select" multiple
                                            data-placeholder="Select engravings">
                                            @if (isset($engravings) & !empty($engravings))
                                                @foreach ($engravings as $key => $value)
                                                    @if (isset($selected_engraving) & !empty($selected_engraving))
                                                        @foreach ($selected_engraving as $slce)
                                                            <option value="{{ $slce->addon_id }}" <?php if ($value->id == $slce->addon_id) {
                                                                echo 'selected';
                                                            } else {
                                                                echo '';
                                                            } ?>>
                                                                {{ $value->title }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <a class="btn btn-icon btn-success" href="{{ route('admin:products') }}"
                                        id="back">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#save").on('click', function() {
                $("#product_form").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        price: {
                            required: true,
                        },
                    }
                });
            });
            $('.multiple_questions').select2();
        });
    </script>
@endpush
