<?php
namespace app\components;

use app\service\film\FilmBuilder;
use Clue\React\Buzz\Browser;
use crm\core\App;
use DateTime;
use DiDom\Document;
use DiDom\Element;
use Psr\Http\Message\ResponseInterface;
use Factory;

class Parser
{
    /**
     * @var Browser
     */
    private $client;

    /**
     * @var array
     */
    private $arrayFilms = [];
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var \React\EventLoop\LoopInterface
     */
    private $loop;

    CONST URL = 'http://www.world-art.ru/cinema/';

    protected $urls = [
        self::URL . 'rating_tv_top.php?public_list_anchor=1',
        self::URL . 'rating_tv_top.php?public_list_anchor=2'
    ];

    /**
     * @var DateTime
     */
    private $dateTime;

    const ENCODING = 'windows-1251';

    /**
     * Parser constructor.
     * @param Browser $client
     * @param  $loop
     */
    public function __construct($client, $loop)
    {
        $this->client = $client;
        $this->loop = $loop;
    }

    public function getLinks($url)
    {
        $this->parse($url, 0, true);
    }

    public function getRecordByDate(DateTime $dateTime = null)
    {
        foreach ($this->urls as $url) {
            $this->getLinks($url);
            foreach ($this->arrayFilms as $key => $item) {
                $this->parse(self::URL . $item['link'], 0, false, true);
            }
            foreach ($this->arrayFilms as $film) {
                yield $this->buildFilm($film);
            }
        }
    }

    protected function buildFilm(array $data)
    {
        return (new FilmBuilder())
            ->setPosition($data['num'])
            ->setRating($data['raiting'])
            ->setNumberVoted($data['voices'])
            ->setYear($data['year'])
            ->setName($data['title'])
            ->setCategory($data['category_id'])
            ->setImg($data['img'])
            ->setStory($data['story'])
            ->setScore($data['score'])
            ->setDate($this->dateTime ?: new DateTime('now'))
            ->create();
    }

    public function parse($url, $timeout = 0, $flag = false, $dom = false)
    {
        if ($flag) {
            $promise = $this->client->get($url)->then(
                function (ResponseInterface $response) {
                    $this->arrayFilms = $this->parseLinks((string)$response->getBody());
                });
        }
        if ($dom) {
            $promise = $this->client->get($url)->then(
                function (ResponseInterface $response) {
                    $this->data = $this->parseDOM((string)$response->getBody());
                });
        }
        $this->loop->run();
    }

    private function parseLinks($html)
    {
        $document = new Document($html, false, self::ENCODING);
        $rows = $document->find('table')[7]->find('table')[2]->find('tr');
        $films = [];
        for ($i = 1; $i < count($rows); $i++) {
            foreach ($rows[$i]->find('a') as $link) {
                $arrLink = explode('?',$link->getAttribute('href'));
                if (in_array('cinema.php',$arrLink)) {
                    $href = $link->getAttribute('href');
                }
            }
            $arr = [];
            $year = substr(end(explode(' ', strip_tags($rows[$i]->find('td')[1]))),1,4);
            foreach ($rows[$i]->find('.review') as $item) {
                $arr[] = $item->text();
            }
            $films[$arr[1]]['num'] = $arr[0];
            $films[$arr[1]]['title'] = $arr[1];
            $films[$arr[1]]['score'] = $arr[2];
            $films[$arr[1]]['voices'] = $arr[3];
            $films[$arr[1]]['raiting'] = $arr[5];
            $films[$arr[1]]['year'] = $year;
            $films[$arr[1]]['link'] = $href;
        }

        return $films;
    }

    public function parseDOM($html)
    {
        $document = new Document($html, false, self::ENCODING);
        $table = $document->find('table')[7]->find('table')[0];
        $title = $table->find('font[size=5]')[0]->text();
        $story =  $document->find('p[class=review]')[0]->text();
        $catId = explode('=', $table->find('form')[0]->previousSibling()->find('a[class=review]')[0]->getAttribute('href'))[1];
        $commentBlock = $document->find('.comment_block')[0];
        $imgUrl = $commentBlock->find('img')[0]->getAttribute('src');
        $img = end(explode('/', $imgUrl));
        $path = ROOT . '/public/imgs';

        $sourcecode = $this->getImageFromUrl(self::URL . $imgUrl);

        if ($sourcecode && !is_file($path . "/" . $img)) {
            file_put_contents($path . "/" . $img, $sourcecode);
        }

        $this->arrayFilms[$title]['story'] = $story;
        $this->arrayFilms[$title]['category_id'] = $catId;

        $this->arrayFilms[$title]['img'] = $img;
    }

    /**
     * @param $imgUrl
     * @return bool|string
     */
    protected function getImageFromUrl($imgUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL,$imgUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}