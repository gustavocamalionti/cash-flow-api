<?php

namespace App\Jobs;

use App\Repositories\TransactionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $modelRepository;
    /**
     * Create a new job instance.
     */
    public function __construct($data, TransactionRepository $modelRepository)
    {
        $this->data = $data;
        $this->modelRepository = $modelRepository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->modelRepository->beginTransaction();
        $this->modelRepository->rollBackTransaction();
        $this->modelRepository->commitTransaction();
    }
}
