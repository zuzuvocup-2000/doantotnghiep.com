<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AutoloadModel;

class Member implements FilterInterface
{
	protected $auth;
	protected $user;
	protected $AutoloadModel;

	public function __construct(){
      $this->AutoloadModel = new AutoloadModel();
      $this->auth = (isset($_COOKIE['member'])) ? $_COOKIE['member'] : '';
      helper(['mystring']);
	}

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->auth = json_decode($this->auth, TRUE);
        if(!isset($this->auth) || is_array($this->auth) == false && count($this->auth) == 0){
            return redirect()->to(BASE_URL);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
