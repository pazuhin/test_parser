<?php


namespace app\controllers;

use app\service\provider\ParserWorldsArtProvider;
use app\service\WorldsAtrService;
use crm\core\Cache;
use RedBeanPHP\R;

class MainController extends AppController
{
    /**
     * @var
     */
    protected $cashDate;

    public function indexAction()
    {
        $this->cashDate = $_GET['date'] ?? '';
        $cache = Cache::instance();
        $groupFilms = $cache->get($this->cashDate);
        if (!$groupFilms) {
            $films = R::getAll("
            WITH
                a AS (select c.name as cat, f.date as date, f.position as pos, f.img as img, f.name as name, f.rating as rait, f.votes as votes, f.score as score, f.year as year from films f join categories c on f.category_id = c.id order by f.rating DESC limit 10)
            SELECT * FROM a where date = '{$this->cashDate}' order by a.cat
            ");
            $groupFilms = [];
            foreach ($films as $n => $film) {
                $groupFilms[$film['cat']][] = $film;
            }
            if ($films) {
                $cache->set($this->cashDate, $groupFilms);
            } else {
                if ($this->isAjax()) {
                    exit('false');
                }
            }
        }

        $this->set(compact('groupFilms'));
    }

    public function parseAction()
    {
        $worldService = new WorldsAtrService(new ParserWorldsArtProvider());
        $collection = $worldService->fetchTopByDate();

        $beans = [];

        foreach ($collection as $film) {
            $bean = R::dispense('films');
            $bean->position = $film->position;
            $bean->rating = $film->rating;
            $bean->name = $film->name;
            $bean->year = $film->year;
            $bean->votes = $film->numberVoted;
            $bean->score = $film->score;
            $bean->story = $film->story;
            $bean->img = $film->img;
            $bean->date = $film->date;
            $bean->category_id = $film->categoryId;
            $bean->score = $film->score;
            $beans[] = $bean;
        }

        R::storeAll($beans);
    }
}