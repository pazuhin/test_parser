<?php

namespace app\service;

use app\service\provider\ProviderInterface;

class WorldsAtrService
{
    /** @var  ProviderInterface */
    protected $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param \DateTime $time
     */
    public function fetchTopByDate(\DateTime $time = null)
    {
        return $this->provider->fetchTopByDate($time);
    }
}