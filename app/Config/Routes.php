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

// Bookfair sales details
$routes->get('bookfair/uploaditemwisesale', 'BookFairUpload::uploadItemwiseSale');


   
// stock
$routes->group('stock', function($routes) {
    $routes->get('/', 'Stock::index');
    $routes->get('stockdashboard', 'Stock::stockdashboard');
    $routes->get('getstockdetails', 'Stock::getstockdetails');
    $routes->get('outofstockdetails', 'Stock::outofstockdetails');
    $routes->get('loststockdetails', 'Stock::loststockdetails');
    $routes->get('outsidestockdetails', 'Stock::outsidestockdetails');
    $routes->get('addstock', 'Stock::addstock');
    $routes->match(['GET', 'POST'], 'bookslist', 'Stock::bookslist');
    $routes->post('submitdetails', 'Stock::submitdetails');    
    $routes->get('stockentrydetails', 'Stock::stockentrydetails');
    $routes->post('validatestock', 'Stock::validateStock');
    $routes->get('otherdistribution', 'Stock::otherdistribution');
    $routes->post('saveotherdistribution', 'Stock::saveotherdistribution');
    $routes->get('validate/(:num)', 'Stock::UpdatevalidateStock/$1');
    $routes->get('getmismatchstock', 'Stock::getmismatchstock');
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

    $routes->get('tppublisherorder', 'TpPublisher::tppublisherOrder');
    $routes->get('tpstockdetails', 'TpPublisher::tpStockDetails');
    $routes->match(['GET', 'POST'], 'tpbookaddstock', 'TpPublisher::tpbookaddstock');
    $routes->post('getAuthorTpBook', 'TpPublisher::getAuthorTpBook');
    $routes->post('addTpBookStock', 'TpPublisher::addTpBookStock');

    $routes->get('tpsalesdetails', 'TpPublisher::tpSalesDetails');
    $routes->get('tpsalesadd', 'TpPublisher::tpSalesAdd');
    $routes->get('tporderfulldetails/(:num)', 'TpPublisher::tpOrderFullDetails/$1');
    $routes->post('tpbookorderdetails', 'TpPublisher::tpbookOrderDetails');
    $routes->post('tppublisherorderpost', 'TpPublisher::tppublisherOrderPost');
    $routes->match(['GET', 'POST'], 'tppublisherordersubmit', 'TpPublisher::tppublisherOrderSubmit');
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
    $routes->get('viewpublisherbooks', 'TpPublisherDashboard::viewPublisherBooks');
    $routes->get('tppublishercreateorder', 'TpPublisherDashboard::tppublisherCreateOrder');
   $routes->get('tporderfulldetails/(:num)', 'TpPublisherDashboard::tpOrderFullDetails/$1');
   $routes->get('tpsalesdetails', 'TpPublisherDashboard::tpSalesDetails');
   $routes->get('handlingandpay', 'TppublisherDashboard::handlingAndPay');
    $routes->post('tppublisherorder', 'TpPublisherDashboard::tppublisherOrder'); 
    $routes->post('tppublisherorderstock', 'TpPublisherDashboard::tppublisherOrderStock');
    $routes->post('tppublisherordersubmit', 'TpPublisherDashboard::tppublisherOrderSubmit');
     $routes->get('tppublisherorderdetails', 'TpPublisherDashboard::tppublisherOrderDetails');
    $routes->get('tppublisherorderpayment', 'TpPublisherDashboard::tppublisherOrderPayment');
});


// user dashboard
$routes->group('user', function ($routes) {
    $routes->get('userdashboard', 'User::userDashboard');
    $routes->post('getuserdetails', 'User::getUserDetails');
    $routes->post('clearuserdevices', 'User::clearUserDevices');
    $routes->post('addplanforuser', 'User::addPlanForUser');
    $routes->get('authorgiftbooks', 'User::authorGiftBooks');
    $routes->post('checkorcreate', 'User::checkOrCreate');
    $routes->post('createuser', 'User::CreateUser');
    $routes->post('submitgiftbook', 'User::submitGiftBook');
});


//Royalty
$routes->get('royalty/royaltyconsolidation', 'Royalty::royaltyconsolidation');
$routes->post('royalty/paynow', 'Royalty::paynow');
$routes->get('royalty/getroyaltybreakup/(:any)', 'Royalty::getroyaltybreakup/$1');
$routes->match(['GET', 'POST'], 'royalty/royaltyrevenue', 'Royalty::royaltyrevenue');
$routes->get('royalty/transactiondetails', 'Royalty::transactiondetails');

