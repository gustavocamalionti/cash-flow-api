<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailToPayerJob implements ShouldQueue
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
        //
    }
}
