<?php

class Controller_Ranking extends Controller_User
{
	public function action_index()
	{
		$setting = Model_Setting::find("first");
		$this->data["start_at"] = $setting->start_at;
		$this->data["finish_at"] = $setting->finish_at;

		$this->template->title = 'Ranking';
		$this->template->content = View::forge('ranking', $this->data);
	}
}
