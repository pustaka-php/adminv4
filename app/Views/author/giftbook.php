<?= $this->extend('layout/layout1'); ?>

<?= $this->section('script'); ?>
<script>
(() => {
    "use strict";

    // Bootstrap validation
    const forms = document.querySelectorAll(".needs-validation");
    Array.from(forms).forEach(form => {
        form.addEventListener("submit", event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        }, false);
    });
})();

// Show Bootstrap alert
function showAlert(message, type = 'danger') {
    const alertPlaceholder = document.getElementById('alertPlaceholder');
    const wrapper = document.createElement('div');
    wrapper.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertPlaceholder.append(wrapper);
}

// Check if user exists
function checkOrCreateUser() {
    let email = document.getElementById("email").value;
    if (!email) return showAlert("Please enter an email.");

    fetch("<?= site_url('user/checkorcreate') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById("userId").value = data.user_id;
        if (data.user_id == 0) {
            // Show Name, Mobile, and Create User button
            document.getElementById("nameField").style.display = "block";
            document.getElementById("mobileField").style.display = "block";
            document.getElementById("createUserBtnField").style.display = "block";
        } else {
            // Hide Name, Mobile, and Create User button
            document.getElementById("nameField").style.display = "none";
            document.getElementById("mobileField").style.display = "none";
            document.getElementById("createUserBtnField").style.display = "none";
        }
    });
}

// Create user manually
function createUser() {
    let email = document.getElementById("email").value;
    let name = document.getElementById("userName").value;
    let mobile = document.getElementById("userMobile").value;

    if (!email || !name || !mobile) {
        return showAlert("Please enter Email, Name and Mobile to create user.");
    }

    fetch("<?= site_url('user/createuser') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, name, mobile })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showAlert("User created successfully!", 'success');
            document.getElementById("userId").value = data.user_id;
            // Hide Name, Mobile, and Create User button after creation
            document.getElementById("nameField").style.display = "none";
            document.getElementById("mobileField").style.display = "none";
            document.getElementById("createUserBtnField").style.display = "none";
        } else {
            showAlert(data.message, 'warning');
        }
    });
}

// Form submission
function submitForm(event) {
    event.preventDefault();

    let email = document.getElementById("email").value;
    let userId = document.getElementById("userId").value;
    let bookId = document.getElementById("book_id").value;
    let authorId = document.getElementById("author_id").value;
    let authorName =document.getElementById("author_name").value;
    let bookTitle = document.getElementById("book_title").value;

    if (!userId || !bookId) {
        return showAlert("Please fill all required fields.");
    }

    let payload = { 
        email :email,
        user_id: userId,
        book_id: bookId ,
        book_title:bookTitle,
        author_id : authorId,
        author_name : authorName,
        };

        // alert(authorName);

    // Include Name & Mobile if new user
    if (userId == 0) {
        let name = document.getElementById("userName").value;
        let mobile = document.getElementById("userMobile").value;

        if (!name || !mobile) {
            return showAlert("Please enter Name and Mobile for new user.");
        }

        payload.name = name;
        payload.mobile = mobile;
    }

    fetch("<?= site_url('user/submitgiftbook') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message, 'warning');
        }
    });
}
</script>
<?= $this->endSection(); ?>


<?= $this->section('content'); ?> 

