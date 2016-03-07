<?php

class Controller_Admin extends Controller_Base
{
	public function before()
	{
		parent::before();
		$this->template = View::forge("admin/template");
		$this->template->is_signin = false;

		// logout
		if((int)Input::post("logout", 0) === 1)
		{
			$this->auth->logout();
			Response::redirect('admin/signin');
		}

		// check login
		if($this->user !== null)
		{
			if(!$this->user->isAdmin())
			{
				$this->auth->logout();
				Response::redirect('admin/signin');
			}
			else
			{
				$this->template->is_signin = true;
			}
		}
		else
		{
			Response::redirect('admin/signin');
		}
	}

	public function action_index()
	{
		$this->template->title = 'Announcement';
		$this->template->content = View::forge('admin/index', $this->data);
	}

}
