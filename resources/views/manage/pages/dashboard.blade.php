@extends('manage.layout.app')

@section('title', 'Dashboard')

@section('content')
 <!--begin::Content-->
 <div id="kt_app_content" class="app-content ">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container ">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-6">
                <!-- begin::Card -->
                <div class="card">
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>


@endsection


@section('scripts')
<script>
    let initChart = () => {
        var chartData = {!! json_encode($chartData) !!};
        var chartOptions = {!! json_encode($chartOptions) !!};

        var ctx = document.getElementById('pieChart').getContext('2d');
        var removedItemsChart = new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: chartOptions,
        });
    }
    initChart();
</script>
@endsection
