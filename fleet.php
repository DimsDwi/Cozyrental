<?php 
require_once 'header.php'; 

// Get filter params
$category  = $_GET['category'] ?? '';
$search    = trim($_GET['search'] ?? '');
$sort      = $_GET['sort'] ?? 'price_desc';

// Build query dynamically
$where = [];
$params = [];
if ($category) { $where[] = "category = ?"; $params[] = $category; }
if ($search)   { $where[] = "(brand LIKE ? OR model LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }

$orderBy = match($sort) {
    'price_asc'  => 'pricePerDay ASC',
    'price_desc' => 'pricePerDay DESC',
    'alpha'      => 'brand ASC',
    default      => 'pricePerDay DESC'
};

$sql = "SELECT * FROM Car" . ($where ? " WHERE " . implode(" AND ", $where) : "") . " ORDER BY $orderBy";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cars = $stmt->fetchAll();

// Get distinct categories for filter pills
$cats = $pdo->query("SELECT DISTINCT category FROM Car ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>

<main>
  <!-- Page Hero -->
  <section style="padding: 5rem 2rem 3rem; text-align: center; max-width: 650px; margin: 0 auto;">
    <div class="section-label">Browse</div>
    <h1 style="font-size: 3rem; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 0.75rem;">
      Our <span style="background: linear-gradient(135deg, #818cf8, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Full Fleet</span>
    </h1>
    <p style="color: var(--muted); font-size: 1.05rem;"><?php echo count($cars); ?> vehicles available — filter by type, search by name, or sort by price.</p>
  </section>

  <!-- Filters -->
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem 2rem;">
    <form method="GET" action="fleet.php" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
      <!-- Search -->
      <div style="flex: 1; min-width: 220px; position: relative;">
        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted);">&#128269;</span>
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
          placeholder="Search brand or model..."
          style="width:100%; background:var(--surface); border:1px solid var(--border2); color:var(--text); padding:0.7rem 1rem 0.7rem 2.5rem; border-radius:10px; outline:none; font-size:0.9rem; transition: border-color 0.2s;"
          onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border2)'">
      </div>

      <!-- Sort -->
      <select name="sort" onchange="this.form.submit()"
        style="background:var(--surface); border:1px solid var(--border2); color:var(--text); padding:0.7rem 1rem; border-radius:10px; outline:none; font-size:0.9rem; cursor:pointer;">
        <option value="price_desc" <?php if($sort==='price_desc') echo 'selected'; ?>>Price: High → Low</option>
        <option value="price_asc"  <?php if($sort==='price_asc')  echo 'selected'; ?>>Price: Low → High</option>
        <option value="alpha"      <?php if($sort==='alpha')       echo 'selected'; ?>>A → Z</option>
      </select>

      <button type="submit" class="btn btn-primary" style="padding: 0.7rem 1.5rem;">Search</button>
      <?php if($search || $category): ?>
        <a href="fleet.php" class="btn btn-ghost" style="padding: 0.7rem 1.2rem;">&#215; Clear</a>
      <?php endif; ?>
    </form>

    <!-- Category Pills -->
    <div style="display: flex; flex-wrap: wrap; gap: 0.6rem; margin-top: 1.25rem;">
      <a href="fleet.php?sort=<?php echo $sort; ?>"
        style="padding: 0.4rem 1rem; border-radius: 999px; font-size: 0.8rem; font-weight: 600; border: 1px solid var(--border2); text-decoration: none; transition: all 0.2s;
          <?php echo !$category ? 'background:var(--primary);color:white;border-color:var(--primary);' : 'background:var(--surface);color:var(--muted);'; ?>">
        All
      </a>
      <?php foreach($cats as $cat): ?>
        <a href="fleet.php?category=<?php echo urlencode($cat); ?>&sort=<?php echo $sort; ?>"
          style="padding: 0.4rem 1rem; border-radius: 999px; font-size: 0.8rem; font-weight: 600; border: 1px solid var(--border2); text-decoration: none; transition: all 0.2s;
            <?php echo $category===$cat ? 'background:var(--primary);color:white;border-color:var(--primary);' : 'background:var(--surface);color:var(--muted);'; ?>">
          <?php echo htmlspecialchars($cat); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Car Grid -->
  <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem 5rem;">
    <?php if(count($cars) === 0): ?>
      <div class="empty-state">
        <p style="font-size: 3rem; margin-bottom: 1rem;">&#128663;</p>
        <p>No vehicles found matching your search.</p>
        <a href="fleet.php" class="btn btn-primary">Clear Filters</a>
      </div>
    <?php else: ?>
    <div class="grid">
      <?php foreach($cars as $car): ?>
        <?php 
          $images = json_decode($car['images'], true);
          $imgUrl = is_array($images) && count($images) > 0 ? $images[0] : '';
        ?>
        <div class="car-card">
          <div class="car-card-img-wrap">
            <?php if($imgUrl): ?>
              <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($car['brand'].' '.$car['model']); ?>" class="car-img">
            <?php else: ?>
              <div class="car-img" style="display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:3rem;">&#128663;</div>
            <?php endif; ?>
            <div class="car-card-badge"><?php echo htmlspecialchars($car['category']); ?></div>
            <?php if($car['fuel']==='Electric'||$car['fuel']==='electric'): ?>
              <div class="car-card-badge" style="left:auto;right:1rem;color:#06b6d4;border-color:rgba(6,182,212,0.3);">&#9889; EV</div>
            <?php endif; ?>
          </div>
          <div class="car-info">
            <h3 class="car-title"><?php echo htmlspecialchars($car['brand'].' '.$car['model']); ?></h3>
            <p class="car-meta">
              <?php echo htmlspecialchars(ucfirst(strtolower($car['transmission']))); ?> &bull;
              <?php echo htmlspecialchars($car['seats']); ?> Seats &bull;
              <?php echo htmlspecialchars($car['fuel']); ?>
            </p>
            <div class="car-price-row">
              <div class="car-price">$<?php echo htmlspecialchars($car['pricePerDay']); ?><span> / day</span></div>
              <a href="car.php?id=<?php echo urlencode($car['id']); ?>" class="btn btn-primary" style="padding:0.5rem 1.1rem;font-size:0.85rem;">Book</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</main>

<?php require_once 'footer.php'; ?>
