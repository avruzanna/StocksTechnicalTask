<!DOCTYPE html>
<html>
<head>
    <title>All Stocks</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .positive-change {
            color: green;
        }
        .negative-change {
            color: red;
        }
        .arrow-up::before {
            content: '▲';
            color: green;
        }
        .arrow-down::before {
            content: '▼';
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">All Stocks</h1>
        <p>{{ $info }}</p>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Stock Name</th>
                    <th>Ticker</th>
                    <th>Price</th>
                    <th>Previous Price</th>
                    <th>Change Percentage</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                        <tr>
                            <td>{{ $stock['stock']->name }}</td>
                            <td>{{ $stock['stock']->ticker }}</td>
                            <td>{{ $stock['stock_price']['close'] }}</td>
                            <td>{{ $stock['stock_price']['previous_close'] }}</td>
                            <td class="{{ $stock['stock_price']['percentage_change'] >= 0 ? 'positive-change arrow-up' : 'negative-change arrow-down' }}">
                                {{ number_format($stock['stock_price']['percentage_change'], 2) }}%
                            </td>
                            <td>{{ $stock['stock_price']['recorded_at'] }}</td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>