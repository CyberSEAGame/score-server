<?php

class Controller_Admin_Upload extends Controller_Admin
{

	public function action_index()
	{
		$this->data["error"] = false;

		if(isset($_FILES['upload_file']))
		{
			$ext = explode(".",$_FILES['upload_file']['name']);
			$ext = end($ext);
			if(preg_match("/(jpg|gif|png|zip)/i", $ext))
			{
				if(move_uploaded_file($_FILES['upload_file']['tmp_name'], DOCROOT."/files/" . $_FILES['upload_file']['name']))
				{

				}
				else
				{
					$this->data["error"] = true;
				}
			}
		}

		$this->data["files"] = scandir(DOCROOT . "/files");

		if(Input::post("file", null) != null)
		{
			foreach($this->data["files"] as $file)
			{
				if(Input::post("file", null) == $file)
				{
					unlink(DOCROOT . "/files/{$file}");
					Response::redirect("admin/upload");
				}
			}
		}

		$this->template->title = 'Upload';
		$this->template->content = View::forge('admin/uploads/index', $this->data);
	}
}