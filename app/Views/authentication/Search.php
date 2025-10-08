<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        
        <!-- Search Header -->
        <div class="page-header">
            <div class="page-title">
                <h6>Search results for "<?= esc($result_books['keyword']) ?>"</h6>
            </div>
        </div><br>

        <!-- Books Section -->
        <div class="mt-4 widget-content widget-content-area br-6">
           <div class="layout-px-spacing mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="mb-0 text-center fs-5">
                <?= esc($result_books['num_records_found']) ?> Book(s) found for 
                "<strong><?= esc($result_books['keyword']) ?></strong>"
            </h6>
        </div>
    </div>
</div>

            
            <?php if ($result_books['num_records_found'] > 0): ?>
                <div class="table-responsive">
                    <table class="zero-config table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="width: 35%;">Title</th>
                                <th>Author</th>
                                <th>Resource</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result_books['search_results'] as $book): ?>
                                <tr>
                                    <td><?= $book['book_id'] ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <!-- Book Title -->
                                            <a target="_blank" 
                                               href="<?= config('Custom')->pustaka_url . 'home/ebook/' . $book['language_name'] . substr(substr($book['download_link'], 0, -1), strripos(substr($book['download_link'], 0, -1), "/")) ?>" 
                                               class="font-weight-bold mb-1">
                                                <?= esc($book['book_title']) ?>
                                                <?php if (!empty($book['book_subtitle'])): ?>
                                                    - <?= esc($book['book_subtitle']) ?>
                                                <?php endif; ?>
                                            </a>
                                            
                                            <!-- External Links -->
                                            <div class="d-flex align-items-center mt-1">
                                                <!-- Amazon -->
                                                <?php if (!empty($book['asin'])): ?>
                                                    <a href="https://amazon.in/dp/<?= esc($book['asin']) ?>" class="mr-2" target="_blank">
                                                        <svg aria-hidden="true" width="18" height="18" focusable="false" data-prefix="fab" data-icon="amazon" class="svg-inline--fa fa-amazon fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M257.2 162.7c-48.7 1.8-169.5 15.5-169.5 117.5 0 109.5 138.3 114 183.5 43.2 6.5 10.2 35.4 37.5 45.3 46.8l56.8-56S341 288.9 341 261.4V114.3C341 89 316.5 32 228.7 32 140.7 32 94 87 94 136.3l73.5 6.8c16.3-49.5 54.2-49.5 54.2-49.5 40.7-.1 35.5 29.8 35.5 69.1zm0 86.8c0 80-84.2 68-84.2 17.2 0-47.2 50.5-56.7 84.2-57.8v40.6zm136 163.5c-7.7 10-70 67-174.5 67S34.2 408.5 9.7 379c-6.8-7.7 1-11.3 5.5-8.3C88.5 415.2 203 488.5 387.7 401c7.5-3.7 13.3 2 5.5 12zm39.8 2.2c-6.5 15.8-16 26.8-21.2 31-5.5 4.5-9.5 2.7-6.5-3.8s19.3-46.5 12.7-55c-6.5-8.3-37-4.3-48-3.2-10.8 1-13 2-14-.3-2.3-5.7 21.7-15.5 37.5-17.5 15.7-1.8 41-.8 46 5.7 3.7 5.1 0 27.1-6.5 43.1z"></path></svg>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="mr-2">
                                                        <a><svg aria-hidden="true" width="18" height="18" focusable="false" data-prefix="fab" data-icon="amazon" class="svg-inline--fa fa-amazon fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#b3b3b3" d="M257.2 162.7c-48.7 1.8-169.5 15.5-169.5 117.5 0 109.5 138.3 114 183.5 43.2 6.5 10.2 35.4 37.5 45.3 46.8l56.8-56S341 288.9 341 261.4V114.3C341 89 316.5 32 228.7 32 140.7 32 94 87 94 136.3l73.5 6.8c16.3-49.5 54.2-49.5 54.2-49.5 40.7-.1 35.5 29.8 35.5 69.1zm0 86.8c0 80-84.2 68-84.2 17.2 0-47.2 50.5-56.7 84.2-57.8v40.6zm136 163.5c-7.7 10-70 67-174.5 67S34.2 408.5 9.7 379c-6.8-7.7 1-11.3 5.5-8.3C88.5 415.2 203 488.5 387.7 401c7.5-3.7 13.3 2 5.5 12zm39.8 2.2c-6.5 15.8-16 26.8-21.2 31-5.5 4.5-9.5 2.7-6.5-3.8s19.3-46.5 12.7-55c-6.5-8.3-37-4.3-48-3.2-10.8 1-13 2-14-.3-2.3-5.7 21.7-15.5 37.5-17.5 15.7-1.8 41-.8 46 5.7 3.7 5.1 0 27.1-6.5 43.1z"></path></svg></a>
                                                    </span>
                                                <?php endif; ?>

                                                <!-- Scribd -->
                                                <?php if (!empty($book['doc_id'])): ?>
                                                    <a href="https://scribd.com/book/<?= esc($book['doc_id']) ?>" class="mr-2" target="_blank">
                                                        <svg aria-hidden="true" width="18" height="18" focusable="false" data-prefix="fab" data-icon="scribd" class="svg-inline--fa fa-scribd fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M42.3 252.7c-16.1-19-24.7-45.9-24.8-79.9 0-100.4 75.2-153.1 167.2-153.1 98.6-1.6 156.8 49 184.3 70.6l-50.5 72.1-37.3-24.6 26.9-38.6c-36.5-24-79.4-36.5-123-35.8-50.7-.8-111.7 27.2-111.7 76.2 0 18.7 11.2 20.7 28.6 15.6 23.3-5.3 41.9.6 55.8 14 26.4 24.3 23.2 67.6-.7 91.9-29.2 29.5-85.2 27.3-114.8-8.4zm317.7 5.9c-15.5-18.8-38.9-29.4-63.2-28.6-38.1-2-71.1 28-70.5 67.2-.7 16.8 6 33 18.4 44.3 14.1 13.9 33 19.7 56.3 14.4 17.4-5.1 28.6-3.1 28.6 15.6 0 4.3-.5 8.5-1.4 12.7-16.7 40.9-59.5 64.4-121.4 64.4-51.9.2-102.4-16.4-144.1-47.3l33.7-39.4-35.6-27.4L0 406.3l15.4 13.8c52.5 46.8 120.4 72.5 190.7 72.2 51.4 0 94.4-10.5 133.6-44.1 57.1-51.4 54.2-149.2 20.3-189.6z"></path></svg>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="mr-2">
                                                        <svg aria-hidden="true" width="18" height="18" focusable="false" data-prefix="fab" data-icon="scribd" class="svg-inline--fa fa-scribd fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="#b3b3b3" d="M42.3 252.7c-16.1-19-24.7-45.9-24.8-79.9 0-100.4 75.2-153.1 167.2-153.1 98.6-1.6 156.8 49 184.3 70.6l-50.5 72.1-37.3-24.6 26.9-38.6c-36.5-24-79.4-36.5-123-35.8-50.7-.8-111.7 27.2-111.7 76.2 0 18.7 11.2 20.7 28.6 15.6 23.3-5.3 41.9.6 55.8 14 26.4 24.3 23.2 67.6-.7 91.9-29.2 29.5-85.2 27.3-114.8-8.4zm317.7 5.9c-15.5-18.8-38.9-29.4-63.2-28.6-38.1-2-71.1 28-70.5 67.2-.7 16.8 6 33 18.4 44.3 14.1 13.9 33 19.7 56.3 14.4 17.4-5.1 28.6-3.1 28.6 15.6 0 4.3-.5 8.5-1.4 12.7-16.7 40.9-59.5 64.4-121.4 64.4-51.9.2-102.4-16.4-144.1-47.3l33.7-39.4-35.6-27.4L0 406.3l15.4 13.8c52.5 46.8 120.4 72.5 190.7 72.2 51.4 0 94.4-10.5 133.6-44.1 57.1-51.4 54.2-149.2 20.3-189.6z"></path></svg>
                                                    </span>
                                                <?php endif; ?>

                                                <!-- Play Store -->
                                                <?php if (!empty($book['play_store_link'])): ?>
                                                    <a href="<?= esc($book['play_store_link']) ?>" class="mr-2" target="_blank">
                                                        <svg aria-hidden="true" width="16" height="16" focusable="false" data-prefix="fab" data-icon="google-play" class="svg-inline--fa fa-google-play fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path></svg>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="mr-2">
                                                        <svg aria-hidden="true" width="18" height="18" focusable="false" data-prefix="fab" data-icon="google-play" class="svg-inline--fa fa-google-play fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#F0F0F0" d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"></path></svg>
                                                    </span>
                                                <?php endif; ?>

                                                <!-- Overdrive -->
                                                <?php if (!empty($book['sample_link'])): ?>
                                                    <a href="<?= esc($book['sample_link']) ?>" target="_blank">
                                                        <img width="40" height="25" src="<?= base_url('assets/images/overdrive-logo-sm-black.png') ?>" alt="Overdrive">
                                                    </a>
                                                <?php else: ?>
                                                    <span>
                                                        <img width="45" height="30" src="<?= base_url('assets/images/overdrive-logo-sm-black.png') ?>" alt="Overdrive">
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($book['author_name']) ?></td>
                                    <td><?= esc($book['resource']) ?></td>
                                    <td><?= $book['date_activated'] ?? '--' ?></td>
                                    <td>
                                        <ul class="table-controls">
                                            <li>
                                                <a class="rounded text-danger bs-tooltip" title="Edit Book" target="_blank" href="<?= base_url('book/editbook/' . $book['book_id']) ?>">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="edit" class="svg-inline--fa fa-edit fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18" height="18">
                                                        <path fill="#2196f3" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                            <!-- <li>
                                                <a href="<?= base_url('adminv3/in_progress_rework_book/' . $book['book_id']) ?>" class="rounded text-danger bs-tooltip" title="Re-Work">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tools" class="svg-inline--fa fa-tools fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16">
                                                        <path fill="#e2a03f" d="M501.1 395.7L384 278.6c-23.1-23.1-57.6-27.6-85.4-13.9L192 158.1V96L64 0 0 64l96 128h62.1l106.6 106.6c-13.6 27.8-9.2 62.3 13.9 85.4l117.1 117.1c14.6 14.6 38.2 14.6 52.7 0l52.7-52.7c14.5-14.6 14.5-38.2 0-52.7zM331.7 225c28.3 0 54.9 11 74.9 31l19.4 19.4c15.8-6.9 30.8-16.5 43.8-29.5 37.1-37.1 49.7-89.3 37.9-136.7-2.2-9-13.5-12.1-20.1-5.5l-74.4 74.4-67.9-11.3L334 98.9l74.4-74.4c6.6-6.6 3.4-17.9-5.7-20.2-47.4-11.7-99.6.9-136.6 37.9-28.5 28.5-41.9 66.1-41.2 103.6l82.1 82.1c8.1-1.9 16.5-2.9 24.7-2.9zm-103.9 82l-56.7-56.7L18.7 402.8c-25 25-25 65.5 0 90.5s65.5 25 90.5 0l123.6-123.6c-7.6-19.9-9.9-41.6-5-62.7zM64 472c-13.2 0-24-10.8-24-24 0-13.3 10.7-24 24-24s24 10.7 24 24c0 13.2-10.7 24-24 24z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('adminv3/initiate_pod_book/' . $book['book_id']) ?>" class="rounded text-danger bs-tooltip" title="Initiate POD">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16">
                                                        <path d="M448 192H64C28.65 192 0 220.7 0 256v96c0 17.67 14.33 32 32 32h32v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h32c17.67 0 32-14.33 32-32V256C512 220.7 483.3 192 448 192zM384 448H128v-96h256V448zM432 296c-13.25 0-24-10.75-24-24c0-13.27 10.75-24 24-24s24 10.73 24 24C456 285.3 445.3 296 432 296zM128 64h229.5L384 90.51V160h64V77.25c0-8.484-3.375-16.62-9.375-22.62l-45.25-45.25C387.4 3.375 379.2 0 370.8 0H96C78.34 0 64 14.33 64 32v128h64V64z"/>
                                                    </svg>
                                                </a>
                                            </li> -->
                                            <li>
                                                <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)" class="rounded text-danger bs-tooltip" title="Add to Test">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                                        <path fill="#e7515a" d="M20.759 20.498c-2.342-3.663-5.575-6.958-5.743-11.498h-2.016c.173 5.212 3.512 8.539 5.953 12.356.143.302-.068.644-.377.644h-1.264l-4.734-7h-3.52c.873-1.665 1.85-3.414 1.936-6h-2.01c-.169 4.543-3.421 7.864-5.743 11.498-.165.347-.241.707-.241 1.057 0 1.283 1.023 2.445 2.423 2.445h13.153c1.4 0 2.424-1.162 2.424-2.446 0-.35-.076-.709-.241-1.056zm-4.759-15.498c0 1.105-.896 2-2 2s-2-.895-2-2 .896-2 2-2 2 .895 2 2zm-5-1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5.672-1.5 1.5-1.5 1.5.671 1.5 1.5zm0 3.5c0 .552-.447 1-1 1s-1-.448-1-1 .447-1 1-1 1 .448 1 1zm3-6c0 .552-.447 1-1 1s-1-.448-1-1 .447-1 1-1 1 .448 1 1z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <h4 class="text-muted fs-5">No matching books found</h4>
                </div>
            <?php endif; ?>
        </div>

        <!-- Authors Section -->
        <div class="mt-4 widget-content widget-content-area br-6">
            <div class="layout-px-spacing mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="mb-0 text-center fs-5">
                <?= esc($result_authors['num_records_found']) ?> Author(s) found for 
                "<strong><?= esc($result_authors['keyword']) ?></strong>"
            </h6>
        </div>
    </div>
