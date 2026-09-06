<div class="fi-wi-loyal-customers-widget rounded-3xl border border-emerald-200/60 bg-gradient-to-r from-emerald-50 via-white to-cyan-50 p-5 shadow-sm ring-1 ring-emerald-100">
    <div class="mb-4 flex items-center justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">Pelanggan loyal</p>
            <h3 class="mt-1 text-xl font-bold text-slate-900">Top customer</h3>
        </div>
        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
            {{ $customer ? 'Terbaik' : 'Kosong' }}
        </span>
    </div>

    @if (! $customer)
        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
            Belum ada pelanggan loyal saat ini.
        </div>
    @else
        <div class="flex items-center justify-between gap-4 rounded-2xl border border-emerald-200 bg-white px-4 py-4 shadow-sm">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <p class="truncate text-lg font-bold text-slate-900">{{ $customer->name }}</p>
                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.12em] text-emerald-700">
                        Loyal
                    </span>
                </div>
                <p class="mt-1 text-sm text-slate-500">{{ $customer->whatsapp_number ?? 'Tanpa WhatsApp' }}</p>
            </div>

            <div class="text-right">
                <div class="text-[10px] uppercase tracking-[0.12em] text-slate-500">Poin</div>
                <div class="text-2xl font-bold text-emerald-700">{{ $customer->points }}</div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
            <div class="rounded-xl bg-slate-50 p-3">
                <div class="text-[10px] uppercase tracking-[0.12em] text-slate-500">Order</div>
                <div class="mt-1 text-lg font-bold text-slate-800">{{ $customer->order_count }}</div>
            </div>
            <div class="rounded-xl bg-slate-50 p-3">
                <div class="text-[10px] uppercase tracking-[0.12em] text-slate-500">Total belanja</div>
                <div class="mt-1 text-lg font-bold text-slate-800">Rp {{ number_format((float) $customer->total_purchase, 0, ',', '.') }}</div>
            </div>
        </div>
    @endif
</div>
