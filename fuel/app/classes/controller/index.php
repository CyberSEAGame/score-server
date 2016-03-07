<?php

class Controller_Index extends Controller_User
{
	public function action_index()
	{
		$this->template->title = 'Announcement';
		$this->template->content = View::forge('index', $this->data);
	}

	public function action_404()
	{
		$this->template->title = '404';
		$this->template->content = View::forge('404', $this->data);
	}
}
