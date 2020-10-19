<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Roles implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = NULL)
    {
        // Do something here
        if (session()->get('roles') != json_encode(['ROLE_ADMIN'])) {

            return redirect()->route('dashboard');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
    {
        // Do something here
    }
}
