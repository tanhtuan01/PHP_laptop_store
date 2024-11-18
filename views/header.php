  <div class="header">
      <div class="header-content">
          <div class="top row">
              <div class="logo">
                  <a href="<?php echo $config['BASE_URL']; ?>">
                      Trang chủ
                      <!-- <img src="https://fecredit.com.vn/wp-content/uploads/2018/12/thegioididong.png" alt=""> -->
                  </a>
              </div>
              <div class="search">
                  <div class="box-search">
                      <form action="<?php echo $config['BASE_URL'] . "/views/search.php" ?>" method="GET">
                          <div class="input">
                              <input type="text" placeholder="Bạn tìm gì..." name="q" id="ips">
                              <button><i class="fa-solid fa-magnifying-glass"></i></button>
                          </div>

                      </form>
                  </div>
              </div>
              <div class="login">
                  <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                  <a href='<?php echo $config['BASE_URL'] . "/user/profile.php"; ?>'><i class="fa-solid fa-user"></i>
                      <?php echo $_SESSION['user']['username']; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $config['BASE_URL'] . "/login.php"; ?>"><i class="fa-solid fa-user"></i>
                      Đăng nhập</a>
                  <?php } ?>
              </div>

              <div class="cart">
                  <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                  <a href="<?php echo $config['BASE_URL'] . "/user/cart.php"; ?>">
                      <i class="fa-solid fa-cart-shopping"></i>
                      Giỏ hàng
                  </a>
                  <?php } else { ?> <a href="<?php echo $config['BASE_URL'] . "/login.php"; ?>">
                      <i class="fa-solid fa-cart-shopping"></i>
                      (0)
                  </a> <?php } ?>
              </div>
              <div class="address">
                  <a href="">
                      <i class="fa-solid fa-location-dot"></i>
                      Hà Nội
                  </a>
                  <i class="fa-solid fa-chevron-right sub-icon"></i>
              </div>
          </div>
          <div class="sub-row">
              <div class="new"></div>
              <div class="old"></div>
          </div>
      </div>
  </div>