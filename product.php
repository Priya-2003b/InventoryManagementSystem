<?php
  $page_title = 'Trending Plants - Grid View';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>

<!-- Amazon-like Product Grid CSS (add to header or in a CSS file if preferred) -->
<style>
/* Grid container */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 18px;
}

/* Card */
.product-card {
  background: #fff;
  border-radius: 8px;
  border: 1px solid rgba(0,0,0,0.06);
  padding: 12px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: box-shadow .18s ease, transform .12s ease;
  min-height: 340px;
}
.product-card:hover {
  box-shadow: 0 8px 28px rgba(0,0,0,0.12);
  transform: translateY(-4px);
}

/* Image area */
.product-thumb {
  height: 170px;
  display:flex;
  align-items:center;
  justify-content:center;
  overflow:hidden;
  margin-bottom:10px;
  background: linear-gradient(180deg, rgba(230,250,230,1), rgba(245,255,245,1));
  border-radius:6px;
}
.product-thumb img {
  max-width:100%;
  max-height:100%;
  object-fit:contain;
  display:block;
}

/* Title and meta */
.product-title {
  font-size: 15px;
  font-weight:600;
  color: #1e3e20;
  margin-bottom:6px;
  min-height:40px;
}
.product-meta { font-size: 13px; color:#6b8a66; margin-bottom:8px; }

/* Price */
.product-price {
  font-size: 18px;
  font-weight: 800;
  color: #0b6b2f;
  margin-bottom:8px;
}
.product-price .old { font-size:13px; color:#8a8a8a; font-weight:600; text-decoration: line-through; margin-left:8px; }

/* Rating */
.rating {
  display:inline-block;
  color: #f5a623;
  margin-right:8px;
  font-weight:700;
  font-size:13px;
}
.reviews { color:#6b8a66; font-size:12px; }

/* Badges */
.badge {
  display:inline-block;
  padding:6px 8px;
  border-radius:999px;
  font-weight:700;
  font-size:11px;
  color:#fff;
  margin-right:6px;
}
.badge-bestseller { background: linear-gradient(90deg,#ff7043,#ff8a65); }
.badge-new { background: linear-gradient(90deg,#7cb342,#9ccc65); }

/* Actions */
.card-actions { display:flex; gap:6px; margin-top:10px; }
.btn-ghost {
  border:1px solid rgba(0,0,0,0.08);
  padding:8px 10px;
  border-radius:6px;
  background: #fff;
  cursor:pointer;
}
.btn-primary-cta {
  background: linear-gradient(90deg,#43a047,#388e3c);
  color:#fff;
  padding:8px 12px;
  border-radius:6px;
  border:none;
  cursor:pointer;
  font-weight:700;
}

/* Responsive: compact on small screens */
@media (max-width:575px){
  .product-thumb { height: 140px; }
  .product-card { min-height: 300px; padding:10px; }
  .product-title { font-size:14px; min-height:34px; }
}
</style>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row" style="margin-bottom:14px; align-items:center;">
  <div class="col-md-8">
    <h2 style="margin:0; color:#274b27;">Explore Plants (Grid)</h2>
    <div class="small-muted">Browse, sort and quickly manage your plant inventory</div>
  </div>
  <div class="col-md-4 text-right">
    <a href="add_product.php" class="btn btn-primary">Add New Plant</a>
  </div>
</div>

<!-- Filters / controls (simple placeholders like Amazon) -->
<div class="row" style="margin-bottom:16px;">
  <div class="col-md-8">
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
      <div class="btn-ghost">All</div>
      <div class="btn-ghost">Indoor</div>
      <div class="btn-ghost">Outdoor</div>
      <div class="btn-ghost">Succulents</div>
      <div class="btn-ghost">Sale</div>
    </div>
  </div>

  <div class="col-md-4 text-right">
    <!-- Simple sort dropdown -->
    <form method="get" style="display:inline-block;">
      <select name="sort" class="form-control" style="display:inline-block; width:auto;">
        <option value="">Sort by: Featured</option>
        <option value="popular">Most Popular</option>
        <option value="new">Newest Arrivals</option>
        <option value="price_asc">Price: Low to High</option>
        <option value="price_desc">Price: High to Low</option>
      </select>
    </form>
  </div>
</div>

<!-- Product grid -->
<div class="product-grid">
  <?php foreach ($products as $product): ?>

    <?php
      // Prepare display values (safe)
      $id    = (int)$product['id'];
      $name  = remove_junk($product['name']);
      $cat   = remove_junk($product['categorie']);
      $qty   = (int)$product['quantity'];
      $buy   = number_format((float)$product['buy_price'], 2);
      $sale  = number_format((float)$product['sale_price'], 2);

      // Image
      $img = ($product['media_id'] === '0') ? 'uploads/products/no_image.png' : 'uploads/products/' . $product['image'];

      // Rating: use existing field if present otherwise default
      $rating = (isset($product['rating']) && $product['rating'] !== '') ? (float)$product['rating'] : 4.3;
      $reviews = (isset($product['reviews']) && $product['reviews'] !== '') ? (int)$product['reviews'] : rand(12, 320); // fallback

      // Lightweight trend / badge heuristics
      $trend_score = (int)round(((float)$product['sale_price']) * $qty);
      $badge_html = '';
      if ($trend_score >= 1500) {
        $badge_html = '<span class="badge badge-bestseller">Best Seller</span>';
      } elseif (strtotime($product['date']) > strtotime('-30 days')) {
        $badge_html = '<span class="badge badge-new">New Arrival</span>';
      }
    ?>

    <div class="product-card" aria-labelledby="product-<?php echo $id; ?>">
      <div>
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
          <div><?php echo $badge_html; ?></div>
          <div style="font-size:12px; color:#6b8a66;">Stock: <?php echo $qty; ?></div>
        </div>

        <div class="product-thumb" role="img" aria-label="<?php echo htmlspecialchars($name); ?>">
          <img loading="lazy" src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($name); ?>">
        </div>

        <div class="product-title" id="product-<?php echo $id; ?>">
          <a href="edit_product.php?id=<?php echo $id; ?>" style="color:inherit; text-decoration:none;">
            <?php echo $name; ?>
          </a>
        </div>

        <div class="product-meta"><?php echo htmlspecialchars($cat); ?> • SKU: <?php echo $id; ?></div>

        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
          <div class="rating">
            <?php
              // show star icons for rating (rounded to 0.5)
              $r = round($rating * 2) / 2;
              for ($i = 1; $i <= 5; $i++) {
                if ($r >= $i) { echo '★'; }
                elseif ($r >= $i - 0.5) { echo '☆'; } // half-star placeholder (simple)
                else { echo '☆'; }
              }
            ?>
          </div>
          <div class="reviews">(<?php echo $reviews; ?>)</div>
        </div>
      </div>

      <div>
        <div class="product-price">
          $<?php echo $sale; ?>
          <?php if ((float)$product['buy_price'] > (float)$product['sale_price']): ?>
            <span class="old">$<?php echo $buy; ?></span>
          <?php endif; ?>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
          <div class="small-muted">Added: <?php echo read_date($product['date']); ?></div>
          <div style="display:flex; gap:6px;">
            <a href="edit_product.php?id=<?php echo $id;?>" class="btn-ghost" title="Edit">
              <span class="glyphicon glyphicon-edit"></span>
            </a>
            <a href="delete_product.php?id=<?php echo $id;?>" class="btn-ghost" title="Delete">
              <span class="glyphicon glyphicon-trash"></span>
            </a>
            <a href="product.php?id=<?php echo $id;?>" class="btn-ghost" title="View">
              <span class="glyphicon glyphicon-eye-open"></span>
            </a>
          </div>
        </div>

        <div class="card-actions" style="margin-top:12px;">
          <!-- Example quick "Add to cart" action (adjust URL to your cart handler) -->
          <form method="post" action="add_cart.php" style="margin:0; display:flex; gap:6px;">
            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
            <input type="hidden" name="qty" value="1">
            <button type="submit" class="btn-primary-cta" aria-label="Add <?php echo htmlspecialchars($name); ?> to cart">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>

  <?php endforeach; ?>
</div>

<!-- Optional: simple pagination placeholder (server-side pagination recommended) -->
<div style="margin-top:18px; display:flex; justify-content:center; gap:8px;">
  <a href="#" class="btn-ghost">« Prev</a>
  <a href="#" class="btn-ghost">1</a>
  <a href="#" class="btn-ghost">2</a>
  <a href="#" class="btn-ghost">3</a>
  <a href="#" class="btn-ghost">Next »</a>
</div>

<?php include_once('layouts/footer.php'); ?>
