<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// adminv4
$routes->group('', function($routes) {
    $routes->get('/', 'Adminv4::index');
    $routes->get('adminv4', 'Adminv4::index'); // This is required
    $routes->get('adminv4/authenticate', 'Adminv4::authenticate'); // Optional
    $routes->post('adminv4/authenticate', 'Adminv4::authenticate');
    $routes->get('adminv4/logout', 'Adminv4::logout');
});


// Transactions methods
$routes->group('transactions', function($routes) {
$routes->get('amazon', 'Transactions\AmazonTransactions::UploadTransactions');
$routes->get('google', 'Transactions\GoogleTransactions::UploadTransactions');
$routes->get('overdrive', 'Transactions\OverdriveTransactions::UploadTransactions');
$routes->get('scribd', 'Transactions\ScribdTransactions::UploadTransactions');
$routes->get('pratilipi', 'Transactions\PratilipiTransactions::UploadTransactions');
$routes->get('storytelebook', 'Transactions\StorytelTransactions::EbookTransactions');
$routes->get('storytelaudiobook', 'Transactions\StorytelTransactions::AudiobookTransactions');
$routes->get('audible', 'Transactions\AudibleTransactions::UploadTransactions');
$routes->get('kukufm', 'Transactions\KukufmTransactions::UploadTransactions');
$routes->get('youtube', 'Transactions\YoutubeTransactions::UploadTransactions');
});

// royalty publisher excel download 
$routes->get('royalty/download_bank_excel', 'DownloadExcel\RoyaltyExcel::DownloadBankExcel');

   
// stock
$routes->group('stock', function($routes) {
    $routes->get('/', 'Stock::index');
    $routes->get('stockdashboard', 'Stock::stockdashboard');
    $routes->get('getstockdetails', 'Stock::getstockdetails');
    $routes->get('outofstockdetails', 'Stock::outofstockdetails');
    $routes->get('loststockdetails', 'Stock::loststockdetails');
    $routes->get('outsidestockdetails', 'Stock::outsidestockdetails');
    $routes->get('addstock', 'Stock::addstock');
    $routes->match(['get', 'post'], 'bookslist', 'Stock::bookslist');
    $routes->post('submitdetails', 'Stock::submitdetails');    
    $routes->get('stockentrydetails', 'Stock::stockentrydetails');
    $routes->post('validatestock', 'Stock::validateStock');
    $routes->get('otherdistribution', 'Stock::otherdistribution');
    $routes->post('saveotherdistribution', 'Stock::saveotherdistribution');
});


