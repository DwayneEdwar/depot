<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ App\Models\SiteSetting::value('meta_description', 'Depot Air Minum - pesan galon air isi ulang cepat dan terpercaya') }}">
        <title>{{ App\Models\SiteSetting::value('site_name', config('app.name', 'Depot Air Minum')) }}</title>
        @livewireStyles
        <style>
            :root {
                --bg: #f4f8fb;
                --panel: #ffffff;
                --panel-soft: #eef8ff;
                --primary: #0f766e;
                --primary-dark: #115e59;
                --primary-soft: #dff7f5;
                --secondary: #0f172a;
                --muted: #64748b;
                --line: #dfeaf1;
                --warning: #f59e0b;
                --success: #10b981;
                --danger: #ef4444;
                --shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            }

            * { box-sizing: border-box; }

            html { scroll-behavior: smooth; }

            body {
                margin: 0;
                font-family: Inter, "Segoe UI", sans-serif;
                background: linear-gradient(135deg, #f8fbff 0%, #edf7fb 42%, #effaf5 100%);
                color: var(--secondary);
            }

            a { color: inherit; text-decoration: none; }
            img { max-width: 100%; display: block; }
            input, textarea, button { font: inherit; }

            .depot-page {
                min-height: 100vh;
                padding: 56px 18px;
            }

            .depot-shell {
                max-width: 1220px;
                margin: 0 auto;
            }

            .depot-topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 22px;
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                font-weight: 800;
                letter-spacing: 0.02em;
                color: var(--secondary);
            }

            .site-footer {
                margin-top: 36px;
                padding: 28px 18px 40px;
            }

            .site-footer-inner {
                max-width: 1220px;
                margin: 0 auto;
                border-top: 1px solid rgba(148,163,184,0.22);
                padding-top: 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                flex-wrap: wrap;
                color: var(--muted);
            }

            .brand-mark {
                width: 44px;
                height: 44px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, var(--primary) 0%, #22c55e 100%);
                color: white;
                font-size: 1.25rem;
                box-shadow: 0 12px 28px rgba(15, 118, 110, 0.22);
            }

            .top-actions {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-wrap: wrap;
            }

            .pill-link,
            .primary-button,
            .secondary-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                padding: 10px 18px;
                font-weight: 700;
                font-size: 0.92rem;
                transition: 0.2s ease;
                cursor: pointer;
            }

            .pill-link {
                background: rgba(255,255,255,0.72);
                border: 1px solid rgba(15, 118, 110, 0.14);
                color: var(--secondary);
            }

            .primary-button {
                background: linear-gradient(135deg, var(--primary) 0%, #0ea5a4 100%);
                color: #fff;
                border: none;
                box-shadow: 0 10px 24px rgba(15, 118, 110, 0.26);
            }

            .secondary-button {
                background: transparent;
                border: 1px solid rgba(15, 23, 42, 0.12);
                color: var(--secondary);
            }

            .depot-hero {
                display: grid;
                grid-template-columns: 1.15fr 0.85fr;
                gap: 28px;
                background: rgba(255,255,255,0.7);
                border: 1px solid rgba(148, 163, 184, 0.18);
                border-radius: 32px;
                box-shadow: var(--shadow);
                overflow: hidden;
                backdrop-filter: blur(10px);
            }

            .hero-copy {
                padding: 46px 42px 40px;
            }

            .eyebrow {
                display: inline-block;
                margin-bottom: 18px;
                background: var(--primary-soft);
                border: 1px solid rgba(15,118,110,0.18);
                color: var(--primary-dark);
                padding: 9px 14px;
                border-radius: 999px;
                font-size: 0.72rem;
                letter-spacing: 0.14em;
                font-weight: 800;
                text-transform: uppercase;
            }

            h1 {
                margin: 0;
                font-size: clamp(2.2rem, 3vw, 4rem);
                line-height: 1.03;
                letter-spacing: -0.06em;
            }

            .lead {
                margin-top: 18px;
                max-width: 620px;
                font-size: 1.08rem;
                line-height: 1.8;
                color: var(--muted);
            }

            .hero-actions {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-top: 28px;
                flex-wrap: wrap;
            }

            .hero-meta {
                margin-top: 28px;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 14px;
            }

            .meta-box {
                padding: 16px 14px;
                background: #f8fafc;
                border: 1px solid var(--line);
                border-radius: 18px;
            }

            .meta-label {
                display: block;
                font-weight: 600;
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--muted);
                margin-bottom: 8px;
            }

            .meta-value {
                font-weight: 800;
                font-size: 1.2rem;
                color: var(--secondary);
            }

            .hero-visual {
                position: relative;
                background: linear-gradient(170deg, #0d766e 0%, #0f172a 100%);
                min-height: 620px;
                padding: 34px 30px 28px;
            }

            .visual-overlay {
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top left, rgba(255,255,255,0.18), transparent 60%), linear-gradient(115deg, rgba(255,255,255,0.05), transparent 65%);
            }

            .visual-content {
                position: relative;
                z-index: 1;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .mini-card {
                background: rgba(255,255,255,0.08);
                border: 1px solid rgba(255,255,255,0.15);
                border-radius: 22px;
                padding: 18px 18px 20px;
                backdrop-filter: blur(8px);
            }

            .mini-card .label {
                color: rgba(255,255,255,0.72);
                font-size: 0.78rem;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                margin-bottom: 12px;
            }

            .mini-card strong {
                display: block;
                font-size: 2rem;
                letter-spacing: -0.05em;
                margin: 0 0 8px;
            }

            .mini-card small {
                color: rgba(255,255,255,0.76);
                font-size: 0.88rem;
            }

            .gallon-graphic {
                display: flex;
                align-items: end;
                justify-content: center;
                min-height: 280px;
                padding-top: 24px;
            }

            .gallon {
                position: relative;
                width: 220px;
                height: 260px;
                border-radius: 28px 28px 36px 36px;
                background: linear-gradient(180deg, rgba(175, 244, 255, 0.38) 0%, rgba(148, 163, 184, 0.08) 40%, rgba(255,255,255,0.10) 100%);
                border: 1px solid rgba(255,255,255,0.14);
                overflow: hidden;
                box-shadow: 0 18px 36px rgba(15, 23, 42, 0.3);
            }

            .gallon::before {
                content: "";
                position: absolute;
                top: -26px;
                left: 20px;
                right: 20px;
                height: 34px;
                border-radius: 18px 18px 10px 10px;
                background: rgba(255,255,255,0.18);
                border: 1px solid rgba(255,255,255,0.22);
            }

            .gallon::after {
                content: "";
                position: absolute;
                left: 28px;
                right: 28px;
                bottom: 32px;
                height: 118px;
                border-radius: 20px;
                background: linear-gradient(180deg, rgba(250,255,255,0.9), rgba(194,241,252,0.74));
                box-shadow: inset 0 0 40px rgba(14,116,144,0.18);
            }

            .gallon .shine {
                position: absolute;
                left: 42px;
                top: 28px;
                width: 22px;
                height: 150px;
                border-radius: 999px;
                background: rgba(255,255,255,0.26);
                transform: rotate(10deg);
            }

            .product-grid {
                margin-top: 28px;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 18px;
            }

            .feature-box {
                background: rgba(255,255,255,0.72);
                border: 1px solid var(--line);
                border-radius: 22px;
                padding: 22px 18px 18px;
                box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
            }

            .feature-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, #dcfce7 0%, #ccfbf1 100%);
                color: var(--primary-dark);
                font-size: 1.3rem;
                margin-bottom: 12px;
            }

            .feature-box h3 {
                margin: 0 0 8px;
                font-size: 1.08rem;
                letter-spacing: -0.03em;
            }

            .feature-box p {
                margin: 0;
                color: var(--muted);
                font-size: 0.95rem;
                line-height: 1.7;
            }

            .order-layout {
                display: grid;
                grid-template-columns: 1.2fr 0.8fr;
                gap: 20px;
                margin-top: 32px;
            }

            .panel {
                background: rgba(255,255,255,0.86);
                border: 1px solid rgba(148,163,184,0.2);
                border-radius: 28px;
                box-shadow: 0 18px 34px rgba(15, 23, 42, 0.06);
            }

            .form-panel {
                padding: 28px 24px 30px;
            }

            .form-panel h2,
            .summary-panel h2,
            .feed-header h2 {
                margin: 0 0 18px;
                font-size: clamp(1.6rem, 2vw, 2.2rem);
                letter-spacing: -0.05em;
            }

            .field-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-bottom: 16px;
            }

            .field.full {
                grid-column: 1 / -1;
            }

            label {
                display: block;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                color: var(--muted);
            }

            input,
            textarea {
                width: 100%;
                padding: 13px 14px;
                border-radius: 14px;
                border: 1px solid var(--line);
                background: #f8fbff;
                color: var(--secondary);
                transition: 0.2s ease;
                appearance: textfield;
                -moz-appearance: textfield;
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input:focus,
            textarea:focus {
                outline: none;
                border-color: rgba(15,118,110,0.45);
                box-shadow: 0 0 0 4px rgba(20,184,166,0.12);
                background: #fff;
            }

            textarea { min-height: 120px; resize: vertical; }

            .error-text {
                color: var(--danger);
                font-size: 0.78rem;
                margin-top: -4px;
            }

            .summary-panel {
                padding: 28px 24px;
                background: linear-gradient(180deg, rgba(15,118,110,0.05), rgba(14,165,233,0.04));
            }

            .summary-box {
                background: white;
                padding: 20px;
                border-radius: 20px;
                border: 1px solid rgba(148,163,184,0.2);
                box-shadow: inset 0 0 0 1px rgba(255,255,255,0.4);
            }

            .price-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 0;
                color: var(--muted);
            }

            .price-row.total {
                padding-top: 16px;
                margin-top: 10px;
                border-top: 1px solid var(--line);
                color: var(--secondary);
                font-weight: 800;
                font-size: 1.2rem;
            }

            .submit-button {
                width: 100%;
                margin-top: 18px;
                border: none;
                background: linear-gradient(135deg, var(--primary) 0%, #0ea5a4 100%);
                color: white;
                border-radius: 14px;
                font-weight: 800;
                padding: 16px 18px;
                box-shadow: 0 18px 30px rgba(15,118,110,0.22);
                cursor: pointer;
            }

            .success-box {
                margin-top: 20px;
                padding: 12px 14px;
                border-radius: 14px;
                background: rgba(16,185,129,0.08);
                border: 1px solid rgba(16,185,129,0.2);
                color: #166534;
                font-weight: 600;
            }

            .feed-shell {
                margin-top: 36px;
                padding: 32px 26px 12px;
            }

            .feed-header {
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 18px;
            }

            .feed-header p {
                margin: 0;
                color: var(--muted);
                font-weight: 600;
            }

            .cards-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 18px;
            }

            .info-card {
                background: rgba(255,255,255,0.9);
                border: 1px solid rgba(148,163,184,0.2);
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 18px 30px rgba(15, 23, 42, 0.05);
            }

            .info-card .card-banner {
                padding: 26px 20px 18px;
                background: linear-gradient(135deg, #0ea5e9 0%, #0f766e 100%);
                color: white;
            }

            .info-card .tag {
                display: inline-flex;
                align-items: center;
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                font-weight: 800;
                opacity: 0.8;
            }

            .info-card h3 {
                margin: 18px 0 0;
                font-size: 1.45rem;
                line-height: 1.2;
                letter-spacing: -0.05em;
            }

            .info-card .card-body {
                padding: 20px 20px 22px;
            }

            .meta-date {
                display: inline-block;
                margin-bottom: 12px;
                font-size: 0.76rem;
                color: var(--muted);
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .info-card .content {
                color: var(--muted);
                line-height: 1.8;
                font-size: 0.97rem;
            }

            .empty-state {
                padding: 44px 20px;
                border-radius: 22px;
                border: 1px dashed rgba(148,163,184,0.7);
                text-align: center;
                color: var(--muted);
                background: rgba(255,255,255,0.6);
                font-weight: 600;
            }

            @media (max-width: 980px) {
                .depot-hero,
                .order-layout,
                .cards-grid {
                    grid-template-columns: 1fr;
                }

                .hero-copy { padding: 30px 24px 24px; }
                .hero-visual { min-height: 420px; }
                .field-grid { grid-template-columns: 1fr; }
            }

            @media (max-width: 640px) {
                .depot-page { padding: 24px 14px; }
                .depot-topbar { flex-direction: column; align-items: flex-start; }
                .hero-meta, .product-grid { grid-template-columns: 1fr; }
                .top-actions { width: 100%; }
                .pill-link, .primary-button, .secondary-button { width: 100%; }
            }
        </style>
    </head>
    <body>
        <main class="depot-page">
            {{ $slot }}
        </main>

        <footer class="site-footer">
            <div class="site-footer-inner">
                <div>
                    <strong>{{ App\Models\SiteSetting::value('site_name', 'Depot Air Minum') }}</strong>
                </div>
                <div>{{ App\Models\SiteSetting::value('footer_text', '© 2026 Semua hak dilindungi.') }}</div>
                <div>{{ App\Models\SiteSetting::value('footer_contact', 'Hubungi kami untuk layanan terbaik') }}</div>
            </div>
        </footer>
        @livewireScripts
    </body>
</html>
