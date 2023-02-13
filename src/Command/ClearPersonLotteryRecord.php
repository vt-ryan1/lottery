<?php

namespace Victtech\Lottery\Command;
use Illuminate\Console\Command;

class ClearPersonLotteryRecord extends Command
{
    protected $signature = 'lottery:clearPersonRecord';
    protected $description = 'clear person record';

    public function handle()
    {
        $infoPath = storage_path('/logs/').'vt_lucky_person.log';
        $this->info('clear person lottery info file.');
        if(file_exists($infoPath)){
            unlink($infoPath);
        }
        $this->info('clear success.');
    }
}
