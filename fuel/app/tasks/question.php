<?php

namespace Fuel\Tasks;

use Oil\Exception;

class Question
{
	public static function import($dir = "")
	{

		if($dir == "")
		{
			exit();
		}

		$categories = \Model_Category::find("all", [
			"where" => [
				["deleted_at", 0]
			]
		]);

		$category_dirs = scandir($dir);

		if($category_dirs == FALSE)
		{
			exit();
		}

		foreach($category_dirs as $category_dir)
		{
			if(!preg_match("/(^\.|README.md)/", $category_dir))
			{
				$has_category = false;

				foreach($categories as $category)
				{
					if($category->title == $category_dir)
					{

						$has_category = true;
						break;
					}
				}

				if(!$has_category)
				{
					$category = \Model_Category::forge();
					$category->title = $category_dir;
					$category->save();
				}

				$question_dirs = scandir("{$dir}/{$category_dir}");

				foreach($question_dirs as $question_dir)
				{
					if(!preg_match("/(^\.)/", $question_dir))
					{
						if(file_exists("{$dir}/{$category_dir}/{$question_dir}/question.txt"))
						{
							$title = "";
							$body = "";

							$file = fopen("{$dir}/{$category_dir}/{$question_dir}/question.txt", "r");

							$count = 0;
							if($file)
							{
								while($line = fgets($file))
								{
									if($count == 0)
									{
										$title = preg_replace('/(?:\n|\r|\r\n)/', '', $line);
									}
									else
									{
										$body = $body . $line;
									}
									$count++;
								}
							}
							fclose($file);

							$flag = "";
							if(file_exists("{$dir}/{$category_dir}/{$question_dir}/flag.txt"))
							{
								$flag = preg_replace('/(?:\n|\r|\r\n)/', '', file_get_contents("{$dir}/{$category_dir}/{$question_dir}/flag.txt"));
							}

							// check
							$question = \Model_Question::find("first",[
								"where" => [
									["title", $title],
									["category_id", $category->id],
									["deleted_at", 0]
								]
							]);

							if($question == null)
							{
								$question = \Model_Question::forge();
								$question->title = $title;
								$question->body = $body;
								$question->answer = $flag;
								$question->point = 100;
								$question->first_point = 0;
								$question->category_id = $category->id;
								$question->save();

								echo "{{$category_dir}/{$question_dir}}:OK\n";
							}
							else
							{
								echo "{{$category_dir}/{$question_dir}}:Duplicate title\n";
							}
						}
						else
						{
							echo "{{$category_dir}/{$question_dir}}:Nothing question.txt\n";
						}
					}
				}

			}
		}
	}
}