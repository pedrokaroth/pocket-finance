@extends('app.master.master')

@section('content')

    @include('app.includes.modals.invoice-income')

    @include('app.includes.modals.invoice-expense')

    <div class="app-home">
        <section class="left">
            <article class="box">
                <canvas id="chart-dashboard"></canvas>
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
        var ctx = document.getElementById('chart-dashboard');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
