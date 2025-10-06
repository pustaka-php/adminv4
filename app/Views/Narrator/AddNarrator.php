<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?> 

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="mt-4 row">
            <div class="col-6">
                <label>Narrator Name</label>
                <input type="text" oninput="fill_url_name()" class="form-control" id="narrator_name" placeholder="Name">

                <label class="mt-3">URL Name</label>
                <input type="text" class="form-control" id="narrator_url_name" placeholder="URL Name">

                <label class="mt-3">Mobile No.</label>
                <input type="text" class="form-control" id="narrator_mobile" placeholder="Mobile Number">

                <label class="mt-3">Email</label>
                <input type="text" class="form-control" id="narrator_email" placeholder="E-Mail">
            </div>

            <div class="col-6">
    <label>Description</label>
    <textarea class="form-control" id="description" rows="5" placeholder="Enter description..."></textarea>

    <div class="mt-4 d-flex justify-content-start gap-2">
        <!-- Add Narrator Button -->
        <button onclick="add_narrator()" class="btn btn-primary">ADD</button>

        <!-- Back Button -->
        <a href="<?= base_url('narrator/narratordashboard') ?>" class="btn btn-secondary">BACK</a>
    </div>
</div>

        </div>
    </div>
</div>

<script>
    const base_url = "<?= base_url() ?>";

    function fill_url_name() {
        let name = document.getElementById('narrator_name').value;
        let formatted = name.replace(/[^a-z\d\s]+/gi, "").split(' ').join('-').toLowerCase();
        document.getElementById('narrator_url_name').value = formatted;
    }

    function add_narrator() {
        const data = {
            narrator_name: document.getElementById('narrator_name').value,
            narrator_url_name: document.getElementById('narrator_url_name').value,
            mobile: document.getElementById('narrator_mobile').value,
            email: document.getElementById('narrator_email').value,
            description: document.getElementById('description').value,
        };

        $.ajax({
            url: base_url + 'narrator/addnarratorpost',  // ✅ matches your route
            type: 'POST',
            data: data,
            success: function(response) {
                if (response == 1) {
                    alert("Narrator Added Successfully!");
                    window.location.href = base_url + 'narrator/narratordashboard';
                } else {
                    alert("Error adding narrator!");
                }
            },
            error: function() {
                alert("Failed to connect to the server.");
            }
        });
    }
</script>

<?= $this->endSection(); ?>
