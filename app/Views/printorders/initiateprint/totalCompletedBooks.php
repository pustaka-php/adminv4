<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <center><h3>Initiate Print Completed List</h3></center>
            </div>
        </div>
        <br>
        <table class="table zero-config">
                <thead class="thead-dark">
                <tr>
                    <th style="border: 1px solid grey; width: 5%;">S.No</th>
                    <th style="border: 1px solid grey; width: 5%;">Created Date</th>
                    <th style="border: 1px solid grey; width: 5%;">Book Id</th>
                    <th style="border: 1px solid grey; width: 10%;">Title</th>
                    <th style="border: 1px solid grey; width: 5%;">Author Name</th>
                    <th style="border: 1px solid grey; width: 5%;">Copies</th>
                    <th style="border: 1px solid grey; width: 5%;">Completed Date</th>
                </tr>
                </thead>
                <tbody style="font-weight: 800;">
                    <?php $i=1;
                    foreach($print['completed_all'] as $print_book ) { 
                        ?>
                        <tr>
                            <td style="border: 1px solid grey"><?php echo $i++; ?></td>
                            <td style="border: 1px solid grey;"><?php echo date('d-m-Y', strtotime($print_book['order_date'])); ?><br></td>
                            <input type="hidden" id="id" name="id" value="<?php $print_book['id']?>">
                            <td style="border: 1px solid grey"><?php echo $print_book['book_id']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $print_book['book_title']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $print_book['author_name']; ?></td>
                            <td style="border: 1px solid grey"><?php echo $print_book['quantity']; ?></td>
                            <td style="border: 1px solid grey;">
                            <?php
                            if ($print_book['completed_date']== NULL) {
                                echo '';
                            } else {
                               echo date('d-m-Y', strtotime($print_book['completed_date'])); 
                            }?>
                           </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</div>