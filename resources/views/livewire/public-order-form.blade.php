<div class="depot-shell">
    <header class="depot-topbar">
        <div class="brand">
            <span class="brand-mark">💧</span>
            <span>{{ App\Models\SiteSetting::value('site_name', 'Depot Air Minum') }}</span>
        </div>

        <nav class="top-actions" aria-label="Navigasi utama">
            <a href="#order" class="pill-link">{{ App\Models\SiteSetting::value('header_cta_primary', 'Pesan Sekarang') }}</a>
            <a href="#info" class="secondary-button">{{ App\Models\SiteSetting::value('header_cta_secondary', 'Info & Promo') }}</a>
        </nav>
    </header>

    <section class="depot-hero">
        <div class="hero-copy">
            <span class="eyebrow">{{ App\Models\SiteSetting::value('hero_badge', 'Layanan rumah & usaha') }}</span>
            <h1>{{ App\Models\SiteSetting::value('hero_title', 'Air minum isi ulang yang cepat, bersih, dan terpercaya.') }}</h1>
            <p class="lead">
                {{ App\Models\SiteSetting::value('hero_description', 'Dapatkan galon air berkualitas untuk keperluan rumah, kantor, toko, dan usaha dengan proses pengiriman yang cepat dan aman.') }}
            </p>

            <div class="hero-actions">
                <a href="#order" class="primary-button">{{ App\Models\SiteSetting::value('hero_primary_button', 'Pesan galon') }}</a>
                <a href="#info" class="secondary-button">{{ App\Models\SiteSetting::value('hero_secondary_button', 'Lihat pengumuman') }}</a>
            </div>

            <div class="hero-meta">
                <div class="meta-box">
                    <span class="meta-label">{{ App\Models\SiteSetting::value('stat_label_1', 'Pengiriman') }}</span>
                    <span class="meta-value">{{ App\Models\SiteSetting::value('stat_value_1', '1–2 jam') }}</span>
                </div>
                <div class="meta-box">
                    <span class="meta-label">{{ App\Models\SiteSetting::value('stat_label_2', 'Galon') }}</span>
                    <span class="meta-value">{{ App\Models\SiteSetting::value('stat_value_2', '15.000') }}</span>
                </div>
                <div class="meta-box">
                    <span class="meta-label">{{ App\Models\SiteSetting::value('stat_label_3', 'Kualitas') }}</span>
                    <span class="meta-value">{{ App\Models\SiteSetting::value('stat_value_3', '100%') }}</span>
                </div>
            </div>
        </div>

        <div class="hero-visual" aria-label="Ilustrasi galon air">
            <div class="visual-overlay"></div>
            <div class="visual-content">
                <div class="mini-card">
                    <div class="label">{{ App\Models\SiteSetting::value('hero_card_label', 'Kenyamanan harian') }}</div>
                    <strong>{{ App\Models\SiteSetting::value('hero_card_value', '2.400+') }}</strong>
                    <small>{{ App\Models\SiteSetting::value('hero_card_description', 'Pelanggan yang sudah menikmati layanan kami.') }}</small>
                </div>

                <div class="gallon-graphic">
                    <div class="gallon">
                        <span class="shine"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-grid" aria-label="Keunggulan produk">
        <article class="feature-box">
            <div class="feature-icon">🚚</div>
            <h3>{{ App\Models\SiteSetting::value('feature_1_title', 'Pengiriman cepat') }}</h3>
            <p>{{ App\Models\SiteSetting::value('feature_1_text', 'Tim kami siap mengantarkan pesanan dengan jadwal yang cepat dan konsisten.') }}</p>
        </article>

        <article class="feature-box">
            <div class="feature-icon">💧</div>
            <h3>{{ App\Models\SiteSetting::value('feature_2_title', 'Air jernih & aman') }}</h3>
            <p>{{ App\Models\SiteSetting::value('feature_2_text', 'Setiap galon diproses dengan standar kebersihan dan kualitas yang terjaga.') }}</p>
        </article>

        <article class="feature-box">
            <div class="feature-icon">📦</div>
            <h3>{{ App\Models\SiteSetting::value('feature_3_title', 'Langganan praktis') }}</h3>
            <p>{{ App\Models\SiteSetting::value('feature_3_text', 'Nikmati pengalaman berlangganan yang lebih mudah untuk kebutuhan harian Anda.') }}</p>
        </article>
    </section>

    <section id="order" class="order-layout" aria-label="Form pemesanan">
        <div class="panel form-panel">
            <h2>Pemesanan galon</h2>

            <form wire:submit.prevent="submit">
                <div class="field-grid">
                    <div class="field full">
                        <label for="customerName">Nama pelanggan</label>
                        <input id="customerName" type="text" wire:model="customerName" placeholder="Masukkan nama lengkap" />
                        @error('customerName')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="whatsappNumber">Nomor WhatsApp</label>
                        <input id="whatsappNumber" type="text" wire:model="whatsappNumber" placeholder="08xxxxxxxxxx" />
                        @error('whatsappNumber')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="address">Alamat pengiriman</label>
                        <textarea id="address" wire:model="address" placeholder="Contoh: Jl. Pahlawan No. 15, Bandung"></textarea>
                        @error('address')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="selectedPackage">Paket harga</label>
                        <select id="selectedPackage" wire:model.live="selectedPackage" style="width: 100%; padding: 13px 14px; border-radius: 14px; border: 1px solid var(--line); background: #f8fbff; color: var(--secondary);">
                            @foreach ($pricingPresets as $preset)
                                <option value="{{ $preset['slug'] ?? 'standard' }}">{{ $preset['label'] ?? ucfirst($preset['slug'] ?? 'Standar') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label for="gallonQuantity">Jumlah galon</label>
                        <input id="gallonQuantity" type="number" min="1" wire:model.live="gallonQuantity" />
                        @error('gallonQuantity')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="deliveryDate">Tanggal pengiriman</label>
                        <input id="deliveryDate" type="date" wire:model="deliveryDate" />
                        @error('deliveryDate')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="submit-button">Pesan sekarang</button>
            </form>

            @if ($isSubmitted)
                <div class="success-box">
                    Pesanan Anda berhasil dikirim. Tim kami akan segera menghubungi Anda.
                </div>
            @endif
        </div>

        <aside class="panel summary-panel">
            <h2>Ringkasan pesanan</h2>

            <div class="summary-box">
                <div class="price-row">
                    <span>Paket</span>
                    <strong>{{ ucfirst($selectedPackage) }}</strong>
                </div>
                <div class="price-row">
                    <span>Harga per galon</span>
                    <strong>Rp {{ number_format($unitPrice, 0, ',', '.') }}</strong>
                </div>
                <div class="price-row">
                    <span>Jumlah galon</span>
                    <strong>{{ $gallonQuantity }}</strong>
                </div>
                <div class="price-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
            </div>
        </aside>
    </section>

    <section id="info" class="panel feed-shell" aria-label="Info dan pengumuman depot">
        <div class="feed-header">
            <h2>Info & pengumuman</h2>
            <p>Update terbaru dari depot</p>
        </div>

        @if ($posts->isEmpty())
            <div class="empty-state">Belum ada pengumuman yang dipublikasikan untuk saat ini.</div>
        @else
            <div class="cards-grid">
                @foreach ($posts as $post)
                    <article class="info-card">
                        <div class="card-banner">
                            <span class="tag">Update</span>
                            <h3>{{ $post->title }}</h3>
                        </div>
                        <div class="card-body">
                            <span class="meta-date">
                                {{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : 'Baru' }}
                            </span>
                            <div class="content">
                                {!! $post->content !!}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
