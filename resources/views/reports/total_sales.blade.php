@extends('layouts.app')

@section('title', 'Total Sales')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0">Yearly Sales</h5>
                        </div>

                        <div class="card-body">
                            {{-- Filter Form: Select Year --}}
                            <div class="container-fluid mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="form" action="{{ route('report.total_sales') }}">
                                            @csrf
                                            <div class="row align-items-center">
                                                
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label">Select State</label>
                                                    <select name="state_id" class="form-control">
                                                        <option value="">All States</option>
                                                        @foreach($states as $st)
                                                            <option value="{{ $st->stateId }}" {{ ($stateId ?? null) == $st->stateId ? 'selected' : '' }}>
                                                                {{ $st->stateName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                
                                                <div class="col-md-3 mb-2">
                                                    <label class="form-label">Select Financial Year</label>
                                                    <select name="year" class="form-control">
                                                        @foreach($years as $year)
                                                            <option value="{{ $year }}"
                                                                {{ $year == $selectedYear ? 'selected' : '' }}>
                                                                {{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <div class="input-group d-flex justify-content-right" style="margin-top: 24px;">
                                                        <button type="submit" class="btn btn-primary mx-2">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Year Amount on Top --}}
                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <strong>Total Sales ({{ $selectedYear }}):</strong>
                                    ₹ {{ number_format($yearTotal, 2) }}
                                </div>
                            </div>

                            {{-- Bar Chart --}}
                            <div class="mt-4">
                                <canvas id="salesChart"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


<script>
    const labels = @json($labels);
const data   = @json($data);

const ctx = document.getElementById('salesChart').getContext('2d');

const salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Monthly Sales (₹)',
            data: data,
            backgroundColor: "rgb(156 175 136 / 84%)",
            borderColor: "rgb(156 175 136 / 100%)",
            borderWidth: 1
        }]
    },
    plugins: [ChartDataLabels],
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',     // place at the bar end
                align: 'top',       // push upward
                offset: 10,         // more space above bar
                clamp: true,        // prevent clipping
                color: '#000',
                formatter: value => value.toLocaleString(),
                font: {
                    weight: 'bold',
                    size: 12
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grace: '30%',  // ← VERY IMPORTANT
            }
        }
    }
});


</script>
@endsection
