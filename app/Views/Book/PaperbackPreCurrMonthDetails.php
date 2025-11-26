<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <!-- Tabs for Previous & Current Month -->
    <ul class="nav nav-tabs" id="monthTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="curr-tab" data-bs-toggle="tab" data-bs-target="#currMonth" type="button" role="tab">
                Current Month (<?= count($dashboard_curr_month_books) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="prev-tab" data-bs-toggle="tab" data-bs-target="#prevMonth" type="button" role="tab">
                Previous Month (<?= count($dashboard_prev_month_books) ?>)
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="monthTabsContent">
        <!-- Current Month -->
        <div class="tab-pane fade show active" id="currMonth" role="tabpanel">
            <div class="row">
                <!-- Author Count -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Authors</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover zero-config">
                                <thead>
                                    <tr>
                                        <th>Author Id</th>
                                        <th>Author</th>
                                        <th>Books Published</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dashboard_curr_month_data as $author): ?>
                                    <tr>
                                        <td><?= esc($author['author_id']) ?></td>
                                        <td><?= esc($author['author_name']) ?></td>
                                        <td>
                                            <div class="progress position-relative" style="height: 20px;">
                                                <div class="progress-bar bg-primary" style="width: <?= min($author['auth_book_cnt']*10,100) ?>%">
                                                    <?= esc($author['auth_book_cnt']) ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Book Details -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Books</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover zero-config">
                                <thead>
                                    <tr>
                                        <th>Book Id</th>
                                        <th>Title</th>
                                        <th>Total Pages</th>
                                        <th>Author</th>
                                        <th>Activated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dashboard_curr_month_books as $book): ?>
                                    <tr>
                                        <td><?= esc($book['book_id']) ?></td>
                                        <td>
                                            <a href="<?= base_url('home/ebook/'.strtolower($book['language']).'/'.$book['url_name']) ?>" target="_blank">
                                                <?= esc($book['book_title']) ?>
                                            </a>
                                        </td>
                                        <td><?= esc($book['author_name']) ?></td>
                                        <td><?= esc($book['paper_back_inr']) ?></td>
                                        <td title="<?= esc($book['paperback_activate_at']) ?>"><?= date('d-m-y', strtotime($book['paperback_activate_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Previous Month -->
        <div class="tab-pane fade" id="prevMonth" role="tabpanel">
            <div class="row">
                <!-- Author Count -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Authors</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover zero-config">
                                <thead>
                                    <tr>
                                        <th>Author Id</th>
                                        <th>Author</th>
                                        <th>Books Published</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dashboard_prev_month_data as $author): ?>
                                    <tr>
                                        <td><?= esc($author['author_id']) ?></td>
                                        <td><?= esc($author['author_name']) ?></td>
                                        <td>
                                            <div class="progress position-relative" style="height: 20px;">
                                                <div class="progress-bar bg-success" style="width: <?= min($author['auth_book_cnt']*10,100) ?>%">
                                                    <?= esc($author['auth_book_cnt']) ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Book Details -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Books</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover zero-config">
                                <thead>
                                    <tr>
                                        <th>Book Id</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Total Pages</th>
                                        <th>Activated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dashboard_prev_month_books as $book): ?>
                                    <tr>
                                        <td><?= esc($book['book_id']) ?></td>
                                        <td>
                                            <a href="<?= base_url('home/ebook/'.strtolower($book['language']).'/'.$book['url_name']) ?>" target="_blank">
                                                <?= esc($book['book_title']) ?>
                                            </a>
                                        </td>
                                        <td><?= esc($book['author_name']) ?></td>
                                        <td><?= esc($book['paper_back_inr']) ?></td>
                                        <td title="<?= esc($book['paperback_activate_at']) ?>"><?= date('d-m-y', strtotime($book['paperback_activate_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
