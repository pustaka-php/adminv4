<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div class="col-md-8 offset-md-2">
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-center">Bookshop Details</h6><br><br>
            <div class="form-wizard">
                <form id="bookshopForm" method="POST">
                    <fieldset class="wizard-fieldset show">
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <label class="form-label">Bookshop Name*</label>
                                <input type="text" class="form-control wizard-required" id="bookshopName" name="bookshopName" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Contact Person*</label>
                                <input type="text" class="form-control wizard-required" id="contactPerson" name="contactPerson" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Mobile*</label>
                                <input type="text" class="form-control wizard-required" id="mobile" name="mobile" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address*</label>
                                <textarea class="form-control wizard-required" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">City*</label>
                                <input type="text" class="form-control wizard-required" id="city" name="city" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Pincode*</label>
                                <input type="text" class="form-control wizard-required" id="pincode" name="pincode" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Preferred Transport*</label>
                                <input type="text" class="form-control wizard-required" id="preferredTransport" name="preferredTransport" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Preferred Transport Name</label>
                                <input type="text" class="form-control" id="preferredTransportName" name="preferredTransportName">
                            </div>
                            <div class="form-group text-end mt-4">
                                <button type="submit" class="form-wizard-submit btn btn-primary-600 px-32 mt-3">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script>
    var base_url = "<?= base_url() ?>";

    $(document).ready(function () {
        $(document).on("click", ".form-wizard-submit", function (event) {
            event.preventDefault();
            var form = $("#bookshopForm");
            var formData = form.serialize();

            $.ajax({
                type: "POST",
                url: base_url + "paperback/addbookshop",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status == 1) {
                        alert(response.message);
                        window.close();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("AJAX Error: " + error);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>
