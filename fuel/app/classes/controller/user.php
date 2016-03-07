<?php

class Controller_User extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template->is_signin = false;

		// logout
		if((int)Input::post("logout", 0) === 1)
		{
			$this->auth->logout();
			Response::redirect('signin');
		}

		// check login
		if($this->user !== null)
		{
			if(!$this->user->isUser())
			{
				//$this->auth->logout();
				//Response::redirect('signin');
			}
			else
			{
				$this->template->is_signin = true;
				$this->template->user = $this->user;
			}
		}
		else
		{
			//Response::redirect('signin');
		}
	}

}
