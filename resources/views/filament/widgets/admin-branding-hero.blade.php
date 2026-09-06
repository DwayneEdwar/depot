@php
    $todayRevenue = number_format((float) $todayRevenue, 0, ',', '.');
    $monthlyRevenue = number_format((float) $monthlyRevenue, 0, ',', '.');
    $yearlyRevenue = number_format((float) $yearlyRevenue, 0, ',', '.');
@endphp

<div class="fi-wi-admin-branding-hero relative overflow-hidden rounded-3xl border border-emerald-200/60 bg-gradient-to-r from-slate-950 via-emerald-900 to-cyan-700 p-6 text-white shadow-2xl shadow-emerald-900/20">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(45,212,191,0.35),transparent_35%)]"></div>
    <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-2xl">
            <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-100">
                <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                Depot Air Minum
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Dashboard Operasional & Keuangan</h2>
            <p class="mt-3 max-w-xl text-sm text-emerald-50/90 sm:text-base">
                Pantau performa bisnis, pencapaian harian, dan pemasukan dari penjualan gallon secara real time dengan tampilan yang lebih premium untuk demo klien.
            </p>
        </div>

        <div class="grid w-full max-w-xl grid-cols-2 gap-3 sm:grid-cols-3">
            <div class="rounded-2xl border border-white/15 bg-white/10 p-3 backdrop-blur-sm">
                <div class="text-[11px] font-medium uppercase tracking-[0.15em] text-emerald-100">Hari ini</div>
                <div class="mt-2 text-2xl font-bold text-white">Rp {{ $todayRevenue }}</div>
            </div>
            <div class="rounded-2xl border border-white/15 bg-white/10 p-3 backdrop-blur-sm">
                <div class="text-[11px] font-medium uppercase tracking-[0.15em] text-emerald-100">Bulan ini</div>
                <div class="mt-2 text-2xl font-bold text-white">Rp {{ $monthlyRevenue }}</div>
            </div>
            <div class="rounded-2xl border border-white/15 bg-white/10 p-3 backdrop-blur-sm">
                <div class="text-[11px] font-medium uppercase tracking-[0.15em] text-emerald-100">Tahun ini</div>
                <div class="mt-2 text-2xl font-bold text-white">Rp {{ $yearlyRevenue }}</div>
            </div>
        </div>
    </div>

    <div class="relative mt-6 grid gap-3 sm:grid-cols-2">
        <div class="rounded-2xl border border-white/15 bg-slate-950/20 p-4 backdrop-blur-sm">
            <div class="text-xs uppercase tracking-[0.2em] text-emerald-100">Order aktif</div>
            <div class="mt-2 text-3xl font-bold text-white">{{ $activeOrders }}</div>
        </div>
        <div class="rounded-2xl border border-white/15 bg-slate-950/20 p-4 backdrop-blur-sm">
            <div class="text-xs uppercase tracking-[0.2em] text-emerald-100">Order selesai</div>
            <div class="mt-2 text-3xl font-bold text-white">{{ $completedOrders }}</div>
        </div>
    </div>
</div>
