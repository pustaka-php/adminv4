<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?> 
<script>
    const books = <?= json_encode($other_distribution['free']) ?>;
</script>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <script>
        setTimeout(function () {
            window.location.href = "<?= base_url('stock/stockdashboard') ?>";
        }, 5000);
    </script>
<?php endif; ?>

<div class="col-xl-12">
    <div class="card h-100 p-0">
        <div class="card-body p-24">
            <form method="post" action="<?= base_url('stock/saveotherdistribution') ?>">
                <div class="row gy-4">

                    <!-- Book ID -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info">
                            <label class="form-label fw-semibold">Book ID</label>
                            <input type="text" id="book_id" name="book_id" class="form-control" placeholder="Enter Book ID" autocomplete="off">
                        </div>
                    </div>

                    <!-- Book Title -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-success-50 radius-8 border-start-width-3-px border-success-main">
                            <label class="form-label fw-semibold">Book Title</label>
                            <input type="text" id="book_title" name="book_title" class="form-control" placeholder="Enter Book Title" list="book_title_list" autocomplete="off">
                            <datalist id="book_title_list">
                                <?php foreach ($other_distribution['free'] as $book): ?>
                                    <option value="<?= esc($book['book_title']) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>

                    <!-- Regional Title -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-success-50 radius-8 border-start-width-3-px border-success-main">
                            <label class="form-label fw-semibold">Regional Title</label>
                            <input type="text" id="regional_title" name="regional_title" class="form-control" placeholder="Enter Regional Title" list="regional_title_list" autocomplete="off">
                            <datalist id="regional_title_list">
                                <?php foreach ($other_distribution['free'] as $book): ?>
                                    <option value="<?= esc($book['regional_book_title']) ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>

                    <!-- Author Name -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-secondary-50 radius-8 border-start-width-3-px border-secondary">
                            <label class="form-label fw-semibold">Author Name</label>
                            <input type="text" id="author_name" name="author_name" class="form-control" placeholder="Author Name" readonly>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-warning-50 radius-8 border-start-width-3-px border-warning-main">
                            <label class="form-label fw-semibold">Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">-- Select Type --</option>
                                <option value="author free copy">Author Free Copy</option>
                                <option value="library sample">Library Sample</option>
                                <option value="award application">Award Application</option>
                                <option value="damage">Damage</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>

                    <!-- Purpose (Conditional) -->
                    <div class="col-lg-6 col-sm-12" id="purpose_container" style="display: none;">
                        <div class="p-16 bg-danger-50 radius-8 border-start-width-3-px border-danger-main">
                            <label class="form-label fw-semibold">Purpose</label>
                            <select name="purpose_disabled" id="purpose" class="form-select" disabled>
                                <option value="">-- Select Purpose --</option>
                                <option value="free copy">Free Copy</option>
                                <option value="complimentary copy">Complimentary Copy</option>
                                <option value="sample">Sample</option>
                                <option value="award copy">Award Copy</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hidden input to always send purpose value -->
                    <input type="hidden" name="purpose" id="hidden_purpose" value="">

                    <!-- Quantity -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="p-16 bg-primary-50 radius-8 border-start-width-3-px border-primary-main">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="0" min="1">
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-24">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Autofill & Clear JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const books = <?= json_encode($other_distribution['free']) ?>;
        const typeDropdown = document.getElementById('type');
        const purposeContainer = document.getElementById('purpose_container');
        const purposeSelect = document.getElementById('purpose');
        const hiddenPurpose = document.getElementById('hidden_purpose');

        const bookIdInput = document.getElementById('book_id');
        const bookTitleInput = document.getElementById('book_title');
        const regionalTitleInput = document.getElementById('regional_title');
        const authorNameInput = document.getElementById('author_name');

        // Show/hide purpose & handle hidden input based on type
        typeDropdown.addEventListener('change', function () {
            const selectedType = this.value;

            if (selectedType === 'others') {
                purposeContainer.style.display = 'block';
                purposeSelect.disabled = false;
                purposeSelect.value = '';
                hiddenPurpose.value = '';
            } else {
                purposeContainer.style.display = 'none';
                purposeSelect.disabled = true;
                hiddenPurpose.value = selectedType || '';
            }
        });

        // Sync hidden input when purpose dropdown changes
        purposeSelect.addEventListener('change', function() {
            hiddenPurpose.value = this.value;
        });

        // Autofill from Book ID
        bookIdInput.addEventListener('input', function () {
            const enteredId = this.value.trim();

            if (enteredId === '') {
                bookTitleInput.value = '';
                regionalTitleInput.value = '';
                authorNameInput.value = '';
                return;
            }

            const matchedBook = books.find(book => book.book_id === enteredId);
            if (matchedBook) {
                bookTitleInput.value = matchedBook.book_title || '';
                regionalTitleInput.value = matchedBook.regional_book_title || '';
                authorNameInput.value = matchedBook.author_name || '';
            } else {
                bookTitleInput.value = '';
                regionalTitleInput.value = '';
                authorNameInput.value = '';
            }
        });

        // Autofill from Book Title
        function syncFromTitle() {
            const enteredTitle = bookTitleInput.value.trim().toLowerCase();

            if (enteredTitle === '') {
                bookIdInput.value = '';
                regionalTitleInput.value = '';
                authorNameInput.value = '';
                return;
            }

            const matchedBook = books.find(book => book.book_title.toLowerCase() === enteredTitle)
                || books.find(book => book.book_title.toLowerCase().includes(enteredTitle));
            if (matchedBook) {
                bookIdInput.value = matchedBook.book_id || '';
                regionalTitleInput.value = matchedBook.regional_book_title || '';
                authorNameInput.value = matchedBook.author_name || '';
            } else {
                bookIdInput.value = '';
                regionalTitleInput.value = '';
                authorNameInput.value = '';
            }
        }

        bookTitleInput.addEventListener('input', syncFromTitle);
        bookTitleInput.addEventListener('change', syncFromTitle);

        // Autofill from Regional Title
        function syncFromRegionalTitle() {
            const enteredRegional = regionalTitleInput.value.trim().toLowerCase();

            if (enteredRegional === '') {
                bookIdInput.value = '';
                bookTitleInput.value = '';
                authorNameInput.value = '';
                return;
            }

            const matchedBook = books.find(book => book.regional_book_title.toLowerCase() === enteredRegional)
                || books.find(book => book.regional_book_title.toLowerCase().includes(enteredRegional));
            if (matchedBook) {
                bookIdInput.value = matchedBook.book_id || '';
                bookTitleInput.value = matchedBook.book_title || '';
                authorNameInput.value = matchedBook.author_name || '';
            } else {
                bookIdInput.value = '';
                bookTitleInput.value = '';
                authorNameInput.value = '';
            }
        }

        regionalTitleInput.addEventListener('input', syncFromRegionalTitle);
        regionalTitleInput.addEventListener('change', syncFromRegionalTitle);
    });
</script>

<?= $this->endSection(); ?>
