<?php 
require_once __DIR__ . '/includes/header.php'; 

// Fetch 6 top cars
$stmt = $pdo->query("SELECT * FROM Car ORDER BY pricePerDay DESC LIMIT 6");
$cars = $stmt->fetchAll();
?>

<!-- ── HERO ── -->
<section class="hero">
  <div class="hero-badge">
    <span class="dot"></span>
    Kini tersedia 50+ kendaraan mewah &amp; elektrik
  </div>

  <h1>
    Kendarai Masa Depan.<br>
    <span class="gradient-text">Rasakan Kemewahan.</span>
  </h1>

  <p>
    Dari sedan elektrik elegan hingga supercar bertenaga tinggi — pesan kendaraan impian Anda dalam 3 menit. Tanpa dokumen, kunci langsung di genggaman.
  </p>

  <div class="hero-actions">
    <a href="/pages/fleet.php" class="btn btn-primary" style="font-size:1rem;padding:0.85rem 2rem;">
      &#9654;&nbsp; Lihat Armada
    </a>
    <a href="/auth/register.php" class="btn btn-ghost" style="font-size:1rem;padding:0.85rem 2rem;">
      Daftar Gratis
    </a>
  </div>

  <div class="hero-scroll-hint">
    <span>Gulir</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- ── STATS BAR ── -->
<div class="stats-bar" data-aos="fade-up" data-aos-delay="200">
  <div class="stat-item">
    <div class="stat-num">50+</div>
    <div class="stat-label">Kendaraan Premium</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">98%</div>
    <div class="stat-label">Kepuasan Pelanggan</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">3 menit</div>
    <div class="stat-label">Rata-rata Waktu Booking</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">24/7</div>
    <div class="stat-label">Dukungan Pelanggan</div>
  </div>
</div>

<!-- ── FEATURED FLEET ── -->
<section class="section">
  <div class="section-label">Armada Kami</div>
  <h2>Pilihan Terbaik Minggu Ini</h2>
  <p class="section-sub">Dipilih dengan cermat, dibersihkan, dan siap dikendarai — pilih dari model paling diminati kami.</p>

  <div class="grid">
    <?php foreach($cars as $index => $car): ?>
      <?php 
        $images = json_decode($car['images'], true);
        $imgUrl = is_array($images) && count($images) > 0 ? $images[0] : '';
        $delay = $index * 100;
      ?>
      <div class="car-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
        <div class="car-card-img-wrap">
          <?php if($imgUrl): ?>
            <img src="<?php echo htmlspecialchars($imgUrl); ?>"
                 alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>"
                 class="car-img">
          <?php else: ?>
            <div class="car-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2rem;">&#128663;</div>
          <?php endif; ?>
          <div class="car-card-badge"><?php echo htmlspecialchars($car['category']); ?></div>
        </div>
        <div class="car-info">
          <h3 class="car-title"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
          <p class="car-meta">
            <?php echo htmlspecialchars(ucfirst(strtolower($car['transmission']))); ?> &bull;
            <?php echo htmlspecialchars($car['seats']); ?> Kursi &bull;
            <?php echo htmlspecialchars($car['fuel']); ?>
          </p>
          <div class="car-price-row">
            <div class="car-price">
              $<?php echo htmlspecialchars($car['pricePerDay']); ?>
              <span>/ hari</span>
            </div>
            <a href="/pages/car.php?id=<?php echo urlencode($car['id']); ?>" class="btn btn-primary" style="padding:0.5rem 1.1rem;font-size:0.85rem;">Pesan</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="text-align:center;margin-top:3rem;">
    <a href="/pages/fleet.php" class="btn btn-outline" style="font-size:1rem;padding:0.8rem 2rem;">
      Lihat Semua Kendaraan &rarr;
    </a>
  </div>
</section>

