@extends('admin.layouts.app', ['title' => __('Permissions')])
@section('css')

    @include('admin.layouts.partials.datatables.dataTablesStyles')

@endsection
@section('content')
    @include('admin.layouts.partials.header', [
    'title' => __('Permission Management'),
    'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-0 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card">
                            <div class="card-header text-right">
                                <a href="{{ route('admin:permission.create') }}">
                                    <button class="btn btn-sm btn-icon btn-success" type="button">
                                        <span class="btn-inner--icon"><i class="ni ni-circle-08"></i></span>
                                        <span class="btn-inner--text">Add Permission</span>
                                    </button>
                                </a>
                            </div>
                        <div class="container table-responsive py-4">
                            <table class="table table-flush" id="datatable-buttons">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Permissions Title</th>
                                        <th>Module</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @if (isset($permissions) && !empty($permissions))
                                        @foreach ($permissions as $key => $value)
                                            @php
                                                $i = $i + 1;
                                                $edit_url = url('/admin/permissions/edit/' . $value->id);
                                                $delete_url = url('/admin/permissions/delete/' . $value->id);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="btn badge badge-success badge-pill">#{{ $i }}
                                                    </div>
                                                </td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->module }}</td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                            role="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                                            x-placement="bottom-end"
                                                            style="position: absolute;will-change: transform;top: 0px;left: 0px;transform: translate3d(-160px, 32px, 0px);">
                                                            <a class="dropdown-item" href="{{ $edit_url }}">Edit</a>

                                                            <a class="dropdown-item" href="{{ $delete_url }}">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')
    </div>
    @push('js')
        @include('admin.layouts.partials.datatables.dataTablesJs')
    @endpush
@endsection
