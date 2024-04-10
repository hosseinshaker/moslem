<!--menu-->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo $base_url; ?>/index.php"> <img alt="تصویر" src="<?php echo $base_url; ?>/assets/img/logo-m.png" class="header-logo"> <span class="logo-name">
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
                <img alt="تصویر" src="<?php echo $base_url; ?>/assets/img/logo-m.png">
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

            <?php  if (in_array(6, $accessArray) || in_array(7, $accessArray) || in_array(8, $accessArray) || in_array(9, $accessArray) || in_array(10, $accessArray)) {?>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="server"></i><span>انبار محصول</span></a>
                <ul class="dropdown-menu">
                <?php  } ?>  
                <?php if (in_array(6, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/Product-output.php">ثبت خروج محصول از انبار</a></li>
                <?php  } ?>  
                <?php if (in_array(7, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/product-input.php">ثبت ورود  محصول به انبار</a></li>
                <?php  } ?> 
                <?php if (in_array(8, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/insert-product.php">تعریف محصول جدید</a></li>
                    <?php  } ?>  
                    <?php if (in_array(9, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/form-output.php">گزارش محصول های خروجی</a></li>
                    <?php  } ?>  
                    <?php if (in_array(10, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/form-input.php">گزارش محصول های ورودی</a></li>
                    <?php  } ?>  
                    <?php if (in_array(11, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/productslist.php"> لیست محصولات </a></li>
                    <?php  } ?>  
                    <?php  if (in_array(6, $accessArray) || in_array(7, $accessArray) || in_array(8, $accessArray) || in_array(9, $accessArray) || in_array(10, $accessArray)) {?>
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