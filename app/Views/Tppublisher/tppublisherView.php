<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
    // Initialize DataTables only once DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        new DataTable("#authorTable");
        new DataTable("#BookTable");
    });
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?>

<div class="row gy-4">
    <div class="col-xxl-12">
        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                <h6 class="text-lg mb-0">Publisher Dashboard</h6>
            </div>

            <div class="card-body p-24 pt-10">
                <!-- Tabs -->
                <ul class="nav bordered-tab border border-top-0 border-start-0 border-end-0 d-inline-flex nav-pills mb-16" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10 active" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-authors-tab" data-bs-toggle="pill" data-bs-target="#pills-authors" type="button" role="tab">Authors</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-books-tab" data-bs-toggle="pill" data-bs-target="#pills-books" type="button" role="tab">Books</button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="pills-tabContent">

                    <!-- ✅ Overview Tab -->
                    <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" tabindex="0">
                        <!-- Metrics Cards -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card h-100 p-0 radius-12">
                                    <div class="card-header border-bottom bg-base py-3 px-4">
                                        <h6 class="fs-5 fw-semibold mb-0">Publisher Metrics</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row row-cols-xxxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 g-3">

                                            <!-- Total Authors -->
                                            <div class="col">
                                                <div class="card shadow-none border bg-gradient-start-1 h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                                            <div>
                                                                <p class="fw-medium text-primary-light mb-1 fs-7">Total Authors</p>
                                                                <h4 class="mb-0 fs-5"><?= htmlspecialchars($author_count ?? '0') ?></h4>
                                                            </div>
                                                            <div class="w-40-px h-40-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                                                <iconify-icon icon="gridicons:multiple-users" class="text-base fs-5"></iconify-icon>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <span class="text-success fw-medium fs-8">
                                                                <iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon>
                                                                <?= htmlspecialchars($active_count_data['active_count_data'] ?? '0') ?> Active
                                                            </span>
                                                            <span class="text-danger fw-medium fs-8">
                                                                <iconify-icon icon="bxs:down-arrow" class="text-xs"></iconify-icon>
                                                                <?= htmlspecialchars($inactive_count_data['inactive_count_data'] ?? '0') ?> Inactive
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Total Books -->
                                            <div class="col">
                                                <div class="card shadow-none border bg-gradient-start-2 h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                                            <div>
                                                                <p class="fw-medium text-primary-light mb-1 fs-7">Total Books</p>
                                                                <h4 class="mb-0 fs-5"><?= htmlspecialchars($book_count ?? '0') ?></h4>
                                                            </div>
                                                            <div class="w-40-px h-40-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                                                <iconify-icon icon="ion:book-outline" class="text-base fs-5"></iconify-icon>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <span class="text-success fw-medium fs-8">
                                                                <iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon>
                                                                <?= htmlspecialchars($active_book_data['active_book_data'] ?? '0') ?> Active
                                                            </span>
                                                            <span class="text-danger fw-medium fs-8">
                                                                <iconify-icon icon="bxs:down-arrow" class="text-xs"></iconify-icon>
                                                                <?= htmlspecialchars($inactive_book_data['inactive_book_data'] ?? '0') ?> Inactive
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Publisher Status -->
                                            <div class="col">
                                                <div class="card shadow-none border bg-gradient-start-3 h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                                            <div>
                                                                <p class="fw-medium text-primary-light mb-1 fs-7">Publisher Status</p>
                                                                <h4 class="mb-0 fs-5">
                                                                    <?php if (!empty($publishers_data)): ?>
                                                                        <?php $status = $publishers_data[0]['status'] ?? null; ?>
                                                                        <?= $status == 1 ? 'Active' : ($status == 0 ? 'Inactive' : 'Pending') ?>
                                                                    <?php endif; ?>
                                                                </h4>
                                                            </div>
                                                            <div class="w-40-px h-40-px bg-success rounded-circle d-flex justify-content-center align-items-center">
                                                                <iconify-icon icon="mdi:account-check-outline" class="text-base fs-5"></iconify-icon>
                                                            </div>
                                                        </div>
                                                        <p class="fw-medium text-primary-light mt-2 mb-0 fs-8">
                                                            Last updated: <?= date('d-m-y') ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Publisher Info + Bank Details -->
                        <div class="row g-3">
                            <?php if (!empty($publishers_data)) { ?>
                                <?php foreach ($publishers_data as $publisher_data) { ?>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card h-100 shadow-none border">
                                            <div class="card-header bg-gradient-info text-white py-2 px-3">
                                                <h5 class="mb-0 fs-6"><strong><?= htmlspecialchars($publisher_data['publisher_name'] ?? 'N/A') ?></strong></h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>Publisher ID:</strong> <?= htmlspecialchars($publisher_data['publisher_id'] ?? 'N/A') ?></li>
                                                    <li><strong>Contact Person:</strong> <?= htmlspecialchars($publisher_data['contact_person'] ?? 'N/A') ?></li>
                                                    <li><strong>Address:</strong> <?= htmlspecialchars($publisher_data['address'] ?? 'N/A') ?></li>
                                                    <li><strong>Mobile:</strong> <?= htmlspecialchars($publisher_data['mobile'] ?? 'N/A') ?></li>
                                                    <li><strong>Email:</strong> <?= htmlspecialchars($publisher_data['email_id'] ?? 'N/A') ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="card h-100 shadow-none border">
                                            <div class="card-header bg-gradient-info text-white py-2 px-3">
                                                <h5 class="mb-0 fs-6"><strong>Bank Details</strong></h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-0">
                                                    <li><strong>Bank Acc No:</strong> <?= htmlspecialchars($publisher_data['bank_acc_no'] ?? 'N/A') ?></li>
                                                    <li><strong>Account Name:</strong> <?= htmlspecialchars($publisher_data['bank_acc_name'] ?? 'N/A') ?></li>
                                                    <li><strong>IFSC Code:</strong> <?= htmlspecialchars($publisher_data['bank_acc_ifsc'] ?? 'N/A') ?></li>
                                                    <li><strong>Account Type:</strong> <?= htmlspecialchars($publisher_data['bank_acc_type'] ?? 'N/A') ?></li>
                                                    <li><strong>Status:</strong>
                                                        <?php
                                                        $status = $publisher_data['status'] ?? null;
                                                        if ($status == 1) {
                                                            echo '<span class="badge bg-success">Active</span>';
                                                        } elseif ($status == 0) {
                                                            echo '<span class="badge bg-danger">Inactive</span>';
                                                        } else {
                                                            echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="col-12">
                                    <div class="alert alert-warning py-2 px-3 fs-7 mb-0">No publishers found.</div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- ✅ Authors Tab -->
                    <div class="tab-pane fade" id="pills-authors" role="tabpanel" tabindex="0">
                        <div class="card basic-data-table">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fs-6">Author Details</h5>
                            </div>
                            <div class="card-body">
                                <table id="authorTable" class="table bordered-table mb-0" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Author ID</th>
                                            <th>Author Name</th>
                                            <th>Mobile No</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($authors_data)) { ?>
                                            <?php $i = 1; foreach ($authors_data as $a) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= esc($a['author_id']) ?></td>
                                                    <td><?= esc($a['author_name']) ?></td>
                                                    <td><?= esc($a['mobile']) ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $s = $a['status'] ?? null;
                                                        echo $s == 1 ? '<span class="badge bg-success">Active</span>'
                                                            : ($s == 0 ? '<span class="badge bg-danger">Inactive</span>'
                                                            : '<span class="badge bg-warning text-dark">Pending</span>');
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr><td colspan="5" class="text-center text-warning py-3">No authors found.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ Books Tab -->
                    <div class="tab-pane fade" id="pills-books" role="tabpanel" tabindex="0">
                        <div class="card basic-data-table">
                            <div class="card-header">
                                <h5 class="card-title mb-0 fs-6">Book Details</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-sm text-center zero-config">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Book ID</th>
                                            <th>Publisher Book ID</th>
                                            <th>Book Name</th>
                                            <th>Author Name</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($publishers_books_data)) { ?>
                                            <?php $i = 1; foreach ($publishers_books_data as $b) { ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= esc($b['book_id']) ?></td>
                                                    <td><?= esc($b['sku_no']) ?></td>
                                                    <td><?= esc($b['book_title']) ?></td>
                                                    <td><?= esc($b['author_name']) ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $s = $b['status'] ?? null;
                                                        echo $s == 1 ? '<span class="badge bg-success">Active</span>'
                                                            : ($s == 0 ? '<span class="badge bg-danger">Inactive</span>'
                                                            : '<span class="badge bg-warning text-dark">Pending</span>');
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr><td colspan="6" class="text-center text-warning py-3">No books found.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div><!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div>
</div>

<?= $this->endSection(); ?>
