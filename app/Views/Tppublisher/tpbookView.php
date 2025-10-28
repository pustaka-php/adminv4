<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-xxl-12">
        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                <h6 class="text-lg mb-0">Author-Publisher-Book Details</h6>
            </div>
            <div class="card-body p-24 pt-10">
                <!-- Tabs -->
                <ul class="nav bordered-tab border border-top-0 border-start-0 border-end-0 d-inline-flex nav-pills mb-16" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10 active" id="pills-author-tab" data-bs-toggle="pill" data-bs-target="#pills-author" type="button" role="tab">Author</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-publisher-tab" data-bs-toggle="pill" data-bs-target="#pills-publisher" type="button" role="tab">Publisher</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-16 py-10" id="pills-books-tab" data-bs-toggle="pill" data-bs-target="#pills-books" type="button" role="tab">Books</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <!-- Author Tab -->
                    <div class="tab-pane fade show active" id="pills-author" role="tabpanel">
                        <div class="row">
                            <?php if (!empty($authors_data)) : ?>
                                <?php foreach ($authors_data as $author_data) : ?>
                                    <div class="col-md-12 mb-4">
                                        <div class="card shadow-none border bg-gradient-start-1">
                                            <div class="card-header bg-base py-3 px-4">
                                                <h6 class="fs-5 fw-semibold mb-0">Author Information</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <?php if ($author_data['author_image']) : ?>
                                                            <img src="<?= base_url('uploads/authors/' . esc($author_data['author_image'])) ?>" 
                                                                 class="img-thumbnail" style="max-width: 200px;">
                                                        <?php else : ?>
                                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 200px; height: 200px;">
                                                                No Image
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="mb-2"><strong>Name:</strong> <?= esc($author_data['author_name']) ?></li>
                                                            <li class="mb-2"><strong>ID:</strong> <?= esc($author_data['author_id']) ?></li>
                                                            <li class="mb-2"><strong>Mobile:</strong> <?= esc($author_data['mobile']) ?></li>
                                                            <li class="mb-2"><strong>Email:</strong> <?= esc($author_data['email_id']) ?></li>
                                                            <li class="mb-2"><strong>Description:</strong> <?= esc($author_data['author_discription']) ?></li>
                                                            <li class="mb-2">
                                                                <strong>Status:</strong>
                                                                <span class="badge bg-<?= $author_data['status'] == 1 ? 'success' : ($author_data['status'] == 0 ? 'danger' : 'warning') ?>">
                                                                    <?= $author_data['status'] == 1 ? 'Active' : ($author_data['status'] == 0 ? 'Inactive' : 'Pending') ?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-warning">No authors found.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Publisher Tab -->
                    <div class="tab-pane fade" id="pills-publisher" role="tabpanel">
                        <div class="row">
                            <?php if (!empty($publishers_data)) : ?>
                                <?php foreach ($publishers_data as $publisher) : ?>
                                    <div class="col-md-12 mb-4">
                                        <div class="card shadow-none border bg-gradient-start-2">
                                            <div class="card-header bg-base py-3 px-4">
                                                <h6 class="fs-5 fw-semibold mb-0">Publisher Information</h6>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-2"><strong>Name:</strong> <?= esc($publisher['publisher_name']) ?></li>
                                                    <li class="mb-2"><strong>ID:</strong> <?= esc($publisher['publisher_id']) ?></li>
                                                    <li class="mb-2"><strong>Contact Person:</strong> <?= esc($publisher['contact_person']) ?></li>
                                                    <li class="mb-2"><strong>Address:</strong> <?= esc($publisher['address']) ?></li>
                                                    <li class="mb-2"><strong>Mobile:</strong> <?= esc($publisher['mobile']) ?></li>
                                                    <li class="mb-2"><strong>Email:</strong> <?= esc($publisher['email_id']) ?></li>
                                                    <li class="mb-2">
                                                        <strong>Status:</strong>
                                                        <span class="badge bg-<?= $publisher['status'] == 1 ? 'success' : ($publisher['status'] == 0 ? 'danger' : 'warning') ?>">
                                                            <?= $publisher['status'] == 1 ? 'Active' : ($publisher['status'] == 0 ? 'Inactive' : 'Pending') ?>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="col-12">
                                    <p class="text-warning">No publishers found.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Books Tab -->
                    <div class="tab-pane fade" id="pills-books" role="tabpanel">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card shadow-none border">
                                    <div class="card-header bg-base py-3 px-4">
                                        <h6 class="fs-5 fw-semibold mb-0">Book Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($books_data)) : ?>
                                            <div class="row">
                                                <?php foreach ($books_data as $book) : ?>
                                                    <div class="col-md-12 mb-4">
                                                        <div class="card shadow-none border bg-gradient-start-3">
                                                            <div class="card-body">
                                                                <h6 class="card-title"><?= esc($book['book_title']) ?></h6>
                                                                <ul class="list-unstyled mb-0">
                                                                    <li class="mb-2"><strong>Book ID:</strong> <?= esc($book['book_id']) ?></li>
                                                                    <li class="mb-2"><strong>Author Name:</strong> <?= esc($book['author_name']) ?></li>
                                                                    <li class="mb-2"><strong>SKU:</strong> <?= esc($book['sku_no']) ?></li>
                                                                    <li class="mb-2"><strong>Regional Title:</strong> <?= esc($book['book_regional_title']) ?></li>
                                                                    <li class="mb-2"><strong>MRP:</strong> <?= esc($book['mrp']) ?></li>
                                                                    <li class="mb-2"><strong>ISBN:</strong> <?= esc($book['isbn']) ?></li>
                                                                    <li class="mb-2"><strong>Stock In Hand:</strong><?= esc($book['stock_in_hand']) ?></li>
                                                                    <li class="mb-2"><strong>Stock Out:</strong> <?= esc($book['stock_out']) ?></li>
                                                                    <li class="mb-2">
                                                                        <strong>Status:</strong>
                                                                        <span class="badge bg-<?= $book['status'] == 1 ? 'success' : ($book['status'] == 0 ? 'danger' : 'warning') ?>">
                                                                            <?= $book['status'] == 1 ? 'Active' : ($book['status'] == 0 ? 'Inactive' : 'Pending') ?>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <p class="text-warning">No books found for this author.</p>
                                        <?php endif; ?>
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

<?= $this->endSection(); ?>
