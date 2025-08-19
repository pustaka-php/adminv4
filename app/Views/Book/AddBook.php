<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<div class="layout-px-spacing">
    
    <div id="form-messages" class="mb-4"></div>
    
    <div class="row">
        <!-- Author Details Column -->
        <div class="col-lg-6 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Author Related Details</h6>
                </div>
                <div class="card-body p-24">
                    <div class="form-group mb-24">
                        <label for="author_id" class="form-label">Select Author</label>
                        <select name="author_id" id="author_id" class="form-select" required>
                            <?php if (isset($author_list)): ?>
                                <?php foreach($author_list as $author): ?>
                                    <option value="<?= esc($author->author_id) ?>" data-name="<?= esc($author->author_name) ?>">
                                        <?= esc($author->author_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label class="form-label mb-12">Exists in Agreement?</label>
                        <div class="d-flex align-items-center flex-wrap gap-28">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="1" name="agreement_flag" id="agreement_yes" required>
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="agreement_yes">Yes</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="0" name="agreement_flag" id="agreement_no" checked>
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="agreement_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label class="form-label mb-12">Enable Type</label>
                        <div class="d-flex align-items-center flex-wrap gap-28">
                            <div class="form-check checked-success d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Ebooks&Paperback" name="paperback_flag" id="paperback_both" checked>
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="paperback_both">Ebooks & Paperback</label>
                            </div>
                            <div class="form-check checked-success d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Ebooks" name="paperback_flag" id="paperback_ebook">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="paperback_ebook">Ebooks Only</label>
                            </div>
                            <div class="form-check checked-success d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Paperback" name="paperback_flag" id="paperback_print">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="paperback_print">Paperback Only</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label class="form-label mb-12">Content Type</label>
                        <div class="d-flex align-items-center flex-wrap gap-28">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Soft Copy" name="content_type" id="content_soft" checked>
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="content_soft">Soft Copy</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Hard Copy" name="content_type" id="content_hard">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="content_hard">Hard Copy</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-24" id="soft-copy-group">
                        <label class="form-label mb-12">Soft Copy Type</label>
                        <div class="d-flex align-items-center flex-wrap gap-28">
                            <div class="form-check checked-warning d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="PDF" name="soft_copy_type" id="pdf">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="pdf">PDF</label>
                            </div>
                            <div class="form-check checked-warning d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="InDesign" name="soft_copy_type" id="indesign">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="indesign">InDesign</label>
                            </div>
                            <div class="form-check checked-warning d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Word Document" name="soft_copy_type" id="word">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="word">Word Document</label>
                            </div>
                            <div class="form-check checked-warning d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Images" name="soft_copy_type" id="images">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="images">Images</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-24 d-none" id="hard-copy-group">
                        <label class="form-label mb-12">Hard Copy Type</label>
                        <div class="d-flex align-items-center flex-wrap gap-28">
                            <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Courier" name="hard_copy_type" id="courier">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="courier">Courier</label>
                            </div>
                            <div class="form-check checked-secondary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Handed Over" name="hard_copy_type" id="handedover">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="handedover">Handed Over</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="royalty" class="form-label">Royalty %</label>
                        <input type="number" class="form-control" name="lending_royalty" id="royalty" value="40" min="0" max="100" required>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label class="form-label mb-12">Type of Book:</label>
                        <div class="d-flex align-items-center flex-wrap gap-28">
                            <div class="form-check checked-info d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="type_of_book" value="1" id="type_ebook" checked>
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="type_ebook">Ebook</label>
                            </div>
                            <div class="form-check checked-info d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="type_of_book" value="2" id="type_emagazine">
                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="type_emagazine">Emagazine</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="desc_text" class="form-label">Description</label>
                        <textarea name="description" oninput="count_chars()" id="desc_text" rows="5" class="form-control" placeholder="Description Goes Here" required></textarea>
                        <div class="mt-2">
                            <span class="badge bg-info">
                                <small class="form-text">Characters: <span id="num_chars">0</span></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Book Details Column -->
        <div class="col-lg-6 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Book Related Details</h6>
                </div>
                <div class="card-body p-24">
                    <div class="form-group mb-24">
                        <label for="lang_id" class="form-label">Select Language</label>
                        <select name="lang_id" id="lang_id" class="form-select" required>
                            <?php if (isset($lang_details)): ?>
                                <?php foreach($lang_details as $lang): ?>
                                    <option value="<?= esc($lang->language_id) ?>" data-name="<?= esc($lang->language_name) ?>">
                                        <?= esc($lang->language_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="book_title" class="form-label">Title</label>
                        <input class="form-control" onInput="fill_url_title()" name="title" id="book_title" required>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="regional_title" class="form-label">Regional Title</label>
                        <input class="form-control" name="regional_book_title" id="regional_title">
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="url_title" class="form-label">URL Title</label>
                        <input class="form-control" name="url_book_title" id="url_title" readonly>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="genre_id" class="form-label">Select Genre</label>
                        <select class="form-select" name="genre_id" id="genre_id" required>
                            <?php if (isset($genre_details)): ?>
                                <?php foreach($genre_details as $genre): ?>
                                    <option value="<?= esc($genre->genre_id) ?>" data-name="<?= esc($genre->genre_name) ?>">
                                        <?= esc($genre->genre_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="book_category" class="form-label">Select Type</label>
                        <select class="form-select" onchange="fill_metadata();" name="book_category" id="book_category" required>
                            <option value="" selected disabled>-- Select Type --</option>
                            <option value="Novel">Novel</option>
                            <option value="Short Stories">Short Stories</option>
                            <option value="Essay">Essay</option>
                            <option value="Articles">Articles</option>
                            <option value="Poetry">Poetry</option>
                            <option value="Magazine">Magazine</option>
                            <option value="Drama">Drama</option>
                            <option value="Epic">Epic</option>
                            <option value="Play">Play</option>
                            <option value="Puranam">Puranam</option>
                            <option value="Sthothram">Sthothram</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" class="form-select" required>
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-24">
                        <label for="no_of_pages" class="form-label">Number Of Pages:</label>
                        <input type="number" id="no_of_pages" name="no_of_pages" class="form-control" min="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="dateAssigned" class="form-label">Date Assigned:</label>
                        <input type="date" id="dateAssigned" name="dateAssigned" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="button" onclick="add_book()" class="btn btn-primary btn-lg px-5 py-2 submit-btn">
            <span class="submit-text">Submit</span>
            <span class="spinner-border spinner-border-sm d-none" id="submit-spinner" role="status"></span>
        </button>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    // Content type toggle
    document.querySelectorAll('input[name="content_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if(this.value === 'Soft Copy') {
                document.getElementById('soft-copy-group').classList.remove('d-none');
                document.getElementById('hard-copy-group').classList.add('d-none');
                document.querySelectorAll('input[name="hard_copy_type"]').forEach(el => el.checked = false);
            } else {
                document.getElementById('hard-copy-group').classList.remove('d-none');
                document.getElementById('soft-copy-group').classList.add('d-none');
                document.querySelectorAll('input[name="soft_copy_type"]').forEach(el => el.checked = false);
            }
        });
    });

    // Character counter
    function count_chars() {
        const num_chars = document.getElementById('desc_text').value.length;
        document.getElementById('num_chars').textContent = num_chars;
    }
    
    // URL title generator
    function fill_url_title() {
        const title = document.getElementById('book_title').value;
        const formatted_title = title
            .replace(/[^a-z\d\s]+/gi, "")
            .split(' ')
            .join('-')
            .toLowerCase();
        document.getElementById('url_title').value = formatted_title;
    }
    
    // Form validation
    function validateForm() {
        let isValid = true;
        const title = document.getElementById('book_title').value.trim();
        
        if(!title) {
            showMessage('Book title is required', 'danger');
            isValid = false;
        }
        
        const contentType = document.querySelector('input[name="content_type"]:checked').value;
        if(contentType === 'Soft Copy' && !document.querySelector('input[name="soft_copy_type"]:checked')) {
            showMessage('Please select a soft copy type', 'danger');
            isValid = false;
        }
        
        if(contentType === 'Hard Copy' && !document.querySelector('input[name="hard_copy_type"]:checked')) {
            showMessage('Please select a hard copy type', 'danger');
            isValid = false;
        }
        
        return isValid;
    }
    
    // Show message
    function showMessage(message, type) {
        const messagesDiv = document.getElementById('form-messages');
        messagesDiv.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Remove after 5 seconds
        setTimeout(() => {
            const alert = messagesDiv.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
    
    // Submit form via AJAX
    function add_book() {
        if(!validateForm()) return;
        
        const btn = document.querySelector('.submit-btn');
        const spinner = document.getElementById('submit-spinner');
        const submitText = document.querySelector('.submit-text');
        
        btn.disabled = true;
        spinner.classList.remove('d-none');
        submitText.textContent = 'Processing...';
        
        // Get form data
        const formData = {
            author_id: document.getElementById('author_id').value,
            royalty: document.getElementById('royalty').value,
            description: document.getElementById('desc_text').value,
            lang_id: document.getElementById('lang_id').value,
            title: document.getElementById('book_title').value,
            regional_title: document.getElementById('regional_title').value,
            url_title: document.getElementById('url_title').value,
            book_category: document.getElementById('book_category').value,
            content_type: document.querySelector('input[name="content_type"]:checked').value,
            hard_copy_type: document.querySelector('input[name="hard_copy_type"]:checked')?.value || '',
            soft_copy_type: document.querySelector('input[name="soft_copy_type"]:checked')?.value || '',
            date_assigned: document.getElementById('dateAssigned').value,
            type_of_book: document.querySelector('input[name="type_of_book"]:checked').value,
            no_of_pages: document.getElementById('no_of_pages').value,
            genre_id: document.getElementById('genre_id').value,
            priority: document.getElementById('priority').value,
            agreement_flag: document.querySelector('input[name="agreement_flag"]:checked').value,
            paperback_flag: document.querySelector('input[name="paperback_flag"]:checked').value,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        };
        
        // AJAX call
        fetch('<?= site_url('adminv3/add_book_post') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showMessage('Book added successfully!', 'success');
                // Reset form
                document.getElementById('desc_text').value = '';
                document.getElementById('num_chars').textContent = '0';
                document.getElementById('book_title').value = '';
                document.getElementById('url_title').value = '';
            } else {
                showMessage(data.message || 'Error adding book', 'danger');
            }
        })
        .catch(error => {
            showMessage('Network error occurred. Please try again.', 'danger');
            console.error('Error:', error);
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            submitText.textContent = 'Submit';
        });
    }
</script>
<?= $this->endSection(); ?>