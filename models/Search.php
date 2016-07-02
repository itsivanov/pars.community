<?php

namespace app\models;

use Yii;

class Search
{

	public $fields;
	public $table;
	public $offset = 0;
	public $limit  = 9;


	public function getSearchWords($req)
	{
	  $req = explode(' ', $req);

		$result = array_filter($req, function($val) {
			return (mb_strlen($val) > 1) ? true : false;
		});

	  return $result;
	}

	public function getQueryData($searchWords)
	{

		$query = (new \yii\db\Query())
			->select(['*'])
			->from($this->table)
			->limit($this->limit)
			->offset($this->offset);

		$i = 0;
		foreach ($searchWords as $word) {

			foreach ($this->fields as $name => $count) {

				$query->orWhere("`{$name}` LIKE :word{$i}");
				$query->addOrderBy("case WHEN `{$name}` LIKE :word{$i} THEN {$count} END DESC");

				if ($this->fields[$name] > 1) $this->fields[$name]--;
			}

			$i++;

		}

		$command      = $query->createCommand();
		$commandCount = $query->select('COUNT(*) AS count')->createCommand();

		$i = 0;
		foreach ($searchWords as $word) {
			$command->bindValue(":word{$i}",'%'.$word.'%');
			$commandCount->bindValue(":word{$i}",'%'.$word.'%');
			$i++;
		}

		$counter = $commandCount->queryOne();

		return ['data'=>$command->queryAll(),'count'=>$counter['count']];
	}

  public function search($req)
  {
      $searchWords = $this->getSearchWords($req);

      if (count($searchWords) == 0) return false;

			return $this->getQueryData($searchWords);

   }
}
