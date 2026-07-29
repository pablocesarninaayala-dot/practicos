@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --tp-ink:    #1c2230;
        --tp-paper:  #f4f5f7;
        --tp-signal: #f2b705;
        --tp-steel:  #3b6e8f;
        --tp-rust:   #c1440e;
        --tp-moss:   #2e7d32;
    }

    .tp-page {
        background-color: #e9e9e7;
        background-image:
            radial-gradient(circle at 18% 22%, rgba(255,255,255,.55) 0, transparent 2.5%),
            radial-gradient(circle at 42% 68%, rgba(28,34,48,.05) 0, transparent 2%),
            radial-gradient(circle at 76% 12%, rgba(255,255,255,.45) 0, transparent 2.2%),
            radial-gradient(circle at 88% 58%, rgba(28,34,48,.06) 0, transparent 2%),
            radial-gradient(circle at 8% 82%, rgba(28,34,48,.045) 0, transparent 2.3%),
            radial-gradient(circle at 62% 40%, rgba(255,255,255,.4) 0, transparent 1.8%),
            radial-gradient(circle at 30% 92%, rgba(28,34,48,.04) 0, transparent 2%),
            repeating-linear-gradient(0deg, rgba(28,34,48,.025) 0 1px, transparent 1px 34px),
            repeating-linear-gradient(90deg, rgba(28,34,48,.025) 0 1px, transparent 1px 34px),
            radial-gradient(ellipse at center, rgba(233,233,231,0) 55%, rgba(28,34,48,.10) 100%);
        background-size: 90px 90px, 70px 70px, 110px 110px, 65px 65px, 95px 95px, 55px 55px, 80px 80px, 34px 34px, 34px 34px, 100% 100%;
        margin: -1rem;
        padding: 1.75rem;
        border-radius: .25rem;
    }

    .tp-title {
        font-family: 'Oswald', sans-serif;
        font-weight: 700;
        letter-spacing: .02em;
        text-transform: uppercase;
        color: var(--tp-ink);
    }

    .tp-plate {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: .7rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #fff;
        background: var(--tp-ink);
        padding: .3rem .65rem;
        border-radius: .2rem;
        margin-bottom: .6rem;
    }
    .tp-plate::before { content: '\25A0'; color: var(--tp-signal); font-size: .6rem; }

    .gauge-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(28,34,48,.08);
        border-radius: .6rem;
        padding: 1.1rem 1.15rem;
        height: 100%;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .gauge-card::before {
        content: '';
        position: absolute;
        top: 0; left: -30%;
        width: 45%; height: 8px;
        background: repeating-linear-gradient(-45deg, var(--tp-signal) 0 10px, var(--tp-ink) 10px 20px);
        transform: translateY(-8px);
        transition: transform .25s ease;
    }
    .gauge-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px -8px rgba(28,34,48,.25);
    }
    .gauge-card:hover::before { transform: translateY(0); }

    .gauge-ring {
        width: 54px; height: 54px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        color: #fff;
        flex-shrink: 0;
    }
    .gauge-label {
        font-family: 'Oswald', sans-serif;
        font-size: .78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .gauge-value {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 1.85rem;
        color: var(--tp-ink);
        line-height: 1.1;
    }
    .gauge-sub {
        font-size: .74rem;
        color: #8a8f9c;
    }

    .tp-chart-card {
        background: #fff;
        border: 1px solid rgba(28,34,48,.08);
        border-radius: .6rem;
        transition: box-shadow .25s ease;
    }
    .tp-chart-card:hover { box-shadow: 0 10px 24px -10px rgba(28,34,48,.2); }

    .tp-table-card {
        background: #fff;
        border: 1px solid rgba(28,34,48,.08);
        border-radius: .6rem;
        overflow: hidden;
    }
    .tp-table-card thead th {
        font-family: 'Oswald', sans-serif;
        font-size: .72rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #6b7280;
        background: #fafafa;
        border-bottom: 2px solid var(--tp-ink);
    }
    .tp-table-card tbody tr { transition: background .15s ease; }
    .tp-table-card tbody tr:hover { background: rgba(242,183,5,.08); }
</style>

<div class="tp-page">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="tp-plate">Panel de control</span>
            <h2 class="tp-title mb-0">Dashboard</h2>
        </div>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="gauge-card d-flex align-items-center gap-3">
                <div class="gauge-ring" style="background: var(--tp-steel)">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="gauge-label" style="color: var(--tp-steel)">Clientes</div>
                    <div class="gauge-value kpi" data-target="{{ $totalClientes }}">0</div>
                    <div class="gauge-sub">Clientes registrados</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="gauge-card d-flex align-items-center gap-3">
                <div class="gauge-ring" style="background: var(--tp-moss)">
                    <i class="bi bi-truck-front-fill"></i>
                </div>
                <div>
                    <div class="gauge-label" style="color: var(--tp-moss)">Vehículos</div>
                    <div class="gauge-value kpi" data-target="{{ $totalVehiculos }}">0</div>
                    <div class="gauge-sub">Vehículos registrados</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="gauge-card d-flex align-items-center gap-3">
                <div class="gauge-ring" style="background: var(--tp-signal)">
                    <i class="bi bi-wrench-adjustable-circle-fill" style="color:#1c2230"></i>
                </div>
                <div>
                    <div class="gauge-label" style="color:#b58a02">Servicios</div>
                    <div class="gauge-value kpi" data-target="{{ $totalServicios }}">0</div>
                    <div class="gauge-sub">Servicios registrados</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="gauge-card d-flex align-items-center gap-3">
                <div class="gauge-ring" style="background: var(--tp-rust)">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <div class="gauge-label" style="color: var(--tp-rust)">Ingresos</div>
                    <div class="gauge-value kpi" data-target="{{ $totalIngresos }}" data-decimals="2">0</div>
                    <div class="gauge-sub">Ingresos totales</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-8 col-lg-7">
            <div class="tp-chart-card p-3 h-100">
                <span class="tp-plate">Tendencia</span>
                <h6 class="tp-title mb-3" style="font-size:1rem">Ingresos · últimos 6 meses</h6>
                <canvas id="graficoIngresos" height="140"></canvas>
            </div>
        </div>

        <div class="col-md-4 col-lg-5">
            <div class="tp-chart-card p-3 h-100">
                <span class="tp-plate">Flota</span>
                <h6 class="tp-title mb-3" style="font-size:1rem">Vehículos por marca</h6>
                <canvas id="graficoMarcas" height="140"></canvas>
            </div>
        </div>

    </div>

    <div class="tp-table-card">
        <div class="card-header bg-white border-0 pb-0 pt-3 px-3">
            <span class="tp-plate">Bitácora</span>
            <h6 class="tp-title mb-2" style="font-size:1rem">Últimos servicios registrados</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Servicio</th>
                        <th>Vehículo</th>
                        <th>Cliente</th>
                        <th class="pe-3">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosServicios as $servicio)
                        <tr>
                            <td class="ps-3">{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->vehiculo->marca }} {{ $servicio->vehiculo->modelo }}</td>
                            <td>{{ $servicio->vehiculo->cliente->nombre }} {{ $servicio->vehiculo->cliente->apellido }}</td>
                            <td class="pe-3 fw-semibold" style="font-family:'JetBrains Mono',monospace">{{ number_format($servicio->precio, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Aún no hay servicios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    document.querySelectorAll('.kpi').forEach(el => {
        const target = parseFloat(el.dataset.target);
        const decimals = parseInt(el.dataset.decimals || 0);
        const duration = 900;
        const start = performance.now();

        function animar(now) {
            const progreso = Math.min((now - start) / duration, 1);
            const valor = target * progreso;
            el.textContent = decimals > 0
                ? valor.toFixed(decimals)
                : Math.floor(valor).toLocaleString('es-BO');
            if (progreso < 1) requestAnimationFrame(animar);
            else {
                el.textContent = decimals > 0
                    ? target.toFixed(decimals)
                    : target.toLocaleString('es-BO');
            }
        }
        requestAnimationFrame(animar);
    });

    const tpInk    = '#1c2230';
    const tpSteel  = '#3b6e8f';
    const tpMoss   = '#2e7d32';
    const tpSignal = '#f2b705';
    const tpRust   = '#c1440e';

    new Chart(document.getElementById('graficoIngresos'), {
        type: 'line',
        data: {
            labels: {!! json_encode($meses) !!},
            datasets: [{
                label: 'Ingresos',
                data: {!! json_encode($ingresosPorMes) !!},
                borderColor: tpRust,
                backgroundColor: 'rgba(193,68,14,.08)',
                fill: true,
                tension: .3,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: tpRust
            }]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: tpInk,
                    titleFont: { family: 'Oswald' },
                    bodyFont: { family: 'JetBrains Mono' },
                    callbacks: {
                        label: (ctx) => ' ' + ctx.parsed.y.toLocaleString('es-BO', { minimumFractionDigits: 2 })
                    }
                }
            },
            animation: { duration: 900, easing: 'easeOutQuart' },
            scales: {
                y: { ticks: { callback: (v) => v.toLocaleString('es-BO'), font: { family: 'JetBrains Mono', size: 11 } } },
                x: { ticks: { font: { family: 'Inter', size: 11 } } }
            }
        }
    });

    new Chart(document.getElementById('graficoMarcas'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($vehiculosPorMarca->pluck('marca')) !!},
            datasets: [{
                data: {!! json_encode($vehiculosPorMarca->pluck('total')) !!},
                backgroundColor: [tpSteel, tpMoss, tpSignal, tpRust, tpInk],
                hoverOffset: 10,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            cutout: '68%',
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Inter', size: 11 } } },
                tooltip: {
                    backgroundColor: tpInk,
                    bodyFont: { family: 'JetBrains Mono' },
                    callbacks: {
                        label: (ctx) => ` ${ctx.label}: ${ctx.parsed} vehículo(s)`
                    }
                }
            },
            animation: { duration: 900, easing: 'easeOutQuart' }
        }
    });
</script>
@endsection