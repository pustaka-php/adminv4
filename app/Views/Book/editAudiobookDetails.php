<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<?php
// Helper function for safe date formatting
function formatDate($date, $format = 'd-m-Y') {
    if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
        return '<span class="text-muted">N/A</span>';
    }
    return date($format, strtotime($date));
}
?>

<div class="container py-4">

    <!-- Page Header -->
    <h6 class="mb-1">Edit Audiobook Details</h6>

    <p class="text-muted mb-1">
        <strong><?= esc($book_details['book_title']); ?></strong>
        (ID: <?= esc($book_details['book_id']); ?>)
    </p>

    <p class="mb-4">
        Status:
        <strong><?= $book_details['status'] == 1 ? 'Active' : 'Inactive'; ?></strong>
    </p>

    <div class="row">
        <div class="col-md-7">

            <div class="card p-4">

                <!-- Narrator -->
                <div class="mb-3">
                    <label class="form-label">Narrator Name</label>
                    <select name="narrator_id" id="narrator_id" class="form-control">
                        <?php foreach ($narrator_list as $n): ?>
                            <option value="<?= esc($n['narrator_id']); ?>"
                                <?= ($n['narrator_id'] == $book_details['narrator_id']) ? 'selected' : ''; ?>>
                                <?= esc($n['narrator_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Agreement -->
                <div class="mb-3">
                    <label class="form-label">Audiobook in Agreement?</label><br>

                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input"
                            name="audiobook_agreement_flag" value="1"
                            <?= $book_details['agreement_flag'] == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label">Yes</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input"
                            name="audiobook_agreement_flag" value="0"
                            <?= $book_details['agreement_flag'] == 0 ? 'checked' : ''; ?>>
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <!-- Royalty -->
                <div class="mb-3">
                    <label class="form-label">Audiobook Royalty</label>
                    <input type="text" class="form-control" id="audiobook_royalty"
                        value="<?= esc($book_details['royalty']); ?>">
                </div>

                <!-- Copyright -->
                <div class="mb-3">
                    <label class="form-label">Copyright Owner</label>
                    <input type="text" class="form-control" id="audiobook_copyright_owner"
                        value="<?= esc($book_details['copyright_owner']); ?>">
                </div>

                <!-- Duration -->
                <div class="mb-3">
                    <label class="form-label">Audiobook Duration (Minutes)</label>
                    <input type="number" class="form-control" id="audiobook_duration"
                        value="<?= esc($book_details['number_of_page']); ?>"
                        oninput="populate_cost()">
                </div>

                <!-- Cost INR -->
                <div class="mb-3">
                    <label class="form-label">Cost (INR)</label>
                    <input type="text" class="form-control" id="audiobook_inr"
                        value="<?= esc($book_details['cost']); ?>">
                </div>

                <!-- Cost USD -->
                <div class="mb-3">
                    <label class="form-label">Cost (USD)</label>
                    <input type="text" class="form-control" id="audiobook_usd"
                        value="<?= esc($book_details['book_cost_international']); ?>">
                </div>

                <!-- Rental Cost -->
                <div class="mb-3">
                    <label class="form-label">Rental Cost (INR)</label>
                    <input type="text" class="form-control" id="rental_cost_inr"
                        value="<?= esc($book_details['rental_cost_inr']); ?>">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="description" rows="5"><?= esc($narrator_details['description'] ?? '') ?></textarea>
                </div>

                <!-- Save -->
                <button onclick="edit_audiobook_details()" class="btn btn-primary mt-2">
                    Save Changes
                </button>

            </div>

        </div>
    </div>

</div>

<script>
    const book_id = "<?= esc($book_details['book_id']); ?>";
    const base_url = "<?= base_url(); ?>";

    // UPDATE FUNCTION
    
    function edit_audiobook_details() {

        let flag = document.querySelector("input[name='audiobook_agreement_flag']:checked").value;

        $.ajax({
            url: base_url + "/book/editaudiobookdetailspost",
            type: "POST",
            data: {
                "book_id": book_id,
                "narrator_id": $("#narrator_id").val(),
                "audiobook_agreement_flag": flag,
                "audiobook_royalty": $("#audiobook_royalty").val(),
                "audiobook_copyright_owner": $("#audiobook_copyright_owner").val(),
                "audiobook_duration": $("#audiobook_duration").val(),
                "audiobook_inr": $("#audiobook_inr").val(),
                "audiobook_usd": $("#audiobook_usd").val(),
                "rental_cost_inr": $("#rental_cost_inr").val(),
                "description": $("#description").val(),
            },
            success: function (data) {
                console.log(data);
                alert(data == 1 ? "Updated Successfully!" : "Error Occurred!");
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert("Server Error! Check console for details.");
            }
        });
    }
    // COST CALCULATOR FUNCTION
    function populate_cost() {

        let num = $("#audiobook_duration").val();

        if (num < 60) {
            $("#audiobook_inr").val(49); $("#audiobook_usd").val(0.75); $("#rental_cost_inr").val(4);
        }
        else if (num < 120) {
            $("#audiobook_inr").val(69); $("#audiobook_usd").val(1); $("#rental_cost_inr").val(7);
        }
        else if (num < 180) {
            $("#audiobook_inr").val(89); $("#audiobook_usd").val(1.25); $("#rental_cost_inr").val(10);
        }
        else if (num < 240) {
            $("#audiobook_inr").val(109); $("#audiobook_usd").val(1.50); $("#rental_cost_inr").val(13);
        }
        else if (num < 300) {
            $("#audiobook_inr").val(129); $("#audiobook_usd").val(1.75); $("#rental_cost_inr").val(16);
        }
        else if (num < 360) {
            $("#audiobook_inr").val(149); $("#audiobook_usd").val(2); $("#rental_cost_inr").val(18);
        }
        else {
            $("#audiobook_inr").val(169); $("#audiobook_usd").val(2.25); $("#rental_cost_inr").val(20);
        }
    }
</script>

<?= $this->endSection(); ?>
