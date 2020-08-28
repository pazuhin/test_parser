<?php


namespace app\service\provider;
use app\components\Parser as Parser;
use Clue\React\Buzz\Browser;
use DateTime;
use React\EventLoop\Factory;

class ParserWorldsArtProvider implements ProviderInterface
{
    /** @var  Parser */
    private $parser;

    /**
     * ParserWorldsArt constructor.
     */
    public function __construct()
    {
        $loop = Factory::create();
        $client = new Browser($loop);
        $this->parser = new Parser($client, $loop);
    }

    /**
     * @param DateTime $time
     */
    public function fetchTopByDate(DateTime $time = null)
    {
        $this->parser->getRecordByDate();
        $list = [];
        foreach ($this->parser->getRecordByDate($time) as $n => $record) {
            $list[] = $record;
        }

        return $list;
    }
}