<!-- ── WHY US ── -->
<section class="section" id="why-us" style="padding-top:0;">
  <div class="section-label">Mengapa Cozy Rental</div>
  <h2>Dibuat untuk Orang yang Menghargai Waktu Mereka</h2>
  <p class="section-sub">Kami menghapus setiap hambatan dalam pengalaman rental tradisional.</p>

  <div class="features-grid">
    <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
      <div class="feature-icon">&#9889;</div>
      <h4>Akses Instan</h4>
      <p>Pesan dalam 3 menit. Kunci digital langsung dikirim ke ponsel Anda. Tanpa antrean, tanpa dokumen.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
      <div class="feature-icon">&#128737;</div>
      <h4>Sudah Ter-asuransi</h4>
      <p>Setiap penyewaan sudah termasuk ganti rugi kerusakan dan asuransi pihak ketiga. Berkendara dengan tenang.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
      <div class="feature-icon">&#128584;</div>
      <h4>Armada Pilihan</h4>
      <p>Setiap mobil dipilih dengan teliti, didetail secara profesional, dan diinspeksi keamanannya sebelum penyewaan.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
      <div class="feature-icon">&#127760;</div>
      <h4>Tersedia 24 / 7</h4>
      <p>Tim concierge kami siap membantu kapan saja selama masa sewa Anda.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
      <div class="feature-icon">&#128267;</div>
      <h4>Pilihan Ramah Lingkungan</h4>
      <p>Armada kendaraan listrik premium yang terus berkembang untuk pengemudi berjiwa lingkungan yang tidak mau berkompromi.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
      <div class="feature-icon">&#128176;</div>
      <h4>Harga Transparan</h4>
      <p>Tidak ada biaya tersembunyi, tidak ada kejutan. Harga yang Anda lihat adalah yang Anda bayar.</p>
    </div>
  </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="section" id="testimonials" style="padding-top:0;">
  <div class="section-label">Ulasan</div>
  <h2>Dicintai Pengemudi di Mana-mana</h2>
  <p class="section-sub">Jangan hanya percaya kata kami — ini yang dikatakan pelanggan kami.</p>

  <div class="testimonials-grid">
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"Pesan Tesla tengah malam untuk keesokan harinya. Kunci sudah di ponsel jam 9 pagi. Pengalaman yang benar-benar mulus — lebih baik dari rental mana pun yang pernah saya coba."</p>
      <div class="testimonial-author">
        <div class="avatar">A</div>
        <div>
          <div class="author-name">Alex T.</div>
          <div class="author-sub">Pebisnis, Jakarta</div>
        </div>
      </div>
    </div>
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"Saya menyewa Lamborghini untuk akhir pekan anniversary. Mobilnya sempurna dan prosesnya sangat cepat. Cozy Rental sudah dapat pelanggan seumur hidup!"</p>
      <div class="testimonial-author">
        <div class="avatar">M</div>
        <div>
          <div class="author-name">Maria L.</div>
          <div class="author-sub">Content Creator, Bali</div>
        </div>
      </div>
    </div>
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"Pengalaman rental mewah terbaik yang pernah ada. Tidak ada biaya tersembunyi, kondisi mobil sangat bagus, dan tim dukungan merespons dalam 2 menit ketika saya punya pertanyaan."</p>
      <div class="testimonial-author">
        <div class="avatar">J</div>
        <div>
          <div class="author-name">James K.</div>
          <div class="author-sub">Pengusaha, Surabaya</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<div style="margin: 0 2rem 6rem; position: relative; overflow: hidden; border-radius: 28px;">
  <!-- Layered gradient background -->
  <div style="
    background: linear-gradient(135deg, #312e81 0%, #1e1b4b 40%, #0c0a1e 70%, #0a1628 100%);
    border: 1px solid rgba(129,140,248,0.25);
    border-radius: 28px;
    padding: 6rem 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  ">
    <!-- Glow orbs -->
    <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:500px;height:300px;background:radial-gradient(ellipse at center,rgba(99,102,241,0.35) 0%,transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-60px;left:15%;width:300px;height:200px;background:radial-gradient(ellipse at center,rgba(6,182,212,0.2) 0%,transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-40px;right:10%;width:250px;height:180px;background:radial-gradient(ellipse at center,rgba(139,92,246,0.2) 0%,transparent 70%);pointer-events:none;"></div>

    <!-- Decorative dots grid -->
    <div style="position:absolute;top:2rem;right:3rem;opacity:0.15;font-size:0.5rem;line-height:1.8;letter-spacing:0.5rem;color:white;pointer-events:none;">
      &#8226;&#8226;&#8226;&#8226;&#8226;<br>&#8226;&#8226;&#8226;&#8226;&#8226;<br>&#8226;&#8226;&#8226;&#8226;&#8226;<br>&#8226;&#8226;&#8226;&#8226;&#8226;
    </div>
    <div style="position:absolute;bottom:2rem;left:3rem;opacity:0.15;font-size:0.5rem;line-height:1.8;letter-spacing:0.5rem;color:white;pointer-events:none;">
      &#8226;&#8226;&#8226;&#8226;&#8226;<br>&#8226;&#8226;&#8226;&#8226;&#8226;<br>&#8226;&#8226;&#8226;&#8226;&#8226;
    </div>

    <!-- Content -->
    <div style="position:relative;">
      <span style="display:inline-block;background:rgba(129,140,248,0.15);border:1px solid rgba(129,140,248,0.35);color:#a5b4fc;padding:0.35rem 1.1rem;border-radius:999px;font-size:0.78rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:1.75rem;">
        &#9889; Mulai Hari Ini &mdash; Gratis
      </span>

      <h2 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;letter-spacing:-1.5px;margin-bottom:1rem;line-height:1.1;">
        Siap Merasakan Pengalaman<br>
        <span style="background:linear-gradient(135deg,#a5b4fc,#67e8f9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Berkendara Luar Biasa?</span>
      </h2>

      <p style="color:rgba(255,255,255,0.6);font-size:1.1rem;max-width:480px;margin:0 auto 2.75rem;line-height:1.7;">
        Bergabunglah dengan ribuan pengemudi puas kami. Pesan mobil impian Anda sekarang &mdash; tanpa dokumen, kunci langsung di tangan.
      </p>

      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="/pages/fleet.php" style="display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#6366f1,#4f46e5);color:white;font-weight:700;font-size:1rem;padding:1rem 2.4rem;border-radius:12px;box-shadow:0 8px 32px rgba(99,102,241,0.5);text-decoration:none;transition:all 0.2s;border:1px solid rgba(255,255,255,0.15);" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 40px rgba(99,102,241,0.7)';" onmouseout="this.style.transform='';this.style.boxShadow='0 8px 32px rgba(99,102,241,0.5);'">
          &#128663; Lihat Armada
        </a>
        <a href="/auth/register.php" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.1);color:white;font-weight:700;font-size:1rem;padding:1rem 2.4rem;border-radius:12px;backdrop-filter:blur(10px);text-decoration:none;transition:all 0.2s;border:1px solid rgba(255,255,255,0.25);" onmouseover="this.style.background='rgba(255,255,255,0.18)';this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.transform='';">
          Daftar Gratis &#8594;
        </a>
      </div>

      <div style="display:flex;align-items:center;justify-content:center;gap:2rem;margin-top:2.5rem;flex-wrap:wrap;">
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; Tanpa kartu kredit</span>
        <span style="color:rgba(255,255,255,0.2);">|</span>
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; Batal kapan saja</span>
        <span style="color:rgba(255,255,255,0.2);">|</span>
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; Dukungan 24/7</span>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
