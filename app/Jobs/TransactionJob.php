<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Services\TransactionService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TransactionJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    protected $data;
    protected $transactionService;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->transactionService = $this->injectTransactionService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->transactionService->executeTransaction($this->data);
        // throw new Exception("Error Processing Request", 1);  
    }


    public function injectTransactionService()
    {
        return resolve(TransactionService::class);
    }
}