// testing
$routes->get('royalty/processing', 'Royalty::processing');
$routes->get('royalty/pay_now', 'Royalty::pay_now');



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
    //online//
    $routes->get('onlineorderbooksstatus', 'Paperback::onlineOrderbooksStatus');
    $routes->get('onlineordership/(:segment)/(:segment)', 'Paperback::onlineordership/$1/$2');
    $routes->get('totalonlineordercompleted','paperback::totalonlineordercompleted');
    $routes->get('onlinebulkordersship/(:num)', 'Paperback::onlinebulkordersship/$1');
    $routes->get('offlineorderbooksstatus','Paperback::offlineorderbooksstatus');
    $routes->get('offlineorderbooksdashboard','Paperback::offlineorderbooksdashboard');
    $routes->get('offlineorderbookslist','Paperback::offlineorderbookslist');
    $routes->get('offlinebulkordersship/(:num)', 'Paperback::offlinebulkordersship/$1');
    $routes->post('bulkordershipmentcompleted', 'Paperback::bulkordershipmentcompleted'); 
    $routes->get('offlineordership/(:num)/(:num)','Paperback::offlineordership/$1/$2');
    $routes->get('offlineorderbooksdashboard','Paperback::offlineorderbooksdashboard');
    $routes->post('offlineorderbookslist','Paperback::offlineorderbookslist');
    $routes->POST('offlineorderstock','Paperback::offlineorderstock');
    $routes->POST('offlineorderbookssubmit','Paperback::offlineorderbookssubmit');
    $routes->get('totalofflineordercompleted','Paperback::totalofflineordercompleted');
    $routes->get('offlineorderdetails/(:num)','Paperback::offlineorderdetails/$1');
    $routes->get('paperbackledgerbooksdetails/(:num)','Paperback::paperbackledgerbooksdetails/$1');
    $routes->get('onlineorderdetails/(:num)','Paperback::onlineorderdetails/$1');
    $routes->get('paperbackprintstatus','Paperback::paperbackprintstatus');
    $routes->get('initiateprintdashboard/(:num)', 'Paperback::initiateprintdashboard/$1');
    $routes->get('initiateprintbooksdashboard','Paperback::initiateprintbooksdashboard');
    $routes->post('initiateprintbookslist','Paperback::initiateprintbookslist');
    $routes->get('amazonorderbooksstatus','Paperback::amazonorderbooksstatus');
    $routes->get('paperbackamazonorder','Paperback::paperbackamazonorder');
    $routes->post('pustakaamazonorderbookslist','Paperback::pustakaamazonorderbookslist');
    $routes->post('pustakaamazonorderstock','Paperback::pustakaamazonorderstock');
    $routes->post('amazonorderbookssubmit','Paperback::amazonorderbookssubmit');
    $routes->get('totalamazonordercompleted','Paperback::totalamazonordercompleted');
    $routes->get('amazonorderdetails/(:num)','Paperback::amazonorderdetails/$1');
    $routes->get('authororderbooksstatus','Paperback::authororderbooksstatus');
    $routes->get('authorlistdetails','Paperback::authorlistdetails');
    $routes->get('authororderbooks/(:num)', 'Paperback::authororderbooks/$1');
    $routes->get('totalauthorordercompleted','Paperback::totalauthorordercompleted');
    $routes->get('authororderdetails/(:num)', 'Paperback::authororderdetails/$1');
    $routes->get('createauthorinvoice/(:num)', 'Paperback::createauthorinvoice/$1');

});

//book//
$routes->group('book', function($routes) {
    $routes->get('bookdashboard', 'Book::bookDashboard');
    $routes->get('getebooksstatus', 'Book::getEbooksStatus');
    $routes->get('ebooks', 'Book::Ebooks');
    $routes->get('audiobookdashboard', 'Book::audioBookDashboard');
    $routes->get('podbooksdashboard', 'Book::podBooksDashboard');
    $routes->get('getholdbookdetails', 'Book::getholdbookdetails');
    $routes->get('getinactivebooks', 'Book::getInactiveBooks');
    $routes->get('addbook', 'Book::addBook');
    $routes->post('ebooksmarkstart', 'Book::ebooksMarkStart');
    $routes->get('filldataview/(:num)', 'Book::fillDataView/$1');
    $routes->post('filldata', 'Book::fillData');
    $routes->post('addtotest', 'Book::addToTest');
    $routes->post('holdinprogress', 'Book::holdInProgress');
    $routes->get('activatebookpage/(:num)', 'Book::activateBookPage/$1');
    $routes->post('activatebook', 'Book::activateBook');
    $routes->post('addbookpost', 'Book::addBookPost');
    $routes->get('browseinprogressbooks', 'Book::browseInProgressBooks');
    $routes->post('ebooksmarkstart', 'Book::ebooksMarkStart');
    $routes->post('markscancomplete', 'Book::markScanComplete');
    $routes->post('markocrcomplete', 'Book::markOcrComplete');
    $routes->post('marklevel1complete', 'Book::markLevel1Complete');
    $routes->post('marklevel2complete', 'Book::markLevel2Complete');
    $routes->post('markcovercomplete', 'Book::markCoverComplete');
    $routes->post('markbookgenerationcomplete', 'Book::markBookGenerationComplete');
    $routes->post('markuploadcomplete', 'Book::markUploadComplete');
    $routes->post('markcompleted', 'Book::markCompleted');

    $routes->get('addaudiobook', 'Book::addAudioBook');
    $routes->post('addaudiobookpost', 'Book::addAudioBookPost');
    $routes->get('audiobookchapters/(:num)', 'Book::audioBookChapters/$1');
    $routes->post('addaudiobookchapter', 'Book::addAudioBookChapter');
    $routes->post('editaudiobookchapter', 'Book::editAudioBookChapter');
    $routes->get('notstartedbooks', 'Book::notStartedBooks');


    $routes->get('pustakadetails', 'Book::pustakaDetails');
    $routes->get('amazondetails', 'Book::amazonDetails');

});

// Publisher
$routes->group('pod', function($routes) {
    $routes->get('publisherdashboard', 'Pod::publisherDashboard');
    $routes->get('publisheradd', 'Pod::publisherAdd');
    $routes->post('publishersubmit', 'Pod::PodpublisherSubmit');

});