<div class="row gy-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">User & Book Selection</h5>
            </div>
            <div class="card-body">

                <!-- Alert placeholder -->
                <div id="alertPlaceholder"></div>

                <form class="row gy-3 needs-validation" novalidate onsubmit="submitForm(event)">
                    
                    <!-- Email Input -->
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <input type="email" id="email" class="form-control" placeholder="Enter Email" required>
                            <button type="button" class="btn btn-secondary" onclick="checkOrCreateUser()">Check/Create</button>
                            <div class="invalid-feedback">
                                Please provide email address.
                            </div>
                        </div>
                    </div>

                    <!-- User ID -->
                    <div class="col-md-6">
                        <label class="form-label">User ID</label>
                        <input type="text" id="userId" class="form-control" readonly>
                    </div>

                    <!-- Name Input (hidden by default) -->
                    <div class="col-md-6" id="nameField" style="display:none;">
                        <label class="form-label">Name</label>
                        <input type="text" id="userName" class="form-control" placeholder="Enter Name">
                    </div>

                    <!-- Mobile Input (hidden by default) -->
                    <div class="col-md-6" id="mobileField" style="display:none;">
                        <label class="form-label">Mobile</label>
                        <input type="text" id="userMobile" class="form-control" placeholder="Enter Mobile">
                    </div>

                    <!-- Create User Button (hidden by default) -->
                    <div class="col-12 mb-3" id="createUserBtnField" style="display:none;">
                        <button type="button" class="btn btn-success" onclick="createUser()">Create User</button>
                    </div>

                    <!-- Book ID -->
                    <div class="col-lg-6 col-sm-12">
                        <label class="form-label fw-semibold">Book ID</label>
                        <input type="text" id="book_id" name="book_id" class="form-control" placeholder="Enter Book ID" autocomplete="off">
                    </div>

                    <!-- Book Title -->
                    <div class="col-lg-6 col-sm-12">
                        <label class="form-label fw-semibold">Book Title</label>
                        <input type="text" id="book_title" name="book_title" class="form-control" placeholder="Enter Book Title" list="book_title_list" autocomplete="off">
                        <datalist id="book_title_list">
                            <?php foreach ($books as $book): ?>
                                <option value="<?= esc($book['book_title']) ?>"></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>

                    <!-- Author ID -->
                    <div class="col-md-6">
                        <label class="form-label">Author ID</label>
                        <input type="text" id="author_id"  name="author_id" class="form-control" readonly>
                    </div>

                    <!-- Author Name -->
                    <div class="col-lg-6 col-sm-12">
                        <label class="form-label fw-semibold">Author Detail</label>
                        <input type="text" id="author_name" name="author_name" class="form-control" placeholder="Author Name" readonly>
                    </div>

                    <div class="col-12 d-flex">
                        <button class="btn btn-primary-600" type="submit">Submit</button>
                        <button type="button" class="btn btn-warning" onclick="clearForm()">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const books = <?= json_encode($books) ?>;

    const bookIdInput = document.getElementById('book_id');
    const bookTitleInput = document.getElementById('book_title');
    const authorNameInput = document.getElementById('author_name');
    const authorIdInput = document.getElementById('author_id');

    // Autofill from Book ID
    bookIdInput.addEventListener('input', function () {
        const enteredId = this.value.trim();

        if (enteredId === '') {
            bookTitleInput.value = '';
            authorNameInput.value = '';
            authorIdInput.value = '';
            return;
        }

        const matchedBook = books.find(book => book.book_id == enteredId);
        if (matchedBook) {
            bookTitleInput.value = matchedBook.book_title || '';
            authorNameInput.value = matchedBook.author_name || '';
            authorIdInput.value = matchedBook.author_id || '';
        } else {
            bookTitleInput.value = '';
            authorNameInput.value = '';
            authorIdInput.value = '';
        }
    });

    // Autofill from Book Title
    function syncFromTitle() {
        const enteredTitle = bookTitleInput.value.trim().toLowerCase();

        if (enteredTitle === '') {
            bookIdInput.value = '';
            authorNameInput.value = '';
            authorIdInput.value = '';
            return;
        }

        const matchedBook = books.find(book => book.book_title.toLowerCase() === enteredTitle)
            || books.find(book => book.book_title.toLowerCase().includes(enteredTitle));

        if (matchedBook) {
            bookIdInput.value = matchedBook.book_id || '';
            authorNameInput.value = matchedBook.author_name || '';
            authorIdInput.value = matchedBook.author_id || '';
        } else {
            bookIdInput.value = '';
            authorNameInput.value = '';
            authorIdInput.value = '';
        }
    }

    bookTitleInput.addEventListener('input', syncFromTitle);
    bookTitleInput.addEventListener('change', syncFromTitle);
});

function clearForm() {
    // Reset all inputs inside the form
    const form = document.querySelector('.needs-validation');
    form.reset();
    form.classList.remove("was-validated");

    // Manually clear hidden/readonly fields
    document.getElementById("userId").value = '';
    document.getElementById("authorId").value = '';
    document.getElementById("author_name").value = '';

    // Hide optional fields again
    document.getElementById("nameField").style.display = "none";
    document.getElementById("mobileField").style.display = "none";
    document.getElementById("createUserBtnField").style.display = "none";

    // Clear alert messages
    document.getElementById("alertPlaceholder").innerHTML = '';
}

</script>

<?= $this->endSection(); ?>
