<?php

namespace Fuel\Tasks;

use Oil\Exception;

class Ranking
{
	public static function calc()
	{
		$teams = \Model_Team::find("all", [
			"where" => [
				["deleted_at", 0]
			]
		]);

		$time = time();

		$rankings = [];

		foreach($teams as $team)
		{
			$rankings["{$team->id}"] = \Model_Ranking::forge();
			$rankings["{$team->id}"]->team_id = $team->id;
		}



		$query_text = <<<EOT
SELECT q.id,
       q.point,
       a.team_id,
       q.first_point,
       a.created_at
FROM questions q
LEFT OUTER JOIN categories c
ON(q.category_id = c.id AND c.deleted_at = 0)
LEFT OUTER JOIN answerlogs a
ON(q.id = a.question_id and is_corrected = 1)
WHERE q.deleted_at = 0
ORDER BY q.id DESC, a.created_at ASC
EOT;

		$query = \DB::query($query_text);

		$questions = $query->execute()->as_array();

		$now = 0;

		foreach($questions as $question)
		{
			if($question["team_id"])
			{
				if($now == 0 || $question["id"] != $now)
				{
					$now = $question["id"];
					$rankings[$question["team_id"]]->first_point += $question["first_point"];
				}

				if($rankings[$question["team_id"]]->last_solved_at < $question["created_at"])
				{
					$rankings[$question["team_id"]]->last_solved_at = $question["created_at"];
				}

				$rankings[$question["team_id"]]->score += $question["point"];
			}
		}

		foreach($teams as $team)
		{
			$rankings["{$team->id}"]->total_score = $rankings["{$team->id}"]->first_point + $rankings["{$team->id}"]->score;
			$rankings["{$team->id}"]->calculated_at = $time;
			$rankings["{$team->id}"]->save();
		}

	}
}