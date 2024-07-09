<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\AttributeModel;
use App\Models\WalletModel;
use App\Models\BlogModel;
use App\Models\Storecustomers;
use App\Models\NewsletterModel;
use App\Models\Ez_pin;
use App\Models\Tabby\TabbyModel;
use App\Models\Paytab;
use App\Models\OfferModel;
use App\Models\SystemModel;

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

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ["cookie" , "language" , "search" ];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		 $this->session = \Config\Services::session();
		   $this->userModel = new UserModel();
		   $this->orderModel = new OrderModel();
		   $this->productModel = new ProductModel();
		   $this->brandModel =new BrandModel();
		   $this->category = new Category();
		   $this->attributeModel = new AttributeModel();
           $this->walletModel = new WalletModel();
           $this->blogModel = new BlogModel();
           $this->newsletterModel = new NewsletterModel();
		   $this->ezpinModel = new Ez_pin();
		   $this->tabbyModel = new TabbyModel();
		   $this->paytabModel = new Paytab();
		   $this->systemModel = new SystemModel();
		   $this->offerModel = new OfferModel();
		   $this->storeModel = new Storecustomers();
		   $this->form_validation =  \Config\Services::validation();
	}
}
