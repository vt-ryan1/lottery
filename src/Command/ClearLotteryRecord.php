<?php

namespace Victtech\Lottery\Command;
use Illuminate\Console\Command;

class ClearLotteryRecord extends Command
{
    protected $signature = 'lottery:clearRecord';
    protected $description = 'clear award record';

    public function handle()
    {
        $infoPath = storage_path('/logs/').'vt_award_info.log';
        $this->info('clear award info file.');
        if(file_exists($infoPath)){
            unlink($infoPath);
        }
        $this->info('clear success.');
    }
}
