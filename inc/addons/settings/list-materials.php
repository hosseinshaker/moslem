<?php
$title_page = "مدیریت طرح‌ها";
require_once '../../../header.php';

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "DELETE FROM materials WHERE id = ? LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $del_message = "True";
    } else {
        echo "خطا در حذف طرح: " . $connection->error;
    }
}

$sql = "SELECT * FROM materials";
$result = $connection->query($sql);
?>

<div class="main-content">
    <nav class="row">
        <?php
        if (!empty($del_message) && $del_message == "True") :
        ?>
            <nav class="col-12 col-md-12 col-lg-12">
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        طرح با موفقیت حذف شد
                    </div>
                </div>
            </nav>
        <?php
        endif;
        ?>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>جدول مدیریت طرح‌ها</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if ($result->num_rows > 0) : ?>
                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>نام طرح</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['material_name']; ?></td>
                                            <td>
                                               
                                                <a href="list-materials.php?del=<?php echo $row['id']; ?>" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-info">
                                هیچ طرحی یافت نشد.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<?php require_once '../../../footer.php'; ?>
