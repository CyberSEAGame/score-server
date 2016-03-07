<?php

class Controller_Api extends Controller_Rest
{

	public function get_ranking()
	{
		$newest_ranking = Model_Ranking::find("first",[
			"order_by" => [
				["calculated_at", "desc"]
			]
		]);

		$query_text = <<<EOT
SELECT r.score,
       r.first_point,
       r.total_score,
       r.calculated_at,
       r.team_id,
       t.name as team_name,
       t.color,
       r.last_solved_at
FROM rankings r
LEFT OUTER JOIN teams t
ON(r.team_id = t.id)
WHERE calculated_at = :calculated_at
ORDER BY r.total_score DESC, r.last_solved_at ASC
EOT;
		$query = DB::query($query_text);
		$query->bind('calculated_at', $newest_ranking->calculated_at);
		$rankings = $query->execute()->as_array();

		$this->response([
			"ranking" => $rankings
		]);
	}

	public function get_rankinghistory()
	{
		$query_text = <<<EOT
SELECT r.score,
       r.first_point,
       r.total_score,
       r.calculated_at,
       r.team_id
FROM rankings r
ORDER BY r.calculated_at asc
EOT;
		$query = DB::query($query_text);
		$rankings = $query->execute()->as_array();

		$query_text = <<<EOT
SELECT t.id,
       t.name,
       t.color
FROM teams t
WHERE t.deleted_at = 0
ORDER BY t.id desc
EOT;
		$query = DB::query($query_text);
		$teams = $query->execute()->as_array();

		$history = [];

		foreach($teams as $team)
		{
			$history["{$team["id"]}"] = [];
		}

		foreach($rankings as $ranking)
		{
			array_push($history["{$ranking["team_id"]}"], $ranking);
		}

		$this->response([
			"teams" => $teams,
			"history" => $history
		]);
	}

	public function get_times()
	{
		$setting = Model_Setting::find("first");
		$this->response([
			"start_at" => $setting->start_at,
			"finish_at" => $setting->finish_at
		]);
	}

	public function get_messages()
	{
		$messages = Model_Message::find("all",[
			"order_by" => [
				["created_at", "desc"]
			]
		]);

		foreach($messages as $message)
		{
			$message->created_at = date("H:i:s", $message->created_at);
		}

		$this->response([
			"messages" => $messages
		]);
	}
}