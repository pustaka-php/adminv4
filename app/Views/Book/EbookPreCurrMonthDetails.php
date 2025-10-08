<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <!-- Tabs for Previous & Current Month -->
    <ul class="nav nav-tabs" id="monthTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="prev-tab" data-bs-toggle="tab" data-bs-target="#prevMonth" type="button" role="tab">
                Previous Month
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="curr-tab" data-bs-toggle="tab" data-bs-target="#currMonth" type="button" role="tab">
                Current Month
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="monthTabsContent">
        <!-- Previous Month -->
        <div class="tab-pane fade show active" id="prevMonth" role="tabpanel">
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
                                        <th>ID</th>
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
                                    </div><br>

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
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Language</th>
                                        <th>Author</th>
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
                                        <td><?= esc($book['language']) ?></td>
                                        <td><?= esc($book['author_name']) ?></td>
                                        <td title="<?= esc($book['activated_at']) ?>"><?= date('d M Y', strtotime($book['activated_at'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Month -->
        <div class="tab-pane fade" id="currMonth" role="tabpanel">
            <div class="row">
                <!-- Author Count -->
                <div class="col-md-12">
                    <div class="card mb-4 ">
                        <div class="card-header">
                            <h6 class="mb-0">Authors</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover zero-config">
                                <thead>
                                    <tr>
                                        <th>ID</th>
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
                                    </div><br>

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
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Language</th>
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
                                        <td><?= esc($book['language']) ?></td>
                                        <td><?= esc($book['author_name']) ?></td>
                                        <td title="<?= esc($book['activated_at']) ?>"><?= date('d M Y', strtotime($book['activated_at'])) ?></td>
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
