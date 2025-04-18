@extends('dashboard.layouts.master')

{{-- اول سكشن هوي العناون  --}}
{{-- انا كنت عامل يلد اسمو تايتل هون عم اعطيه قيمة  --}}
@section('title')
@endsection
{{-- فينا نحط اند سكشن او ستووب نفس الشي --}}
{{-- تاني يلد تبع السي اس اس  --}}
{{-- بحط فيه السي اس اس الخاص بهي الصفحة فقط  --}}
@section('css')
@stop

@section('title_page')

@stop
@section('tiltle_page2')
@stop

@section('contant')

{{-- ++++++++++++++++++++++ --}}
<section class="content">
    <div class="container-fluid">
      <div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order List</h3>
        </div>
        <!-- /.card-header -->
        {{-- <div class="card-body">
            <table id="example2" class="table table-bordered table-hover"> --}}

                <div class="table-responsive">
                    <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Billing Name</th>
                        <th>Billing Address</th>
                        <th>City</th>
                        <th>Province</th>
                        <th>Postal Code</th>
                        <th>Phone</th>
                        <th>Name on Card</th>
                        <th>Discount</th>
                        <th>Discount Code</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Payment Gateway</th>
                        <th>Shipped</th>
                        <th>Error</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Not Registered' }}</td>
                            <td>{{ $order->billing_email ?? 'N/A' }}</td>
                            <td>{{ $order->billing_name ?? 'N/A' }}</td>
                            <td>{{ $order->billing_address ?? 'N/A' }}</td>
                            <td>{{ $order->billing_city ?? 'N/A' }}</td>
                            <td>{{ $order->billing_province ?? 'N/A' }}</td>
                            <td>{{ $order->billing_postalcode ?? 'N/A' }}</td>
                            <td>{{ $order->billing_phone ?? 'N/A' }}</td>
                            <td>{{ $order->billing_name_on_card ?? 'N/A' }}</td>
                            <td>{{ $order->billing_discount }}</td>
                            <td>{{ $order->billing_discount_code ?? 'N/A' }}</td>
                            <td>{{ number_format($order->billing_subtotal, 2) }}$</td>
                            <td>{{ number_format($order->billing_tax, 2) }}$</td>
                            <td>{{ number_format($order->billing_total, 2) }}$</td>
                            <td>{{ ucfirst($order->payment_gateway) }}</td>
                            <td>{{ $order->shipped ? 'Yes' : 'No' }}</td>
                            <td>{{ $order->error ?? 'None' }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



      </div>
    </div>
    <section>


{{-- +++++++++++++++++++++++++++ --}}
@endsection

@section('scripts')
@endsection

