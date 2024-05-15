<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Google\Cloud\Storage\StorageClient;


// use model

use App\Models\DbBpk;
use Myth\Auth\Models\UserModel;
use App\Libraries\Terbilang;
use Myth\Auth\Models\GroupModel;
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
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['auth', 'url', 'form', 'csrf', 'security'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    
    protected $validation; // Definisi properti $Validation
    protected $storage; // Definisi properti $storage
    protected $dbBpk; // Definisi properti $dbBpk
    protected $db; // Definisi properti $db
    protected $security; // Definisi properti $security
    protected $builder; // Definisi properti $builder
    protected $userModel; // Definisi properti $userModel
    protected $terbilang; // Definisi properti $terbilang
    protected $groupModel; // Definisi properti $groupModel
    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->groupModel = new GroupModel();
        $this->dbBpk = new DbBpk();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
        $this->security = \Config\Services::security();
        $this->userModel = new UserModel();
        $this->builder = $this->db->table('users');
        $this->terbilang = new Terbilang();
        // $this->gCloud = new \Config\GoogleCloud();
        $this->storage = new StorageClient([
            'keyFilePath' => '../credential/amplified-alpha-420813-52eeeba253ff.json',
        ]);
    }
}
