<?php
  $page_title = 'Nursery Admin Dashboard';
  require_once('includes/load.php');
  // Check what level user has permission to view this page
  page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('5');
?>
<?php include_once('layouts/header.php'); ?>

<!-- ENHANCED NURSERY DASHBOARD STYLES & SCRIPTS -->
<style>
  :root {
    --bg: #f0f9f0;
    --card: #ffffff;
    --accent: #2f7a33;
    --accent-2: #66bb6a;
    --muted: #5a7d5a;
    --shadow: 0 12px 28px rgba(21,64,21,0.06);
    --radius: 14px;
  }

  body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(180deg,#e6f5e6,var(--bg));
    color: #163b1f;
  }

  .dashboard-wrap { max-width: 1250px; margin: 24px auto; padding: 0 18px; }

  .top-row { display:flex; flex-wrap:wrap; gap:16px; margin-bottom:18px; }

  /* Hero Section */
  .hero {
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    background: linear-gradient(145deg, rgba(102,187,106,0.08), rgba(46,125,50,0.05));
    border-radius: var(--radius);
    padding:22px;
    box-shadow: var(--shadow);
  }
  .hero-left { flex:1; min-width:280px; }
  .hero-title { font-size:24px; font-weight:800; color: var(--accent); margin:0; }
  .hero-sub { font-size:14px; color:var(--muted); margin-top:4px; }
  .hero-cta a { text-decoration:none; transition: transform .14s ease; }
  .hero-cta a:hover { transform: translateY(-3px); }

  .btn-primary {
    background: linear-gradient(90deg,var(--accent),var(--accent-2));
    color:white; padding:10px 16px; border-radius:12px; font-weight:700;
    box-shadow:0 10px 20px rgba(46,125,50,0.08);
  }
  .btn-ghost {
    background: var(--card); border:1px solid rgba(33,75,39,0.08);
    padding:9px 14px; color:var(--accent); border-radius:12px; font-weight:600;
  }

  .hero-right img { border-radius:12px; box-shadow:0 12px 28px rgba(16,48,16,0.06); width:140px; height:140px; object-fit:cover; }

  /* Stats */
  .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; margin-top:20px; }
  .stat-card { display:flex; gap:12px; background:var(--card); border-radius: var(--radius); padding:16px; align-items:center; box-shadow: var(--shadow); transition: transform .14s ease, box-shadow .14s ease; }
  .stat-card:hover { transform:translateY(-6px); box-shadow:0 20px 36px rgba(21,64,21,0.08); }
  .stat-icon { width:56px;height:56px;display:flex;align-items:center;justify-content:center;font-size:22px;border-radius:12px;background: linear-gradient(180deg, rgba(102,187,106,0.12), rgba(46,125,50,0.06)); color: var(--accent); }
  .stat-label { font-size:13px; font-weight:700; color: var(--muted); }
  .stat-value { font-size:24px; font-weight:800; color: var(--accent); margin-top:4px; }

  /* Main content */
  .main-row { display:grid; grid-template-columns:1fr 440px; gap:18px; margin-top:24px; }
  .card { background:var(--card); border-radius:var(--radius); box-shadow: var(--shadow); padding:16px; overflow:hidden; }
  .card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
  .card-title { font-weight:800; font-size:18px; color:var(--accent); margin:0; }
  .card-sub { font-size:13px; color:var(--muted); }

  .table { width:100%; border-collapse:collapse; margin-top:6px; }
  .table th, .table td { padding:10px 8px; text-align:left; border-bottom: 1px solid rgba(0,0,0,0.04); }
  .table th { font-weight:700; font-size:13px; color:var(--accent); background: rgba(102,187,106,0.03); }

  .product-pill { display:flex; align-items:center; gap:10px; }
  .product-thumb-sm { width:44px;height:44px; border-radius:8px; object-fit:cover; box-shadow:0 4px 12px rgba(21,64,21,0.04); }

  .list-group { display:flex; flex-direction:column; gap:10px; margin-top:8px; }
  .list-item { display:flex; justify-content:space-between; align-items:center; padding:10px; border-radius:10px; transition: background .12s ease; text-decoration:none; color:inherit; }
  .list-item:hover { background: rgba(102,187,106,0.08); }

  .price-badge { background: linear-gradient(90deg,#ffb74d,#ffa726); color:#3b2f00; padding:6px 10px; border-radius:10px; font-weight:700; }

  /* Responsive */
  @media (max-width:1100px) { .main-row { grid-template-columns:1fr; } .hero-right{display:none;} }
  @media (max-width:600px) { .stats-grid { grid-template-columns:1fr; } }
</style>

<div class="dashboard-wrap">
  <div class="top-row">
    <div style="flex:1 1 100%;">
      <?php echo display_msg($msg); ?>
    </div>
  </div>

  <!-- HERO -->
  <div class="hero" role="banner" aria-label="Nursery dashboard welcome">
    <div class="hero-left">
      <h2 class="hero-title">Hello, <?php echo $user['name'] ?? 'Nursery Manager'; ?> — Welcome to your Dashboard 🌿</h2>
      <p class="hero-sub">Quick insights and shortcuts to manage plants, orders, staff and categories.</p>
      <div class="hero-cta" role="navigation" aria-label="Quick actions">
        <a class="btn-primary" href="product.php">Browse Plants</a>
        <a class="btn-ghost" href="sales.php">View Orders</a>
        <a class="btn-ghost" href="add_product.php">Add New Plant</a>
      </div>
    </div>

    <div class="hero-right" aria-hidden="false">
      <img class="hero-plant" src="uploads/plant_welcome.png" alt="Decorative plant" onerror="this.src='uploads/products/no_image.png'">
    </div>
  </div>

  <!-- Stats Grid -->
  <div class="stats-grid" role="region" aria-label="Key statistics">
    <div class="stat-card" tabindex="0">
      <div class="stat-icon">🌿</div>
      <div class="stat-body">
        <div class="stat-label">Plants</div>
        <div class="stat-value" data-target="<?php echo (int)$c_product['total']; ?>">0</div>
      </div>
    </div>

    <div class="stat-card" tabindex="0">
      <div class="stat-icon">📁</div>
      <div class="stat-body">
        <div class="stat-label">Plant Types</div>
        <div class="stat-value" data-target="<?php echo (int)$c_categorie['total']; ?>">0</div>
      </div>
    </div>

    <div class="stat-card" tabindex="0">
      <div class="stat-icon">🧾</div>
      <div class="stat-body">
        <div class="stat-label">Orders</div>
        <div class="stat-value" data-target="<?php echo (int)$c_sale['total']; ?>">0</div>
      </div>
    </div>

    <div class="stat-card" tabindex="0">
      <div class="stat-icon">👥</div>
      <div class="stat-body">
        <div class="stat-label">Staff</div>
        <div class="stat-value" data-target="<?php echo (int)$c_user['total']; ?>">0</div>
      </div>
    </div>
  </div>

  <!-- Main Row -->
  <div class="main-row">
    <!-- Left column -->
    <div>
      <!-- Top Selling Plants -->
      <div class="card" aria-labelledby="top-sales-heading">
        <div class="card-header">
          <div>
            <h3 class="card-title" id="top-sales-heading">Top Selling Plants</h3>
            <div class="card-sub">Top performers by total sold</div>
          </div>
          <div>
            <a class="btn-ghost" href="product.php" title="Manage plants">Manage Plants</a>
          </div>
        </div>
        <div style="overflow:auto;">
          <table class="table" role="table" aria-label="Top selling plants">
            <thead>
              <tr>
                <th>Plant</th>
                <th style="width:120px;">Total Sold</th>
                <th style="width:120px;">Total Qty</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($products_sold)): ?>
                <?php foreach ($products_sold as  $product_sold): ?>
                  <tr>
                    <td>
                      <div class="product-pill">
                        <?php
                          $thumb = 'uploads/products/no_image.png';
                          if (isset($product_sold['image']) && $product_sold['image'] != '') {
                            $thumb_path = 'uploads/products/' . $product_sold['image'];
                            if (file_exists($thumb_path)) { $thumb = $thumb_path; }
                          }
                        ?>
                        <img src="<?php echo $thumb; ?>" alt="<?php echo remove_junk(first_character($product_sold['name'])); ?>" class="product-thumb-sm">
                        <div>
                          <strong><?php echo remove_junk(first_character($product_sold['name'])); ?></strong><br>
                          <small class="small-muted"><?php echo remove_junk(first_character($product_sold['categorie'] ?? '')); ?></small>
                        </div>
                      </div>
                    </td>
                    <td><?php echo (int)$product_sold['totalSold']; ?></td>
                    <td><?php echo (int)$product_sold['totalQty']; ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="3" class="text-center small-muted">No data available</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Recently Added Plants -->
      <div class="card" style="margin-top:14px;" aria-labelledby="recent-heading">
        <div class="card-header">
          <div>
            <h3 class="card-title" id="recent-heading">Recently Added Plants</h3>
            <div class="card-sub">Latest inventory additions</div>
          </div>
          <div><a class="btn-ghost" href="add_product.php">Add New</a></div>
        </div>

        <div class="list-group" role="list">
          <?php if(!empty($recent_products)): ?>
            <?php foreach ($recent_products as $recent_product): ?>
              <a class="list-item" href="edit_product.php?id=<?php echo (int)$recent_product['id']; ?>" role="listitem">
                <div class="list-left">
                  <?php if($recent_product['media_id'] === '0'): ?>
                    <img class="product-thumb-sm" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                    <img class="product-thumb-sm" src="uploads/products/<?php echo $recent_product['image']; ?>" alt="">
                  <?php endif; ?>
                  <div>
                    <strong><?php echo remove_junk(first_character($recent_product['name'])); ?></strong><br>
                    <small class="small-muted"><?php echo remove_junk(first_character($recent_product['categorie'])); ?> • <?php echo read_date($recent_product['date']); ?></small>
                  </div>
                </div>
                <div>
                  <div class="price-badge">$<?php echo (int)$recent_product['sale_price']; ?></div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="text-center small-muted">No recently added plants</div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Right column -->
    <div>
      <!-- Latest Orders -->
      <div class="card" aria-labelledby="orders-heading">
        <div class="card-header">
          <div>
            <h3 class="card-title" id="orders-heading">Latest Orders</h3>
            <div class="card-sub">Most recent sales activity</div>
          </div>
          <div><a class="btn-ghost" href="sales.php">All Orders</a></div>
        </div>

        <canvas id="salesChart" role="img" aria-label="Recent sales chart"></canvas>

        <div style="margin-top:8px;">
          <table class="table" aria-label="Recent orders list">
            <thead>
              <tr>
                <th style="width:40px;">#</th>
                <th>Product</th>
                <th style="width:120px;">Date</th>
                <th style="width:90px;">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($recent_sales)): $cnt = 0; ?>
                <?php foreach ($recent_sales as $recent_sale): $cnt++; ?>
                  <tr>
                    <td class="text-center"><?php echo $cnt; ?></td>
                    <td>
                      <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">
                        <?php echo remove_junk(first_character($recent_sale['name'])); ?>
                      </a>
                    </td>
                    <td><?php echo read_date($recent_sale['date']); ?></td>
                    <td>$<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="4" class="text-center small-muted">No recent orders</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card" style="margin-top:12px;">
        <div class="card-header">
          <h4 class="card-title">Quick Actions & Tips</h4>
        </div>
        <ul style="margin:8px 0 0 16px; color:var(--muted);">
          <li>Check plants with low stock and reorder.</li>
          <li>Update product images for better listings.</li>
          <li>Review best sellers to prepare promotions.</li>
        </ul>
        <div style="margin-top:10px; text-align:right;">
          <a class="btn-primary" href="product.php">Manage Inventory</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Inline JS: counter animation + simple sales chart -->
