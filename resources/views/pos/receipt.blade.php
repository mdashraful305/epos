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
    <table class="body-wrap">
        <tbody><tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td class="content-wrap aligncenter">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                        <td class="content-block">
                                            <h2>Thanks for using our Shop</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <table class="invoice">
                                                <tbody><tr>
                                                    <td>{{ $order->customer->name }}<br>Invoice #{{ $order->id }}<br>{{ date('d M Y',strtotime($order->created_at)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table class="invoice-items" cellpadding="0" cellspacing="0">

                                                                <tbody>
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp
                                                                    @foreach ($order->carts as $item)
                                                                        @php
                                                                            $total = $total + ($item->price*$item->quantity);
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $item->product->name }} X {{ $item->quantity }}</td>
                                                                            <td class="alignright">{{ $item->price*$item->quantity }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr class="total">
                                                                        <td class="alignright" width="80%">Total</td>
                                                                        <td class="alignright">{{ $total }}</td>
                                                                    </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                           {{ $order->store->name }}<br> {{ $order->store->address }}<br> {{ $order->store->phone }}
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                    <div class="footer">
                        <table width="100%">
                            <tbody><tr>
                                <td class="aligncenter content-block">Questions? Email <a href="tel:{{ $order->store->phone }}">{{ $order->store->phone }}</a></td>
                            </tr>
                        </tbody></table>
                    </div></div>
            </td>
            <td></td>
        </tr>
    </tbody></table>

</body>

</html>
