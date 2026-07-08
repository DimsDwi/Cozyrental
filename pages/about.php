<?php require_once __DIR__ . '/../includes/header.php'; ?>

<main>
  <!-- Hero -->
  <section style="padding: 6rem 2rem 3rem; text-align: center; max-width: 700px; margin: 0 auto;">
    <div class="section-label">Our Story</div>
    <h1 style="font-size: 3rem; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 1rem;">
      Built for People Who <span style="background: linear-gradient(135deg, #818cf8, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Drive Different</span>
    </h1>
    <p style="color: var(--muted); font-size: 1.1rem; line-height: 1.8;">
      Cozy Car Rental was founded in 2026 with a single mission: make premium car rental as effortless as ordering a coffee. No counters, no paperwork, no waiting.
    </p>
  </section>

  <!-- Stats -->
  <div class="stats-bar">
    <div class="stat-item"><div class="stat-num">2026</div><div class="stat-label">Year Founded</div></div>
    <div class="stat-item"><div class="stat-num">50+</div><div class="stat-label">Vehicles in Fleet</div></div>
    <div class="stat-item"><div class="stat-num">3,000+</div><div class="stat-label">Happy Renters</div></div>
    <div class="stat-item"><div class="stat-num">4.9 ★</div><div class="stat-label">Average Rating</div></div>
  </div>

  <!-- Mission & Vision -->
  <section class="section">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
      <div>
        <div class="section-label">Mission</div>
        <h2>Redefining What Rental Feels Like</h2>
        <p style="color: var(--muted); line-height: 1.8; margin-top: 1rem;">
          Traditional car rental is stuck in the past — long queues, paper forms, generic fleets. We built Cozy Rental to flip that entirely. Our platform gives you instant digital access to a curated fleet of the world's finest and most exciting vehicles.
        </p>
        <p style="color: var(--muted); line-height: 1.8; margin-top: 1rem;">
          Every vehicle is safety-inspected, professionally detailed, and pre-configured before every rental. You just pick up and drive.
        </p>
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem;">
          <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">&#9889;</div>
          <h4 style="font-weight: 700; margin-bottom: 0.4rem;">Instant Access</h4>
          <p style="color: var(--muted); font-size: 0.85rem;">Book and get keys digitally in under 3 minutes.</p>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem;">
          <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">&#128737;</div>
          <h4 style="font-weight: 700; margin-bottom: 0.4rem;">Fully Insured</h4>
          <p style="color: var(--muted); font-size: 0.85rem;">Every rental comes with comprehensive coverage included.</p>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem;">
          <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">&#127757;</div>
          <h4 style="font-weight: 700; margin-bottom: 0.4rem;">Eco Options</h4>
          <p style="color: var(--muted); font-size: 0.85rem;">A growing fleet of premium EV models available now.</p>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem;">
          <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">&#128222;</div>
          <h4 style="font-weight: 700; margin-bottom: 0.4rem;">24/7 Support</h4>
          <p style="color: var(--muted); font-size: 0.85rem;">Real humans available around the clock for help.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <div class="cta-section" style="margin-bottom: 0;">
    <h2>Ready to Experience It?</h2>
    <p>Join thousands of drivers who've made the switch to premium, effortless car rental.</p>
    <a href="/pages/fleet.php" class="btn btn-primary" style="font-size: 1rem; padding: 0.9rem 2.2rem;">Browse the Fleet</a>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
