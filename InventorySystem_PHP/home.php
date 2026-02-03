<?php
  $page_title = 'Home Page';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>

<!-- Nursery theme styles (inline for quick use; move to main CSS if preferred) -->
<style>
  /* Page background & typography */
  body {
    background: linear-gradient(180deg, #f7fbf7 0%, #eef9ee 100%);
    color: #214b27;
    font-family: "Poppins", Arial, sans-serif;
  }

  .nursery-hero {
    background: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
    border-radius: 12px;
    padding: 36px 24px;
    color: #08310b;
    box-shadow: 0 8px 32px rgba(33,75,39,0.08);
    position: relative;
    overflow: hidden;
  }
  .nursery-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(255,255,255,0.65), rgba(255,255,255,0.4));
    mix-blend-mode: multiply;
    pointer-events: none;
  }

  .hero-inner { position: relative; z-index: 2; }

  .hero-title {
    font-size: 30px;
    margin: 0 0 8px 0;
    font-weight: 700;
    color: #08310b;
  }
  .hero-sub {
    font-size: 16px;
    color: #365f3b;
    margin-bottom: 18px;
  }
  .hero-cta { display:flex; gap:10px; flex-wrap:wrap; }

  .btn-nursery {
    background: linear-gradient(90deg,#43a047,#2e7d32);
    color:white;
    border:none;
    padding:10px 16px;
    border-radius: 8px;
    font-weight:700;
    box-shadow: 0 6px 18px rgba(67,160,71,0.12);
    transition: transform .12s ease;
  }
  .btn-nursery:hover { transform: translateY(-3px); }

  .btn-outline {
    background: rgba(255,255,255,0.9);
    border: 1px solid rgba(33,75,39,0.08);
    color: #2f6230;
    padding:10px 14px;
    border-radius:8px;
    font-weight:600;
  }

  .quick-links {
    display:flex;
    gap:12px;
    margin-top:16px;
    flex-wrap:wrap;
  }

  .link-card {
    background: #fff;
    border-radius:10px;
    padding: 12px 14px;
    min-width:160px;
    display:flex;
    gap:10px;
    align-items:center;
    box-shadow: 0 6px 18px rgba(33,75,39,0.04);
    text-decoration:none;
    color: inherit;
  }
  .link-card .icon {
    width:44px;
    height:44px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    background: linear-gradient(180deg,#e8f6e8, #dff2df);
    color:#2e7d32;
    border: 1px solid rgba(46,125,50,0.06);
  }
  .link-card .meta { font-weight:700; }
  .link-card .sub { font-size:12px; color:#6b8a66; }

  .dashboard-row { margin-top:18px; display:flex; gap:16px; flex-wrap:wrap; }

  .stat-card {
    flex:1 1 220px;
    background: #fff;
    border-radius:10px;
    padding:14px;
    box-shadow: 0 6px 18px rgba(33,75,39,0.04);
    display:flex;
    justify-content:space-between;
    align-items:center;
  }
  .stat-left { font-size:13px; color:#6b8a66; }
  .stat-value { font-size:26px; font-weight:800; color:#1b3b12; }

  .panel {
    margin-top:18px;
    background: #fff;
    border-radius:10px;
    padding:14px;
    box-shadow: 0 6px 18px rgba(33,75,39,0.04);
  }

  .welcome-plant {
    max-width:160px;
    height:auto;
    border-radius:8px;
    box-shadow: 0 6px 18px rgba(33,75,39,0.06);
  }

  @media (max-width:767px) {
    .hero-title { font-size:22px; }
    .dashboard-row { flex-direction:column; }
    .quick-links { gap:8px; }
  }
</style>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>

  <div class="col-md-12">
    <div class="nursery-hero">
      <div class="hero-inner">
        <div style="display:flex; gap:18px; align-items:center; justify-content:space-between; flex-wrap:wrap;">
          <div style="flex:1 1 60%;">
            <h1 class="hero-title">Welcome back, <?php echo $user['name'] ?? 'User'; ?> 🌿</h1>
            <p class="hero-sub">This is your Nursery Dashboard — manage plants, orders, staff and plant types from one place.</p>

            <div class="hero-cta">
              <a href="product.php" class="btn-nursery" role="button">Browse Plants</a>
              <a href="sales.php" class="btn-outline" role="button">View Orders</a>
              <a href="add_product.php" class="btn-outline" role="button">Add New Plant</a>
            </div>

            <div class="quick-links" aria-hidden="false">
              <a class="link-card" href="product.php">
                <div class="icon">🌱</div>
                <div>
                  <div class="meta">Plants</div>
                  <div class="sub">Manage stock & details</div>
                </div>
              </a>

              <a class="link-card" href="sales.php">
                <div class="icon">🧾</div>
                <div>
                  <div class="meta">Orders</div>
                  <div class="sub">Recent sales & invoices</div>
                </div>
              </a>

              <a class="link-card" href="categorie.php">
                <div class="icon">🌿</div>
                <div>
                  <div class="meta">Plant Types</div>
                  <div class="sub">Categories & tags</div>
                </div>
              </a>

              <a class="link-card" href="users.php">
                <div class="icon">👥</div>
                <div>
                  <div class="meta">Staff</div>
                  <div class="sub">Manage roles & permissions</div>
                </div>
              </a>
            </div>
          </div>

          <div style="flex:0 0 180px; text-align:center;">
            <img class="welcome-plant" src="uploads/plant_welcome.png" alt="Welcome plant image" onerror="this.src='uploads/products/no_image.png'">
            <div style="margin-top:8px; color:#356434; font-weight:700;">Happy Growing!</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick stats -->
<div class="row dashboard-row">
  <div class="col-md-3 col-sm-6">
    <div class="stat-card">
      <div>
        <div class="stat-left">Total Plants</div>
        <div class="stat-value"><?php $c_product = count_by_id('products'); echo $c_product['total'] ?? '0'; ?></div>
      </div>
      <div style="font-size:28px;">🌿</div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="stat-card">
      <div>
        <div class="stat-left">Plant Types</div>
        <div class="stat-value"><?php $c_categorie = count_by_id('categories'); echo $c_categorie['total'] ?? '0'; ?></div>
      </div>
      <div style="font-size:28px;">📁</div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="stat-card">
      <div>
        <div class="stat-left">Orders</div>
        <div class="stat-value"><?php $c_sale = count_by_id('sales'); echo $c_sale['total'] ?? '0'; ?></div>
      </div>
      <div style="font-size:28px;">🧾</div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="stat-card">
      <div>
        <div class="stat-left">Staff</div>
        <div class="stat-value"><?php $c_user = count_by_id('users'); echo $c_user['total'] ?? '0'; ?></div>
      </div>
      <div style="font-size:28px;">👥</div>
    </div>
  </div>
</div>

<!-- Recent activity / useful links -->
<div class="row" style="margin-top:18px;">
  <div class="col-md-8">
    <div class="panel">
      <h4 style="margin-top:0; color:#234d20;">Recent Activity</h4>
      <p class="small-muted">Quick snapshot of recent changes — open the relevant pages for full details.</p>

      <ul style="padding-left:18px; margin:0;">
        <li><a href="product.php">Manage Plants</a> — edit stock, update prices, add images.</li>
        <li><a href="sales.php">Review Orders</a> — see latest orders and invoices.</li>
        <li><a href="categorie.php">Edit Plant Types</a> — manage categories and tags for plants.</li>
        <li><a href="users.php">Staff Management</a> — add or update staff accounts/roles.</li>
      </ul>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel">
      <h4 style="margin-top:0; color:#234d20;">Tips for Today</h4>
      <ol style="padding-left:18px; margin:0;">
        <li>Check low-stock plants and restock popular varieties.</li>
        <li>Review orders placed in the last 24 hours.</li>
        <li>Upload fresh plant photos to boost online sales.</li>
      </ol>
      <div style="margin-top:12px; text-align:right;">
        <a href="sales.php" class="btn-nursery">Process Orders</a>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
