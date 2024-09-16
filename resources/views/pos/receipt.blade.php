<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Receipt</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 0;
            width: 300px;
            background-color: #f7f7f7;
        }

        .receipt {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            border: 1px solid #000;
            margin: auto;
            background-color: #fff;
        }

        .receipt-header,
        .receipt-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt-header h1 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .receipt-header p {
            margin: 5px 0;
        }

        .section-title {
            text-align: left;
            margin: 15px 0 5px 0;
            font-weight: bold;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }

        .customer-info,
        .payment-info {
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
        }

        .info-row div {
            flex: 1;
        }

        .receipt-body {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin: 10px 0;
            padding: 10px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .item .name {
            flex: 1;
        }

        .item .qty {
            width: 50px;
            text-align: right;
        }

        .item .price {
            width: 60px;
            text-align: right;
        }

        .total {
            font-weight: bold;
            margin-top: 10px;
        }

        .receipt-footer p {
            margin: 5px 0;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
    </style>
</head>

<body>

    <div class="receipt">
        <div class="receipt-header">
            <h1> {{ $order->store->name }}</h1>
            <p>{{ $order->store->address }}</p>
            <p>{{ $order->store->phone }}</p>
            <p>Date: {{ date('d M Y', strtotime($order->created_at)) }}</p>
            <p>Receipt #: {{ $order->id }}</p>
        </div>

        <div class="customer-info">
            <div class="section-title">Customer Info</div>
            <div class="info-row">
                <div>Name:</div>
                <div>{{ $order->customer->name }}</div>
            </div>
            @isset($order->customer->email)
                <div class="info-row">
                    <div>Email:</div>
                    <div>{{ $order->customer->email }}</div>
                </div>
            @endisset
            @isset($order->customer->phone)
                <div class="info-row">
                    <div>Phone:</div>
                    <div>{{ $order->customer->phone }}</div>
                </div>
        </div>
        @endisset
        <div class="receipt-body">
            @php
                $total = 0;
            @endphp
            @foreach ($order->carts as $item)
                @php
                    $total = $total + $item->price;
                @endphp
                <div class="item">
                    <div class="name">{{ $item->product->name }}</div>
                    <div class="qty">{{ $item->quantity }}</div>
                    <div class="price">{{ $item->price }}</div>
                </div>
            @endforeach
            <hr>
            <div class="total">
                <div class="name">Total</div>
                <div class="price">{{ $total }}</div>
            </div>
        </div>

        {{-- <div class="payment-info">
            <div class="section-title">Payment Info</div>
            <div class="info-row">
                <div>Payment Method:</div>
                <div>Credit Card</div>
            </div>
            <div class="info-row">
                <div>Card Type:</div>
                <div>VISA</div>
            </div>
            <div class="info-row">
                <div>Card Number:</div>
                <div>**** **** **** 1234</div>
            </div>
        </div> --}}

        <div class="receipt-footer">
            <p>Thank you for your business!</p>
            <p>Visit again soon!</p>
        </div>
    </div>

</body>

</html>
