<!--menu-->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo $base_url; ?>/index.php"> <img alt="تصویر" src="<?php echo $base_url; ?>/assets/img/logo-shirazcover.png" class="header-logo"> <span class="logo-name">
                <?php
$columnName = "sitename";
$tablename="options";
$value = getColumnValue($connection, $columnName,$tablename);
echo "$value";
                ?>
            </span>
            </a>
        </div>
        <div class="sidebar-user">
            <div class="sidebar-user-picture">
                <img alt="تصویر" src="<?php echo $base_url; ?>/assets/img/logo-shirazcover.png">
            </div>
            <div class="sidebar-user-details">
                <div class="user-name"><?php echo $_SESSION["username"];?></div>
                    <?php
    // تبدیل رشته به آرایه از اعداد
    $accessArray = explode(',', $_SESSION["access"]);
    // بررسی وجود عدد  در آرایه
    ?>
            </div>
        </div>
        <ul class="sidebar-menu">
        <?php  if (in_array(1, $accessArray) || in_array(2, $accessArray) || in_array(3, $accessArray) || in_array(4, $accessArray) || in_array(5, $accessArray)) {
  ?>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="database"></i><span>انبار مواد اولیه</span></a>
                <ul class="dropdown-menu">
                <?php  } ?>  
                <?php if (in_array(1, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/primary-products/insert-product.php">تعریف مواد اولیه جدید</a></li>
                    <?php  } ?>  
                    <?php if (in_array(2, $accessArray)) {?>        
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/primary-products/productslist.php">لیست مواد های اولیه</a></li>
                    <?php  } ?>  
                    <?php if (in_array(3, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/primary-products/deduction-product.php">خروج مواد اولیه</a></li>
                    <?php  } ?>  
                    <?php if (in_array(4, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/primary-products/increase-product.php">ورود مواد اولیه</a></li>
                    <?php  } ?>  
                    <?php if (in_array(5, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/primary-products/search-report.php">گزارش ورود/خروج مواد اولیه</a></li>
                    <?php  } ?>  
<?php  if (in_array(1, $accessArray) || in_array(2, $accessArray) || in_array(3, $accessArray) || in_array(4, $accessArray) || in_array(5, $accessArray)) {?>
                </ul>
            </li>
            <?php  } ?>  
            <?php  if (in_array(6, $accessArray) || in_array(7, $accessArray) || in_array(8, $accessArray) || in_array(9, $accessArray) || in_array(10, $accessArray)) {?>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="server"></i><span>انبار محصول</span></a>
                <ul class="dropdown-menu">
                <?php  } ?>  
                <?php if (in_array(6, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/Product-output.php">ثبت خروج محصول</a></li>
                <?php  } ?>  
                <?php if (in_array(7, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/product-input.php">ثبت ورود محصول</a></li>
                <?php  } ?>  
                <?php if (in_array(8, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/insert-product.php">تعریف محصول جدید</a></li>
                    <?php  } ?>  
                    <?php if (in_array(9, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/form-output.php">لیست محصول های خروجی</a></li>
                    <?php  } ?>  
                    <?php if (in_array(10, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/form-input.php">لیست محصول های ورودی</a></li>
                    <?php  } ?>  
                    <?php if (in_array(11, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/calculate-Products.php">محاسبه مواد اولیه هر محصول</a></li>
                    <?php  } ?>  
                    <?php  if (in_array(6, $accessArray) || in_array(7, $accessArray) || in_array(8, $accessArray) || in_array(9, $accessArray) || in_array(10, $accessArray)) {?>
                </ul>
            </li>
            <?php  } ?>  
<?php  if (in_array(12, $accessArray) || in_array(13, $accessArray) || in_array(14, $accessArray) || in_array(16, $accessArray) || in_array(18, $accessArray)| in_array(19, $accessArray)) {?>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="users"></i><span>کاربران/خیاط ها</span></a>
                <ul class="dropdown-menu">
                <?php  } ?>  
                <?php if (in_array(12, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/users/add-user.php">ثبت کاربر جدید</a></li>
                <?php  } ?>  
                <?php if (in_array(13, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/users/user-list.php">لیست کاربران</a></li>
                <?php  } ?>  
                <?php if (in_array(14, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/users/add-stock.php">افزودن موجودی انبار کاربر</a></li>
                <?php  } ?>  
                <?php if (in_array(16, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/users/deducation-stock.php">کاهش موجودی انبار کاربر</a></li>
                <?php  } ?>  
                <?php if (in_array(18, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/users/form-stock.php">لیست موجودی کاربران</a></li>
                <?php  } ?>  
                <?php if (in_array(19, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/users/dastmozd.php">محاسبه حقوق کاربر</a></li>
                <?php  } ?>  
                <?php  if (in_array(12, $accessArray) || in_array(13, $accessArray) || in_array(14, $accessArray) || in_array(16, $accessArray) || in_array(18, $accessArray)| in_array(19, $accessArray)) {?>          
            </ul>
            </li>
            <?php  } ?>  


            <?php  if (in_array(20, $accessArray) || in_array(21, $accessArray) || in_array(22, $accessArray)|| in_array(25, $accessArray)|| in_array(26, $accessArray) ) {?>          
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="settings"></i><span>تنظیمات سامانه</span></a>
                <ul class="dropdown-menu">
                <?php  } ?>  
                <?php if (in_array(20, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/settings.php">تنظیمات</a></li>
                <?php  } ?>  
                <?php if (in_array(21, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/users-list.php">لیست پرسنل سامانه</a></li>
                <?php  } ?>  
                <?php if (in_array(22, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/add-user.php">افزودن پرسنل به سامانه</a></li>
                <?php  } ?> 
                <?php if (in_array(15, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/add-color.php">افزودن رنگ</a></li>
                <?php  } ?>  
                <?php if (in_array(17, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/add-material.php">افزودن طرح</a></li>
                <?php  } ?>  
                <?php if (in_array(25, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/list-colors.php">مدیریت رنگ ها</a></li>
                <?php  } ?> 
                <?php if (in_array(26, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/list-materials.php">مدیریت طرح ها</a></li>
                <?php  } ?> 
                <?php  if (in_array(20, $accessArray) || in_array(21, $accessArray) || in_array(22, $accessArray)|| in_array(25, $accessArray)|| in_array(26, $accessArray) ) {?>          
            </ul>
            </li>
            <?php  } ?> 
            <?php if (in_array(24, $accessArray)) {?>
            <li><a class="nav-link text-info" href="<?php echo $base_url; ?>/backup.php"><i data-feather="database"></i><span>پشتیبان گیری از اطلاعات</span></a></li>
            <?php  } ?> 
            <li><a class="nav-link text-danger" href="<?php echo $base_url; ?>/exit.php"><i data-feather="power"></i><span class="text-danger">خروج از سامانه</span></a></li>
        </ul>
    </aside>
</div>
<!--end--menu-->