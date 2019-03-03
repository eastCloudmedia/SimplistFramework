<?php
/**
 * Created by PhpStorm.
 * User: farva
 * Date: 21/03/2018
 * Time: 03:07 AM
 */

namespace Model\Repository\MainFunction;


use Model\Repository\BaseRepository;

class UrlRepository extends BaseRepository
{
    private $target = "target";
    private $String="";
    public function __construct()
    {
        parent::__construct();
        $this->Table = "urls";
        $this->PrimaryKey = "Id";
    }
    public function Insert($Url,$Target)
    {
        self::StringGenerator($Url);
        $Result = $this->rStatement->Commander("INSERT INTO {$this->Table} (url, target) VALUES ('".$this->String."','".$Target."')");
        $Result->fetch(\PDO::FETCH_COLUMN);
        return $Result->rowCount();
    }
    public function Update($Id,$Url,$Target)
    {

        $Result = $this->rStatement->Commander("UPDATE {$this->Table} SET url='".$Url."', target='".$Target."' WHERE {$this->PrimaryKey}='".$Id."'");
        return ['Values'=>$Result->fetchAll(\PDO::FETCH_ASSOC),'Rows'=>$Result->rowCount()];

    }
    public function Delete($Id)
    {
        $Result = $this->rStatement->Commander("DELETE FROM {$this->Table} WHERE {$this->PrimaryKey}='".$Id."'");
        return ['Values'=>$Result->fetchAll(\PDO::FETCH_ASSOC),'Rows'=>$Result->rowCount()];

    }
    public function FindByUrl($Url)
    {
        $Result = $this->rStatement->Commander("SELECT * FROM {$this->Table} WHERE url='".$Url."'");
        return ['Values'=>$Result->fetchAll(\PDO::FETCH_ASSOC),'Rows'=>$Result->rowCount()];
    }
	public function FindById($Id)
	{
		$Result = $this->rStatement->Commander("SELECT * FROM {$this->Table} WHERE Id='".$Id."'");
		return ['Values'=>$Result->fetchAll(\PDO::FETCH_ASSOC),'Rows'=>$Result->rowCount()];
	}
    public function FindUrl()
    {
        $Result = $this->rStatement->Commander("SELECT * FROM {$this->Table}");
        return $Result->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function Counter($Url)
    {

        $Result = $this->rStatement->Commander("UPDATE {$this->Table} SET clicks=clicks+1 WHERE url='".$Url."'");
        return ['Values'=>$Result->fetchAll(\PDO::FETCH_ASSOC),'Rows'=>$Result->rowCount()];

    }
    public function StringGenerator($Url)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        if ($Url!="" || $Url!=null)
        {
            $this->String=$Url;

        }
        else
        {
            for ($i = 0; $i < 5; $i++) {
                $this->String .= $characters[rand(0, $charactersLength - 1)];
            }
        }

    }
}