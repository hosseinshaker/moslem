<?php
$title_page = "نمایش لیست محصولات ";
require_once '../../../header.php';
// دستور SELECT
$sql = "SELECT * FROM products";
$result = $connection->query($sql);
?>

<div class="main-content">
    <nav class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $title_page;  ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                        <?php if ($result->num_rows > 0) : ?>
                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>شناسه/بارکد</th>
                                        <th>نام محصول</th>
                                        <th>تعداد موجودی</th>
                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $row['productqr']; ?></td>
                                            <td class="text-left"><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['stock']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <div class="alert alert-info">
                                هیچ محصولی یافت نشد.
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
