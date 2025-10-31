<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <center><h3>Paperback Books List </h3></center>
            </div>
        </div>
        <br>
        <center>
            <div class="btn-group" role="group">
                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    All Books  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                    <a class="dropdown-item" href="?filter=all">All Books</a>
                    <a class="dropdown-item" href="?filter=ready">Ready File</a>
                    <a class="dropdown-item" href="?filter=not_ready">Not ReadyFile</a>
                </div>
            </div>
        </center>
        <table class="zero-config table table-hover mt-5">
            <thead class="thead-dark">
                <th style="width: 5%;">S.NO</th>
                <th style="width: 8%;">Book ID</th>
                <th style="width: 10%;">Title</th>
                <th style="width: 10%;">Regional Title</th>
                <th style="width: 10%;">Author</th>
                <th style="width: 5%;">InDesign readiness</th>
                <th style="width: 15%;">Rack stock</th>
                <th style="width: 15%;">Ledger Stock</th>
                <th style="width: 25%;" class="text-center">Actions</th>
            </thead>
            <tbody>
                <?php 
                $i=1;
                $selectedOption = $_GET['filter'] ?? 'all';

                foreach($paperback_books as $books) {
                    if (($selectedOption === 'all') || ($selectedOption === 'not_ready' && $books['paper_back_readiness_flag'] == 0)) {
                ?>
                        <tr>
                        <td><?php echo $i++ ?></td>
                        <td><a href="<?= base_url('pustaka_paperback/paperback_ledger_books_details/' .$books['book_id']) ?>" target="_blank"><?php echo $books['book_id'] ?></a></td>
                        <td><?php echo $books['book_title'] ?></td>
                        <td><?php echo $books['regional_book_title'] ?></td>
                        <td><?php echo $books['author_name'] ?></td>
                        <td><b><?php
                        if ($books['paper_back_readiness_flag'] == 1) {
                            echo '<span style="color: green;">Ready</span>';
                        } else {
                            echo '<span style="color: Red;">Not Ready</span>';
                        }
                        ?></b>
                        </td>
                        <td>
                            Total Quantity: <strong><?php echo $books['quantity'] ?></strong> <br>
                            Book Fair: <strong><?php echo $books['bookfair'] ?></strong><br>
                            stock in hand: <strong><?php echo $books['stock_in_hand'] ?></strong><br>
                        </td>
                        <td>
                            Stock In:<strong><?php echo $books['stock_in'] ?></strong><br>
                            Stock Out:<strong><?php echo $books['stock_out'] ?></strong> <br>
                            Available:<strong><?php echo $books['ledger_balance'] ?></strong> <br>
                        </td>
                        <td class="text-center">
                            <?php
                                   if (($books['stock_in_hand'] == 0) && ($books['bookfair'] == 0) && ($books['quantity'] == 0) &&
                                   ($books['ledger_balance'] == 0) && ($books['stock_out'] == 0) && ($books['stock_in'] == 0)) 
                                   {
                                        // Both Stock in Hand and Available are 0 or null
                                        echo '<div class="alert alert-warning mb-4" role="alert">
                                             <strong>No Stock and Transactions!</strong>
                                        </div>';
                                    } else if ($books['quantity'] == $books['ledger_balance']) {
                                        echo '<div class="alert alert-success" role="alert">
                                            <h6 style="color:green; text-align: center;"> <strong>Matched!</strong> Total Quantity is equal to Available Stock.</h6>
                                        </div>';
                                    }else if ($books['quantity'] > $books['ledger_balance']) {
                                        echo '<div class="alert alert-danger" role="alert">
                                            <h6 style="color:red; text-align: center;"><strong>Mismatch!</strong> Total Quantity is greater than Available Stock.</h6>
                                        </div>';
                                    } else {
                                        echo '<div class="alert alert-primary" role="alert">
                                            <h6 style="color:blue; text-align: center;"> <strong>Mismatch!</strong>Total Quantity is less than Available Stock.</h6>
                                        </div>';
                                    }   
                                ?>
                        </td>
                    </tr>

                <?php
                    }else if($selectedOption === 'ready' && $books['paper_back_readiness_flag'] == 1){
                        ?>
                        <tr>
                        <td><?php echo $i++ ?></td>
                        <td><a href="<?= base_url('pustaka_paperback/paperback_ledger_books_details/' .$books['book_id']) ?>" target="_blank"><?php echo $books['book_id'] ?></a></td>
                        <td><?php echo $books['book_title'] ?></td>
                        <td><?php echo $books['regional_book_title'] ?></td>
                        <td><?php echo $books['author_name'] ?></td>
                        <td><b><?php
                        if ($books['paper_back_readiness_flag'] == 1) {
                            echo '<span style="color: green;">Ready</span>';
                        } else {
                            echo '<span style="color: Red;">Not Ready</span>';
                        }
                        ?></b>
                        </td>
                        <td>
                            Total Quantity: <strong><?php echo $books['quantity'] ?></strong> <br>
                            Book Fair: <strong><?php echo $books['bookfair'] ?></strong><br>
                            stock in hand: <strong><?php echo $books['stock_in_hand'] ?></strong><br>
                        </td>
                        <td>
                            Stock In:<strong><?php echo $books['stock_in'] ?></strong><br>
                            Stock Out:<strong><?php echo $books['stock_out'] ?></strong> <br>
                            Available:<strong><?php echo $books['ledger_balance'] ?></strong> <br>
                        </td>
                        <td class="text-center">
                            <?php
                                   if (($books['stock_in_hand'] == 0) && ($books['bookfair'] == 0) && ($books['quantity'] == 0) &&
                                   ($books['ledger_balance'] == 0) && ($books['stock_out'] == 0) && ($books['stock_in'] == 0)) 
                                   {
                                        // Both Stock in Hand and Available are 0 or null
                                        echo '<div class="alert alert-warning mb-4" role="alert">
                                             <strong>No Stock and Transactions!</strong>
                                        </div>';
                                    } else if ($books['quantity'] == $books['ledger_balance']) {
                                        echo '<div class="alert alert-success" role="alert">
                                            <h6 style="color:green; text-align: center;"> <strong>Matched!</strong> Current Stock is equal to Available Stock.</h6>
                                        </div>';
                                    }else if ($books['quantity'] > $books['ledger_balance']) {
                                        echo '<div class="alert alert-danger" role="alert">
                                            <h6 style="color:red; text-align: center;"><strong>Mismatch!</strong>  Stock in Hand is greater than Available Stock.</h6>
                                        </div>';
                                    } else {
                                        echo '<div class="alert alert-primary" role="alert">
                                            <h6 style="color:blue; text-align: center;"> <strong>Mismatch!</strong> Stock in Hand is less than Available Stock.</h6>
                                        </div>';
                                    }   
                                ?>
                        </td>
                    </tr>
                    <?php
                    }else if($selectedOption === 'not_ready' && $books['paper_back_readiness_flag'] == 0){
                        ?>
                        <tr>
                        <td><?php echo $i++ ?></td>
                        <td><a href="<?= base_url('pustaka_paperback/paperback_ledger_books_details/' .$books['book_id']) ?>" target="_blank"><?php echo $books['book_id'] ?></a></td>
                        <td><?php echo $books['book_title'] ?></td>
                        <td><?php echo $books['regional_book_title'] ?></td>
                        <td><?php echo $books['author_name'] ?></td>
                        <td><b><?php
                        if ($books['paper_back_readiness_flag'] == 1) {
                            echo '<span style="color: green;">Ready</span>';
                        } else {
                            echo '<span style="color: Red;">Not Ready</span>';
                        }
                        ?></b>
                        </td>
                        <td>
                            Total Quantity: <strong><?php echo $books['quantity'] ?></strong> <br>
                            Book Fair: <strong><?php echo $books['bookfair'] ?></strong><br>
                            stock in hand: <strong><?php echo $books['stock_in_hand'] ?></strong><br>
                        </td>
                        <td>
                            Stock In:<strong><?php echo $books['stock_in'] ?></strong><br>
                            Stock Out:<strong><?php echo $books['stock_out'] ?></strong> <br>
                            Available:<strong><?php echo $books['ledger_balance'] ?></strong> <br>
                        </td>
                        <td class="text-center">
                            <?php
                                   if (($books['stock_in_hand'] == 0) && ($books['bookfair'] == 0) && ($books['quantity'] == 0) &&
                                   ($books['ledger_balance'] == 0) && ($books['stock_out'] == 0) && ($books['stock_in'] == 0)) 
                                   {
                                        // Both Stock in Hand and Available are 0 or null
                                        echo '<div class="alert alert-warning mb-4" role="alert">
                                             <strong>No Stock and Transactions!</strong>
                                        </div>';
                                    } else if ($books['quantity'] == $books['ledger_balance']) {
                                        echo '<div class="alert alert-success" role="alert">
                                            <h6 style="color:green; text-align: center;"> <strong>Matched!</strong> Current Stock is equal to Available Stock.</h6>
                                        </div>';
                                    }else if ($books['quantity'] > $books['ledger_balance']) {
                                        echo '<div class="alert alert-danger" role="alert">
                                            <h6 style="color:red; text-align: center;"><strong>Mismatch!</strong>  Stock in Hand is greater than Available Stock.</h6>
                                        </div>';
                                    } else {
                                        echo '<div class="alert alert-primary" role="alert">
                                            <h6 style="color:blue; text-align: center;"> <strong>Mismatch!</strong> Stock in Hand is less than Available Stock.</h6>
                                        </div>';
                                    }   
                                ?>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>    
            </tbody>
        </table>
    </div>
</div>
