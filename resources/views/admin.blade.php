@extends('layout_admin.master')
@section('content')
    @include('admin.dashboard')
@endsection
@section('js')
    <script src="{{asset('js/user/moneyConvert.js')}}"></script>
    <script>
        //define chart revenue
        var ctx1 = document.getElementById("chart-revenue").getContext('2d');
        var dataRevenue = {
            labels: [
                @foreach($revenues as $revenue)
                    '{{$revenue->day}}',
                @endforeach
            ],
            datasets: [
                {
                    label: 'Doanh thu (.000đ)',
                    data: [
                        @foreach($revenues as $revenue)
                        {{$revenue->revenue}},
                        @endforeach
                    ],
                    backgroundColor: [
                        @for ($i = 0; $i < 30; $i++)
                            'rgba(75, 192, 192, 0.5)',
                        @endfor
                    ],
                    borderColor: [
                        @for ($i = 0; $i < 30; $i++)
                            'rgba(75, 192, 192, 1)',
                        @endfor
                    ],
                    borderWidth: 1,
                    yAxisID: 'revenue-axes'
                }
            ]
        };
        var optionRevenue = {
            scales: {
                yAxes: [
                    {
                        scaleLabel: {
                            display: true,
                            labelString: 'Doanh thu'
                        },
                        id: 'revenue-axes',
                        ticks: {
                            beginAtZero: true,
                            callback: function (val, index, values) {
                                return money(val);
                            }
                        },
                        position: 'left'
                    }
                ]
            },
            tooltips: {
                callbacks: {
                    label: function (item, data) {
                        return "Doanh thu: " + money(item.yLabel + '000') + 'đ';
                    }
                }
            }
        };
        var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: dataRevenue,
            options: optionRevenue
        });

        //define chart order
        var ctx2 = document.getElementById("chart-order").getContext('2d');
        var dataOrder = {
            labels: [
                @foreach($orders as $order)
                    '{{$order->status}}',
                @endforeach
            ],
            datasets: [
                {
                    label: 'Đơn hàng',
                    data: [
                        @foreach($orders as $order)
                            '{{$order->count}}',
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(54, 162, 235, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1,
                    yAxisID: 'revenue-axes'
                }
            ]
        };
        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: dataOrder
        });
    </script>
    <script>
        /**
         * event change time statistic revenue
         */
        $(document).ready(function () {
            $('#revenue-time').on('change', function (e) {
                var time = $(this).val();
                $.ajax({
                    url: '/admin/revenue',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: {
                        time: time
                    },
                    success: function (res) {
                        myChart1.destroy();
                        if (res.success) {
                            dataRevenue.labels = res.data.map(function (item) {
                                return item.day;
                            });
                            dataRevenue.datasets[0].data = res.data.map(function (item) {
                                return item.revenue;
                            });
                            dataRevenue.datasets[0].backgroundColor = res.data.map(function (item) {
                                return 'rgba(75, 192, 192, 0.5)';
                            });
                            dataRevenue.datasets[0].borderColor = res.data.map(function (item) {
                                return 'rgba(75, 192, 192, 1)';
                            });
                        }
                        myChart1 = new Chart(ctx1, {
                            type: 'bar',
                            data: dataRevenue,
                            options: optionRevenue
                        });
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            })
        })
    </script>
    <script>
        /**
         * event change statistic order
         */
        $(document).ready(function () {
            $('#order-time').on('change', function (e) {
                var time = $(this).val();
                $.ajax({
                    url: '/admin/order',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: {
                        time: time
                    },
                    success: function (res) {
                        var date = new Date();
                        var strDate = '';
                        switch (time) {
                            case 'day':
                                strDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
                                break;
                            case 'month':
                                strDate = (date.getMonth() + 1) + '/' + date.getFullYear();
                                break;
                            case 'year':
                                strDate = date.getFullYear();
                                break;
                        }
                        $('#time-order').text(strDate);
                        myChart2.destroy();
                        if (res.success) {
                            dataOrder.labels = res.data.map(function (item) {
                                return item.status;
                            });
                            dataOrder.datasets[0].data = res.data.map(function (item) {
                                return item.count;
                            });
                        }
                        myChart2 = new Chart(ctx2, {
                            type: 'pie',
                            data: dataOrder
                        });
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            })
        })
    </script>
@endsection
