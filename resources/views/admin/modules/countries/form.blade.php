@extends('admin.layouts.app', ['title' => __('Countries')])

@section('content')
    @include('admin.layouts.partials.header', [
    'title' => __('Add New Country'),
    'class' => 'col-lg-12',
    ])
    <?php
    if (isset($country->id) && $country->id != 0) {
        $submit_url = route('admin:country.update', [$country->id ?? '']);
    } else {
        $submit_url = route('admin:country.add');
    }
    ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Country Form') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="question_form" method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <h6 class="heading-small text-muted mb-4">{{ __('Add New Country') }}</h6>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 offset-md-2">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">* </span>{{__('Country Name')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $country->name ?? '' }}" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">* </span>{{__('Country Code')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $country->code ?? '' }}" id="code" name="code">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 offset-md-2">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">* </span>{{__('Currency Name')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $country->currency ?? '' }}" id="currency" name="currency">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">* </span>{{__('Currency Symbol')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ $country->currency_symbol ?? '' }}" id="currency_symbol" name="currency_symbol">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <a class="btn btn-icon btn-success" href="{{ route('admin:countries') }}" id="back">
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
                        country: {
                            required: true,
                        }
                    }
                });
            });
        });
    </script>
@endpush
