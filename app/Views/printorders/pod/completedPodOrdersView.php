<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="layout-px-spacing">
    <div class="table-responsive">
        <center><h6 class="mb-4 mt-2 fw-semibold">POD Completed Order List</h6></center>

        <table class="table table-bordered mb-4 zero-config text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Publisher</th>
                    <th>Title</th>
                    <th>Cover</th>
                    <th>Content</th>
                    <th>Full Details</th>
                    <th>Delivered Date</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($pending_books['completed_orders'])): ?>
                    <?php foreach ($pending_books['completed_orders'] as $publisher_pending_book): ?>
                        <?php
                            $del_date = !empty($publisher_pending_book['actual_delivery_date'])
                                ? date_create($publisher_pending_book['actual_delivery_date'])
                                : null;

                            $pages  = $publisher_pending_book['total_num_pages'] . " pgs / " . $publisher_pending_book['num_copies'] . " cps";
                            $specs  = $publisher_pending_book['book_size'] . " / " . $publisher_pending_book['cover_gsm'] . " / " . $publisher_pending_book['lamination_type'];
                            $specs1 = $publisher_pending_book['content_paper'] . " / " . $publisher_pending_book['content_gsm'];
                        ?>
                        <tr>
                            <td><?= esc($publisher_pending_book['publisher_name']); ?></td>

                            <td>
                                <?= esc($publisher_pending_book['book_title']); ?>
                                <p class="text-danger mb-0"><?= esc($pages); ?></p>
                            </td>

                            <td><?= esc($specs); ?></td>
                            <td><?= esc($specs1); ?></td>
                            
                            <td>
                                <a href="<?= base_url('pod/bookview/'.$publisher_pending_book['book_id']) ?>" 
                                   class="btn btn-sm btn-info">
                                   View
                                </a>
                            </td>
                            <!-- <td>
                                <a href="<?= base_url('pod/pod_publisher_completed_view/' . $publisher_pending_book['book_id']); ?>" 
                                   class="btn btn-sm btn-info">
                                   View
                                </a>
                            </td> -->

                            <td>
                                <?= $del_date ? date_format($del_date, "d-m-y") : '-'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted">No completed orders found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
