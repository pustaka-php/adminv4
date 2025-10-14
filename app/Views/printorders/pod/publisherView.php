<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="row mt-3">
    <!-- Publisher Card -->
    <div class="col-md-12">
        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
        <div class="card-header fs-5 fw-bold">
            Publisher Details
        </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= esc($publisher['publisher_name']) ?></p>
                <p><strong>Address:</strong> <?= esc($publisher['address']) ?></p>
                <p><strong>City:</strong> <?= esc($publisher['city']) ?></p>
                <p><strong>Contact Person:</strong> <?= esc($publisher['contact_person']) ?></p>
                <p><strong>Mobile:</strong> <?= esc($publisher['contact_mobile']) ?></p>
                <p><strong>Preferred Transport:</strong> <?= esc($publisher['preferred_transport']) ?></p>
            </div>
        </div>
    </div>
</div>

   <!-- Books Table -->
<div class="col-md-12">
    <div class="card shadow-sm mb-3">
        <div class="card-header fs-5 fw-bold">
            Books of <?= esc($publisher['publisher_name']) ?>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover zero-config">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Total Pages</th>
                        <th>Copies</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($books)): ?>
                        <?php foreach($books as $i => $b): ?>
                            <tr class="align-middle border-bottom border-light">
                                <td class="text-center"><?= $i+1 ?></td>
                                <td><?= esc($b['book_title']) ?></td>
                                <td><?= esc($b['total_num_pages']) ?></td>
                                <td><?= esc($b['num_copies']) ?></td>
                                <td><?= date('d M Y', strtotime($b['order_date'])) ?></td>
                                <td class="text-center">
                                    <?php if($b['delivery_flag']): ?>
                                        <span class="badge bg-success">Delivered</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">In Process</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('pod/bookview/'.$b['book_id']) ?>" 
                                       class="btn btn-sm btn-primary rounded-pill px-3 py-1"
                                       title="View Book Details" target="_blank">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No books found for this publisher.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?= $this->endSection(); ?>
