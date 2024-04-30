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
        <?php  if (in_array(1, $accessArray) || in_array(2, $accessArray) || in_array(3, $accessArray) || in_array(4, $accessArray) || in_array(5, $accessArray)|| in_array(6, $accessArray)|| in_array(7, $accessArray)|| in_array(8, $accessArray)|| in_array(13, $accessArray)) {?>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="server"></i><span>انبار محصول</span></a>
                <ul class="dropdown-menu" style="display: block;">
                <?php  } ?>
                <?php if (in_array(1, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/Product-output.php">ثبت خروج محصول از انبار</a></li>
                <?php  } ?>
                <?php if (in_array(2, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/product-input.php">ثبت ورود  محصول به انبار</a></li>
                <?php  } ?>
                <?php if (in_array(3, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/register-product.php">تعریف محصول جدید</a></li>
                    <?php  } ?>
                    <?php if (in_array(4, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/form-list-output.php">گزارش محصول های خروجی</a></li>
                    <?php  } ?>  
                    <?php if (in_array(5, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/form-list-input.php">گزارش محصول های ورودی</a></li>
                    <?php  } ?>  
                    <?php if (in_array(6, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/productslist.php"> لیست محصولات </a></li>
                    <?php  } ?>  
                    <?php if (in_array(7, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/report-output-product-form.php"> گزارش تعداد محصول های خروجی  </a></li>
                    <?php  } ?>  
                    <?php if (in_array(8, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/report-input-product-form.php"> گزارش تعداد محصول های ورودی  </a></li>
                    <?php  } ?>  
                    <?php if (in_array(13, $accessArray)) {?>
                    <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/products/stock.php"> موجودی محصولات </a></li>
                    <?php  } ?>  
                    <?php  if (in_array(1, $accessArray) || in_array(2, $accessArray) || in_array(3, $accessArray) || in_array(4, $accessArray) || in_array(5, $accessArray)|| in_array(6, $accessArray)|| in_array(7, $accessArray)|| in_array(8, $accessArray)|| in_array(13, $accessArray)) {?>
                </ul>
            </li>
            <?php  } ?>  
            <?php  if (in_array(9, $accessArray) || in_array(10, $accessArray) || in_array(11, $accessArray)) {?>          
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown"><i data-feather="settings"></i><span>تنظیمات سامانه</span></a>
                <ul class="dropdown-menu">
                <?php  } ?>  
                <?php if (in_array(9, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/settings.php">تنظیمات</a></li>
                <?php  } ?>
                <?php if (in_array(10, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/add-user.php">افزودن کاربر جدید</a></li>
                <?php  } ?>
                <?php if (in_array(11, $accessArray)) {?>
                <li><a class="nav-link" href="<?php echo $base_url; ?>/inc/addons/settings/users-list.php">لیست کاربران</a></li>
                <?php  } ?>
                <?php  if (in_array(9, $accessArray) || in_array(10, $accessArray) || in_array(11, $accessArray)) {?>          
            </ul>
            </li>
            <?php  } ?> 
            <?php if (in_array(12, $accessArray)) {?>
            <li><a class="nav-link text-info" href="<?php echo $base_url; ?>/backup.php"><i data-feather="database"></i><span>پشتیبان گیری از اطلاعات</span></a></li>
            <?php  } ?> 
            <li><a class="nav-link text-danger" href="<?php echo $base_url; ?>/exit.php"><i data-feather="power"></i><span class="text-danger">خروج از سامانه</span></a></li>
        </ul>
    </aside>
</div>
<!--end--menu-->