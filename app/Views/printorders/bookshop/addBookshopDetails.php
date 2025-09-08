<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>

<body>
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="container">
                <center>
                    <h3>Bookshop Details</h3>
                </center>
                <div class="page-header">
                    <div class="row">
                        <div class="col-6">

                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                </div>
                <form id="bookshopForm" class="text-left" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bookshopName">Bookshop Name:</label>
                                <input type="text" class="form-control" id="bookshopName" name="bookshopName" required>
                            </div>
                            <div class="form-group">
                                <label for="contactPerson">Contact Person:</label>
                                <input type="text" class="form-control" id="contactPerson" name="contactPerson" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile:</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type class="form-control" id="city" name="city" rows="1" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pincode:</label>
                                <input type class="form-control" id="pincode" name="pincode" rows="1" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="preferredTransport">Preferred Transport:</label>
                                <input type class="form-control" id="preferredTransport" name="preferredTransport" rows="1" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="preferredTransportName">Preferred Transport Name:</label>
                                <input type class="form-control" id="preferredTransportName" name="preferredTransportName" rows="1" ></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    var base_url = window.location.origin;
        $(document).ready(function () {
            $('#bookshopForm').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission
                
                // Serialize the form data
                var formData = $(this).serialize();
                
                // alert( formData );
                // AJAX request
                    $.ajax({
                        type: "POST",
                        url: base_url + '/pustaka_paperback/add_bookshop',
                        data: formData,
                        success: function(data) {
                            if (data == 1) {
                                alert("Added Successfully!!");
                                window.close();
                            } else {
                                alert("Unknown error!! Check again!")
                            }
                        }
                    });
            });
        });
</script>
