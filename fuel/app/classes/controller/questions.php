<?php

class Controller_Questions extends Controller_User
{
	public function before()
	{
		parent::before();

	}

	public function action_index()
	{

		if(!$this->template->is_signin)
		{
			Response::redirect(404);
		}

		if(Model_Setting::checkTime() < 0)
		{
			if(Model_Setting::checkTime() == -1)
			{
				$this->template->title = 'The Contest hasn\'t started yet.';
				$this->template->content = View::forge('hasnt_started', $this->data);
			}
			else
			{
				$this->template->title = 'The contest has already ended.';
				$this->template->content = View::forge('ended', $this->data);
			}
		}
		else
		{
			$query_text = <<<EOT
SELECT count(q.id) as c
FROM questions q
LEFT OUTER JOIN categories c
ON(q.category_id = c.id AND c.deleted_at = 0)
WHERE q.deleted_at = 0 AND q.is_opened = 1
EOT;

			$query = DB::query($query_text);

			$count = $query->execute()->as_array();

			if(isset($count[0]))
			{
				$count = $count[0]["c"];
			}
			else
			{
				$count = 0;
			}

			$config= [
				'pagination_url'=>"",
				'uri_segment'=>"p",
				'num_links'=>9,
				'per_page'=>20,
				'total_items'=>$count,
			];

			$pager = Pagination::forge('mypagination', $config);

			$query_text = <<<EOT
SELECT q.id,
       q.title,
       c.title as category,
       q.point,
       q.first_point,
       q.is_opened,
       q.is_solved,
       a.id as answer_id
FROM questions q
LEFT OUTER JOIN categories c
ON(q.category_id = c.id AND c.deleted_at = 0)
LEFT OUTER JOIN answerlogs a
ON(a.team_id = :team_id AND q.id = a.question_id and is_corrected = 1)
WHERE q.deleted_at = 0 AND q.is_opened = 1
ORDER BY c.sort DESC, q.point ASC
LIMIT :offset,:limit
EOT;

			$query = DB::query($query_text);

			$query->bind("team_id", $this->user->team_id);

			$offset = $pager->offset;
			$limit = $pager->per_page;
			$query->bind("offset", $offset);
			$query->bind("limit", $limit);

			$this->data["questions"] = $query->execute()->as_array();

			$this->data["pager"] = $pager;

			$this->template->title = 'Questions';
			$this->template->content = View::forge('questions/index', $this->data);
		}
	}

	public function action_detail($id = 0)
	{

		if(!$this->template->is_signin)
		{
			Response::redirect(404);
		}

		if(Model_Setting::checkTime() < 0)
		{
			if(Model_Setting::checkTime() == -1)
			{
				$this->template->title = 'The Contest hasn\'t started yet.';
				$this->template->content = View::forge('hasnt_started', $this->data);
			}
			else
			{
				$this->template->title = 'The contest has already ended.';
				$this->template->content = View::forge('ended', $this->data);
			}
		}
		else
		{
			$this->data["question"] = Model_Question::find($id,[
				"where" => [
					["deleted_at", 0],
					["is_opened", 1]
				]
			]);

			if($this->data["question"] == null)
			{
				Response::redirect(404);
			}

			$this->data["status"] = 0;

			$this->data["log"] = Model_Answerlog::find("first",[
				"where" => [
					["team_id", $this->user->team_id],
					["is_corrected", 1],
					["question_id", $id]
				]
			]);

			// check answer
			if(Input::post("answer", null) != null && Input::post("csrf_token") == $this->user->csrf_token)
			{
				if($this->user->checkLock())
				{
					$old_log = Model_Answerlog::find("first", [
						"where" => [
							["team_id", $this->user->team_id],
							["question_id", $id],
							["is_corrected", 1]
						]
					]);

					if($old_log == null)
					{
						$log = Model_Answerlog::forge();
						$log->user_id = $this->user->id;
						$log->team_id = $this->user->team_id;
						$log->body = Input::post("answer", null);
						$log->question_id = $id;

						if($log->body == $this->data["question"]->answer)
						{
							$log->is_corrected = 1;
							$this->data["status"] = 1;
							$this->data["log"] = $log;

							$message = Model_Message::forge();
							$message->type = 1;

							if($this->data["question"]->is_solved == 0)
							{
								$point = $this->data["question"]->point + $this->data["question"]->first_point;
								$message->body = "{$this->user->username}({$this->user->team->name}) solved {$this->data["question"]->title}({$point}).";
								$this->data["question"]->is_solved = 1;
								$this->data["question"]->save();
							}
							else
							{
								$message->body = "{$this->user->username}({$this->user->team->name}) solved {$this->data["question"]->title}({$this->data["question"]->point}).";
							}
							$message->save();
						}
						else
						{
							$log->is_corrected = 0;
							$this->data["status"] = 2;
						}

						$log->save();
					}
				}
				else
				{
					$this->data["status"] = 3;
				}

			}

			$this->data["user"] = $this->user;

			$this->template->title = "{$this->data["question"]->title}({$this->data["question"]->category->title})";
			$this->template->content = View::forge('questions/detail', $this->data);
		}
	}
}
