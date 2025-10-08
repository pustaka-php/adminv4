<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

// Import your models here
use App\Models\AdminModel;
use App\Models\UserModel;
use App\Models\StockModel;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $session;

    protected $db;
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    // protected $helpers = [];
    
    protected $helpers = ['form', 'url', 'file', 'email', 'html', 'cookie'];


    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    
    // Define model properties
    protected $adminModel;
    protected $userModel;
    protected $stockModel;


  
    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
        $this->session = service('session');

        // db as called globally 
        $this->db = \Config\Database::connect();


        //  Load your models here
        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();
        $this->stockModel = new StockModel();

        // Get current controller name
        $router = service('router');
        $controller = strtolower(class_basename($router->controllerName()));
        $method = $router->methodName();

        // Only allow adminv4 without login
        $allowedControllers = ['adminv4'];

        if (!in_array($controller, $allowedControllers) && !$this->session->get('user_id')) {
            redirect()->to('/adminv4')->send(); // force send redirect
            exit(); // Stop further execution
        }

    
    }
}
