<?= $this->extend('layout/layout1'); ?>
<?= $this->section('script'); ?>
    <script>
        let BookTable = new DataTable("#BookTable");
    </script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?> 
<div class="row gy-4">
    <div class="col-xxl-12">
        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                <h6 class="text-lg mb-0">Author Details</h6>
            </div>
            <div class="card-body p-24 pt-10">
                <ul class="nav bordered-tab border border-top-0 border-start-0 border-end-0 d-inline-flex nav-pills mb-16" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10 active" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab" aria-controls="pills-overview" aria-selected="true">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-publisher-tab" data-bs-toggle="pill" data-bs-target="#pills-publisher" type="button" role="tab" aria-controls="pills-publisher" aria-selected="false">Publisher</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-books-tab" data-bs-toggle="pill" data-bs-target="#pills-books" type="button" role="tab" aria-controls="pills-books" aria-selected="false">Books</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
                        <!-- Metrics Cards Row -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card h-100 p-0 radius-12">
                                    <div class="card-header border-bottom bg-base py-3 px-4">
                                        <h6 class="fs-5 fw-semibold mb-0">Author Metrics</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row row-cols-xxxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 g-3">
                                            <!-- Book Count Card -->
                                            <div class="col">
                                                <div class="card shadow-none border bg-gradient-start-2 h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                                            <div>
                                                                <p class="fw-medium text-primary-light mb-1 fs-7">Total Books</p>
                                                                <h4 class="mb-0 fs-5"><?= esc($book_count) ?></h4>
                                                            </div>
                                                            <div class="w-40-px h-40-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                                                <iconify-icon icon="ion:book-outline" class="text-base fs-5"></iconify-icon>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row g-3">
                            <?php if (!empty($authors_data)) { ?>
                                <?php foreach ($authors_data as $author_data) { ?>
                                    <!-- Author Info Card -->
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card h-100 shadow-none border">
                                            <div class="card-header bg-gradient-info text-white py-2 px-3">
                                                <h5 class="mb-0 fs-6"><strong>Author Information</strong></h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-2 d-flex">
                                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Name:</span>
                                                        <span class="fs-7"><?= esc($author_data['author_name']) ?></span>
                                                    </li>
                                                    <li class="mb-2 d-flex">
                                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Mobile:</span>
                                                        <span class="fs-7"><?= esc($author_data['mobile']) ?></span>
                                                    </li>
                                                    <li class="mb-2 d-flex">
                                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Email:</span>
                                                        <span class="fs-7"><?= esc($author_data['email_id']) ?></span>
                                                    </li>
                                                    <li class="mb-2 d-flex">
                                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Description:</span>
                                                        <span class="fs-7"><?= esc($author_data['author_discription']) ?></span>
                                                    </li>
                                                    <li class="d-flex">
                                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Image:</span>
                                                        <span class="fs-7"><?= esc($author_data['author_image']) ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Card -->
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card h-100 shadow-none border">
                                            <div class="card-header bg-gradient-info text-white py-2 px-3">
                                                <h5 class="mb-0 fs-6"><strong>Status</strong></h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-center">
                                                        <span class="fw-semibold me-2 fs-7" style="min-width: 100px;">Status:</span>
                                                        <?php
                                                        $status = $author_data['status'] ?? null;
                                                        if ($status == 1) {
                                                            echo '<span class="badge bg-success py-1 px-2 fs-8"> Active</span>';
                                                        } elseif ($status == 0) {
                                                            echo '<span class="badge bg-danger py-1 px-2 fs-8"> Inactive</span>';
                                                        } else {
                                                            echo '<span class="badge bg-warning text-dark py-1 px-2 fs-8"> Pending</span>';
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
                                    <div class="alert alert-warning py-2 px-3 fs-7 mb-0">No author information available.</div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Publisher Tab -->
                    <div class="tab-pane fade" id="pills-publisher" role="tabpanel" aria-labelledby="pills-publisher-tab" tabindex="0">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <?php if (!empty($publishers_data)) : ?>
                                    <?php foreach ($publishers_data as $publisher) : ?>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2 d-flex">
                                                <span class="fw-semibold me-2 fs-7" style="min-width: 120px;">Name:</span>
                                                <span class="fs-7"><?= esc($publisher['publisher_name']) ?></span>
                                            </li>
                                            <li class="mb-2 d-flex">
                                                <span class="fw-semibold me-2 fs-7" style="min-width: 120px;">Contact Person:</span>
                                                <span class="fs-7"><?= esc($publisher['contact_person']) ?></span>
                                            </li>
                                            <li class="mb-2 d-flex">
                                                <span class="fw-semibold me-2 fs-7" style="min-width: 120px;">Address:</span>
                                                <span class="fs-7"><?= esc($publisher['address']) ?></span>
                                            </li>
                                            <li class="mb-2 d-flex">
                                                <span class="fw-semibold me-2 fs-7" style="min-width: 120px;">Mobile:</span>
                                                <span class="fs-7"><?= esc($publisher['mobile']) ?></span>
                                            </li>
                                            <li class="mb-2 d-flex">
                                                <span class="fw-semibold me-2 fs-7" style="min-width: 120px;">Email:</span>
                                                <span class="fs-7"><?= esc($publisher['email_id']) ?></span>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <span class="fw-semibold me-2 fs-7" style="min-width: 120px;">Status:</span>
                                                <?php
                                                $status = $publisher['status'] ?? null;
                                                if ($status == 1) {
                                                    echo '<span class="badge bg-success py-1 px-2 fs-8">Active</span>';
                                                } elseif ($status == 0) {
                                                    echo '<span class="badge bg-danger py-1 px-2 fs-8">Inactive</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning text-dark py-1 px-2 fs-8">Pending</span>';
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-muted fs-7">No publisher data available for this author.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Books Tab -->
                    <div class="tab-pane fade" id="pills-books" role="tabpanel" aria-labelledby="pills-books-tab" tabindex="0">
                        <div class="card shadow-none border">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center mb-3 px-3 pt-2">
                                    <h6 class="mb-0 fs-6">Total Books: <?= esc($book_count) ?></h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-sm text-center zero-config">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">Book ID</th>
                                                <th class="text-nowrap">Publisher Book Id</th>
                                                <th class="text-nowrap">Title</th>
                                                <th class="text-nowrap">MRP</th>
                                                <th class="text-nowrap text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($publishers_books_data)) : ?>
                                                <?php foreach ($publishers_books_data as $book) : ?>
                                                    <tr>
                                                        <td><?= esc($book['book_id']) ?></td>
                                                        <td><?= esc($book['sku_no']) ?></td>
                                                        <td><?= esc($book['book_title']) ?></td>
                                                        <td><?= esc($book['mrp']) ?></td>
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
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-warning fs-7">No books found for this author.</td>
                                                </tr>
                                            <?php endif; ?>
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