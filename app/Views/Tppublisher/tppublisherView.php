<?= $this->extend('layout/layout1'); ?>
<?= $this->section('script'); ?>
    <script>
        let authorTable = new DataTable("#authorTable");
let bookTable = new DataTable("#BookTable");
    </script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-xxl-12">
        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                <h6 class="text-lg mb-0">Publisher Dashboard</h6>
            </div>
            <div class="card-body p-24 pt-10">
                <ul class="nav bordered-tab border border-top-0 border-start-0 border-end-0 d-inline-flex nav-pills mb-16" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10 active" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab" aria-controls="pills-overview" aria-selected="true">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-authors-tab" data-bs-toggle="pill" data-bs-target="#pills-authors" type="button" role="tab" aria-controls="pills-authors" aria-selected="false">Authors</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-books-tab" data-bs-toggle="pill" data-bs-target="#pills-books" type="button" role="tab" aria-controls="pills-books" aria-selected="false">Books</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
    <!-- Overview Tab -->
    <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
        <!-- Metrics Cards Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card h-100 p-0 radius-12">
                    <div class="card-header border-bottom bg-base py-3 px-4"> 
                        <h6 class="fs-5 fw-semibold mb-0">Publisher Metrics</h6> 
                    </div>
                    <div class="card-body p-3"> 
                        <div class="row row-cols-xxxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 g-3">
                            <!-- Total Authors Card -->
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

                            <!-- Total Books Card -->
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

                            <!-- Status Card -->
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
                                            Last updated: <?= date('Y-m-d') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publisher Details Section -->
        <div class="row g-3">
            <?php if (!empty($publishers_data)) { ?>
                <?php foreach ($publishers_data as $publisher_data) { ?>
                    <!-- Publisher Info Card -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card h-100 shadow-none border">
                            <div class="card-header bg-gradient-info text-white py-2 px-3"> <!-- Reduced padding -->
                                <h5 class="mb-0 fs-6"><strong><?= htmlspecialchars($publisher_data['publisher_name'] ?? 'N/A') ?></strong></h5> <!-- Smaller heading -->
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Publisher ID:</span> <!-- Smaller font and reduced min-width -->
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['publisher_id'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Contact Person:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['contact_person'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Address:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['address'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Mobile:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['mobile'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Email ID:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['email_id'] ?? 'N/A') ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details Card -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card h-100 shadow-none border">
                            <div class="card-header bg-gradient-info text-white py-2 px-3"> 
                                <h5 class="mb-0 fs-6"><strong>Bank Details</strong></h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Bank Acc No:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['bank_acc_no'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Account Name:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['bank_acc_name'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">IFSC Code:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['bank_acc_ifsc'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="mb-2 d-flex">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Account Type:</span>
                                        <span class="fs-7"><?= htmlspecialchars($publisher_data['bank_acc_type'] ?? 'N/A') ?></span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Status:</span>
                                        <?php
                                        $status = $publisher_data['status'] ?? null;
                                        if ($status == 1) {
                                            echo '<span class="badge bg-success py-1 px-2 fs-8"> Active</span>';
                                        } elseif ($status == 0) {
                                            echo '<span class="badge bg-danger py-1 px-2 fs-8"> Inactive</span>';
                                        } else {
                                            echo '<span class="badge bg-warning text-dark py-1 px-2 fs-8">⏳ Pending</span>';
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
</div>


                    <!-- Authors Tab -->
    <div class="tab-pane fade" id="pills-authors" role="tabpanel" aria-labelledby="pills-authors-tab" tabindex="0">
    <div class="card h-100 p-0 radius-12">
        <div class="card-header border-bottom bg-base py-3 px-4 d-flex align-items-center flex-wrap gap-3 justify-content-between">
        </div>
        <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0" style="font-size:16px;">Author Details</h5>
        </div>
        <div class="card-body">
            <table id="authorTable" class="table bordered-table mb-0" data-page-length="10" style="font-size:13px; table-layout: fixed; width: 100%;">
                <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">SL</th>
                            <th scope="col" class="text-nowrap">Author ID</th>
                            <th scope="col" class="text-nowrap">Author Name</th>
                            <th scope="col" class="text-nowrap">Mobile No</th>
                            <th scope="col" class="text-nowrap text-center">Status</th>
                            <!-- <th scope="col" class="text-nowrap text-center">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($authors_data)) { ?>
                            <?php $i = 1; foreach ($authors_data as $author_data) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($author_data['author_id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($author_data['author_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($author_data['mobile'] ?? 'N/A') ?></td>
                                    <td class="text-center">
                                        <?php
                                        $status = $author_data['status'] ?? null;
                                        if ($status == 1) {
                                            echo '<span class="badge bg-success-focus text-success-600 border border-success-main px-3 py-1 radius-4 fw-medium text-sm">Active</span>';
                                        } elseif ($status == 0) {
                                            echo '<span class="badge bg-danger-focus text-danger-600 border border-danger-main px-3 py-1 radius-4 fw-medium text-sm">Inactive</span>';
                                        } else {
                                            echo '<span class="badge bg-warning-focus text-warning-600 border border-warning-main px-3 py-1 radius-4 fw-medium text-sm">Pending</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-warning">No authors found for this publisher.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Books Tab -->
<div class="tab-pane fade" id="pills-books" role="tabpanel" aria-labelledby="pills-books-tab" tabindex="0">
    <div class="card h-100 p-0 radius-12">
        <div class="card-header border-bottom bg-base py-3 px-4 d-flex align-items-center flex-wrap gap-3 justify-content-between">

         <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0" style="font-size:16px;">Book Details</h5>
        </div>
        <div class="card-body">
            <table id="BookTable" class="table bordered-table mb-0" data-page-length="10" style="font-size:13px; table-layout: fixed; width: 100%;">
                <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">SL</th>
                            <th scope="col" class="text-nowrap">Book ID</th>
                            <th scope="col" class="text-nowrap">Publisher Book ID</th>
                            <th scope="col" class="text-nowrap">Book Name</th>
                            <th scope="col" class="text-nowrap">Author Name</th>
                            <th scope="col" class="text-nowrap text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($publishers_books_data)) { ?>
                            <?php $i = 1; foreach ($publishers_books_data as $book) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($book['book_id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($book['sku_no'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($book['book_title'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($book['author_name'] ?? 'N/A') ?></td>
                                    <td class="text-center">
                                        <?php
                                        $status = $book['status'] ?? null;
                                        if ($status == 1) {
                                            echo '<span class="badge bg-success-focus text-success-600 border border-success-main px-3 py-1 radius-4 fw-medium text-sm">Active</span>';
                                        } elseif ($status == 0) {
                                            echo '<span class="badge bg-danger-focus text-danger-600 border border-danger-main px-3 py-1 radius-4 fw-medium text-sm">Inactive</span>';
                                        } else {
                                            echo '<span class="badge bg-warning-focus text-warning-600 border border-warning-main px-3 py-1 radius-4 fw-medium text-sm">Pending</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-warning">No books found for this publisher.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>