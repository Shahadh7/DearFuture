<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewMailLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:view {--lines=50 : Number of lines to show} {--search= : Search term to filter emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View email logs when using MAIL_MAILER=log';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            $this->error('No log file found at: ' . $logFile);
            return 1;
        }

        $lines = $this->option('lines');
        $search = $this->option('search');
        
        $this->info("📧 Viewing email logs from: {$logFile}");
        $this->info("Lines: {$lines}" . ($search ? " | Search: '{$search}'" : ''));
        $this->line('');

        // Read the log file
        $content = File::get($logFile);
        $lines_array = explode("\n", $content);
        
        // Get the last N lines
        $last_lines = array_slice($lines_array, -$lines);
        
        // Filter by search term if provided
        if ($search) {
            $filtered_lines = [];
            foreach ($last_lines as $line) {
                if (stripos($line, $search) !== false) {
                    $filtered_lines[] = $line;
                }
            }
            $last_lines = $filtered_lines;
        }

        // Display the lines
        foreach ($last_lines as $line) {
            // Highlight email-related content
            if (strpos($line, 'Subject:') !== false) {
                $this->line('<fg=green>' . $line . '</>');
            } elseif (strpos($line, 'To:') !== false) {
                $this->line('<fg=blue>' . $line . '</>');
            } elseif (strpos($line, 'From:') !== false) {
                $this->line('<fg=yellow>' . $line . '</>');
            } elseif (strpos($line, 'Content-Type: text/html') !== false) {
                $this->line('<fg=magenta>--- EMAIL CONTENT START ---</>');
            } elseif (strpos($line, '--') !== false && strlen(trim($line)) <= 20) {
                $this->line('<fg=magenta>--- EMAIL CONTENT END ---</>');
            } else {
                $this->line($line);
            }
        }

        $this->line('');
        $this->info('💡 Tips:');
        $this->line('  • Use --search="Subject" to find specific emails');
        $this->line('  • Use --search="test@example.com" to find emails to specific addresses');
        $this->line('  • Use --lines=100 to see more content');
        $this->line('  • The log file is at: ' . $logFile);
    }
} 