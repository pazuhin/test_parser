<?php


namespace app\service\film;

use DateTime;

class FilmBuilder
{
    /** @var  int */
    protected $position;
    /** @var  int */
    protected $categoryId;
    /** @var  string */
    protected $img;
    /** @var  string */
    protected $story;
    /** @var  float */
    protected $rating;
    /** @var  string */
    protected $name;
    /** @var  int */
    protected $year;
    /** @var  int */
    protected $numberVoted;
    /** @var  DateTime */
    protected $date;

    /**
     * FilmBuilder constructor.
     * @param array $properties
     * @throws \Exception
     */
    public function __construct(array $properties = [])
    {
        foreach ($properties as $name => $value) {
            if ($name == 'date') {
                $value = new DateTime($value);
            }

            $this->{'set' . $name}($value);
        }
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param float $score
     * @return $this
     */
    public function setScore(float $score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @param string $story
     * @return $this
     */
    public function setStory(string $story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * @param int $categoryId
     * @return $this
     */
    public function setCategory(int $categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @param string $img
     * @return $this
     */
    public function setImg(string $img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @param float $rating
     * @return $this
     */
    public function setRating(float $rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function setYear(int $year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @param int $numberVoted
     * @return $this
     */
    public function setNumberVoted(int $numberVoted)
    {
        $this->numberVoted = $numberVoted;

        return $this;
    }

    /**
     * @param DateTime $date
     * @return $this
     */
    public function setDate(?DateTime $date)
    {
        $this->date = $date;

        return $this;
    }


    public function create()
    {
        return new Film(
            $this->position,
            $this->categoryId,
            $this->img,
            $this->story,
            $this->score,
            $this->rating,
            $this->name,
            $this->year,
            $this->numberVoted,
            $this->date
        );
    }
}