<?php
    $inactive_audio_books = $audio_books_dashboard_data['inactive_audio_books'];
    $active_audio_books = $audio_books_dashboard_data['active_audio_books'];
    $cancelled_audio_books = $audio_books_dashboard_data['cancelled_audio_books'];
    $graph_cnt_data = json_encode($audio_books_dashboard_data['graph_data']['activated_cnt']);
    $graph_date_data = json_encode($audio_books_dashboard_data['graph_data']['activated_date']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Audio Books Dashboard</title>
</head>
<body>

<div class="container" style="margin: 5; padding: 5; margin-top: -650px;">
    <div style="margin-bottom: 30px;">
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1;">
                    <h3 style="margin: 0; color: #333;">📚 Audio Books Dashboard</h3>
                </div>
                <div>
                    <a href="<?php echo base_url().'book/add_audio_book' ?>" style="background-color: #7ce3f3ff; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-weight: bold;">➕ ADD AUDIO BOOK</a>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div style="flex: 1; background-color: #efbc6fff; padding: 15px; border-radius: 8px; color: #333;">
                <div style="text-align: center; font-size: 20px; margin-bottom: 5px;">⏳ Inactive</div>
                <div style="text-align: center; font-size: 30px; font-weight: bold;"><?php echo sizeof($inactive_audio_books) ?></div>
            </div>
            <div style="flex: 1; background-color: #d599f1ff; padding: 15px; border-radius: 8px; color:#333">
                <div style="text-align: center; font-size: 20px; margin-bottom: 5px;">✅ Active</div>
                <div style="text-align: center; font-size: 30px; font-weight: bold;"><?php echo sizeof($active_audio_books) ?></div>
            </div>
            <div style="flex: 1; background-color: #c8eb83ff; padding: 15px; border-radius: 8px; color: #333">
                <div style="text-align: center; font-size: 20px; margin-bottom: 5px;">❌ Cancelled</div>
                <div style="text-align: center; font-size: 30px; font-weight: bold;"><?php echo sizeof($cancelled_audio_books) ?></div>
            </div>
        </div>

        <!-- Inactive Audio Books Table -->
        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h3 style="margin: 0; color: #333;">⏳ Inactive Audio Books (<?php echo sizeof($inactive_audio_books) ?>)</h3>
            </div>
            <div style="overflow-x: auto;">
                <table id="inactiveAudioBooksTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inactive_audio_books as $i => $book) { ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $book['book_id'] ?></td>
                                <td><?= $book['book_title'] ?></td>
                                <td><?= $book['author_name'] ?></td>
                                <td><?= $book['narrator_name'] ?></td>
                                <td><?= $book['number_of_page'] ?> mins</td>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <a href="<?= base_url()."book/audio_book_chapters/".$book['book_id'] ?>">📖</a>
                                        <a href="<?= base_url().'adminv3/in_progress_edit_book/'.$book['book_id'] ?>" target="_blank">✏️</a>
                                        <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)">🧪</a>
                                        <a href="<?= base_url()."book/activate_book_page/".$book['book_id'] ?>">✅</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Active Audio Books Table -->
        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h3 style="margin: 0; color: #333;">✅ Active Audio Books (<?php echo sizeof($active_audio_books) ?>)</h3>
            </div>
            <div style="overflow-x: auto;">
                <table id="activeAudioBooksTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($active_audio_books as $i => $book) { ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $book['book_id'] ?></td>
                                <td><?= $book['book_title'] ?></td>
                                <td><?= $book['author_name'] ?></td>
                                <td><?= $book['narrator_name'] ?></td>
                                <td><?= $book['number_of_page'] ?> mins</td>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <a href="<?= base_url()."adminv3/audio_book_chapters/".$book['book_id'] ?>">📖</a>
                                        <a href="<?= base_url().'adminv3/in_progress_edit_book/'.$book['book_id'] ?>" target="_blank">✏️</a>
                                        <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)">🧪</a>
                                        <a href="#" onclick="add_to_test(<?= $book['book_id'] ?>)">⏸️</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cancelled Audio Books Table -->
        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div style="padding: 15px 20px; border-bottom: 1px solid #eee;">
                <h3 style="margin: 0; color: #333;">❌ Cancelled Audio Books (<?php echo sizeof($cancelled_audio_books) ?>)</h3>
            </div>
            <div style="overflow-x: auto;">
                <table id="cancelledAudioBooksTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th>#</th><th>Book ID</th><th>Title</th><th>Author</th><th>Narrator</th><th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cancelled_audio_books as $i => $book) { ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $book['book_id'] ?></td>
                                <td><?= $book['book_title'] ?></td>
                                <td><?= $book['author_name'] ?></td>
                                <td><?= $book['narrator_name'] ?></td>
                                <td><?= $book['number_of_page'] ?> mins</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activation Graph (Moved to bottom) -->
        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-top: 30px; padding: 20px;">
            <h3 style="margin: 0 0 20px 0; text-align: center; color: #333;">📈 Month-wise Activated Books</h3>
            <div id="monthly_activated_books"></div>
        </div>

    </div>
</div>

<script>
    var base_url = "<?php echo base_url(); ?>";
    var graph_options = {
        chart: { type: 'area', stacked: true, height: 350 },
        colors: ['#ff5757'],
        dataLabels: { enabled: false },
        series: [{ name: "Book's", data: <?php echo $graph_cnt_data; ?> }],
        xaxis: { categories: <?php echo $graph_date_data; ?> }
    };
    var graph_chart = new ApexCharts(document.querySelector("#monthly_activated_books"), graph_options);
    graph_chart.render();

    function add_to_test(book_id) {
        var user_id = prompt("Enter User Id:");
        $.ajax({
            url: base_url + '/book/add_to_test',
            type: 'POST',
            data: { "book_id": book_id, "user_id": user_id },
            success: function(data) {
                if (data == 1) { alert("Book added to test"); }
            }
        });
    }

    $(document).ready(function() {
        $('#inactiveAudioBooksTable').DataTable({ pageLength: 10, ordering: true });
        $('#activeAudioBooksTable').DataTable({ pageLength: 10, ordering: true });
        $('#cancelledAudioBooksTable').DataTable({ pageLength: 10, ordering: true });
    });
</script>

</body>
</html>
