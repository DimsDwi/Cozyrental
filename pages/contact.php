<?php
$sent = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (!$fname || !$email || !$message) {
        $error = 'Please fill in all fields.';
    } else {
        // In production, send an email. For now, just mark as sent.
        $sent = true;
    }
}
require_once __DIR__ . '/../includes/header.php';
?>

<main>
  <section style="padding: 6rem 2rem 3rem; text-align: center; max-width: 600px; margin: 0 auto;">
    <div class="section-label">Contact Us</div>
    <h1 style="font-size: 3rem; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 1rem;">
      We're Here to <span style="background: linear-gradient(135deg, #818cf8, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Help</span>
    </h1>
    <p style="color: var(--muted); font-size: 1.05rem;">Questions about a booking, custom requests, or just want to chat about cars? Reach out anytime.</p>
  </section>

  <section class="section" style="padding-top: 2rem;">
    <div style="display: grid; grid-template-columns: 1fr 1.4fr; gap: 4rem; align-items: start;">

      <!-- Info -->
      <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; display: flex; gap: 1rem; align-items: flex-start;">
          <div style="font-size: 1.5rem; flex-shrink:0;">&#128205;</div>
          <div>
            <h4 style="font-weight: 700; margin-bottom: 0.25rem;">Headquarters</h4>
            <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.7;">123 Luxury Drive, Suite 100<br>Beverly Hills, CA 90210</p>
          </div>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; display: flex; gap: 1rem; align-items: flex-start;">
          <div style="font-size: 1.5rem; flex-shrink:0;">&#128222;</div>
          <div>
            <h4 style="font-weight: 700; margin-bottom: 0.25rem;">Phone</h4>
            <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.7;">+1 (800) 555-COZY<br>Mon–Fri, 8am – 8pm PST</p>
          </div>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; display: flex; gap: 1rem; align-items: flex-start;">
          <div style="font-size: 1.5rem; flex-shrink:0;">&#128140;</div>
          <div>
            <h4 style="font-weight: 700; margin-bottom: 0.25rem;">Email</h4>
            <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.7;">support@cozyrental.com<br>Replies within 24 hours</p>
          </div>
        </div>
      </div>

      <!-- Form -->
      <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 2.5rem;">
        <?php if ($sent): ?>
          <div class="success-msg">&#10003; Message sent! We'll get back to you within 24 hours.</div>
        <?php endif; ?>
        <?php if ($error): ?>
          <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="/pages/contact.php">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="fname" placeholder="John" required>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="lname" placeholder="Doe">
            </div>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="john@example.com" required>
          </div>
          <div class="form-group">
            <label>Subject</label>
            <input type="text" name="subject" placeholder="Booking inquiry, support...">
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea name="message" rows="5" required
              style="width:100%; padding:0.75rem 1rem; border-radius:10px; background:var(--bg); border:1px solid var(--border2); color:var(--text); outline:none; font-size:0.95rem; resize:vertical; font-family: inherit; transition: border-color 0.2s;"
              placeholder="How can we help you?"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding: 0.85rem;">
            Send Message &#8594;
          </button>
        </form>
      </div>
    </div>
  </section>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
