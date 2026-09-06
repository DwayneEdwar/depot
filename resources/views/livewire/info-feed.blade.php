<div class="depot-shell">
    <header class="depot-topbar">
        <div class="brand">
            <span class="brand-mark">💧</span>
            <span>Depot Air Minum</span>
        </div>

        <nav class="top-actions" aria-label="Navigasi info">
            <a href="/" class="pill-link">Kembali ke beranda</a>
            <a href="#info" class="secondary-button">Info terbaru</a>
        </nav>
    </header>

    <section id="info" class="panel feed-shell" aria-label="Info depot">
        <div class="feed-header">
            <h2>Info & pengumuman</h2>
            <p>Berita terbaru dari depot kami</p>
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
