@extends('admin.layouts.app', ['title' => __('Permission Modules')])

@section('content')
    @include('admin.layouts.partials.header', [
    'title' => __('Permission Modules'),
    'class' => 'col-lg-12',
    ])
    <?php
    if (isset($role_id) && $role_id != 0) {
        $submit_url = route('admin:permissions-modules.update', [$role_id ?? '']);
    }
    ?>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Permission Modules Form') }}</h3>
                        </div>
                    </div>
                    <?php
                    //  if(isset($permissions) && !empty($permissions)) { if(in_array($value, $permissions)){ echo "checked"; } }
                    //print_r($permissions_list);exit;
                    ?>
                    <div class="card-body">
                        <form id="roles_form" method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                @foreach ($permissions_list as $key => $value)
                                    <div class="mt-3">
                                        <h6 class="heading-small text-muted mb-3">{{ $value['module'] }}</h6>
                                        <div class="row">
                                            @foreach ($value['permissions'] as $index => $permissions)
                                                <div class="col-lg-3 col-md-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="modules[]"
                                                            value="{{ $permissions->name }}" id="{{ $permissions->name }}"
                                                            <?php if (isset($permissions_active) && !empty($permissions_active)) {
                                                                if (in_array($permissions->id, $permissions_active)) {
                                                                    echo 'checked';
                                                                }
                                                            } ?>>
                                                        <label class="custom-control-label text-capitalize"
                                                            for="{{ $permissions->name }}">{{ str_replace('-', ' ', $permissions->name) }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                @endforeach
                    </div>
                    </fieldset>

                    <br>
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <a class="btn btn-icon btn-success" href="{{ route('admin:roles') }}" id="back">
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
