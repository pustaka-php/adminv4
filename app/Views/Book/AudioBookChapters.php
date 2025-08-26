<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
<?php
    if (isset($audio_book_info['chapters_data'])) {
        $chapters_data = $audio_book_info['chapters_data'];
    }
?>
<div id="container">
	<div class="layout-px-spacing">
		<div class="page-header">
			<div class="page-title">
				<div class="mt-3 row">
					<div class="col-10">
						<h6>
						<?php echo $audio_book_info['book_info']['book_title'] ?>
						</h6>
					</div>
					<div class="col-2">
						<button style="position: fixed;" id="add_chapter" class="btn btn-info">
							ADD CHAPTER
						</button>
					</div>
				</div>
			</div>
		</div>
		<table id="chapters_table" class="mt-4 table table-bordered">
			<thead>
				<tr>
					<th>Chp. ID</th>
					<th>Regional Name</th>
					<th>English Name</th>
					<th width="30%">File Path</th>
					<th>Chapter Duration</th>
					<th class="no-content"></th>
                    <th class="no-content"></th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($chapters_data)) { ?>
                    <?php for ($i = 0; $i < sizeof($chapters_data); $i++) { ?>
                    <tr class="chapter_table_row">
                        <td><?php echo $chapters_data[$i]['chapter_id'] ?></td>
                        <td><?php echo $chapters_data[$i]['chapter_name'] ?></td>
                        <td>
                            <?php echo $chapters_data[$i]['chapter_name_english'] ?>
                        </td>
                        <td><?php echo $chapters_data[$i]['chapter_url'] ?></td>
                        <td>
                            <?php echo $chapters_data[$i]['chapter_duration'] ?>
                        </td>
                        <td onclick="edit_chapter(this, <?php echo $chapters_data[$i]['id'] ?>)"><button style="background: none; border: none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg></button></td>
                    </tr>
                    <?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var base_url = window.location.origin;
    $('#add_chapter').on('click', () => {
        var tableRef = document.getElementById('chapters_table');

        var newRow = tableRef.insertRow(-1);

        var idInput = "<input class='form-control' id='chapter_id' type='text' placeholder='Chapter ID' />";
        var idCell = newRow.insertCell(0);
        idCell.innerHTML = idInput;

        var regNameInput = "<input class='form-control' id='regional_name' type='text' placeholder='Regional Name' />";
        var regNameCell = newRow.insertCell(1);
        regNameCell.innerHTML = regNameInput;

        var nameInput = "<input class='form-control' onInput='fill_file_path()' id='chapter_name' type='text' placeholder='English Name' />";
        var nameCell = newRow.insertCell(2);
        nameCell.innerHTML = nameInput;

        var pathInput = "<input class='form-control' id='chapter_file_path' type='text' placeholder='File Path' />";
        var pathCell = newRow.insertCell(3);
        pathCell.innerHTML = pathInput;

        var durationInput = `
            <input class='form-control' id='chapter_duration' type='text' placeholder='Time (Min:Sec)' />
        `;
        var durationCell = newRow.insertCell(4);
        durationCell.innerHTML = durationInput;

        var addInput = `
        <div>
            <button style="display: inline-block; background: none; border: none; outline: none;" onClick="add_chapter()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg>
            </button>
        </div>`;
        var addCell = newRow.insertCell(5);
        addCell.innerHTML = addInput;

        var copyInput = `
        <td onClick="copy_previous_chapter(this)">
            <button style="display: inline-block; background: none; border: none; outline: none;" >
                <svg aria-hidden="true" focusable="false" width="24" height="24" data-prefix="fas" data-icon="copy" class="svg-inline--fa fa-copy fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M320 448v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V120c0-13.255 10.745-24 24-24h72v296c0 30.879 25.121 56 56 56h168zm0-344V0H152c-13.255 0-24 10.745-24 24v368c0 13.255 10.745 24 24 24h272c13.255 0 24-10.745 24-24V128H344c-13.2 0-24-10.8-24-24zm120.971-31.029L375.029 7.029A24 24 0 0 0 358.059 0H352v96h96v-6.059a24 24 0 0 0-7.029-16.97z"></path></svg>
            </button>
        </td>`;
        var copyCell = newRow.insertCell(6);
        copyCell.innerHTML = copyInput;
    });

    function add_chapter() {
    var chp_id = document.getElementById('chapter_id').value;
    var regional_name = document.getElementById('regional_name').value;
    var title = document.getElementById('chapter_name').value;
    var file_path = document.getElementById('chapter_file_path').value;
    var chapter_duration = document.getElementById('chapter_duration').value;

    $.ajax({
        url: base_url + '/book/addaudiobookchapter',
        type: 'POST',
        data: {
            chp_id: chp_id,
            regional_name: regional_name,
            title: title,
            file_path: file_path,
            chapter_duration: chapter_duration,
            book_id: <?= $book_id ?> // ensure this is rendered correctly
        },
        dataType: 'json', // important to parse JSON response
        success: function (data) {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message);
            }
        },
        error: function() {
            alert('Ooops...Something went wrong, Please try again');
        }
    });
}


    function edit_chapter(element, id) {
        const chapter_tbl = document.getElementById('chapters_table');
        const row_number = element.parentNode.rowIndex - 1;;

        const row = document.getElementsByClassName("chapter_table_row")[row_number];
        const cells = row.getElementsByTagName("td");

        var cell_value = `<input id='chapter_id' type='text' class='form-control' value='${cells[0].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[0].innerHTML = cell_value;

        var cell_value = `<input id='regional_name' type='text' class='form-control' value='${cells[1].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[1].innerHTML = cell_value;

        var cell_value = `<input id='title' type='text' class='form-control' value='${cells[2].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[2].innerHTML = cell_value;

        var cell_value = `<input id='file_path' type='text' class='form-control' value='${cells[3].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[3].innerHTML = cell_value;

        var cell_value = `<input id='chapter_duration' type='text' class='form-control' value='${cells[4].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[4].innerHTML = cell_value;

        var cell_value = `<button style="background: none; border: none; outline: none;" onclick='edit_chapter_post(${id})'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg></button>`;
        chapter_tbl.rows[row_number + 1].cells[5].innerHTML = cell_value;
    }

    function copy_previous_chapter(element) {
        const chapter_tbl = document.getElementById('chapters_table');
        const row_number = element.parentNode.rowIndex - 1;
        alert(row_number);
        //const previous_row_number = row_number - 1;

        const row = document.getElementsByClassName("chapter_table_row")[row_number];
        const cells = row.getElementsByTagName("td");


        const prev_row = document.getElementsByClassName("chapter_table_row")[previous_row_number];
        const prev_cells = row.getElementsByTagName("td");

        var cell_value = `<input id='chapter_id' type='text' class='form-control' value='${prev_cells[0].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[0].innerHTML = cell_value;

        var cell_value = `<input id='regional_name' type='text' class='form-control' value='${prev_cells[1].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[1].innerHTML = cell_value;

        var cell_value = `<input id='title' type='text' class='form-control' value='${prev_cells[2].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[2].innerHTML = cell_value;

        var cell_value = `<input id='file_path' type='text' class='form-control' value='${prev_cells[3].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[3].innerHTML = cell_value;

        var cell_value = `<input id='chapter_duration' type='text' class='form-control' value='${cells[4].innerText}' />`;
        chapter_tbl.rows[row_number + 1].cells[4].innerHTML = cell_value;

        var cell_value = `<button style="background: none; border: none; outline: none;" onclick='edit_chapter_post(${id})'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/></svg></button>`;
        chapter_tbl.rows[row_number + 1].cells[5].innerHTML = cell_value;
    }

    function edit_chapter_post(id) {
    var chp_id = document.getElementById('chapter_id').value;
    var regional_name = document.getElementById('regional_name').value;
    var title = document.getElementById('title').value;
    var file_path = document.getElementById('file_path').value;
    var chapter_duration = document.getElementById('chapter_duration').value;

    $.ajax({
        url: base_url + '/book/editaudiobookchapter',
        type: 'POST',
        dataType: 'json',
        data: {
            chp_id: chp_id,
            regional_name: regional_name,
            title: title,
            file_path: file_path,
            chapter_duration: chapter_duration,
            id: id
        },
        success: function (data) {
            console.log("Server Response:", data); // Debug response
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message);
            }
        },
        error: function (xhr, status, error) {
            console.log("Error:", xhr.responseText); // Show actual PHP error in console
            alert('Ooops...Something went wrong, Please try again');
        }
    });
}



    function fill_file_path() {
        var chp_id = document.getElementById('chapter_id').value;
        var title = document.getElementById('chapter_name').value;
        var formatted_chapter_name = title.replace(/[^a-z\d\s]+/gi, "");
        formatted_chapter_name = formatted_chapter_name.split(' ').join('-');
        formatted_chapter_name = formatted_chapter_name.toLowerCase();
        var language_name = '<?php echo $audio_book_info['book_info']['language_url_name'] ?>';
        var genre_name = '<?php echo $audio_book_info['book_info']['genre_url_name'] ?>';
        var book_title = '<?php echo $audio_book_info['book_info']['url_name'] ?>';
        book_title = book_title.replace('-audio', '');

        var file_path = `${language_name}/audio/${genre_name}/${book_title}/${chp_id}-${formatted_chapter_name}.mp3`;
        document.getElementById('chapter_file_path').value = file_path;
    }

</script>
<?= $this->endSection(); ?>
