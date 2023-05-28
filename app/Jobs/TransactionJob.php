<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Repositories\UserRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $tries = 3;
    protected $data;
    protected $modelRepository;
    protected $userRepository;
    /**
     * Create a new job instance.
     */
    public function __construct($data, TransactionRepository $modelRepository, UserRepository $userRepository)
    {
        $this->data = $data;
        $this->modelRepository = $modelRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->modelRepository->beginTransaction();
        $this->modelRepository->save([
           
    ]);
        $this->modelRepository->rollBackTransaction();
        $this->modelRepository->commitTransaction();
    }
}
