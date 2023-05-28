<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailToPayerJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        // Logo('construtor send');
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // throw new Exception("Error Processing Request", 1);
    }
}
