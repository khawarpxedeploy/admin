@extends('admin.layouts.app', ['title' => __('Users')])

@section('content')
    @include('admin.layouts.partials.header', [
    'title' => __('Register Users'),
    'class' => 'col-lg-12',
    ])
    <?php
    if (isset($user_data->id) && $user_data->id != 0) {
        $submit_url = route('admin:user.update', [$user_data->id ?? '']);
    } else {
        $submit_url = route('admin:user.add');
    }
    ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('User Registration Form') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="user_form" method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <h6 class="heading-small text-muted mb-4">{{ __('User Information') }}</h6>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">* </span>{{ __('Full Name')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ old('name', $user_data->name ?? '') }}" placeholder="eg. Jhon" id="name"
                                                name="name">
                                                @error('name')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Username')}}</label>
                                            <input class="form-control form-control-alternative" autocomplete="off"
                                                type="text" value="{{ old('username', $user_data->username ?? '') }}"
                                                placeholder="Unique username" id="username" name="username">
                                                @error('username')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Email')}}</label>
                                            <input class="form-control form-control-alternative" autocomplete="off"
                                                type="email" value="{{ old('email', $user_data->email ?? '') }}"
                                                placeholder="example@abc.com" id="email" name="email">
                                                @error('email')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            @if (!isset($user_data->password))
                                                <label class="form-control-label"><span class="required-icon">*
                                                    </span>{{__('Password')}}</label>
                                                <input class="form-control form-control-alternative" autocomplete="off"
                                                    type="password" id="password" name="password" value="{{ old('password', null)}}">
                                                    @error('password')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Phone')}}#</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ old('phone',$user_data->phone ?? '') }}" placeholder="+92123456789" id="phone"
                                                name="phone">
                                                @error('phone')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Gender')}}</label>
                                            <select class="form-control form-control-alternative" name="gender">
                                                <option value="Male" {{ old('gender', $user_data->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $user_data->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Not Specified" {{ old('gender', $user_data->gender ?? '') == 'Not Specified' ? 'selected' : '' }}>Not Specified</option>
                                            </select>
                                            @error('gender')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Role')}}</label>
                                            <select class="form-control form-control-alternative required" name="role_id">
                                                @if (isset($roles) & !empty($roles))
                                                    @foreach ($roles as $key => $value)
                                                        <option value="{{ $value->id }}" {{ old('role_id', null) == $value->id ? 'selected' : '' }} <?php if ($value->id == ($role_id ?? 0)) {
                                                                    echo 'selected';
                                                                } ?>>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('role_id')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Country')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ old('country',$user_data->country ?? '') }}" id="country" name="country">
                                                @error('country')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('City')}}</label>
                                            <input class="form-control form-control-alternative" type="text"
                                                value="{{ old('city',$user_data->city ?? '') }}" id="city" name="city">
                                                @error('city')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><span class="required-icon">*
                                                </span>{{__('Address')}}</label>
                                            <textarea rows="1" class="form-control" name="address"
                                                id="address">{{ old('address',$user_data->address ?? '') }}</textarea>
                                                @error('address')
                                                <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <a class="btn btn-icon btn-success" href="{{ route('admin:users') }}" id="back">
                                        <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                                        <span class="btn-inner--text">{{__('Back')}}</span>
                                    </a>
                                </div>
                                <div class="col-lg-2 col-md-2 offset-lg-8">
                                    <button class="btn btn-icon btn-success" type="submit" id="save">
                                        <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                                        <span class="btn-inner--text">{{__('Save')}}</span>
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
                $("#user_form").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        username: {
                            required: true,
                        },
                        address: {
                            required: true,
                        },
                        country: {
                            required: true,
                        },
                        city: {
                            required: true,
                        },
                        company: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true
                        }
                    }
                });
            });

        });
    </script>
@endpush
