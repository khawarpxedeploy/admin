@extends('admin.layouts.app', ['title' => __('Orders')])
@section('css')

    @include('admin.layouts.partials.datatables.dataTablesStyles')

@endsection
@section('content')
    @include('admin.layouts.partials.header', [
    'title' => __('Orders'),
    'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-0 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card">
                        <div class="container table-responsive py-4">
                            <table class="table table-flush" id="datatable-buttons">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('Order#') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Payment Method') }}</th>
                                        <th>{{ __('Payment Status') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @if (isset($orders) && !empty($orders))
                                        @foreach ($orders as $key => $value)
                                            @php
                                                $i = $i + 1;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="btn badge badge-success badge-pill">#{{ $value->order_id }}
                                                    </div>
                                                </td>
                                                <td>{{ $value->customer->name }}</td>
                                                <td><strong>{{ $value->total ?? 0.00 }}</strong></td>
                                                <td class="text-uppercase">{{ $value->payment_method }}</td>
                                                <td>
                                                    <span class="badge badge-dot mr-4 current_status">
                                                        @if ($value->payment_status == 1)
                                                            <i class="bg-success"></i>
                                                            <span
                                                                class="status badge badge-success badge-pill text-uppercase">Paid</span>
                                                        @else
                                                            <i class="bg-danger"></i>
                                                            <span
                                                                class="status badge badge-danger badge-pill text-uppercase">Unpaid</span>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-alternative" data-toggle="select">
                                                    @if (isset($statuses) & !empty($statuses))
                                                        @foreach ($statuses as $key => $status)
                                                            @if (isset($value->status) & !empty($value->status))
                                                                <option value="{{ $status }}"
                                                                    <?php if($status == $value->status) { echo 'selected'; } else { echo ''; } ?>>
                                                                    {{ strtoupper($status) }}</option>
                                                            @else
                                                                <option class="text-uppercase" value="{{ $status }}">{{ $status }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                            role="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        {{-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                                                            x-placement="bottom-end"
                                                            style="position: absolute;will-change: transform;top: 0px;left: 0px;transform: translate3d(-160px, 32px, 0px);">
                                                            @if ($value->status == 1)
                                                                <a class="dropdown-item status-change"
                                                                    href="javascript:void(0);" rel="{{ $value->status }}"
                                                                    data-id="{{ $value->id }}">Deactivate</a>
                                                            @else
                                                                <a class="dropdown-item status-change"
                                                                    href="javascript:void(0);" rel="{{ $value->status }}"
                                                                    data-id="{{ $value->id }}">Activate</a>
                                                            @endif
                                                        </div> --}}
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


        {{-- <script type="text/javascript">
            $('.status-change').on('click', function() {
                var status = $(this).attr('rel');
                var id = $(this).attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route("admin:customer.status") }}',
                    data: {
                        'status': status,
                        'id': id,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        var status = response.status;
                        var message = response.message;
                        var current_status = response.current_status;
                        if (status == true) {
                            location.reload();
                        }
                    }
                });
            });
        </script> --}}
    @endpush

@endsection
