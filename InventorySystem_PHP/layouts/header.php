<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "Inventory Management System";?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
  </head>
  <style>
  body {
    background: linear-gradient(to bottom right, #c8e6c9, #a5d6a7);
    font-family: 'Poppins', sans-serif;
  }

  .login-page {
    max-width: 400px;
    margin: 60px auto;
    background: #ffffffcc;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    padding: 30px;
    backdrop-filter: blur(6px);
  }

  .text-center h1 {
    color: #2e7d32;
    font-weight: 700;
    text-shadow: 1px 1px #9ccc65;
  }

  .text-center h4 {
    color: #558b2f;
    margin-bottom: 25px;
  }

  .form-control {
    border: 1px solid #81c784;
    border-radius: 10px;
  }

  .form-control:focus {
    border-color: #388e3c;
    box-shadow: 0 0 5px #66bb6a;
  }

  .btn-danger {
    background-color: #4caf50 !important;
    border: none;
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 10px !important;
    transition: 0.3s;
  }

  .btn-danger:hover {
    background-color: #388e3c !important;
    transform: scale(1.05);
  }

  /* Add small plant icons or leaves as decoration */
  .login-page::before, .login-page::after {
    content: '';
    position: absolute;
    width: 80px;
    height: 80px;
    background: url('https://cdn-icons-png.flaticon.com/512/7662/7662794.png') no-repeat center;
    background-size: contain;
    opacity: 0.2;
  }

  .login-page::before {
    top: 20px;
    left: -60px;
  }

  .login-page::after {
    bottom: 20px;
    right: -60px;
  }

  label {
    color: #33691e;
    font-weight: 500;
  }

  input::placeholder {
    color: #81c784;
  }
</style>

  <body>
    <style>
/* Nursery theme - add to header */
body {
  background: linear-gradient(135deg, #f1fbf3 0%, #e6f7ea 100%);
  font-family: 'Poppins', Arial, sans-serif;
  color: #254a23;
}

.nursery-panel {
  border-radius: 12px;
  background: rgba(255,255,255,0.95);
  box-shadow: 0 6px 18px rgba(37,74,35,0.06);
  padding: 12px;
  position: relative;
}

.nursery-heading {
  background: linear-gradient(90deg, rgba(76,175,80,0.08), rgba(139,195,74,0.04));
  border-bottom: 1px solid rgba(76,175,80,0.12);
  color: #2e7d32;
}

.panel-icon {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size: 20px;
  color: #fff;
}

.bg-secondary1 { background: #7cb342; }
.bg-red { background: #66bb6a; }
.bg-blue2 { background: #8bc34a; }
.bg-green { background: #43a047; }

.panel-value h2 { color: #2b5a2a; font-weight: 700; }
.panel-value p { margin:0; color:#557a3b; }

.table > thead > tr > th {
  background: rgba(76,175,80,0.05);
  color: #2e7d32;
}

/* avatars */
.img-avatar { width:36px; height:36px; object-fit:cover; border-radius:50%; margin-right:8px; }

/* small decorative leaf in corners */
body::before {
  content: "🌿";
  position: fixed;
  left: 12px;
  bottom: 12px;
  font-size: 28px;
  opacity: 0.18;
}
</style>

  <?php  if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
      <div class="logo pull-left"> Inventory System</div>
      <div class="header-content">
      <div class="header-date pull-left">
        <strong><?php echo date("F j, Y, g:i a");?></strong>
      </div>
      <div class="pull-right clearfix">
        <ul class="info-menu list-inline list-unstyled">
          <li class="profile">
            <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
              <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
              <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                  <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                      <i class="glyphicon glyphicon-user"></i>
                      Profile
                  </a>
              </li>
             <li>
                 <a href="edit_account.php" title="edit account">
                     <i class="glyphicon glyphicon-cog"></i>
                     Settings
                 </a>
             </li>
             <li class="last">
                 <a href="logout.php">
                     <i class="glyphicon glyphicon-off"></i>
                     Logout
                 </a>
             </li>
           </ul>
          </li>
        </ul>
      </div>
     </div>
    </header>
    <div class="sidebar">
      <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
      <?php include_once('admin_menu.php');?>

      <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special user -->
      <?php include_once('special_menu.php');?>

      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
      <?php include_once('user_menu.php');?>

      <?php endif;?>

   </div>
<?php endif;?>

<div class="page">
  <div class="container-fluid">
