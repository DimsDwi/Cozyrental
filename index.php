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
    Now available: 50+ premium & electric vehicles
  </div>

  <h1>
    Drive the Future.<br>
    <span class="gradient-text">Experience Luxury.</span>
  </h1>

  <p>
    From elegant electric sedans to high-performance supercars — book your dream ride in 3 minutes. Zero paperwork, instant digital access.
  </p>

  <div class="hero-actions">
    <a href="/pages/fleet.php" class="btn btn-primary" style="font-size:1rem;padding:0.85rem 2rem;">
      &#9654;&nbsp; Explore Fleet
    </a>
    <a href="/auth/register.php" class="btn btn-ghost" style="font-size:1rem;padding:0.85rem 2rem;">
      Join for Free
    </a>
  </div>

  <div class="hero-scroll-hint">
    <span>Scroll</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- ── STATS BAR ── -->
<div class="stats-container" data-aos="fade-up" data-aos-delay="200">
  <div class="stats-bar">
    <div class="stat-item">
      <div class="stat-num">50+</div>
      <div class="stat-label">Premium Vehicles</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">98%</div>
      <div class="stat-label">Client Satisfaction</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">3 mins</div>
      <div class="stat-label">Average Booking Time</div>
    </div>
    <div class="stat-item">
      <div class="stat-num">24/7</div>
      <div class="stat-label">Concierge Support</div>
    </div>
  </div>
</div>

<!-- ── MARQUEE ── -->
<div class="marquee-container">
  <div class="marquee-content">
    <span>LUXURY</span><span>&bull;</span>
    <span>ELECTRIC</span><span>&bull;</span>
    <span>SPORTS</span><span>&bull;</span>
    <span>PREMIUM</span><span>&bull;</span>
    <span>CHAUFFEUR</span><span>&bull;</span>
    <span>LUXURY</span><span>&bull;</span>
    <span>ELECTRIC</span><span>&bull;</span>
    <span>SPORTS</span><span>&bull;</span>
    <span>PREMIUM</span><span>&bull;</span>
    <span>CHAUFFEUR</span>
  </div>
</div>

<!-- ── FEATURED FLEET ── -->
<section class="section">
  <div class="section-label">Our Fleet</div>
  <h2>This Week's Top Picks</h2>
  <p class="section-sub">Hand-picked, professionally detailed, and ready to drive — choose from our most demanded models.</p>

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
            <?php echo htmlspecialchars($car['seats']); ?> Seats &bull;
            <?php echo htmlspecialchars($car['fuel']); ?>
          </p>
          <div class="car-price-row">
            <div class="car-price">
              $<?php echo htmlspecialchars($car['pricePerDay']); ?>
              <span>/ day</span>
            </div>
            <a href="/pages/car.php?id=<?php echo urlencode($car['id']); ?>" class="btn btn-primary" style="padding:0.5rem 1.1rem;font-size:0.85rem;">Reserve</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="text-align:center;margin-top:3rem;">
    <a href="/pages/fleet.php" class="btn btn-outline" style="font-size:1rem;padding:0.8rem 2rem;">
      View All Vehicles &rarr;
    </a>
  </div>
</section>

