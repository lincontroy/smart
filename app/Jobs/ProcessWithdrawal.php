<?php

namespace App\Jobs;

use App\Models\Withdrawal;
use App\Notifications\WithdrawalRequested;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWithdrawal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function handle()
    {
        // In a real app, this would process the actual withdrawal
        // For now, we'll just simulate processing
        
        sleep(5); // Simulate processing time
        
        // Update status to completed
        $this->withdrawal->update(['status' => 'completed']);
        
        // Notify user
        $this->withdrawal->user->notify(new WithdrawalRequested($this->withdrawal));
    }
}