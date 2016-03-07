<?php

class Controller_Admin_Setting extends Controller_Admin
{

	public function action_index()
	{
		$setting = Model_Setting::find("first");
		if($setting == null)
		{
			$setting = Model_Setting::forge();
			$setting->start_at = time();
			$setting->finish_at = time();
			$setting->save();
		}

		if(Input::post("start_at", null) !== null && Security::check_token())
		{
			$setting->start_at = strtotime(Input::post("start_at", null) . ":00");
			$setting->finish_at = strtotime(Input::post("finish_at", null) . ":00");
			$setting->save();
		}

		$this->data["setting"] = $setting;

		$this->template->title = 'Setting';
		$this->template->content = View::forge('admin/setting/index', $this->data);
	}
}