<?php
namespace app\service\provider;

use DateTime;

interface ProviderInterface
{
    /**
     * @param DateTime $time
     */
    public function fetchTopByDate(DateTime $time = null);
}