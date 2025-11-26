<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<div class="layout-px-spacing">
    <div class="row gy-4">
        <!-- Author Details Column -->
        <div class="col-lg-6 col-12">
            <div class="card mb-4 h-80">
                <div class="card-header">
                    <h6 class="mb-0">Author Related Details</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
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
                    
                    <div class="form-group mb-3">
                        <label class="form-label mb-2">Exists in Agreement?</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="1" name="agreement_flag" id="agreement_yes" required>
                                <label class="form-check-label" for="agreement_yes">Yes</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="0" name="agreement_flag" id="agreement_no" checked>
                                <label class="form-check-label" for="agreement_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label mb-2">Enable Type</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Ebooks&Paperback" name="paperback_flag" id="paperback_both" checked>
                                <label class="form-check-label" for="paperback_both">Ebooks & Paperback</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Ebooks" name="paperback_flag" id="paperback_ebook">
                                <label class="form-check-label" for="paperback_ebook">Ebooks Only</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Paperback" name="paperback_flag" id="paperback_print">
                                <label class="form-check-label" for="paperback_print">Paperback Only</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label mb-2">Content Type</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Soft Copy" name="content_type" id="content_soft" checked>
                                <label class="form-check-label" for="content_soft">Soft Copy</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Hard Copy" name="content_type" id="content_hard">
                                <label class="form-check-label" for="content_hard">Hard Copy</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3" id="soft-copy-group">
                        <label class="form-label mb-2">Soft Copy Type</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="PDF" name="soft_copy_type" id="pdf">
                                <label class="form-check-label" for="pdf">PDF</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="InDesign" name="soft_copy_type" id="indesign">
                                <label class="form-check-label" for="indesign">InDesign</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Word Document" name="soft_copy_type" id="word">
                                <label class="form-check-label" for="word">Word Document</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Images" name="soft_copy_type" id="images">
                                <label class="form-check-label" for="images">Images</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3 d-none" id="hard-copy-group">
                        <label class="form-label mb-2">Hard Copy Type</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Courier" name="hard_copy_type" id="courier">
                                <label class="form-check-label" for="courier">Courier</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" value="Handed Over" name="hard_copy_type" id="handedover">
                                <label class="form-check-label" for="handedover">Handed Over</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="royalty" class="form-label">Royalty %</label>
                        <input type="number" class="form-control" name="lending_royalty" id="royalty" value="40" min="0" max="100" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label mb-2">Type of Book:</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="type_of_book" value="1" id="type_ebook" checked>
                                <label class="form-check-label" for="type_ebook">Ebook</label>
                            </div>
                            <div class="form-check checked-primary d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="type_of_book" value="2" id="type_emagazine">
                                <label class="form-check-label" for="type_emagazine">Emagazine</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="desc_text" class="form-label">Description</label>
                        <textarea name="description" oninput="count_chars()" id="desc_text" rows="4" class="form-control" placeholder="Description Goes Here" required></textarea>
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
            <div class="card mb-4 h-80">
                <div class="card-header">
                    <h6 class="mb-0">Book Related Details</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
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
                    
                    <div class="form-group mb-3">
                        <label for="book_title" class="form-label">Title</label>
                        <input class="form-control" onInput="fill_url_title()" name="title" id="book_title" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="regional_title" class="form-label">Regional Title</label>
                        <input class="form-control" name="regional_book_title" id="regional_title">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="url_title" class="form-label">URL Title</label>
                        <input class="form-control" name="url_book_title" id="url_title">
                    </div>
                    
                    <div class="form-group mb-3">
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
                    
                    <div class="form-group mb-3">
                        <label for="book_category" class="form-label">Select Type</label>
                        <select class="form-select" name="book_category" id="book_category" required>
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
                    
                    <div class="form-group mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" class="form-select" required>
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="no_of_pages" class="form-label">Number Of Pages</label>
                        <input type="number" id="no_of_pages" name="no_of_pages" class="form-control" min="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="dateAssigned" class="form-label">Date Assigned</label>
                        <input type="date" id="dateAssigned" name="dateAssigned" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <button type="button" onclick="add_book()" class="btn btn-primary btn-lg">Submit</button>
       <a href="<?= base_url('book/getebooksstatus'); ?>" class="btn btn-danger btn-lg">cancel</a>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
    // Initialize form controls
    function initForm() {
        enableradio(); // Default to soft copy enabled
        
        // Set default checked values
        document.querySelector('input[name="soft_copy_type"][value="PDF"]').checked = true;
        document.querySelector('input[name="hard_copy_type"][value="Courier"]').checked = true;
    }
    
    // Function for enabling soft copy types and disabling hard copy types
    function enableradio() {
        // Enabling Soft Copy Types
        document.querySelector('#pdf').disabled = false;
        document.querySelector('#indesign').disabled = false;
        document.querySelector('#word').disabled = false;
        document.querySelector('#images').disabled = false;
        // Disabling Hard Copy Types
        document.querySelector('#courier').disabled = true;
        document.querySelector('#handedover').disabled = true;
        // Disabling Checked Values in Hard Copy Types
        document.querySelector('#courier').checked = false;
        document.querySelector('#handedover').checked = false;
    }
    
    // Function for enabling hard copy types and disabling soft copy types
    function disableradio() {
        // Disabling Soft Copy Types
        document.querySelector('#pdf').disabled = true;
        document.querySelector('#indesign').disabled = true;
        document.querySelector('#word').disabled = true;
        document.querySelector('#images').disabled = true;
        // Enabling Hard Copy Types
        document.querySelector('#courier').disabled = false;
        document.querySelector('#handedover').disabled = false;
        // Disabling Checked Values in Soft Copy Types
        document.querySelector('#pdf').checked = false;
        document.querySelector('#images').checked = false;
        document.querySelector('#word').checked = false;
        document.querySelector('#indesign').checked = false;
    }
    
    function count_chars() {
        var num_chars = document.getElementById('desc_text').value.length;
        document.getElementById('num_chars').textContent = num_chars;
    }
    
    function fill_url_title() {
        var title = document.getElementById('book_title').value;
        var formatted_title = title.replace(/[^a-z\d\s]+/gi, "");
        formatted_title = formatted_title.split(' ').join('-');
        formatted_title = formatted_title.toLowerCase();
        document.getElementById('url_title').value = formatted_title;
    }
    
    var base_url = "<?= base_url() ?>";
    function add_book() {
    var title = document.getElementById('book_title').value.trim();
    var urlTitle = document.getElementById('url_title').value.trim();

    if (!title) {
        alert("⚠️ Please enter a book title.");
        return;
    }

    // Step 1: Check if url_title exists
    $.ajax({
        url: base_url + "book/checkBookUrl",
        type: "POST",
        dataType: "json",
        data: { url_title: urlTitle },
        success: function(response) {
            if (response.exists) {
                alert("⚠️ URL Title already exists! Please choose another one.");
                document.getElementById('url_title').focus();
                return;
            } else {
                // Step 2: Continue with add book
                submitBook();
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("⚠️ Error checking URL Title!");
        }
    });
}

function submitBook() {
        // Get form values
        var formData = {
            author_id: document.getElementById('author_id').value,
            royalty: document.getElementById('royalty').value,
            description: document.getElementById('desc_text').value.trim(),
            lang_id: document.getElementById('lang_id').value,
            title: document.getElementById('book_title').value,
            regional_title: document.getElementById('regional_title').value,
            url_title: document.getElementById('url_title').value,
            book_category: document.getElementById('book_category').value,
            content_type: document.querySelector('input[name="content_type"]:checked').value,
            type_of_book: document.querySelector('input[name="type_of_book"]:checked').value,
            no_of_pages: document.getElementById('no_of_pages').value,
            genre_id: document.getElementById('genre_id').value,
            priority: document.getElementById('priority').value,
            agreement_flag: document.querySelector('input[name="agreement_flag"]:checked').value,
            paperback_flag: document.querySelector('input[name="paperback_flag"]:checked').value,
            date_assigned: document.getElementById('dateAssigned').value
        };

        // Set soft/hard copy type based on selection
        if (formData.content_type === "Soft Copy") {
            formData.soft_copy_type = document.querySelector('input[name="soft_copy_type"]:checked')?.value || "";
            formData.hard_copy_type = "";
        } else {
            formData.hard_copy_type = document.querySelector('input[name="hard_copy_type"]:checked')?.value || "";
            formData.soft_copy_type = "";
        }
        

        // // Validate required fields
        // if (!formData.title || !formData.description || !formData.book_category) {
        //     alert("Please fill all required fields!");
        //     return false;
        // }

        // Show loading state
        const submitBtn = document.querySelector('button[onclick="add_book()"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        // AJAX request
        $.ajax({
            url: base_url + "book/addbookpost",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function(response) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit';
                
                if (response.result) {
                    alert("✅ Successfully added book");
                    // // Optionally reset form or redirect
                    // document.getElementById('bookAddForm').reset();
                    window.location.href = base_url + "book/addbook";
                } else {
                    alert("❌ Failed to add book! " + (response.message || ""));
                }
            },
            error: function(xhr, status, error) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit';
                
                console.error(xhr.responseText);
                alert("⚠️ Error while submitting data! Please check console for details.");
            }
        });
    }

    // Content type toggle handler
    document.querySelectorAll('input[name="content_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Soft Copy') {
                document.getElementById('soft-copy-group').classList.remove('d-none');
                document.getElementById('hard-copy-group').classList.add('d-none');
                enableradio();
            } else {
                document.getElementById('hard-copy-group').classList.remove('d-none');
                document.getElementById('soft-copy-group').classList.add('d-none');
                disableradio();
            }
        });
    });

    // Initialize form when DOM is loaded
    document.addEventListener('DOMContentLoaded', initForm);
</script>
<?= $this->endSection(); ?>