// tppublisher
$routes->group('tppublisher', function($routes) {
    $routes->get('/', 'TpPublisher::tppublisherDashboard', ['as' => 'tppublisher']);
    $routes->get('tppublisherdetails', 'TpPublisher::tpPublisherDetails'); 
    $routes->post('setpublisherstatus', 'TpPublisher::setpublisherstatus');
    $routes->get('tppublisherview', 'TpPublisher::tpPublisherView');
    $routes->post('tpPublisherAdd', 'TpPublisher::tpPublisherAdd');
    $routes->get('tppublisherdetailsview/(:num)', 'TpPublisher::tpPublisherDetailsView/$1');
    $routes->get('tppublisheredit/(:num)', 'TpPublisher::tpPublisherEdit/$1');
    $routes->post('editpublisherpost', 'TpPublisher::editPublisherPost');

    $routes->get('tpauthordetails', 'TpPublisher::tpAuthorDetails');
    $routes->get('tpauthoradddetails', 'TpPublisher::tpAuthorAddDetails');
    $routes->post('tpAuthoradd', 'TpPublisher::tpAuthoradd');
    $routes->post('setAuthorStatus', 'TpPublisher::setAuthorStatus');
    $routes->get('tpauthorview/(:num)', 'TpPublisher::tpAuthorView/$1');
    $routes->get('tpauthoredit/(:num)', 'TpPublisher::tpAuthorEdit/$1');
    $routes->post('editauthorpost', 'TpPublisher::editAuthorPost');

    $routes->get('tpbookdetails', 'TpPublisher::tpBookDetails');
    $routes->get('tpbookadddetails', 'TpPublisher::tpBookAddDetails');
    $routes->post('getAuthorsByPublisher', 'TpPublisher::getAuthorsByPublisher');
    $routes->post('tpBookPost', 'TpPublisher::tpBookPost');
    $routes->post('tpbookupdatestatus', 'TpPublisher::tpBookUpdateStatus');
    $routes->post('setBookStatus', 'TpPublisher::setBookStatus');
    $routes->get('tpbookview/(:num)', 'TpPublisher::tpBookView/$1');
    $routes->get('edittpbook/(:num)', 'TpPublisher::editTpBook/$1');
    $routes->post('edittpbookpost', 'TpPublisher::editTpBookPost');

    $routes->get('tpstockdetails', 'TpPublisher::tpStockDetails');
    $routes->match(['get', 'post'], 'tpbookaddstock', 'TpPublisher::tpbookaddstock');
    $routes->post('getAuthorTpBook', 'TpPublisher::getAuthorTpBook');
    $routes->post('addTpBookStock', 'TpPublisher::addTpBookStock');

    $routes->get('tpsalesdetails', 'TpPublisher::tpSalesDetails');
    $routes->get('tpsalesadd', 'TpPublisher::tpSalesAdd');
    $routes->post('tpbookorderdetails', 'TpPublisher::tpbookOrderDetails');
    $routes->post('tppublisherorderpost', 'TpPublisher::tppublisherOrderPost');
    $routes->match(['get', 'post'], 'tppublisherordersubmit', 'TpPublisher::tppublisherOrderSubmit');
    $routes->get('tpordersuccess', 'TpPublisher::tpordersuccess'); 



    $routes->get('tppublisherorderdetails', 'TpPublisher::tppublisherOrderDetails');
    $routes->get('tppublisherorderpayment', 'TpPublisher::tppublisherOrderPayment');

    $routes->post('markShipped', 'TpPublisher::markShipped');
    $routes->post('markCancel', 'TpPublisher::markCancel');
    $routes->post('markReturn', 'TpPublisher::markReturn');
    $routes->post('initiatePrint', 'TpPublisher::initiatePrint');

    $routes->post('markAsPaid', 'TpPublisher::markAsPaid');
    $routes->post('tppublisheradd', 'TpPublisher::tpPublisherAdd');
});



// tppublisher dashboard
$routes->group('tppublisherdashboard', function($routes) {
    $routes->get('/', 'TpPublisherDashboard::tpPublisherDashboard', ['as' => 'tppublisherdashboard']);
    $routes->get('tppublisherdashboard', 'TpPublisherDashboard::tpPublisherDashboard');
    $routes->post('tppublisherorder', 'TpPublisherDashboard::tppublisherOrder'); 
    $routes->post('tppublisherorderstock', 'TpPublisherDashboard::tppublisherOrderStock');
    $routes->post('tppublisherordersubmit', 'TpPublisherDashboard::tppublisherOrderSubmit');
     $routes->get('tppublisherorderdetails', 'TpPublisherDashboard::tppublisherOrderDetails');
    $routes->get('tppublisherorderpayment', 'TpPublisherDashboard::tppublisherOrderPayment');
});


// user dashboard
$routes->group('user', function($routes) {
    $routes->get('userdashboard', 'User::userDashboard');
    $routes->post('getuserdetails', 'User::getUserDetails');
});
//Royalty
$routes->get('royalty/royaltyconsolidation', 'Royalty::royaltyconsolidation');
$routes->post('royalty/paynow', 'Royalty::paynow');
$routes->get('royalty/getroyaltybreakup/(:any)', 'Royalty::getroyaltybreakup/$1');
$routes->match(['get', 'post'], 'royalty/royaltyrevenue', 'Royalty::royaltyrevenue');
$routes->get('royalty/transactiondetails', 'Royalty::transactiondetails');

//Sales
$routes->group('sales', function($routes) {
    $routes->get('salesdashboard', 'Sales::salesdashboard');
    $routes->get('salesreports', 'Sales::salesReports');
    $routes->get('ebooksales', 'Sales::ebookSales');
    $routes->get('audiobooksales', 'Sales::audiobookSales');
    $routes->get('paperbacksales', 'Sales::paperbackSales');
});

//Paperback//
$routes->group('paperback', function($routes){
   $routes->get('dashboard', 'Paperback::dashboard');
});