<script>
  (function animateCounters(){
    const els = document.querySelectorAll('.stat-value');
    els.forEach(el => {
      const target = parseInt(el.getAttribute('data-target') || el.textContent || '0', 10);
      let cur = 0;
      const duration = 900;
      const stepTime = Math.max(12, Math.floor(duration / Math.max(1,target)));
      const start = Date.now();
      function step(){
        const elapsed = Date.now() - start;
        const progress = Math.min(1, elapsed / duration);
        const value = Math.floor(progress * target);
        el.textContent = value;
        if(progress < 1) requestAnimationFrame(step);
        else el.textContent = target;
      }
      step();
    });
  })();

  (function renderSalesChart(){
    const recentSales = [];
    <?php
      $sales_by_day = [];
      if (!empty($recent_sales)) {
        foreach ($recent_sales as $s) {
          $d = date('Y-m-d', strtotime($s['date']));
          if (!isset($sales_by_day[$d])) $sales_by_day[$d] = 0;
          $sales_by_day[$d] += 1;
        }
      }
      $js_labels = [];
      $js_values = [];
      if (!empty($sales_by_day)) {
        foreach ($sales_by_day as $d => $v) {
          $js_labels[] = $d;
          $js_values[] = $v;
        }
      }
      if (empty($js_labels)) {
        $js_labels = [date('Y-m-d', strtotime('-4 days')), date('Y-m-d', strtotime('-3 days')), date('Y-m-d', strtotime('-2 days')), date('Y-m-d', strtotime('-1 days')), date('Y-m-d')];
        $js_values = [0,0,0,0,0];
      }
    ?>
    const labels = <?php echo json_encode(array_values($js_labels)); ?>;
    const values = <?php echo json_encode(array_values($js_values)); ?>;

    const canvas = document.getElementById('salesChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const DPR = window.devicePixelRatio || 1;
    const padding = 8;
    const w = canvas.clientWidth || canvas.offsetWidth;
    const h = canvas.clientHeight || 110;
    canvas.width = w * DPR;
    canvas.height = h * DPR;
    ctx.scale(DPR, DPR);
    ctx.clearRect(0,0,w,h);

    const max = Math.max(1, ...values);
    const barCount = values.length;
    const gap = 8;
    const usableW = w - padding*2;
    const barW = Math.max(6, (usableW - gap*(barCount-1)) / barCount );
    const baseY = h - padding;

    values.forEach((v,i) => {
      const x = padding + i * (barW + gap);
      const barH = ( (v / max) * (h - padding*2) );
      const g = ctx.createLinearGradient(x, baseY - barH, x, baseY);
      g.addColorStop(0, 'rgba(102,187,106,0.95)');
      g.addColorStop(1, 'rgba(46,125,50,0.9)');
      ctx.fillStyle = g;
      const y = baseY - barH;
      const radius = 6;
      ctx.beginPath();
      ctx.moveTo(x + radius, y);
      ctx.arcTo(x + barW, y, x + barW, y + radius, radius);
      ctx.arcTo(x + barW, baseY, x + barW - radius, baseY, radius);
      ctx.arcTo(x, baseY, x, baseY - radius, radius);
      ctx.arcTo(x, y, x + radius, y, radius);
      ctx.closePath();
      ctx.fill();

      ctx.fillStyle = '#2f7a33';
      ctx.font = '12px Inter, Arial';
      ctx.fillText(v, x + barW/2 - ctx.measureText(String(v)).width/2, y - 6);
    });

    ctx.fillStyle = '#6b8a66';
    ctx.font = '11px Inter, Arial';
    labels.forEach((lab,i) => {
      const x = padding + i * (barW + gap);
      const short = lab.split('-').slice(1).join('-');
      ctx.fillText(short, x, h - 4);
    });
  })();
</script>

<?php include_once('layouts/footer.php'); ?>
