<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<div class="layout-px-spacing">
<div class="row">
    <div class="col-6">
        <h6 class="mt-3">Author Related Details</h6>
        <label class="mt-3">Select Author</label>
        <select name="author_id" id="author_id" class="form-control">
            <?php if (isset($author_list)) { ?>
                <?php for($i=0; $i<count($author_list); $i++) {?>
                    <option value="<?php echo $author_list[$i]->author_id;?>" data-name="<?php echo $author_list[$i]->author_name; ?>"><?php echo $author_list[$i]->author_name; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <label class="mt-3">Select Narrator (<a href="<?php echo base_url()."adminv3/add_narrator" ?>" style="color: blue">add narrator</a>)</label>
        <select name="narrator_id" id="narrator_id" class="form-control">
            <?php if (isset($narrator_list)) { ?>
                <?php for($i=0; $i<count($narrator_list); $i++) {?>
                    <option value="<?php echo $narrator_list[$i]->narrator_id;?>" data-name="<?php echo $narrator_list[$i]->narrator_name; ?>"><?php echo $narrator_list[$i]->narrator_name; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <label class="mt-3">Royalty %</label>
        <input class="form-control" name="lending_royalty" value=40 id="royalty" />
        <label class="mt-3">Description</label>
        <textarea name="" oninput="count_chars()" id="desc_text" rows="5" class="form-control" placeholder="Description Goes Here"></textarea>
        <div class=" mt-1">
            <span class="badge badge-info">
            <small id="" class="form-text mt-0">Charecters: <span id="num_chars">0</span></small>
            </span>
        </div>
        <label class="mt-3">Number Of Minutes:</label>
        <input type="number" oninput="populate_cost()" id="no_of_pages" name="no_of_pages" value="" class="form-control">
        <label class="mt-3">Price</label>
        <div class="row">
            <div class="col-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><span style="height: 30px; width: 30px" >₹</span></span>
                    </div>
                    <input type="text" id="cost_inr" class="form-control" placeholder="Cost INR" aria-label="notification" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><span style="height: 30px; width: 30px" >$</span></span>
                    </div>
                    <input type="text" id="cost_usd" class="form-control" placeholder="Cost USD" aria-label="notification" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><span style="height: 30px; width: 30px" >₹</span></span>
                    </div>
                    <input type="text" id="rental_cost_inr" class="form-control" placeholder="Rental Cost INR" aria-label="notification" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><span style="height: 30px; width: 30px" >$</span></span>
                    </div>
                    <input type="text" id="rental_cost_usd" class="form-control" placeholder="Rental Cost USD" aria-label="notification" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h6 class="mt-3">Book Related Details</h6>
        <label class="mt-3">Select Language</label>
        <select name="lang_id" id="lang_id" class="form-control">
            <?php if (isset($lang_details)) { ?>
                <?php for($i=0; $i<count($lang_details); $i++) { ?>
                    <option value="<?php echo $lang_details[$i]->language_id;?>" data-name="<?php echo $lang_details[$i]->language_name; ?>"><?php echo $lang_details[$i]->language_name; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <label class="mt-3">Title</label>
        <input class="form-control" onInput="fill_url_title()" name="title" id="book_title" />
        <label class="mt-3">Regional Title</label>
        <input class="form-control" name="regional_book_title" id="regional_title" />
        <label class="mt-3">URL Title</label>
        <input class="form-control" name="url_book_title" id="url_title" />
        <label class="mt-3">Select Genre</label>
        <select class="form-control" name="genre_id" id="genre_id">
            <?php if (isset($genre_details)) { ?>
                <?php for($i=0; $i<count($genre_details); $i++) { ?>
                    <option value="<?php echo $genre_details[$i]->genre_id;?>" data-name="<?php echo $genre_details[$i]->genre_name; ?>"><?php echo $genre_details[$i]->genre_name; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <label class="mt-3">Select Type</label>
        <select class="form-control" onchange="fill_metadata();" name="book_category" id="book_category">
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
    </div>
    <a href="" onclick="add_book()" class="ml-3 mb-5 mt-3 btn btn-outline-secondary btn-rounded btn-lg">Submit</a>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script type="text/javascript">
    var base_url = window.location.origin;
    // Storing all values from form into variables
    function add_book() {
        var tmp = document.getElementById('author_id');
        var auth_id = tmp.options[tmp.selectedIndex].value;
        var tmp = document.getElementById('narrator_id');
        var narrator_id = tmp.options[tmp.selectedIndex].value;
        var royalty = document.getElementById('royalty').value;
        var desc = document.getElementsByName('description');
        var desc_text = document.getElementById('desc_text').value;
        var tmp = document.getElementById("lang_id");
        var lang_id = tmp.options[tmp.selectedIndex].value;
        var title = document.getElementById('book_title').value;
        var regional_title = document.getElementById('regional_title').value;
        var url_title = document.getElementById('url_title').value;
        var tmp = document.getElementById('genre_id');
        var genre_id = tmp.options[tmp.selectedIndex].value;
        var book_category = document.getElementById('book_category').value;
        var types_of_book = document.getElementsByName('type_of_book');
        var type_of_book;
        for (var i = 0; i < types_of_book.length; i++) {
            if (types_of_book[i].checked) {
                type_of_book = types_of_book[i].value;
            }
        }
        var tmp = document.getElementById('priority');
        var no_of_minutes = document.getElementById('no_of_pages').value;
        var cost_inr = document.getElementById("cost_inr").value;
        var cost_usd = document.getElementById("cost_usd").value;
        var rental_cost_inr = document.getElementById("rental_cost_inr").value;
        var rental_cost_usd = document.getElementById("rental_cost_usd").value;
        // Inserting values into database
        $.ajax({
    url: base_url + '/book/addaudiobookpost',
    type: 'POST',
    data: {
        "author_id": auth_id,
        "narrator_id": narrator_id,
        "royalty": royalty,
        "desc_text": desc_text,
        "lang_id": lang_id,
        "title": title,
        "regional_title": regional_title,
        "url_title": url_title,
        "book_category": book_category,
        "type_of_book": type_of_book,
        "no_of_minutes": no_of_minutes,
        "genre_id": genre_id,
        "cost_inr": cost_inr,
        "cost_usd": cost_usd,
        "rental_cost_inr": rental_cost_inr,
        "rental_cost_usd": rental_cost_usd
    },
    dataType: "json", 
    success: function(response) {
        if (response.success) {
            alert(response.message);
        } else {
            alert(response.message);
        }
    }
});

    }

    function fill_url_title() {
        var title = document.getElementById('book_title').value;
        var formatted_title = title.replace(/[^a-z\d\s]+/gi, "");
        formatted_title = formatted_title.split(' ').join('-');
        formatted_title = formatted_title.toLowerCase();
        document.getElementById('url_title').value = formatted_title;
    }
    function populate_cost() {
        var num_mins = document.getElementById("no_of_pages").value;

        if (num_mins < 60) {
            document.getElementById("cost_inr").value = 49;
            document.getElementById("cost_usd").value = 0.75;
            document.getElementById("rental_cost_inr").value = 4;
            document.getElementById("rental_cost_usd").value = 0.15;
        }
        else if (num_mins > 60 && num_mins < 120) {
            document.getElementById("cost_inr").value = 69;
            document.getElementById("cost_usd").value = 1;
            document.getElementById("rental_cost_inr").value = 7;
            document.getElementById("rental_cost_usd").value = 0.30;
        }
        else if (num_mins > 120 && num_mins < 180) {
            document.getElementById("cost_inr").value = 89;
            document.getElementById("cost_usd").value = 1.25;
            document.getElementById("rental_cost_inr").value = 10;
            document.getElementById("rental_cost_usd").value = 0.45;
        }
        else if (num_mins > 180 && num_mins < 240) {
            document.getElementById("cost_inr").value = 109;
            document.getElementById("cost_usd").value = 1.50;
            document.getElementById("rental_cost_inr").value = 13;
            document.getElementById("rental_cost_usd").value = 0.60;
        }
        else if (num_mins > 240 && num_mins < 300) {
            document.getElementById("cost_inr").value = 129;
            document.getElementById("cost_usd").value = 1.75;
            document.getElementById("rental_cost_inr").value = 16;
            document.getElementById("rental_cost_usd").value = 0.75;
        }
        else if (num_mins > 300 && num_mins < 360) {
            document.getElementById("cost_inr").value = 149;
            document.getElementById("cost_usd").value = 2;
            document.getElementById("rental_cost_inr").value = 18;
            document.getElementById("rental_cost_usd").value = 0.90;
        }
        else {
            document.getElementById("cost_inr").value = 169;
            document.getElementById("cost_usd").value = 2.25;
            document.getElementById("rental_cost_inr").value = 20;
            document.getElementById("rental_cost_usd").value = 1;
        }
    }
</script>
<?= $this->endSection(); ?>