</div>

            
            <?php if ($result_authors['num_records_found'] > 0): ?>
                <div class="table-responsive">
                    <table class="zero-config table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>User ID</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result_authors['search_results'] as $author): ?>
                                <tr>
                                    <td><?= $author['author_id'] ?></td>
                                    <td>
                                        <a target="_blank" href="<?= config('Custom')->pustaka_url . 'home/author/' . $author['url_name'] ?>" class="text-dark font-weight-bold">
                                            <?= esc($author['author_name']) ?>
                                        </a>
                                    </td>
                                    <td><?= $author['user_id'] ?></td>
                                    <td><?= $author['created_at'] ?></td>
                                    <td>
                                        <ul class="table-controls">
                                            <li>
                                                <a target="_blank" class="rounded text-danger bs-tooltip" title="Edit Author Links" href="<?= base_url('adminv3/edit_author_links/' . $author['author_id']) ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                                        <path fill="#5c1ac3" d="M6.188 8.719c.439-.439.926-.801 1.444-1.087 2.887-1.591 6.589-.745 8.445 2.069l-2.246 2.245c-.644-1.469-2.243-2.305-3.834-1.949-.599.134-1.168.433-1.633.898l-4.304 4.306c-1.307 1.307-1.307 3.433 0 4.74 1.307 1.307 3.433 1.307 4.74 0l1.327-1.327c1.207.479 2.501.67 3.779.575l-2.929 2.929c-2.511 2.511-6.582 2.511-9.093 0s-2.511-6.582 0-9.093l4.304-4.306zm6.836-6.836l-2.929 2.929c1.277-.096 2.572.096 3.779.574l1.326-1.326c1.307-1.307 3.433-1.307 4.74 0 1.307 1.307 1.307 3.433 0 4.74l-4.305 4.305c-1.311 1.311-3.44 1.3-4.74 0-.303-.303-.564-.68-.727-1.051l-2.246 2.245c.236.358.481.667.796.982.812.812 1.846 1.417 3.036 1.704 1.542.371 3.194.166 4.613-.617.518-.286 1.005-.648 1.444-1.087l4.304-4.305c2.512-2.511 2.512-6.582.001-9.093-2.511-2.51-6.581-2.51-9.092 0z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a target="_blank" class="rounded text-danger bs-tooltip" title="Edit Author" href="<?= base_url('author/edit_author/' . $author['author_id']) ?>">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="edit" class="svg-inline--fa fa-edit fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
                                                        <path fill="#2196f3" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a target="_blank" class="rounded text-danger bs-tooltip" title="View Details" href="<?= base_url('author/author_details/' . $author['author_id']) ?>">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="newspaper" class="svg-inline--fa fa-newspaper fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16">
                                                        <path fill="#e2a03f" d="M552 64H112c-20.858 0-38.643 13.377-45.248 32H24c-13.255 0-24 10.745-24 24v272c0 30.928 25.072 56 56 56h496c13.255 0 24-10.745 24-24V88c0-13.255-10.745-24-24-24zM48 392V144h16v248c0 4.411-3.589 8-8 8s-8-3.589-8-8zm480 8H111.422c.374-2.614.578-5.283.578-8V112h416v288zM172 280h136c6.627 0 12-5.373 12-12v-96c0-6.627-5.373-12-12-12H172c-6.627 0-12 5.373-12 12v96c0 6.627 5.373 12 12 12zm28-80h80v40h-80v-40zm-40 140v-24c0-6.627 5.373-12 12-12h136c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H172c-6.627 0-12-5.373-12-12zm192 0v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0-144v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12zm0 72v-24c0-6.627 5.373-12 12-12h104c6.627 0 12 5.373 12 12v24c0 6.627-5.373 12-12 12H364c-6.627 0-12-5.373-12-12z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="layout-px-spacing mb-4">
    <div class="card shadow-sm">
        <div class="card-body text-center py-4">
            <h6 class="text-muted mb-0 fs-5">No matching authors found</h6>
        </div>
    </div>
</div>

            <?php endif; ?>
        </div>

    </div>
</div>

<script>
    var base_url = "<?= base_url() ?>";

    function add_to_test(book_id) {
        var user_id = prompt("Enter User Id:");
        if (user_id) {
            $.ajax({
                url: base_url + 'book/addtotest',
                type: 'POST',
                data: {
                    "book_id": book_id,
                    "user_id": user_id
                },
                success: function(data) {
                    if (data == 1) {
                        alert("Added to test successfully");
                    } else {
                        alert("Failed to add to test");
                    }
                },
                error: function() {
                    alert("An error occurred. Please try again.");
                }
            });
        }
    }
</script>

<?= $this->endSection(); ?>