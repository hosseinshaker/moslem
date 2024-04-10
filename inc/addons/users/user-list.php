<?php
$title_page = "نمایش محصولات اولیه";
require_once '../../../header.php';

if(isset($_GET['del'])){
    $id=$_GET['del'];
    $sql = "DELETE FROM users WHERE id = $id";
    if ($connection->query($sql) === TRUE) {
       $del_message="True";
    } else {
        echo "خطا در حذف کاربر: " . $connection->error;
    }
}
// دستور SELECT
$sql = "SELECT * FROM users";
$result = $connection->query($sql);
?>

<div class="main-content">
    <nav class="row">
    <?php
if(!empty($del_message)&&  $del_message= "True"):
?>
<nav class="col-12 col-md-12 col-lg-12">
<div class="alert alert-danger alert-dismissible show fade">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
 کاربر با موفقیت حذف شد
                    </div>
                    </div>
</nav>
<?php
endif;
?>

    <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>جدول مدیریت  کاربران</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <?php if ($result->num_rows > 0) : ?>
                                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>شناسه</th>
                                                    <th>نام کاربر </th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td>
                                <a href="edit-user.php?id=<?php echo $row['id']; ?>" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                <a href="user-list.php?del=<?php echo $row['id']; ?>" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                </td>
                                                </tr>
                                                <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                            <?php else : ?>
                <div class="alert alert-info">
                    هیچ  کاربری  یافت نشد.
                </div>
            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    </nav>
</div>

<?php require_once '../../../footer.php'; ?>