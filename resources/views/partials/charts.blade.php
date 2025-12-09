<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart 1 - Sales Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .graph-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid #4361ee;
        }

        .graph-title {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .stats-card {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .stats-value {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .stats-label {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .period-selector {
            background: #edf2f7;
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }

        .btn-period {
            background: white;
            border: 2px solid #cbd5e0;
            color: #4a5568;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            margin: 0 5px;
            transition: all 0.3s;
        }

        .btn-period.active {
            background: #4361ee;
            border-color: #4361ee;
            color: white;
        }

        .btn-period:hover:not(.active) {
            border-color: #4361ee;
            color: #4361ee;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .graph-footer {
            background: #f7fafc;
            border-radius: 10px;
            padding: 15px;
            margin-top: 25px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center text-dark fw-bold">📊 Chart 1: Monthly Sales Statistics</h1>
                <p class="text-center text-muted">Analysis of sales performance over the past 12 months</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="stats-card">
                    <div class="stats-value">$124,580</div>
                    <div class="stats-label">Total Sales</div>
                    <div class="mt-3">
                        <span class="badge bg-light text-primary">↑ 12.5%</span>
                        <small class="d-block mt-1">Compared to last year</small>
                    </div>
                </div>

                <div class="stats-card" style="background: linear-gradient(135deg, #06d6a0 0%, #05b585 100%);">
                    <div class="stats-value">3,842</div>
                    <div class="stats-label">Number of Orders</div>
                    <div class="mt-3">
                        <span class="badge bg-light text-success">↑ 8.2%</span>
                        <small class="d-block mt-1">Increase in Orders</small>
                    </div>
                </div>

                <div class="stats-card" style="background: linear-gradient(135deg, #118ab2 0%, #0e7490 100%);">
                    <div class="stats-value">$320</div>
                    <div class="stats-label">Average Order Value</div>
                    <div class="mt-3">
                        <span class="badge bg-light text-info">↑ 4.1%</span>
                        <small class="d-block mt-1">Increase in Average</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="graph-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="graph-title">📈 Monthly Sales Evolution</h3>
                        <div class="period-selector">
                            <button class="btn-period active">12 Months</button>
                            <button class="btn-period">6 Months</button>
                            <button class="btn-period">Quarterly</button>
                            <button class="btn-period">Monthly</button>
                        </div>
                    </div>

                    <canvas id="salesChart"></canvas>

                    <div class="mt-4">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #4361ee;"></div>
                            <span>2024 Sales</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: rgba(67, 97, 238, 0.2);"></div>
                            <span>2023 Sales</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #06d6a0;"></div>
                            <span>Monthly Target</span>
                        </div>
                    </div>

                    <div class="graph-footer">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <h5 class="text-primary">$14,850</h5>
                                <small class="text-muted">Highest Sales (December)</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <h5 class="text-success">$8,420</h5>
                                <small class="text-muted">Lowest Sales (February)</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <h5 class="text-info">12.5%</h5>
                                <small class="text-muted">Annual Growth Rate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart Data
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const sales2024 = [8500, 8420, 9200, 10500, 11200, 12400,
            11800, 13200, 12800, 13800, 14200, 14850
        ];

        const sales2023 = [7800, 7650, 8200, 8800, 9200, 9800,
            9400, 10100, 10500, 11200, 11800, 12400
        ];

        const monthlyTarget = [10000, 10000, 10000, 10000, 10000, 10000,
            10000, 10000, 10000, 10000, 10000, 10000
        ];

        // Chart Setup
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                        label: '2024 Sales',
                        data: sales2024,
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 5,
                        pointBackgroundColor: '#4361ee'
                    },
                    {
                        label: '2023 Sales',
                        data: sales2023,
                        borderColor: 'rgba(67, 97, 238, 0.3)',
                        backgroundColor: 'rgba(67, 97, 238, 0.05)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4
                    },
                    {
                        label: 'Monthly Target',
                        data: monthlyTarget,
                        borderColor: '#06d6a0',
                        borderWidth: 2,
                        borderDash: [3, 3],
                        fill: false,
                        tension: 0,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        // rtl: true, // Removed Arabic RTL setting
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: $${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            },
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Time Period Button Interaction
        document.querySelectorAll('.btn-period').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.btn-period').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Here you can add logic to update data based on the selected period
                console.log('Selected Period:', this.textContent);
            });
        });
    </script>
</body>

</html>
