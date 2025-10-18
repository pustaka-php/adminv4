<?= $this->extend('layout/layout1'); ?>
<?= $this->section('content'); ?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Author Details - <?php echo $author_details['basic_author_details']['author_name'] ?> </h3>
				<br>
            </div>
        </div>
		<br>
		<br>
        <div class="row mb-4 mt-3">
            <div class="col-sm-9 col-12 order-sm-0 order-1">
                <div class="tab-content" id="v-right-pills-tabContent">
                    <!-- Basic Author Details Tab -->
                    <div class="tab-pane fade show active" id="basic_author_details" role="tabpanel" aria-labelledby="v-right-pills-profile-tab">
                        <div class="media">
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-6">
                                        <blockquote class="blockquote">
                                            <h6>Email: <?php echo $author_details['basic_author_details']['email'] ?></h6>
                                            <h6 class="mt-2">Mobile: <?php echo $author_details['basic_author_details']['mobile'] ?></h6>
                                            <h6 class="mt-2">Password: <?php echo $author_details['user_password'] ?></h6>
											<br>
                                            <h6 class="mt-2">Address: <?php echo $author_details['basic_author_details']['author_address'] ?></h6>
                                        </blockquote>
                                    </div>
                                    <div class="col-6">
                                        <blockquote class="blockquote">
                                            <h6>Bank Account Number: <?php echo $author_details['basic_author_details']['bank_acc_no'] ?></h6>
											<br>
                                            <h6 class="mt-2">IFSC Code: <?php echo $author_details['basic_author_details']['ifsc_code'] ?></h6>
											<br>
                                            <h6 class="mt-2">PAN Number: <?php echo $author_details['basic_author_details']['pan_number'] ?></h6>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <blockquote class="blockquote">
                                            <h6>FaceBook: <?php echo $author_details['basic_author_details']['fb_url'] ?></h6>
                                            <h6 class="mt-2">Twitter: <?php echo $author_details['basic_author_details']['twitter_url'] ?></h6>
                                            <h6 class="mt-2">Blog: <?php echo $author_details['basic_author_details']['blog_url'] ?></h6>
                                        </blockquote>
                                    </div>
									<div class="col-6">
                                        <blockquote class="blockquote">
										<h6 class="mt-2">Aggreement Details: <?php echo $author_details['basic_author_details']['agreement_details'] ?></h6>
                                        </blockquote>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-6">
                                        <blockquote class="blockquote">
										<h6 class="mt-2">Copyright Owner: <?php echo $author_details['basic_author_details']['copy_right_owner_name'] ?></h6>
										<br>
										<h6 class="mt-2">Publisher Name: <?php echo $author_details['basic_author_details']['publisher_names'] ?></h6>
                                        </blockquote>
                                    </div>
                                </div>
								
                                <blockquote class="blockquote">
                                    <h6>Description: <?php echo $author_details['basic_author_details']['description'] ?></h6>
                                </blockquote>
                            </div>
                        </div>
                    </div>
					<div class="tab-pane fade" id="author_book_details" role="tabpanel" aria-labelledby="v-right-pills-profile-tab">
						<div class="media">
							<div class="media-body">
								<ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#books_tab" role="tab" aria-controls="pills-home" aria-selected="true">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
												<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
												<path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
											</svg>
											E-Books
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#audio_books_tab" role="tab" aria-controls="pills-contact" aria-selected="false">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-headphones">
												<path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
												<path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
											</svg>
											Audio Books
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-paper-tab" data-toggle="pill" href="#paperback_books_tab" role="tab" aria-controls="pills-paper" aria-selected="false">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book">
												<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
												<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
											</svg>
											Paperbacks
										</a>
									</li>
								</ul>
								<div class="tab-content" id="pills-tabContent">
									<!-- E-Books Tab -->
									<div class="tab-pane fade show active" id="books_tab" role="tabpanel" aria-labelledby="pills-home-tab">
										<div class="row">
											<div class="col-3">
												<blockquote class="blockquote">
													<center>
														<h5>Total E-Books</h5>
														<hr>
														<h4><?php echo $ebook_count['total_count']['ebook_count']; ?></h4>
													</center>
												</blockquote>
											</div>
											<div class="col-3">
												<blockquote class="blockquote">
													<center>
														<h5>Active E-Books</h5>
														<hr>
														<h4><?php echo $ebook_count['active']['ebook_count']; ?></h4>
													</center>
												</blockquote>
											</div>
											<div class="col-3">
												<blockquote class="blockquote">
													<center>
														<h5>Inactive E-Books</h5>
														<hr>
														<h4><?php echo $ebook_count['inactive']['ebook_count']; ?></h4>
													</center>
												</blockquote>
											</div>
											<div class="col-3">
												<blockquote class="blockquote">
													<center>
														<h5>Suspended E-Books</h5>
														<hr>
														<h4><?php echo $ebook_count['suspended']['ebook_count']; ?></h4>
													</center>
												</blockquote>
											</div>
										</div>
									</div>

									<!-- Audio Books -->
									<div class="tab-pane fade" id="audio_books_tab" role="tabpanel" aria-labelledby="pills-contact-tab">
										<?php if ($audio_count['total_count']['audio_count'] > 0) { ?>
											<div class="row">
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Total Audio Books</h5>
															<hr>
															<h4><?php echo $audio_count['total_count']['audio_count']; ?></h4>
														</center>
													</blockquote>
												</div>
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Active</h5>
															<hr>
															<h4><?php echo $audio_count['active']['audio_count']; ?></h4>
														</center>
													</blockquote>
												</div>
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Inactive</h5>
															<hr>
															<h4><?php echo $audio_count['inactive']['audio_count']; ?></h4>
														</center>
													</blockquote>
												</div>
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Suspended</h5>
															<hr>
															<h4><?php echo $audio_count['suspended']['audio_count']; ?></h4>
														</center>
													</blockquote>
												</div>
											</div>
										<?php } else { ?>
											<center>
												<h3>No Audio Books</h3>
											</center>
										<?php } ?>
									</div>

									<!-- Paperback Books -->
									<div class="tab-pane fade" id="paperback_books_tab" role="tabpanel" aria-labelledby="pills-paper-tab">
										<?php if (isset($paperback['total_counts']) && $paperback['total_counts']['paperback_count'] > 0) { ?>
											<div class="row">
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Total Paperbacks</h5>
															<hr>
															<h4><?php echo $paperback['total_counts']['paperback_count']; ?></h4>
														</center>
													</blockquote>
												</div>
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Active</h5>
															<hr>
															<h4><?php echo $paperback['active']['paperback_count']; ?></h4>
														</center>
													</blockquote>
												</div>
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Inactive</h5>
															<hr>
															<h4><?php echo $paperback['inactive']['paperback_count']; ?></h4>
														</center>
													</blockquote>
												</div>
												<div class="col-3">
													<blockquote class="blockquote">
														<center>
															<h5>Suspended</h5>
															<hr>
															<h4><?php echo $paperback['suspended']['paperback_count']; ?></h4>
														</center>
													</blockquote>
												</div>
											</div>
										<?php } else { ?>
											<center>
												<h3>No Paperbacks</h3>
											</center>
										<?php } ?>
									</div>
									<br><br>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="author_channel_details" role="tabpanel" aria-labelledby="v-right-pills-settings-tab">
						<div class="media">
							<div class="media-body">
								<div class="row">
									<div class="col-2 col-3">
									<a href="https://www.pustaka.co.in/home/author/<?php echo $author_details['basic_author_details']['url_name']; ?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['pustaka']; ?></h1>
													</div>
													<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 32 32">
													<g>
														<path d="M110.163,252.806c-15.669-18.493-24.039-44.673-24.136-77.765c0-97.714,73.188-149.004,162.728-149.004
														c95.961-1.557,152.604,47.69,179.37,68.712l-49.149,70.172l-36.303-23.943l26.181-37.566
														c-35.524-23.359-77.276-35.524-119.71-34.844C199.8,67.789,140.431,95.041,140.431,142.73
														c0,18.199,10.901,20.146,27.835,15.182c22.677-5.159,40.779,0.583,54.307,13.626
														c25.695,23.65,22.58,65.791-0.681,89.442C193.474,289.691,138.971,287.55,110.163,252.806z
														M419.364,258.547c-15.085-18.297-37.86-28.613-61.509-27.834c-37.08-1.947-69.198,27.25-68.614,65.404
														c-0.681,16.35,5.84,32.115,17.908,43.113c13.723,13.528,32.116,19.175,54.793,14.015
														c16.936-4.963,27.836-3.016,27.836,15.184c0,4.184-0.487,8.272-1.361,12.359
														c-16.255,39.807-57.909,62.678-118.155,62.678c-50.51,0.196-99.66-15.96-140.244-46.034l32.799-38.346l-34.648-26.669
														l-59.173,69.881l14.988,13.431c51.096,45.551,117.18,70.561,185.599,70.27
														c50.026,0,91.877-10.219,130.028-42.921C455.18,393.051,452.359,297.867,419.364,258.547z" fill="#00858E"/>
													</g>
													</svg>
													<p class="mt-2 ico-counter-text">Pustaka</p>
													<a href="<?php echo base_url()."author/author_pustaka_details/".$author_id ?>"class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-2 col-3">
									<a href="<?php echo $author_details['basic_author_details']['amazon_link']?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['amazon']; ?></h1>
													</div>
													<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 32 32" fill-rule="evenodd">
													<path d="M28.312 28.26C25.003 30.7 20.208 32 16.08 32c-5.8 0-11.002-2.14-14.945-5.703-.3-.28-.032-.662.34-.444C5.73 28.33 11 29.82 16.426 29.82a29.73 29.73 0 0 0 11.406-2.332c.56-.238 1.03.367.48.773m1.376-1.575c-.42-.54-2.796-.255-3.86-.13-.325.04-.374-.243-.082-.446 1.9-1.33 4.994-.947 5.356-.5s-.094 3.56-1.87 5.044c-.273.228-.533.107-.4-.196.4-.996 1.294-3.23.87-3.772" fill="#f90"/>
													<path d="M18.43 13.864c0 1.692.043 3.103-.812 4.605-.7 1.22-1.8 1.973-3.005 1.973-1.667 0-2.644-1.27-2.644-3.145 0-3.7 3.316-4.373 6.462-4.373v.94m4.38 10.584c-.287.257-.702.275-1.026.104-1.44-1.197-1.704-1.753-2.492-2.895-2.382 2.43-4.074 3.157-7.158 3.157-3.658 0-6.498-2.254-6.498-6.767 0-3.524 1.905-5.924 4.63-7.097 2.357-1.038 5.65-1.22 8.165-1.5V8.9c0-1.032.08-2.254-.53-3.145-.525-.8-1.54-1.13-2.437-1.13-1.655 0-3.127.85-3.487 2.608-.073.4-.36.776-.757.794L7 7.555c-.354-.08-.75-.366-.647-.9C7.328 1.54 11.945 0 16.074 0c2.113 0 4.874.562 6.54 2.162 2.113 1.973 1.912 4.605 1.912 7.47V16.4c0 2.034.843 2.925 1.637 4.025.275.4.336.86-.018 1.154a184.26 184.26 0 0 0-3.328 2.883l-.006-.012" fill="#221f1f"/>
													<path d="M-29.65 355.868c-35 25.797-85.73 39.56-129.406 39.56-61.243 0-116.377-22.65-158.088-60.325-3.277-2.963-.34-7 3.592-4.693 45.014 26.2 100.673 41.947 158.166 41.947 38.775 0 81.43-8.022 120.65-24.67 5.925-2.517 10.88 3.88 5.086 8.18m14.55-16.647c-4.457-5.715-29.573-2.7-40.846-1.363-3.434.42-3.96-2.57-.865-4.72 20.003-14.078 52.827-10.015 56.655-5.296 3.828 4.745-.996 37.647-19.794 53.35-2.884 2.412-5.637 1.127-4.352-2.07 4.22-10.54 13.685-34.16 9.202-39.902" fill="#f90"/>
													<path d="M-55.16 233.75v-13.685c0-2.07 1.573-3.46 3.46-3.46H9.57c1.966 0 3.54 1.416 3.54 3.46v11.72c-.026 1.966-1.678 4.536-4.614 8.6l-31.75 45.33c11.798-.288 24.25 1.468 34.947 7.498 2.412 1.363 3.067 3.356 3.25 5.322v14.603c0 1.992-2.202 4.326-4.5 3.12-18.85-9.884-43.887-10.96-64.73.105-2.124 1.154-4.352-1.154-4.352-3.146v-13.87c0-2.228.026-6.03 2.255-9.412l36.782-52.748h-32c-1.966 0-3.54-1.4-3.54-3.434m-223.495 85.385h-18.64c-1.783-.13-3.198-1.468-3.33-3.172V220.3c0-1.914 1.6-3.434 3.592-3.434h17.382c1.8.08 3.25 1.468 3.382 3.198v12.505h.34c4.536-12.086 13.056-17.723 24.54-17.723 11.666 0 18.955 5.637 24.198 17.723 4.5-12.086 14.76-17.723 25.745-17.723 7.813 0 16.36 3.225 21.576 10.46 5.9 8.05 4.693 19.74 4.693 29.992l-.026 60.377c0 1.914-1.6 3.46-3.592 3.46h-18.614c-1.86-.13-3.356-1.625-3.356-3.46v-50.703c0-4.037.367-14.105-.524-17.932-1.4-6.423-5.558-8.232-10.96-8.232-4.5 0-9.228 3.015-11.142 7.84s-1.73 12.9-1.73 18.326v50.703c0 1.914-1.6 3.46-3.592 3.46h-18.614c-1.888-.13-3.356-1.625-3.356-3.46l-.026-50.703c0-10.67 1.757-26.374-11.483-26.374-13.397 0-12.872 15.3-12.872 26.374v50.703c0 1.914-1.6 3.46-3.592 3.46m344.496-104.3c27.66 0 42.63 23.752 42.63 53.954 0 29.18-16.543 52.33-42.63 52.33-27.16 0-41.947-23.752-41.947-53.35 0-29.782 14.97-52.932 41.947-52.932m.157 19.532c-13.738 0-14.603 18.72-14.603 30.385 0 11.693-.184 36.65 14.445 36.65 14.445 0 15.127-20.135 15.127-32.404 0-8.075-.34-17.297-13.174-17.296" fill="#f90"/>
													</svg>
													<p class="mt-2 ico-counter-text">Amazon</p>
													<a href="<?php echo base_url()."author/author_channel/".$author_id ?>"class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-2 col-3">
									<a href="<?php echo $author_details['basic_author_details']['googlebooks_link']?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['google']; ?></h1>
													</div>
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="64px" height="64px">
													<path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
													<path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
													<path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
													<path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
													</svg>
													<p class="mt-2 ico-counter-text">Google</p>
													<a href="<?php echo base_url()."author/authors_google_details/".$author_id ?>" class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-2 col-3">
									<a href="<?php echo $author_details['basic_author_details']['overdrive_link']?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['overdrive']; ?></h1>
													</div>
													<!-- <img src="<?php echo base_url(); ?>assets/img/overdrive-logo-md.png" alt="widget-card-2"> -->
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64">
													<circle cx="32" cy="32" r="30" fill="#006595"/>
													<path d="M32 10c12.2 0 22 9.8 22 22s-9.8 22-22 22S10 44.2 10 32 19.8 10 32 10z" fill="#fff"/>
													<polygon points="32,18 27,29 37,29" fill="#006595"/>
													<polygon points="32,46 37,35 27,35" fill="#006595"/>
													</svg>
													<p class="mt-2 ico-counter-text">Overdrive</p>
													<a href="<?php echo base_url()."author/author_overdrive_details/".$author_id ?>" class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-2 col-3 mt-4">
									<a href="<?php echo $author_details['basic_author_details']['scribd_link']?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['scribd']; ?></h1>
													</div>
													<?xml version="1.0" encoding="UTF-8"?>
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 512 512" version="1.1">
													<g>
														<path d="M110.163,252.806c-15.669-18.493-24.039-44.673-24.136-77.765c0-97.714,73.188-149.004,162.728-149.004
														c95.961-1.557,152.604,47.69,179.37,68.712l-49.149,70.172l-36.303-23.943l26.181-37.566
														c-35.524-23.359-77.276-35.524-119.71-34.844C199.8,67.789,140.431,95.041,140.431,142.73
														c0,18.199,10.901,20.146,27.835,15.182c22.677-5.159,40.779,0.583,54.307,13.626
														c25.695,23.65,22.58,65.791-0.681,89.442C193.474,289.691,138.971,287.55,110.163,252.806z
														M419.364,258.547c-15.085-18.297-37.86-28.613-61.509-27.834c-37.08-1.947-69.198,27.25-68.614,65.404
														c-0.681,16.35,5.84,32.115,17.908,43.113c13.723,13.528,32.116,19.175,54.793,14.015
														c16.936-4.963,27.836-3.016,27.836,15.184c0,4.184-0.487,8.272-1.361,12.359
														c-16.255,39.807-57.909,62.678-118.155,62.678c-50.51,0.196-99.66-15.96-140.244-46.034l32.799-38.346l-34.648-26.669
														l-59.173,69.881l14.988,13.431c51.096,45.551,117.18,70.561,185.599,70.27
														c50.026,0,91.877-10.219,130.028-42.921C455.18,393.051,452.359,297.867,419.364,258.547z" fill="#00858E"/>
													</g>
													</svg>
													<p class="mt-2 ico-counter-text">Scribd</p>
													<a href="<?php echo base_url()."author/author_scribd_details/".$author_id ?>" class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
									<br>
									<div class="col-2 col-3 mt-4">
									<a href="<?php echo $author_details['basic_author_details']['storytel_link']?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['storytel']; ?></h1>
													</div>
													<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="-1.62 -70.34 743.10309931 869.74" fill="#ff5c28">
													<path d="m710.06 382.67c30.35-166.61-71.06-315.65-229.85-365.14-282.04-87.87-481.83 170.68-479.55 431.27 1.9 210.57 46.91 350.57 46.94 350.6-1.99-6.23 53.28-35.39 59.66-38.66 5.43-2.76 10.95-5.4 16.5-7.95s11.13-4.98 16.79-7.3c5.64-2.34 11.34-4.53 17.06-6.64 5.73-2.11 11.51-4.09 17.3-5.99 47.53-15.85 96.75-25.81 145.56-36.73 152.62-34.86 316.54-100.78 374.93-259.26a323.894 323.894 0 0 0 14.63-54.2z" fill="#ff5c28"/>
													</svg>
													<p class="mt-2 ico-counter-text">Storytel</p>
													<a href="<?php echo base_url()."author/author_storytel_details/".$author_id?>"class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-2 mt-4 col-3">
									<a href="<?php echo $author_details['basic_author_details']['pratilipi_link']?>"target="_blank">
										<div class="widget-content widget-content-area text-center">
											<div class="icon--counter-container">
												<div class="counter-container">
													<div class="counter-content">
														<h1 class="ico-counter1 ico-counter"><?php echo $author_details['channel_wise_cnt']['pratilipi']; ?></h1>
													</div>
													<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="-1.62 -70.34 743.10309931 869.74" fill="#ff5c28">
													<!-- <path d="m710.06 382.67c30.35-166.61-71.06-315.65-229.85-365.14-282.04-87.87-481.83 170.68-479.55 431.27 1.9 210.57 46.91 350.57 46.94 350.6-1.99-6.23 53.28-35.39 59.66-38.66 5.43-2.76 10.95-5.4 16.5-7.95s11.13-4.98 16.79-7.3c5.64-2.34 11.34-4.53 17.06-6.64 5.73-2.11 11.51-4.09 17.3-5.99 47.53-15.85 96.75-25.81 145.56-36.73 152.62-34.86 316.54-100.78 374.93-259.26a323.894 323.894 0 0 0 14.63-54.2z" fill="#ff5c28"/> -->
													</svg>
													<p class="mt-2 ico-counter-text">Pratilipi</p>
													<a href="<?php echo base_url()."author/author_pratilipi_details/".$author_id ?>" class="btn btn-large btn-dark mt-2">View</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- // author royalty details // -->
					<div class="tab-pane fade" id="author_royalty_details" role="tabpanel" aria-labelledby="v-right-pills-profile-tab">
                        <div class="media">
                            <div class="media-body">
                                <?php 
                                $allowed_user_type = 4; 
                                $user_type = $_SESSION['user_type'] ?? null;
                                ?>
                                <div class="row">
                                    <div class="col-md-3"> 
                                        <div class="card text-center p-2" style="background-color: #e6ffcc; border: 1px solid #e0e0e0;">
                                            <div class="card-body">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up">
                                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                    <polyline points="17 6 23 6 23 12"></polyline>
                                                </svg>
                                                <h5 class="mt-2" style="font-size: 1rem;">Total Revenue</h5> 
                                                <hr>
                                                <h4 style="font-size: 1.2rem;"> 
                                                    ₹<?php echo ($user_type == $allowed_user_type) 
                                                        ? number_format($royalty['details'][0]['total_revenue'] ?? 0, 2) 
                                                        : '###'; ?>
                                                </h4>
                                                <br><br>
                                                <h7>Note : Pustaka revenue is not included</h7>
                                                <br><br><br><br><br><br>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="card text-center p-2" style="background-color: #ffe6f2; border: 1px solid #e0e0e0;">
                                            <div class="card-body">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="30" viewBox="0 -2 24 28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="square">
                                                    <line x1="12" y1="2" x2="12" y2="23"></line>
                                                    <path d="M17 5H9a5 5 0 0 0 0 10h6a5 5 0 0 1 0 10H7"></path>
                                                </svg>
                                                <br>
                                                <h5 class="mt-2" style="font-size: 1rem;">Total Royalty</h5><br>
                                                <h4 style="font-size: 1.2rem;"> 
                                                    ₹<?php echo ($user_type == $allowed_user_type) 
                                                        ? number_format($royalty['details'][0]['total_royalty'] ?? 0, 2) 
                                                        : '###'; ?>
                                                </h4>
                                                <br>
                                                <h5 class="mt-2" style="font-size: 1rem;">Royalty Percentage</h5> 
                                                <h4 style="font-size: 1.2rem;"> 
                                                    <?php 
                                                    if ($user_type == $allowed_user_type) {
                                                        $total_revenue = $royalty['details'][0]['total_revenue'] ?? 0;
                                                        $total_royalty = $royalty['details'][0]['total_royalty'] ?? 0;
                                                        $profit_percentage = ($total_revenue > 0) ? ($total_royalty / $total_revenue) * 100 : 0;
                                                        echo number_format($profit_percentage, 2) . '%';
                                                    } else {
                                                        echo '###';
                                                    }
                                                    ?>
                                                </h4>
                                                <h7>Note : Paperback royalty is not included</h7>
                                                <br><br><br><br><br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4"> 
                                        <div class="card text-center p-2" style="background-color: #cceeff; border: 1px solid #e0e0e0;">
                                            <div class="card-body">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent">
                                                    <line x1="19" y1="5" x2="5" y2="19"></line>
                                                    <circle cx="6.5" cy="6.5" r="2.5"></circle>
                                                    <circle cx="17.5" cy="17.5" r="2.5"></circle>
                                                </svg>
                                                <br><br>
                                                <h5 class="mt-2" style="font-size: 1rem;">Royalty Settlement</h5> 
                                                <br>
                                                <h5 style="font-size: 1.2rem;"> 
                                                    <?php 
                                                    if ($user_type == $allowed_user_type) {
                                                        $total_settlement = $author['total'][0]['total_settlement'] ?? 0;
                                                        $total_bonus_value = $author['total'][0]['total_bonus'] ?? 0;
                                                        $final_settlement = ($author['total'][0]['total_settlement'] ?? 0) - ($author['total'][0]['total_bonus'] ?? 0);
                                                        
                                                        echo "Settlement: ₹" . number_format($total_settlement, 2) . "<br><br>";
                                                        echo "Total Bonus: ₹" . number_format($total_bonus_value, 2) . "<br><br>";
                                                        echo "<h5>(Settlement - Bonus Value) : ₹" . number_format($final_settlement, 2) . "</h5>"; 

                                                    } else {
                                                        echo '###';
                                                    }
                                                    ?>
                                                </h5>
                                                <br><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <?php 
                                $allowed_user_type = 4; 
                                $user_type = $_SESSION['user_type'] ?? null;
                                ?>
                                <div class="table-responsive mt-4">
									<table class="table contextual-table">
										<thead>
											<tr class="table-secondary">
												<th class="text-center">#</th>
												<th>Type</th>
												<th>Total Revenue</th>
												<th>Total Royalty</th>
												<th>Revenue Share %</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$types = ['ebook' => 'table-primary', 'audiobook' => 'table-success', 'paperback' => 'table-warning'];
											$count = 1;
											$grand_total_revenue = 0;
											$grand_total_royalty = 0;

											foreach ($types as $type => $row_class) {
												$total_revenue = $royalty[$type][0]['total_revenue'] ?? 0;
												$total_royalty = $royalty[$type][0]['total_royalty'] ?? 0;
												$profit_percentage = ($total_revenue > 0) ? ($total_royalty / $total_revenue) * 100 : 0;

												$grand_total_revenue += $total_revenue;
												$grand_total_royalty += $total_royalty;
											?>
												<tr class="<?php echo $row_class; ?>">
													<td class="text-center"><?php echo $count++; ?></td>
													<td><?php echo ucfirst($type); ?></td>
													<td><?php echo ($user_type == $allowed_user_type) ? '₹' . number_format($total_revenue, 2) : '#'; ?></td>
													<td><?php echo ($user_type == $allowed_user_type) ? '₹' . number_format($total_royalty, 2) : '#'; ?></td>
													<td><?php echo ($user_type == $allowed_user_type) ? number_format($profit_percentage, 2) . '%' : '#'; ?></td>
												</tr>
											<?php } ?>
											<tr class="table-danger">
												<td class="text-center" colspan="2"><strong>Total</strong></td>
												<td><strong><?php echo ($user_type == $allowed_user_type) ? '₹' . number_format($grand_total_revenue, 2) : '#'; ?></strong></td>
												<td><strong><?php echo ($user_type == $allowed_user_type) ? '₹' . number_format($grand_total_royalty, 2) : '#'; ?></strong></td>
												<td><strong><?php echo ($grand_total_revenue > 0) ? number_format(($grand_total_royalty / $grand_total_revenue) * 100, 2) . '%' : '#'; ?></strong></td>
											</tr>
										</tbody>
									</table>
								</div>
                                <br>
                                <?php 
								$allowed_user_type = 4; 
								$user_type = $_SESSION['user_type'] ?? null;
								?>
								<div id="content" class="main-content">
									<div class="page-header">
										<div class="page-title">
											<h3><center>Pending Revenue & Royalty</center> </h3>
											<br>
										</div>
									</div>
									<div style="width: 1100px; margin: auto; margin-left: -60px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; overflow: hidden; background: white;">
										<table style="width: 100%; border-collapse: collapse; border: 2px solid #ccc;">
											<tr>
												<th style="background: #343a40; color: white; font-size: 18px; padding: 15px; border: 2px solid #ccc; text-align: center;">Pending Revenue</th>
												<th style="background: #343a40; color: white; font-size: 18px; padding: 15px; border: 2px solid #ccc; text-align: center;">Pending Royalty</th>
											</tr>
											<tr>
												<td style="font-size: 16px; font-weight: bold; background-color: #C1E1C1; color: #444; padding: 15px; text-align: center; border: 2px solid #ccc;">
													<?php 
														if (isset($user_type) && $user_type == 4) {
															echo "₹" . number_format($pending['author_pending'][0]['total_revenue'] ?? 0, 2);
														} else {
															echo "#";
														}
													?>
												</td>
												<td style="font-size: 16px; font-weight: bold; background-color: #C1E1C1; color: #444; padding: 15px; text-align: center; border: 2px solid #ccc;">
													<?php 
														if (isset($user_type) && $user_type == 4) {
															echo "₹" . number_format($pending['author_pending'][0]['total_royalty'] ?? 0, 2);
														} else {
															echo "#";
														}
													?>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<br>
                                <?php 
								$user_type = $_SESSION['user_type'] ?? 0; 
								?>
								<div id="content" class="main-content">
									<div class="page-header">
										<div class="page-title">
											<h3><center>Channel Wise Pending</center></h3>
										</div>
									</div>
									<br><br>
									<table class="table table-bordered" style="width: 1100px; margin-left: -60px;">
										<thead class="thead-dark">
											<tr>
												<th>Channel</th>
												<th>Total Pending Revenue</th>
												<th>Total Pending Royalty</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($pending['channel_pending'])) { ?>
												<?php foreach ($pending['channel_pending'] as $row) { ?>
													<tr>
														<td style="width: 40%;"><?php echo ucfirst($row['channel']); ?></td>
														<td style="width: 40%;">
															<?php 
															echo ($user_type == 4) 
																? number_format($row['total_pending_revenue'], 2) 
																: '#'; 
															?>
														</td>
														<td style="width: 50%;">
															<?php 
															echo ($user_type == 4) 
																? number_format($row['total_pending_royalty'], 2) 
																: '#'; 
															?>
														</td>
													</tr>
												<?php } ?>
											<?php } else { ?>
												<tr>
													<td colspan="3">No pending data available.</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<br><br><br>
                                <div class="container mt-4">
                                    <ul class="nav nav-tabs" id="channelTabs" role="tablist">
                                        <?php 
                                        $channels = ['pustaka', 'amazon', 'overdrive', 'scribd', 'google', 'storytel', 'pratilipi', 'audible', 'kobo', 'kukufm', 'youtube'];
                                        foreach ($channels as $index => $channel): ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?php echo ($index === 0) ? 'active' : ''; ?>" 
                                                        id="<?php echo htmlspecialchars($channel); ?>-tab" 
                                                        data-bs-toggle="tab" 
                                                        data-bs-target="#<?php echo htmlspecialchars($channel); ?>" 
                                                        type="button" 
                                                        role="tab" 
                                                        aria-controls="<?php echo htmlspecialchars($channel); ?>" 
                                                        aria-selected="<?php echo ($index === 0) ? 'true' : 'false'; ?>">
                                                    <?php echo ucfirst(htmlspecialchars($channel)); ?>
                                                </button>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="tab-content mt-3" id="channelTabsContent">
                                        <?php 
                                        $user_type = $_SESSION['user_type'] ?? null; 

                                        foreach ($channels as $index => $channel): ?>
                                            <div class="tab-pane fade <?php echo ($index === 0) ? 'show active' : ''; ?>" 
                                                id="<?php echo htmlspecialchars($channel); ?>" 
                                                role="tabpanel" 
                                                aria-labelledby="<?php echo htmlspecialchars($channel); ?>-tab">
                                                <br>
                                                <br>
                                                <br>
                                                <center>
                                                    <h4>Month-Wise Chart</h4>
                                                </center>
                                                <div class="chart-container mt-4">
                                                    <canvas id="<?php echo htmlspecialchars($channel); ?>Chart"></canvas>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                                <script>
                                    let chartData = <?php echo json_encode($channel_chart); ?>;
                                    let userType = <?php echo json_encode($user_type); ?>; 
                                    let charts = {}; 

                                    function loadChart(channelName) {
                                        if (charts[channelName]) return; 

                                        let ctx = document.getElementById(channelName + "Chart").getContext('2d');
                                        let months = [], revenues = [], royalties = [];

                                        if (chartData[channelName] && chartData[channelName].length > 0) {
                                            chartData[channelName].forEach(row => {
                                                let period = row.year + '-' + (row.month < 10 ? '0' + row.month : row.month);
                                                months.push(period);
                                                revenues.push(parseFloat(row[channelName + "_revenue"] || 0));
                                                royalties.push(parseFloat(row[channelName + "_royalty"] || 0));
                                            });
                                        } else {
                                            months = ["No Data"];
                                            revenues = [0];
                                            royalties = [0];
                                        }

                                        charts[channelName] = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: months,
                                                datasets: [
                                                    {
                                                        label: "Revenue",
                                                        borderColor: "blue",
                                                        backgroundColor: "transparent",
                                                        fill: false,
                                                        data: revenues,
                                                        tension: 0.1,
                                                    },
                                                    {
                                                        label: "Royalty",
                                                        borderColor: "red",
                                                        backgroundColor: "transparent",
                                                        fill: false,
                                                        data: royalties,
                                                        tension: 0.1,
                                                    }
                                                ]
                                            },
                                            options: {
                                                responsive: true,
                                                scales: {
                                                    y: { beginAtZero: true }
                                                },
                                                plugins: {
                                                    tooltip: {
                                                        callbacks: {
                                                            label: function(context) {
                                                                let value = context.raw;
                                                                return userType == 4 ? value : '#';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    }

                                    document.addEventListener("DOMContentLoaded", function () {
                                        let firstChannel = "<?php echo $channels[0]; ?>";
                                        loadChart(firstChannel);

                                        document.querySelectorAll('.nav-link').forEach(tab => {
                                            tab.addEventListener('click', function () {
                                                let channelName = this.getAttribute('id').replace('-tab', '');
                                                loadChart(channelName);
                                            });
                                        });
                                    });
                                </script>
                                <br>
                                <br>
                                <br>
                                <h4 class="text-center"> Year-Wise Revenue & Royalty</h4>
                                <div class="container">
                                    <!-- <div id="content" class="main-content" style="overflow-y:auto;">
                                        <div class="media">
                                            <div class="media-body"> -->
                                                <div class="layout-px-spacing">
                                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#ebooks_tab" role="tab" aria-controls="pills-home" aria-selected="true" style="display: flex; align-items: center;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open" style="margin-right: 5px;">
                                                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                                                </svg>
                                                                E-Books
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#audiobooks_tab" role="tab" aria-controls="pills-contact" aria-selected="false" style="display: flex; align-items: center;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-headphones" style="margin-right: 5px;">
                                                                    <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                                                                    <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                                                                </svg>
                                                                Audio Books
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <style>
                                                        .table-bordered th, .table-bordered td {
                                                            border: 1px solid #000 !important; 
                                                            padding: 10px;
                                                            text-align: center;
                                                        }

                                                        .table thead th {
                                                            background-color: #DCEEF2; 
                                                            color: green;
                                                            text-align: center;
                                                        }

                                                        .table-container {
                                                            max-height: 1200px;
                                                            width:100%; 
                                                            overflow-x: auto;
                                                            overflow-y: auto; 
                                                            white-space: nowrap;
                                                        }
                                                    
                                                    </style>
                                                    <div class="tab-content">
                                                        <?php 
                                                        $ebook_details = $channel_wise['ebook_details'] ?? []; 
                                                        $audiobook_details = $channel_wise['audiobook_details'] ?? [];

                                                        function format_currency($amount, $user_type) {
                                                            return ($user_type == 4) ? '₹' . number_format($amount, 2) : '#';
                                                        }
                                                        ?>
                                                        <div class="tab-pane fade show active" id="ebooks_tab" role="tabpanel" aria-labelledby="pills-home-tab">
                                                            <div class="table-container">
                                                                <h4 class="text-center">📚 E-Books - Channel-Wise Revenue & Royalty</h4><br>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th rowspan="2">FY</th>
                                                                            <th rowspan="2">Total Revenue</th>
                                                                            <th rowspan="2">Total Royalty</th>
                                                                            <?php $ebook_channels = ['pustaka', 'amazon', 'overdrive', 'scribd', 'google', 'storytel', 'pratilipi', 'kobo']; ?>
                                                                            <?php foreach ($ebook_channels as $channel): ?>
                                                                                <th colspan="2"><?php echo ucfirst(htmlspecialchars($channel)); ?></th>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <?php foreach ($ebook_channels as $channel): ?>
                                                                                <th>Revenue</th>
                                                                                <th>Royalty</th>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $fy_list = !empty($ebook_details) ? array_unique(array_column($ebook_details, 'fy')) : [];
                                                                        sort($fy_list);

                                                                        foreach ($fy_list as $fy):
                                                                            $data = array_filter($ebook_details, function($d) use ($fy) {
                                                                                return $d['fy'] === $fy;
                                                                            });
                                                                            $data = reset($data) ?: [];
                                                                        ?>
                                                                            <tr style="background-color: #f0f0f0;">
                                                                                <td><?php echo htmlspecialchars($fy); ?></td>
                                                                                <td><?php echo format_currency($data["full_total_revenue"] ?? 0, $_SESSION['user_type'] ?? null); ?></td>
                                                                                <td><?php echo format_currency($data["full_total_royalty"] ?? 0, $_SESSION['user_type'] ?? null); ?></td>
                                                                                <?php foreach ($ebook_channels as $channel): ?>
                                                                                    <td><?php echo format_currency($data["total_{$channel}_revenue"] ?? 0, $_SESSION['user_type'] ?? null); ?></td>
                                                                                    <td><?php echo format_currency($data["total_{$channel}_royalty"] ?? 0, $_SESSION['user_type'] ?? null); ?></td>
                                                                                <?php endforeach; ?>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="audiobooks_tab" role="tabpanel" aria-labelledby="pills-contact-tab">
                                                            <div class="table-container">
                                                                <h4 class="text-center">🎧 Audiobooks - Channel-Wise Revenue & Royalty</h4><br><br>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th rowspan="2">FY</th>
                                                                            <th rowspan="2">Total Revenue</th>
                                                                            <th rowspan="2">Total Royalty</th>
                                                                            <?php $audiobook_channels = ['pustaka', 'overdrive', 'google', 'storytel', 'audible', 'kukufm', 'youtube']; ?>
                                                                            <?php foreach ($audiobook_channels as $channel): ?>
                                                                                <th colspan="2"><?php echo ucfirst(htmlspecialchars($channel)); ?></th>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <?php foreach ($audiobook_channels as $channel): ?>
                                                                                <th>Revenue</th>
                                                                                <th>Royalty</th>
                                                                            <?php endforeach; ?>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $fy_list = !empty($audiobook_details) ? array_unique(array_column($audiobook_details, 'fy')) : [];
                                                                        sort($fy_list);

                                                                        foreach ($fy_list as $fy):
                                                                            $data = array_filter($audiobook_details, function($d) use ($fy) {
                                                                                return $d['fy'] === $fy;
                                                                            });
                                                                            $data = reset($data) ?: [];
                                                                            $total_revenue = 0;
                                                                            $total_royalty = 0;

                                                                            foreach ($audiobook_channels as $channel) {
                                                                                $total_revenue += $data["total_{$channel}_revenue"] ?? 0;
                                                                                $total_royalty += $data["total_{$channel}_royalty"] ?? 0;
                                                                            }
                                                                        ?>
                                                                            <tr style="background-color: #f0f0f0;">
                                                                                <td><?php echo htmlspecialchars($fy); ?></td>
                                                                                <td><?php echo format_currency($total_revenue, $_SESSION['user_type'] ?? null); ?></td>
                                                                                <td><?php echo format_currency($total_royalty, $_SESSION['user_type'] ?? null); ?></td>
                                                                                <?php foreach ($audiobook_channels as $channel): ?>
                                                                                    <td><?php echo format_currency($data["total_{$channel}_revenue"] ?? 0, $_SESSION['user_type'] ?? null); ?></td>
                                                                                    <td><?php echo format_currency($data["total_{$channel}_royalty"] ?? 0, $_SESSION['user_type'] ?? null); ?></td>
                                                                                <?php endforeach; ?>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </div>
                                        </div>
                                    </div> -->
                                </div>
                                <br><br><br>
                                <br><br><br>
								<?php
								$user_type = $_SESSION['user_type'] ?? 0;

								function getMonthName($monthNumber) {
									$months = [
										1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 
										5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 
										9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
									];
									return $months[$monthNumber] ?? ''; 
								}
								?>
								<div class="container mt-4">
									<div class="layout-px-spacing">
										<div class="page-header">
											<h2 class="text-center">Month Wise Royalty Settlement</h2>        
											<div class="table-responsive">
												<table id="author_table" class="table table-bordered table-striped">
													<thead class="thead-dark">
														<tr>
															<th>Month</th>
															<th>Year</th>
															<th>Pustaka E-Books</th>
															<th>Pustaka Audiobooks</th>
															<th>Pustaka Paperback</th>
															<th>Pustaka Consolidated</th>  
															<th>Amazon</th>
															<th>Kobo</th>
															<th>Scribd</th>
															<th>Google Ebooks</th>
															<th>Google Audiobooks</th>
															<th>Overdrive Ebooks</th>
															<th>Overdrive Audiobooks</th>
															<th>Storytel Ebooks</th>
															<th>Storytel Audiobooks</th>
															<th>Pratilipi Ebooks</th>
															<th>Audible</th>
															<th>Kukufm Audiobooks</th>
														</tr>
													</thead>
													<tbody>
														<?php if (!empty($author['details'])): ?>
															<?php foreach ($author['details'] as $row): ?>
																<tr>
																	<td><?= htmlspecialchars(getMonthName($row['month'] ?? '')); ?></td>
																	<td><?= htmlspecialchars($row['year'] ?? ''); ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['pustaka_ebooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['pustaka_audiobooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['pustaka_paperback'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['pustaka_consolidated'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['amazon'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['kobo'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['scribd'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['google_ebooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['google_audiobooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['overdrive_ebooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['overdrive_audiobooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['storytel_ebooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['storytel_audiobooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['pratilipi_ebooks'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['audible'] ?: '-') : '#'; ?></td>
																	<td class="text-center"><?= $user_type == 4 ? htmlspecialchars($row['kukufm_audiobooks'] ?: '-') : '#'; ?></td>
																</tr>
															<?php endforeach; ?>
														<?php else: ?>
															<tr>
																<td colspan="18" class="text-center">No records found</td>
															</tr>
														<?php endif; ?>
													</tbody>
												</table>
											</div>

											<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
											<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
											<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
											<script>
												$(document).ready(function() {
													$('#author_table').DataTable({
														"scrollX": true,
														"scrollY": "400px",
														"paging": false,
														"searching": false,
														"ordering": false,
														"info": false,
														"autoWidth": false
													});
												});
											</script>
										</div>
									</div>
								</div>
                                <div id="content" class="main-content">
                                    <div class="layout-px-spacing">
                                        <div class="page-header">
                                            <!DOCTYPE html>
                                            <html lang="en">
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                                <style>
                                                    
                                                    #chart-container {
                                                        width: 900px; 
                                                        height: 600px; 
                                                        margin: auto; 
                                                    }
                                                </style>
                                            </head>
                                            <body>
                                                <h5><center>Year-Wise Royalty Settlement</center></h5>
                                                <div id="chart-container">
                                                    <canvas id="royaltyChart"></canvas> 
                                                </div>
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        let chartData = <?php echo json_encode($author['chart']); ?>;
                                                        let userType = <?php echo json_encode($user_type); ?>; 

                                                        let years = [];
                                                        let settlements = [];
                                                        let maskedSettlements = [];

                                                        chartData.forEach(function(item) {
                                                            years.push(item.fy);
                                                            settlements.push(item.total_settlement); 
                                                            maskedSettlements.push(userType == 4 ? item.total_settlement : null); 
                                                        });

                                                        var ctx = document.getElementById("royaltyChart").getContext("2d");
                                                        var myChart = new Chart(ctx, {
                                                            type: "line", 
                                                            data: {
                                                                labels: years, 
                                                                datasets: [{
                                                                    label: "Total Settlement",
                                                                    data: settlements, 
                                                                    backgroundColor: "rgba(54, 162, 235, 0.6)", 
                                                                    borderColor: "rgba(54, 162, 235, 1)",
                                                                    borderWidth: 1
                                                                }]
                                                            },
                                                            options: {
                                                                responsive: true,
                                                                maintainAspectRatio: false, 
                                                                scales: {
                                                                    y: {
                                                                        beginAtZero: true
                                                                    }
                                                                },
                                                                plugins: {
                                                                    tooltip: {
                                                                        callbacks: {
                                                                            label: function(context) {
                                                                                return userType == 4 ? context.raw : '#';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </body>
                                            </html>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <?php 
                                $user_type = $_SESSION['user_type'] ?? 0; 
                                ?>
                                <div class="container mt-3">
                                    <h4 class="text-center">Bookwise Royalty Details (E-Book)</h4>
                                    <table class="zero-config table table-hover mt-3">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Book ID</th>
                                                <th>Book Title</th>
                                                <th>Total Royalty</th>
                                                <th>Pustaka Royalty</th>
                                                <th>Amazon Royalty</th>
                                                <th>Google Royalty</th>
                                                <th>Overdrive Royalty</th>
                                                <th>Scribd Royalty</th>
                                                <th>Storytel Royalty</th>
                                                <th>Pratilipi Royalty</th>
                                                <th>Kobo Royalty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($bookwise['ebook'])): ?>
                                                <?php foreach ($bookwise['ebook'] as $ebook): ?>
                                                    <tr>
                                                        <td><?= $ebook['book_id'] ?></td>
                                                        <td><?= $ebook['book_title'] ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['total'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['pustaka_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['amazon_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['google_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['overdrive_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['scribd_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['storytel_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['pratilipi_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($ebook['kobo_royalty'] ?? 0, 2) : '#' ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No data available</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="container mt-3">
                                    <h4 class="text-center">Bookwise Royalty Details (Audio-Book)</h4>
                                    <table class="zero-config table table-hover mt-3">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Book ID</th>
                                                <th>Book Title</th>
                                                <th>Total Royalty</th>
                                                <th>Pustaka Royalty</th>
                                                <th>Audible Royalty</th>
                                                <th>Google Royalty</th>
                                                <th>Overdrive Royalty</th>
                                                <th>Storytel Royalty</th>
                                                <th>Kukufm Royalty</th>
                                                <th>Youtube Royalty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($bookwise['audiobook'])): ?>
                                                <?php foreach ($bookwise['audiobook'] as $book): ?>
                                                    <tr>
                                                        <td><?= $book['book_id'] ?></td>
                                                        <td><?= $book['book_title'] ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['total_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['pustaka_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['audible_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['google_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['overdrive_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['storytel_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['kukufm_royalty'] ?? 0, 2) : '#' ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($book['youtube_royalty'] ?? 0, 2) : '#' ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No data available</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="container mt-3">
                                    <h4 class="text-center">Bookwise Royalty Details (Paperback)</h4>
                                    <table class="zero-config table table-hover mt-3">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Book ID</th>
                                                <th>Book Title</th>
                                                <th>Pustaka Royalty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($bookwise['paperback'])): ?>
                                                <?php foreach ($bookwise['paperback'] as $books): ?>
                                                    <tr>
                                                        <td><?= $books['book_id'] ?></td>
                                                        <td><?= $books['book_title'] ?></td>
                                                        <td><?= ($user_type == 4) ? number_format($books['pustaka_royalty'] ?? 0, 2) : '#' ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No data available</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>          
                            </div>
                        </div>
                    </div>
            	</div>
            </div>
            <div class="col-sm-3 sm-10 col-14">
                <div class="nav flex-column nav-pills mb-sm-0 mb-3" id="v-right-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-2 active" id="v-right-pills-home-tab" data-toggle="pill" href="#basic_author_details" role="tab" aria-controls="v-right-pills-home" aria-selected="true">Basic</a>
                    <a class="nav-link mb-2" id="v-right-pills-profile-tab" data-toggle="pill" href="#author_book_details" role="tab" aria-controls="v-right-pills-profile" aria-selected="false">Books</a>
                    <a class="nav-link mb-2" id="v-right-pills-profile-tab" data-toggle="pill" href="#author_channel_details" role="tab" aria-controls="v-right-pills-profile" aria-selected="false">Channels</a>
                    <a class="nav-link mb-2" id="v-right-pills-settings-tab" data-toggle="pill" href="#author_royalty_details" role="tab" aria-controls="v-right-pills-settings" aria-selected="false">Royalty</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // JavaScript for Charts// -->
<script type="text/javascript">
    var options = {
        chart: {
            type: 'bar',
            stacked: true,
            height: 300,
            toolbar: {
                tools: {
                    download: false
                }
            },
        },
        colors: ['#B9189E'],
        dataLabels: {
            enabled: false
        },
        series: [{
            name: "Book Count",
            data: <?php echo json_encode($author_details['author_graph_data']['book_graph_data']['book_cnt']); ?>
        }],
        xaxis: {
            categories: <?php echo json_encode($author_details['author_graph_data']['book_graph_data']['months']); ?>
        }
    };
    var chart = new ApexCharts(document.querySelector("#month_wise_published_books"), options);
    chart.render();

    var options = {
        chart: {
            type: 'area',
            stacked: true,
            height: 300,
            toolbar: {
                tools: {
                    download: false
                }
            },
        },
        colors: ['#18B933'],
        dataLabels: {
            enabled: false
        },
        series: [{
            name: 'Page Count',
            data: <?php echo json_encode($author_details['author_graph_data']['page_graph_data']['page_cnt']); ?>
        }],
        xaxis: {
            categories: <?php echo json_encode($author_details['author_graph_data']['page_graph_data']['months']); ?>
        }
    };
    var chart = new ApexCharts(document.querySelector("#month_wise_published_pages"), options);
    chart.render();
</script>
<?= $this->endSection(); ?>