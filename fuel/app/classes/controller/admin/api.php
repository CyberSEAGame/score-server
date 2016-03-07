<?php

class Controller_Admin_Api extends Controller_Rest
{
	private $user = null;

	public function before(){

		parent::before();

		if(Auth::check()){

			$user_id = Auth::get_user_id()[1];
			$this->user = Model_User::find($user_id,[
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($this->user != null)
			{
				if(!$this->user->isAdmin())
				{
					$this->user = null;
				}
			}
		}

	}

	public function post_changeannouncement(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$announcement = Model_Announcement::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($announcement == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				if($announcement->is_public == 1)
				{
					$announcement->is_public = 0;
				}
				else
				{
					$announcement->is_public = 1;
				}

				$announcement->save();
			}
		}
	}

	public function post_deleteannouncement(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$announcement = Model_Announcement::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($announcement == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$announcement->safeDelete();
			}
		}
	}

	public function post_deleteteam(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$team = Model_Team::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($team == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$team->safeDelete();
			}
		}
	}

	public function post_changerole(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$role = Model_Role::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($role == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				if($role->is_public == 1)
				{
					$role->is_public = 0;
				}
				else
				{
					$role->is_public = 1;
				}

				$role->save();
			}

		}
	}

	public function post_deleterole(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$role = Model_Role::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($role == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$role->safeDelete();
			}
		}
	}

	public function post_deletedeftype(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$def_type = Model_Defensetype::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($def_type == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$def_type->safeDelete();
			}
		}
	}

	public function post_deletedefense(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$defense = Model_Defense::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($defense == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$defense->safeDelete();
			}
		}
	}

	public function post_deleteatktype(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$atk_type = Model_Attacktype::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($atk_type == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$atk_type->safeDelete();
			}
		}
	}

	public function post_deleteattack(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$attack = Model_Attack::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($attack == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$attack->safeDelete();
			}
		}
	}

	public function post_deleteuser(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$user = Model_User::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($user == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$user->safeDelete();
			}
		}
	}

	public function post_deletequestionnairetitle(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$title = Model_Questionnairetitle::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($title == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$title->safeDelete();
			}
		}
	}

	public function post_deletequestionnaire(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$questionnaire = Model_Questionnaire::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($questionnaire == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$questionnaire->safeDelete();
			}
		}
	}

	public function post_deletecategory(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$category = Model_Category::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($category == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$category->safeDelete();
			}
		}
	}

	public function post_deletequestion(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$question = Model_Question::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($question == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				$question->safeDelete();
			}
		}
	}

	public function post_changequestionopened(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$question = Model_Question::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($question == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				if($question->is_opened == 1)
				{
					$question->is_opened = 0;
				}
				else
				{
					$question->is_opened = 1;
				}

				$question->save();
			}
		}
	}

	public function post_changequestionsoleved(){

		if($this->user == null || !Security::check_token())
		{
			$this->response->set_status(400);
		}
		else
		{
			$question = Model_Question::find((int)Input::post("id"), [
				"where" => [
					["deleted_at", 0]
				]
			]);

			if($question == null)
			{
				$this->response->set_status(400);
			}
			else
			{
				if($question->is_solved == 1)
				{
					$question->is_solved = 0;
				}
				else
				{
					$question->is_solved = 1;
				}

				$question->save();
			}
		}
	}
}