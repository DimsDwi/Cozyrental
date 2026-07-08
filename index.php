<?php 
require_once 'header.php'; 

// Fetch 6 top cars
$stmt = $pdo->query("SELECT * FROM Car ORDER BY pricePerDay DESC LIMIT 6");
$cars = $stmt->fetchAll();
?>

<!-- ── HERO ── -->
<section class="hero">
  <div class="hero-badge">
    <span class="dot"></span>
    Now featuring 50+ luxury &amp; electric vehicles
  </div>

  <h1>
    Drive the Future.<br>
    <span class="gradient-text">Feel the Luxury.</span>
  </h1>

  <p>
    From sleek electric sedans to roaring supercars — book your dream ride in under 3 minutes. Zero paperwork, instant keys.
  </p>

  <div class="hero-actions">
    <a href="fleet.php" class="btn btn-primary" style="font-size:1rem;padding:0.85rem 2rem;">
      &#9654;&nbsp; Explore Fleet
    </a>
    <a href="register.php" class="btn btn-ghost" style="font-size:1rem;padding:0.85rem 2rem;">
      Create Free Account
    </a>
  </div>

  <div class="hero-scroll-hint">
    <span>Scroll</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- ── STATS BAR ── -->
<div class="stats-bar">
  <div class="stat-item">
    <div class="stat-num">50+</div>
    <div class="stat-label">Premium Vehicles</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">98%</div>
    <div class="stat-label">Customer Satisfaction</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">3 min</div>
    <div class="stat-label">Avg. Booking Time</div>
  </div>
  <div class="stat-item">
    <div class="stat-num">24/7</div>
    <div class="stat-label">Concierge Support</div>
  </div>
</div>

<!-- ── FEATURED FLEET ── -->
<section class="section">
  <div class="section-label">Our Fleet</div>
  <h2>Top Picks This Week</h2>
  <p class="section-sub">Handpicked, cleaned, and ready — choose from our most sought-after models.</p>

  <div class="grid">
    <?php foreach($cars as $car): ?>
      <?php 
        $images = json_decode($car['images'], true);
        $imgUrl = is_array($images) && count($images) > 0 ? $images[0] : '';
      ?>
      <div class="car-card">
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
            <a href="car.php?id=<?php echo urlencode($car['id']); ?>" class="btn btn-primary" style="padding:0.5rem 1.1rem;font-size:0.85rem;">Book Now</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="text-align:center;margin-top:3rem;">
    <a href="fleet.php" class="btn btn-outline" style="font-size:1rem;padding:0.8rem 2rem;">
      View All Vehicles &rarr;
    </a>
  </div>
</section>

<!-- ── WHY US ── -->
<section class="section" id="why-us" style="padding-top:0;">
  <div class="section-label">Why Cozy Rental</div>
  <h2>Built for People Who Value Their Time</h2>
  <p class="section-sub">We remove every friction point of the traditional rental experience.</p>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">&#9889;</div>
      <h4>Instant Access</h4>
      <p>Book in under 3 minutes. Digital keys sent directly to your phone. Zero queues, zero paperwork.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">&#128737;</div>
      <h4>Fully Insured</h4>
      <p>Every rental includes collision damage waiver and third-party liability. Drive confidently from day one.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">&#128584;</div>
      <h4>Curated Fleet</h4>
      <p>Each car is handpicked, professionally detailed, and safety-inspected before every rental.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">&#127760;</div>
      <h4>Available 24 / 7</h4>
      <p>Our concierge team is available around the clock for any support you need during your rental.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">&#128267;</div>
      <h4>Eco-Friendly Options</h4>
      <p>A growing fleet of premium electric vehicles for the eco-conscious driver who refuses to compromise.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">&#128176;</div>
      <h4>Transparent Pricing</h4>
      <p>No hidden fees, no surprises. What you see on the booking page is exactly what you pay.</p>
    </div>
  </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="section" id="testimonials" style="padding-top:0;">
  <div class="section-label">Reviews</div>
  <h2>Loved By Drivers Everywhere</h2>
  <p class="section-sub">Don't just take our word for it — here's what our customers say.</p>

  <div class="testimonials-grid">
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"Booked a Tesla Model S at midnight for the next morning. Keys were on my phone by 9 AM. Absolutely seamless experience — better than any rental service I've used."</p>
      <div class="testimonial-author">
        <div class="avatar">A</div>
        <div>
          <div class="author-name">Alex T.</div>
          <div class="author-sub">Business Traveler, New York</div>
        </div>
      </div>
    </div>
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"I rented a Lamborghini Urus for my anniversary weekend. The car was immaculate and the process was so quick. Cozy Rental has a customer for life."</p>
      <div class="testimonial-author">
        <div class="avatar">M</div>
        <div>
          <div class="author-name">Maria L.</div>
          <div class="author-sub">Lifestyle Influencer, Miami</div>
        </div>
      </div>
    </div>
    <div class="testimonial-card">
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p>"Best luxury rental experience I've had. No hidden fees, great car condition, and their support team responded in under 2 minutes when I had a question."</p>
      <div class="testimonial-author">
        <div class="avatar">J</div>
        <div>
          <div class="author-name">James K.</div>
          <div class="author-sub">Entrepreneur, Los Angeles</div>
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
        &#9889; Start Today &mdash; It's Free
      </span>

      <h2 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;letter-spacing:-1.5px;margin-bottom:1rem;line-height:1.1;">
        Ready to Drive Something<br>
        <span style="background:linear-gradient(135deg,#a5b4fc,#67e8f9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Extraordinary?</span>
      </h2>

      <p style="color:rgba(255,255,255,0.6);font-size:1.1rem;max-width:480px;margin:0 auto 2.75rem;line-height:1.7;">
        Join thousands of satisfied drivers. Book your dream car today &mdash; zero paperwork, instant keys.
      </p>

      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="fleet.php" style="
          display:inline-flex;align-items:center;gap:0.5rem;
          background:linear-gradient(135deg,#6366f1,#4f46e5);
          color:white;font-weight:700;font-size:1rem;
          padding:1rem 2.4rem;border-radius:12px;
          box-shadow:0 8px 32px rgba(99,102,241,0.5);
          text-decoration:none;transition:all 0.2s;
          border:1px solid rgba(255,255,255,0.15);
        " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 40px rgba(99,102,241,0.7)';" onmouseout="this.style.transform='';this.style.boxShadow='0 8px 32px rgba(99,102,241,0.5)';">
          &#128663; Browse Fleet
        </a>
        <a href="register.php" style="
          display:inline-flex;align-items:center;gap:0.5rem;
          background:rgba(255,255,255,0.1);
          color:white;font-weight:700;font-size:1rem;
          padding:1rem 2.4rem;border-radius:12px;
          backdrop-filter:blur(10px);
          text-decoration:none;transition:all 0.2s;
          border:1px solid rgba(255,255,255,0.25);
        " onmouseover="this.style.background='rgba(255,255,255,0.18)';this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.transform='';">
          Create Free Account &#8594;
        </a>
      </div>

      <!-- Trust indicators -->
      <div style="display:flex;align-items:center;justify-content:center;gap:2rem;margin-top:2.5rem;flex-wrap:wrap;">
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; No credit card required</span>
        <span style="color:rgba(255,255,255,0.2);">|</span>
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; Cancel anytime</span>
        <span style="color:rgba(255,255,255,0.2);">|</span>
        <span style="color:rgba(255,255,255,0.45);font-size:0.8rem;">&#10003; 24/7 support</span>
      </div>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>
