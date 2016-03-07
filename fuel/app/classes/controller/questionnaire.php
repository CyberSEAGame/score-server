<?php

class Controller_Questionnaire extends Controller_User
{
	public function action_index()
	{
		if(!$this->template->is_signin)
		{
			Response::redirect(404);
		}



		$user = $this->template->user;

		if($user == null)
		{
			Response::redirect("404");
		}

		if(Input::post("submit", null) !== null && Security::check_token())
		{
			foreach($_POST as $key => $val)
			{
				if(is_int($key))
				{
					$answer = Model_Questionnaireanswer::find("first",[
						"where" => [
							["user_id", $this->template->user->id],
							["questionnaire_id", (int)$key]
						]
					]);

					if($answer == null)
					{
						$answer = Model_Questionnaireanswer::forge();
						$answer->user_id = $this->template->user->id;
						$answer->questionnaire_id = (int)$key;
					}

					$answer->body = $val;
					$answer->save();
				}

			}

		}

		$query_text = <<<EOT
SELECT q.id,
       t.title,
       q.body,
       q.type_id,
       a.body as answer
FROM questionnairetitles t
LEFT OUTER JOIN questionnaires q
ON(q.title_id = t.id and q.deleted_at = 0)
LEFT OUTER JOIN questionnaireanswers a
ON(a.questionnaire_id = q.id and a.deleted_at = 0 and a.user_id = :user_id)
WHERE t.deleted_at = 0
ORDER BY t.sort desc,
         t.id desc,
         q.sort desc,
         q.id desc
EOT;

		$team_id = (int)Input::get("team_id", 0);

		$query = DB::query($query_text);
		$query->bind('user_id', $user->id);
		$this->data["questionnaires"] = $query->execute()->as_array();
		$this->template->title = 'Questionnaire';
		$this->template->content = View::forge('questionnaires/form', $this->data);
	}
}
