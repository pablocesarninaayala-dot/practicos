@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --tp-ink:    #1c2230;
        --tp-signal: #f2b705;
        --tp-steel:  #3b6e8f;
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
        min-height: calc(100vh - 2rem);
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
        padding: 1.4rem 1.5rem;
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
        width: 64px; height: 64px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        color: #fff;
        flex-shrink: 0;
    }
    .gauge-label {
        font-family: 'Oswald', sans-serif;
        font-size: .85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .gauge-value {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 2.4rem;
        color: var(--tp-ink);
        line-height: 1.1;
    }
    .gauge-sub {
        font-size: .8rem;
        color: #8a8f9c;
    }
</style>

<div class="tp-page">

    <div class="mb-4">
        <span class="tp-plate">Panel de control</span>
        <h2 class="tp-title mb-0">Dashboard</h2>
    </div>

    <div class="row g-3 justify-content-center">

        <div class="col-12 col-md-5">
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

        <div class="col-12 col-md-5">
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

    </div>

</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.kpi').forEach(el => {
        const target = parseFloat(el.dataset.target);
        const duration = 900;
        const start = performance.now();

        function animar(now) {
            const progreso = Math.min((now - start) / duration, 1);
            const valor = target * progreso;
            el.textContent = Math.floor(valor).toLocaleString('es-BO');
            if (progreso < 1) requestAnimationFrame(animar);
            else el.textContent = target.toLocaleString('es-BO');
        }
        requestAnimationFrame(animar);
    });
</script>
@endsection