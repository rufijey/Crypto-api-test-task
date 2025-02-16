<?php

namespace App\Scheduler;

use Symfony\Component\Console\Messenger\RunCommandMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsSchedule]
final class LoadDataSchedule implements ScheduleProviderInterface
{
    public function __construct()
    {
    }

    public function getSchedule(): Schedule
    {

        return (new Schedule())
            ->with(
                RecurringMessage::cron('1 * * * *', new RunCommandMessage('rates:load'))
            );
    }
}
