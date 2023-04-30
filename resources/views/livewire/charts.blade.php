<div>
    <x-section class="max-w-5xl" title="APEX">
        <x-apex-chart title="Default Test">
            <div id="chart-retire"></div>
        </x-apex-chart>
    </x-section>
</div>

@push('apex-charts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Chart Options
        var options = {
            chart: {
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            grid: {
                show: true,
                borderColor: '#90A4AE',
                strokeDashArray: 0,
                position: 'back',
                xaxis: {
                    lines: {
                        show: false
                    }
                },   
                yaxis: {
                    lines: {
                        show: false
                    }
                },  
                row: {
                    colors: undefined,
                    opacity: 0.5
                },  
                column: {
                    colors: undefined,
                    opacity: 0.5
                },  
                padding: {
                    top: 0,
                    right: 10,
                    bottom: 0,
                    left: 0
                },  
            },
            legend: {
                floating: true
            },
            series: [{
                name: '{!! $tooltip !!}',
                data: @json($collection->values()->toArray())
            }],
            xaxis: {
                categories: @json($collection->keys()->toArray()),
                labels: {
                    show: true
                }
            },
            yaxis: {
                labels: {
                    show: false
                },
                max: 90
            }
        }

        // Chart ID + Render()
        var chart = new ApexCharts(document.querySelector("#chart-retire"), options);
        chart.render();
    </script>
@endpush

