<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['My_helper','sms_mail_helper','invoice_helper','Payment_slip_helper','html_helper','duty_slip_helper','api_helper','csv',
    'url','file','form','session','security','filesystem','html','cookie'];
     protected $session;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
}
