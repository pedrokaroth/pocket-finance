@extends('app.master.master')

@section('content')

    @include('app.includes.modals.invoice-income')

    @include('app.includes.modals.invoice-expense')

    <div class="app-home">
        <section class="left">
            <article class="box">
                <header class="box-header">
                    <span>
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </span>
                </header>
                <div class="box-body">
                    <div id="control"></div>
                </div>
            </article>
        </section>
        <section class="right">
            <article class="widget-launch">
                <button class="income btn btn-outline-success open-modal" data-modal="invoice-income">
                    <i class="fas fa-plus-circle"></i>
                    <span>RECEITA</span>
                </button>
                <button class="expense btn btn-outline-danger open-modal" data-modal="invoice-expense">
                    <i class="fas fa-minus-circle"></i>
                    <span>DESPESA</span>
                </button>
            </article>
        </section>
    </div>
@endsection

@section('script')
    <script>
        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: '.'
            }
        });

        const chart = Highcharts.chart('control', {
            chart: {
                type: 'areaspline',
                height: 300
            },
            title: null,
            xAxis: {
                categories: @json($chartData->categories),
                minTickInterval: 1
            },
            yAxis: {
                allowDecimals: true,
                title: null,
            },
            tooltip: {
                shared: true,
                valueDecimals: 2,
                valuePrefix: 'R$ '
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: 'Receitas',
                data: @json($chartData->income),
                color: '#61DDBC',
                lineColor: '#36BA9B'
            }, {
                name: 'Despesas',
                data: @json($chartData->expense),
                color: '#F76C82',
                lineColor: '#D94352'
            }]
        });
    </script>
@endsection
