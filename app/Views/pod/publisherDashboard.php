<?= $this->extend('layout/layout1'); ?>

<?= $this->section('content'); ?>
	<div class="layout-px-spacing">
        <div class="mt-3 row">
            <div class="col-10 text-center">
                
            </div>
            <div class="col-2">
                <a href="<?php echo base_url().'pod/publisheradd' ?>" class="btn btn-success">ADD PUBLISHER</a>
            </div>
        </div>
        <br>
        <table class="table table-bordered table-hover zero-config">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Publisher Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Contact Person</th>
                    <th>Contact Mobile</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $publisher_data=$publisher_data['publisher'];
                for ($i = 0; $i < sizeof($publisher_data); $i++) { ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $publisher_data[$i]['publisher_name'] ?></td>
                        <td><?php echo $publisher_data[$i]['address'] ?></td>
                        <td><?php echo $publisher_data[$i]['city'] ?></td>
                        <td><?php echo $publisher_data[$i]['contact_person'] ?></td>
                        <td><?php echo $publisher_data[$i]['contact_mobile'] ?></td>
                        <td><?php echo $publisher_data[$i]['create_date'] ?></td>
                        <td>
                            <ul class="table-controls">
                                <li>
                                    <a class="rounded text-danger bs-tooltip" title="Edit Publisher" target="_blank" href="<?php echo base_url().'pod/edit_publisher/'.$publisher_data[$i]['id'] ?>" data-toggle="tooltip" data-placement="top">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="edit" class="svg-inline--fa fa-edit fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path fill="#2196f3" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="rounded text-danger bs-tooltip" title="View Publisher" target="_blank" href="<?php echo base_url().'pod/view_publisher/'.$publisher_data[$i]['id'] ?>" data-toggle="tooltip" data-placement="right">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?= $this->endSection(); ?>
