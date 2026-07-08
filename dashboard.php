<?php 
require_once 'db.php'; 
requireLogin();
require_once 'header.php'; 

// Fetch user info
$uStmt = $pdo->prepare("SELECT * FROM User WHERE id = ?");
$uStmt->execute([$_SESSION['user_id']]);
$user = $uStmt->fetch();

// Fetch bookings with car info
$bStmt = $pdo->prepare("
    SELECT b.*, c.brand, c.model, c.category, c.images
    FROM Booking b
    JOIN Car c ON b.carId = c.id
    WHERE b.userId = ?
    ORDER BY b.createdAt DESC
");
$bStmt->execute([$_SESSION['user_id']]);
$bookings = $bStmt->fetchAll();

$active   = array_filter($bookings, fn($b) => $b['status'] === 'PENDING' || $b['status'] === 'ACTIVE');
$past     = array_filter($bookings, fn($b) => $b['status'] === 'COMPLETED' || $b['status'] === 'CANCELLED');
?>

<div style="background: var(--bg); min-height: calc(100vh - 80px);">
  <!-- Gorgeous Gradient Header Area -->
  <div style="position: relative; overflow: hidden; padding: 4rem 2rem 6rem; background: linear-gradient(135deg, #1e1b4b 0%, #0c0a1e 100%); border-bottom: 1px solid rgba(129,140,248,0.2);">
    <div style="position:absolute;top:-50%;left:0;width:600px;height:600px;background:radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 60%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-50%;right:0;width:600px;height:600px;background:radial-gradient(circle, rgba(6,182,212,0.1) 0%, transparent 60%);pointer-events:none;"></div>
    
    <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 10; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 2rem;">
      <div style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #6366f1, #06b6d4); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: white; box-shadow: 0 10px 30px rgba(99,102,241,0.4); border: 2px solid rgba(255,255,255,0.2);">
          <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
        </div>
        <div>
          <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.4rem;">Cozy Member</p>
          <h1 style="font-size: 2.5rem; font-weight: 900; letter-spacing: -1px; line-height: 1; margin-bottom: 0.25rem;">
            Welcome, <?php echo htmlspecialchars(explode(' ', $user['name'])[0]); ?>.
          </h1>
          <p style="color: #a5b4fc; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
            &#128231; <?php echo htmlspecialchars($user['email']); ?>
          </p>
        </div>
      </div>
      <div>
        <a href="fleet.php" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 0.95rem; box-shadow: 0 10px 30px rgba(99,102,241,0.3); border-radius: 12px;">
          + New Booking
        </a>
      </div>
    </div>
  </div>

  <div style="max-width: 1200px; margin: -3rem auto 0; padding: 0 2rem 4rem; position: relative; z-index: 20;">
    
    <!-- Premium Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
      <div style="background: rgba(24,24,31,0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
          <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--muted);"></span> Total Bookings
        </p>
        <p style="font-size: 3rem; font-weight: 900; color: white; line-height: 1;"><?php echo count($bookings); ?></p>
      </div>
      <div style="background: rgba(24,24,31,0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
          <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--accent);box-shadow:0 0 10px var(--accent);"></span> Active Rentals
        </p>
        <p style="font-size: 3rem; font-weight: 900; color: white; line-height: 1;"><?php echo count($active); ?></p>
      </div>
      <div style="background: rgba(24,24,31,0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
          <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--primary-light);"></span> Total Spent
        </p>
        <p style="font-size: 3rem; font-weight: 900; background: linear-gradient(135deg, #818cf8, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1;">
          $<?php echo number_format(array_sum(array_column($bookings, 'totalPrice'))); ?>
        </p>
      </div>
    </div>

    <!-- Booking History -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem;">
      <h2 style="font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;">Your Reservations</h2>
    </div>

    <?php if (count($bookings) === 0): ?>
      <div style="background: rgba(24,24,31,0.5); border: 1px dashed rgba(255,255,255,0.15); border-radius: 24px; padding: 6rem 2rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;">&#128663;</div>
        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; font-weight: 700;">No Reservations Yet</h3>
        <p style="color: var(--muted); margin-bottom: 2rem;">Ready to experience the drive of a lifetime?</p>
        <a href="fleet.php" class="btn btn-primary" style="padding: 0.9rem 2.5rem; font-size: 1rem; border-radius: 14px;">Browse the Fleet</a>
      </div>
    <?php else: ?>
      <div style="display: flex; flex-direction: column; gap: 1.25rem;">
        <?php foreach($bookings as $b):
          $imgs = json_decode($b['images'], true);
          $img  = is_array($imgs) && count($imgs) > 0 ? $imgs[0] : '';
          
          $isActive = ($b['status'] === 'PENDING' || $b['status'] === 'ACTIVE');
          $statusColor = match($b['status']) {
            'ACTIVE'    => '#06b6d4',
            'PENDING'   => '#f59e0b',
            'COMPLETED' => '#10b981',
            'CANCELLED' => '#ef4444',
            default     => '#818cf8'
          };
        ?>
          <div style="
            background: var(--surface); 
            border: 1px solid <?php echo $isActive ? 'rgba(99,102,241,0.3)' : 'var(--border)'; ?>; 
            border-radius: 20px; 
            padding: 1.5rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            flex-wrap: wrap; 
            gap: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: <?php echo $isActive ? '0 10px 30px rgba(0,0,0,0.3)' : 'none'; ?>;
          " onmouseover="this.style.transform='translateY(-3px)';this.style.borderColor='rgba(99,102,241,0.5)';" onmouseout="this.style.transform='';this.style.borderColor='<?php echo $isActive ? "rgba(99,102,241,0.3)" : "var(--border)"; ?>';">
            
            <div style="display: flex; gap: 1.5rem; align-items: center;">
              <!-- Thumbnail -->
              <div style="width: 140px; height: 90px; border-radius: 12px; overflow: hidden; background: var(--surface2); border: 1px solid var(--border2); position: relative;">
                <?php if($img): ?>
                  <img src="<?php echo htmlspecialchars($img); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                  <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:2rem; color:var(--muted);">&#128663;</div>
                <?php endif; ?>
                <?php if($isActive): ?>
                  <div style="position: absolute; top: 8px; left: 8px; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); padding: 0.2rem 0.5rem; border-radius: 6px; font-size: 0.65rem; font-weight: 700; color: white; border: 1px solid rgba(255,255,255,0.1);">
                    UPCOMING
                  </div>
                <?php endif; ?>
              </div>
              
              <!-- Details -->
              <div>
                <p style="color: var(--muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.3rem;">
                  <?php echo htmlspecialchars($b['category']); ?>
                </p>
                <h4 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.4rem; letter-spacing: -0.3px;">
                  <?php echo htmlspecialchars($b['brand'].' '.$b['model']); ?>
                </h4>
                <div style="display: flex; align-items: center; gap: 1rem; color: var(--muted); font-size: 0.9rem;">
                  <span style="display: flex; align-items: center; gap: 0.4rem;">
                    &#128197; <?php echo date('M d, Y', strtotime($b['pickupDate'])); ?> &rarr; <?php echo date('M d, Y', strtotime($b['returnDate'])); ?>
                  </span>
                  <span style="display: flex; align-items: center; gap: 0.4rem;">
                    &#128205; <?php echo htmlspecialchars($b['pickupLocation']); ?>
                  </span>
                </div>
              </div>
            </div>

            <!-- Price & Status -->
            <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 0.75rem;">
              <div style="font-size: 1.5rem; font-weight: 900; color: white;">
                $<?php echo number_format($b['totalPrice']); ?>
              </div>
              <div style="
                background: <?php echo $statusColor; ?>15; 
                color: <?php echo $statusColor; ?>; 
                border: 1px solid <?php echo $statusColor; ?>40;
                padding: 0.35rem 1rem; 
                border-radius: 8px; 
                font-size: 0.75rem; 
                font-weight: 700; 
                letter-spacing: 0.05em;
              ">
                <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:<?php echo $statusColor; ?>;margin-right:0.4rem;box-shadow:0 0 8px <?php echo $statusColor; ?>;"></span>
                <?php echo htmlspecialchars($b['status']); ?>
              </div>
            </div>
            
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once 'footer.php'; ?>
