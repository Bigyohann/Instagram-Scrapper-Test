<?php

namespace App\Console\Commands;

use App\Services\InstagramScrapService;
use Illuminate\Console\Command;
use Psr\SimpleCache\InvalidArgumentException;

class ScrapInstagramProfile extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:profile {username}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap an instagram profile with his username';

    public function __construct(private readonly InstagramScrapService $instagramScrapService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public function handle(): int
    {
        try {
            $this->instagramScrapService->retrieveInstagramPostFromUsername($this->argument('username'));
        } catch (\Exception $exception) {
            $this->output->error($exception->getMessage());
            return Command::FAILURE;
        }
        $this->output->success('Profile retrieved');
        return Command::SUCCESS;
    }
}