<!-- ── WHY US ── -->
<section class="section" id="why-us" style="padding-top:0;">
  <div class="section-label">Why Cozy Rental</div>
  <h2>Built for Those Who Value Time</h2>
  <p class="section-sub">We eliminated every friction in the traditional rental experience.</p>

  <div class="features-grid">
    <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
      <div class="feature-icon">&#9889;</div>
      <h4>Instant Access</h4>
      <p>Book in 3 minutes. Digital keys sent straight to your phone. Zero lines, zero paperwork.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
      <div class="feature-icon">&#128737;</div>
      <h4>Fully Insured</h4>
      <p>Every rental includes comprehensive damage coverage and third-party insurance. Drive with peace of mind.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
      <div class="feature-icon">&#128584;</div>
      <h4>Curated Fleet</h4>
      <p>Every single vehicle is meticulously chosen, professionally detailed, and safety-inspected prior to rental.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
      <div class="feature-icon">&#127760;</div>
      <h4>24/7 Availability</h4>
      <p>Our dedicated concierge team is ready to assist you at any time during your rental period.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
      <div class="feature-icon">&#128267;</div>
      <h4>Eco-Friendly Options</h4>
      <p>A growing fleet of premium electric vehicles for the eco-conscious driver who refuses to compromise.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
      <div class="feature-icon">&#128176;</div>
      <h4>Transparent Pricing</h4>
      <p>No hidden fees, no surprises. The price you see is exactly the price you pay.</p>
    </div>
  </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="section" id="testimonials" style="padding-top:0;">
  <div class="section-label">Testimonials</div>
  <h2>Loved by Drivers Everywhere</h2>
  <p class="section-sub">Don't just take our word for it — here's what our clients have to say.</p>

  <div class="testimonials-grid">
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"Booked a Tesla at midnight for the next morning. Keys were on my phone by 9 AM. An absolutely seamless experience — better than any rental I've ever tried."</p>
      <div class="testimonial-author">
        <div class="avatar">A</div>
        <div>
          <div class="author-name">Alex T.</div>
          <div class="author-sub">Executive, Jakarta</div>
        </div>
      </div>
    </div>
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"I rented a Lamborghini for our anniversary weekend. The car was immaculate and the process was incredibly fast. Cozy Rental has earned a customer for life!"</p>
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
      <p>"The best luxury rental experience ever. No hidden fees, the car condition was superb, and support responded within 2 minutes when I had a question."</p>
      <div class="testimonial-author">
        <div class="avatar">J</div>
        <div>
          <div class="author-name">James K.</div>
          <div class="author-sub">Entrepreneur, Surabaya</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<div style="margin: 0 2rem 4rem; position: relative; overflow: hidden; border-radius: 28px;">
  <!-- Layered gradient background -->
  <div style="
    background: linear-gradient(135deg, #312e81 0%, #1e1b4b 40%, #0c0a1e 70%, #0a1628 100%);
    border: 1px solid rgba(129,140,248,0.25);
    border-radius: 28px;
    padding: 4rem 2rem;
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
        &#9889; Start Today &mdash; Free
      </span>

      <h2 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;letter-spacing:-1.5px;margin-bottom:1rem;line-height:1.1;">
        Ready to Experience<br>
        <span style="background:linear-gradient(135deg,#a5b4fc,#67e8f9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">The Ultimate Drive?</span>
      </h2>

      <p style="color:rgba(255,255,255,0.6);font-size:1.1rem;max-width:480px;margin:0 auto 2.75rem;line-height:1.7;">
        Join thousands of satisfied drivers. Book your dream car now &mdash; zero paperwork, keys instantly in your hand.
      </p>

      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="/pages/fleet.php" style="display:inline-flex;align-items:center;gap:0.5rem;background:linear-gradient(135deg,#6366f1,#4f46e5);color:white;font-weight:700;font-size:1rem;padding:1rem 2.4rem;border-radius:12px;box-shadow:0 8px 32px rgba(99,102,241,0.5);text-decoration:none;transition:all 0.2s;border:1px solid rgba(255,255,255,0.15);" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 40px rgba(99,102,241,0.7)';" onmouseout="this.style.transform='';this.style.boxShadow='0 8px 32px rgba(99,102,241,0.5);'">
          &#128663; Explore Fleet
        </a>
        <a href="/auth/register.php" style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.1);color:white;font-weight:700;font-size:1rem;padding:1rem 2.4rem;border-radius:12px;backdrop-filter:blur(10px);text-decoration:none;transition:all 0.2s;border:1px solid rgba(255,255,255,0.25);" onmouseover="this.style.background='rgba(255,255,255,0.18)';this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.transform='';">
          Join for Free &#8594;
        </a>
      </div>

      <div style="display:flex;align-items:center;justify-content:center;gap:2rem;margin-top:2.5rem;flex-wrap:wrap;">
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; No credit card needed</span>
        <span style="color:rgba(255,255,255,0.2);">|</span>
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; Cancel anytime</span>
        <span style="color:rgba(255,255,255,0.2);">|</span>
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; 24/7 Support</span>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
