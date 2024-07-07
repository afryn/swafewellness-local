<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LoginFilter implements FilterInterface
{

    public function before( RequestInterface $request, $arguments = null )
    {

        if ( empty( session()->get( 'last_login_token' ) ) ) {
            session()->destroy();    
            return redirect()->to(base_url('login'));
        }

    }
    public function after( RequestInterface $request, ResponseInterface $response, $arguments = null )
    {
        // Do something here
    }

}
