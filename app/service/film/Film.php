<?php


namespace app\service\film;

use DateTime;

class Film
{
    /** @var  int */
    public $position;
    /** @var  int */
    public $categoryId;
    /** @var  string */
    public $img;
    /** @var  string */
    public $story;
    /** @var  float */
    public $rating;
    /** @var  string */
    public $name;
    /** @var  int */
    public $year;
    /** @var  int */
    public $numberVoted;
    /** @var  DateTime */
    public $date;
    /**
     * @var float
     */
    public $score;

    /**
     * Film constructor.
     * @param int $position
     * @param null $category
     * @param null $img
     * @param null $story
     * @param null $score
     * @param float $rating
     * @param string $name
     * @param int $year
     * @param int $numberVoted
     * @param DateTime $date
     */
    public function __construct($position = null, $category = null, $img = null, $story = null, $score = null, $rating = null, $name = null, $year = null, $numberVoted = null, DateTime $date = null)
    {
        $this->position = $position;
        $this->categoryId = $category;
        $this->img = $img;
        $this->story = $story;
        $this->score = $score;
        $this->rating = $rating;
        $this->name = $name;
        $this->year = $year;
        $this->numberVoted = $numberVoted;
        $this->date = $date;
        $this->score = $score;
    }
}