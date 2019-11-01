
<div class="ui compact inverted vertical labeled icon menu click-menu">
  <a class="item">
    <i class="windows icon"></i>
    Menu
  </a>
</div>

<div class="ui left demo vertical inverted sidebar labeled icon menu">
  
  <?php if(empty($_SESSION['borrow'])){ ?>
  <a class="item" href="./index.php">
    <i class="configure icon"></i>
    ยืมอุปกรณ์
  </a>
  <?php } ?>
  <a class="item" href="./allow.php">
    <i class="map pin icon"></i>
    รอการอนุมัติ
  </a>
  <a class="item" href="./give_back.php">
    <i class="checkmark box icon"></i>
    อนุมัติแล้ว/รอคืน
  </a>z
  <a class="item" href="./history.php">
    <i class="history icon"></i>
    ประวัติย้อนหลัง
  </a>
  <?php if(empty($_SESSION['borrow'])){ ?>
  <a class="item"  href="./login.php">
    <i class="sign in icon"></i>
    LOG IN
  </a>
  <?php }else { ?>
  <a class="item" href="./configure.php">
    <i class="configure icon"></i>
    จัดการอุปกรณ์
  </a>
  <a class="item" href="./logout.php">
    <i class="sign out icon"></i>
    LOG OUT
  </a>
  <?php } ?>
</div>