@extends('admin.layouts.app', ['title' => __('Shipment')])
@section('content')
    @include('admin.layouts.partials.header', [
        'title' => __('Shipment Details'),
        'class' => 'col-lg-7',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-0 col-md-12 col-sm-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">{{ __('Customer Information') }}</h6>
                            <div class="pl-lg-4">
                                <h4>{{ $order->customer->name ?? '' }}</h4>
                                <h4>{{ $order->customer->email ?? '' }}</h4>
                                <h4>{{ $order->customer->phone ?? '' }}</h4>
                                <h4>{{ $order->customer->address ?? '' }}</h4>

                            </div>
                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">{{ __('Order Details') }}</h6>
                            <div class="pl-lg-4">
                                <h4><strong class="text-muted"> {{ __('Order Type') }}</strong><span class="text-capitalize"
                                        style="float: right">{{ $order->type ?? '' }}</span>
                                </h4>
                                <h4><strong class="text-muted"> {{ __('Order Status') }}</strong><span class="text-capitalize"
                                        style="float: right">{{ $order->status ?? '' }}</span>
                                </h4>
                                <h4><strong class="text-muted"> {{ __('Payment Method') }}</strong><span class="text-capitalize"
                                        style="float: right">{{ $order->payment_method ?? '' }}</span>
                                </h4>
                                <h4><strong class="text-muted"> {{ __('Payment Status') }}</strong><span class="text-capitalize"
                                        style="float: right">
                                        @if ($order->payment_status == 1)
                                            <i class="bg-success"></i>
                                            <span class="status badge badge-success badge-pill text-uppercase">Paid</span>
                                        @else
                                            <i class="bg-danger"></i>
                                            <span class="status badge badge-danger badge-pill text-uppercase">Unpaid</span>
                                        @endif
                                    </span>
                                </h4>
                                <h4> <strong class="text-muted"> {{ __('Pickup Location') }}</strong> <span
                                        style="float: right">{{ $order->pickup_location ?? '-' }}<span>
                                </h4>
                                @php
                                    if ($order->delivery_location) {
                                        $location = $order->delivery_location;
                                        $location = $location->address ?? '';
                                    }
                                @endphp
                                <h4> <strong class="text-muted"> {{ __('Delivery Location') }}</strong> <span
                                        style="float: right">{{ $location ?? '-' }}<span></h4>

                            </div>
                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">{{ __('Order Information') }}</h6>
                            <div class="pl-lg-4">
                                <h4 class="mb-3"><strong class="text-muted"> Status</strong><span style="float: right">
                                        <div class="btn badge badge-info badge-pill text-capitalize">{{ $order->status ?? '' }}</div>
                                        <span></h4>
                                @if ($order->status == 'Cancelled')
                                    <h4> <strong class="text-muted"> Cancelled Reason</strong> <span
                                            style="float: right">{{ $order->cancelled_reason ?? '' }}<span></h4>
                                @endif

                                <h4> <strong class="text-muted"> Delivered On Date/Time</strong> <span
                                        style="float: right">{{ $order->delivered_on ?? '' }}<span></h4>

                            </div>
                            @isset($order->items)
                                <hr class="my-4" />
                                <h6 class="heading-small text-muted mb-4">{{ __('Order Items') }}</h6>
                                <div class="pl-lg-4">
                                    @php
                                        $items = 0;
                                    @endphp
                                    @foreach ($order->items as $item)
                                        @php
                                            $items++;
                                        @endphp
                                        <h5 class="heading-small text-muted">{{ __('Item# ' . $items) }}</h5>
                                        <h4>
                                            {{ __('Product Name') }}<span
                                                style="float: right">{{ $item->product->name ?? '-' }}</span>
                                        </h4>
                                        <h4>
                                            {{ __('Product Price') }}<span
                                                style="float: right">{{ $item->product->price ?? '-' }}</span>
                                        </h4>
                                        <h3 class="mt-3">{{__('Addons')}}</h3>
                                        @if ($item->addons['stone'])
                                            <h2 class="heading-small mt-3">{{ __('Stones') }}</h2>
                                            <hr class="" />
                                            <h4 class="heading-small text-muted">
                                                {{ __('Title') }}<span
                                                    style="float: right">{{ $item->addons['stone']->title ?? '-' }}</span>
                                            </h4>
                                            <h4 class="heading-small text-muted">
                                                {{ __('Price') }}<span
                                                    style="float: right">{{ $item->addons['stone']->price ?? 0.0 }}</span>
                                            </h4>
                                            <hr class="" />
                                        @endif

                                        @if ($item->addons['weight'])
                                        <h2 class="heading-small mt-3">{{ __('Weight') }}</h2>
                                        <hr class="" />
                                        <h4 class="heading-small text-muted">
                                            {{ __('Title') }}<span
                                                style="float: right">{{ $item->addons['weight']->title ?? '-' }}</span>
                                        </h4>
                                        <h4 class="heading-small text-muted">
                                            {{ __('Price') }}<span
                                                style="float: right">{{ $item->addons['weight']->price ?? 0.0 }}</span>
                                        </h4>
                                        <hr class="" />
                                    @endif


                                    @if ($item->addons['size'])
                                        <h2 class="heading-small mt-3">{{ __('Size') }}</h2>
                                        <hr class="" />
                                        <h4 class="heading-small text-muted">
                                            {{ __('Title') }}<span
                                                style="float: right">{{ $item->addons['size']->title ?? '-' }}</span>
                                        </h4>
                                        <h4 class="heading-small text-muted">
                                            {{ __('Price') }}<span
                                                style="float: right">{{ $item->addons['size']->price ?? 0.0 }}</span>
                                        </h4>
                                        <hr class="" />
                                    @endif

                                    @if ($item->addons['engraving'])
                                        <h2 class="heading-small mt-3">{{ __('Engraving') }}</h2>
                                        <hr class="" />
                                        <h4 class="heading-small text-muted">
                                            {{ __('Title') }}<span
                                                style="float: right">{{ $item->addons['engraving']->title ?? '-' }}</span>
                                        </h4>
                                        <h4 class="heading-small text-muted">
                                            {{ __('Price') }}<span
                                                style="float: right">{{ $item->addons['engraving']->price ?? 0.0 }}</span>
                                        </h4>
                                        <hr class="" />
                                    @endif
                                        <hr class="my-4" />
                                    @endforeach
                                </div>
                            @endisset
                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">{{ __('Total Charges') }}</h6>
                            <div class="pl-lg-4">
                                <h4><strong class="text-muted"> Total Charges</strong><span
                                        style="float: right">${{ $order->total ?? '' }}<span></h4>
                            </div>
                            <hr class="my-4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')
    </div>


@endsection
