<div id="product-list" class="row g-2">
            <?php
                include("connectdb.php");
                @$src = $_POST['src'];
                $sql = "SELECT products.*, MIN(size.price) AS min_price, MAX(size.price) AS max_price 
                        FROM `products`
                        JOIN `size` ON products.id = size.id
                        WHERE (`products`.`barcode` LIKE '%{$src}%' OR `products`.`name` LIKE '%{$src}%') AND `products`.`status` = 'active'
                        GROUP BY products.id
                        ORDER BY `id` ASC";

                $rs = mysqli_query($conn, $sql);
                while ($data = mysqli_fetch_array($rs)){
            ?>
            <!-- Product card responsive setup -->
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="assets/images/products_2/<?=$data['id'];?>.<?=$data['img'];?>" class="card-img-top" alt="" height="240px">
                    <div class="card-body">
                        <h8 class="card-title d-inline-block text-truncate" style="max-width: 150px;"><?=$data['name'];?></h8>
                        <p class="card-text">
                            <?php if ($data['min_price'] == $data['max_price']) { ?>
                                <?= number_format($data['min_price'],); ?> บาท
                            <?php } else { ?>
                                <?= number_format($data['min_price'],); ?> - <?= number_format($data['max_price'],); ?> บาท
                            <?php } ?>
                        </p>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            data-product-id="<?=$data['id'];?>"
                            data-product-name="<?=$data['name'];?>">
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
            <?php
                }
                mysqli_close($conn);
            ?>
            </div>









            <div class="row">
            <?php
                include("connectdb.php");
                @$src = $_POST['src'];
                $sql = "SELECT products.*, MIN(size.price) AS min_price, MAX(size.price) AS max_price 
                        FROM `products`
                        JOIN `size` ON products.id = size.id
                        WHERE (`products`.`barcode` LIKE '%{$src}%' OR `products`.`name` LIKE '%{$src}%') AND `products`.`status` = 'active'
                        GROUP BY products.id
                        ORDER BY `id` ASC";

                $rs = mysqli_query($conn, $sql);
                while ($data = mysqli_fetch_array($rs)){
            ?>
    <div class="col-4">
        <div class="row g-2 mb-2">
            <div class="form-floating">
                <input type="text" name="size_name" class="form-control" id="size_name" placeholder="ชื่อขนาด" value="<?= htmlspecialchars($data['size_name']); ?>" required>
                <label for="size_name">ชื่อขนาด</label>
            </div>
        </div>
    </div>

    <div class="col-2">
        <div class="row g-2 mb-2">
            <div class="form-floating">
                <input type="number" name="size_qty" class="form-control" id="size_qty" placeholder="จำนวน" value="<?= htmlspecialchars($data['qty']); ?>" required>
                <label for="size_qty">จำนวน</label>
            </div>
        </div>
    </div>

    <div class="col-2">
        <div class="row g-2 mb-2">
            <div class="form-floating">
                <input type="number" name="size_restock" class="form-control" id="size_restock" placeholder="จุดรีสต๊อก" value="<?= htmlspecialchars($data['re_stock']); ?>" required>
                <label for="size_restock">จุดรีสต๊อก</label>
            </div>
        </div>
    </div>

    <div class="col-2">
        <div class="row g-2 mb-2">
            <div class="form-floating">
                <input type="text" name="size_price" class="form-control" id="size_price" placeholder="ราคา" value="<?= htmlspecialchars($data['price']); ?>" required>
                <label for="size_price">ราคา</label>
            </div>
        </div>
    </div>

    <!-- ปุ่มลบ ที่อยู่ตรงกลางของแถวและคอลัมน์ พร้อมขนาดเท่ากับ input -->
    <div class="col-2 d-flex align-items-center justify-content-center">
        <button type="button" class="btn btn-danger form-control">
            <i class="ph ph-trash"></i>
        </button>
    </div>
    <?php
                }
                mysqli_close($conn);
            ?>
</div>
