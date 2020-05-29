<?php

namespace App\Jobs;

use App\Notifications\ProductionApproved as Notification;
use App\Production;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductionApprovedNotifier implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    protected $production;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Production $roduction)
    {
        $this->production = $roduction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userData = User::where('branch_id', $this->production->branch_id)->get();
        foreach ($userData as $value) {
            if ($this->production->status == 4) {
                if ($value->can('Approve-Production')) {
                    $value->notify(new Notification($this->production));
                }
                if ($value->can('Create-Production')) {
                    $value->notify(new Notification($this->production));
                }
            } elseif ($this->production->status == 3 || $this->production->status == 0) {
                if ($value->can('Create-Production')) {
                    $value->notify(new Notification($this->production));
                }
            }
        }
    }
}
