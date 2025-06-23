<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExtractMailLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:extract {--output=storage/mail-logs : Output directory for extracted emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract emails from log file and save as HTML files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');
        $outputDir = $this->option('output');
        
        if (!File::exists($logFile)) {
            $this->error('No log file found at: ' . $logFile);
            return 1;
        }

        // Create output directory
        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        $this->info("📧 Extracting emails from: {$logFile}");
        $this->info("📁 Saving to: {$outputDir}");
        $this->line('');

        // Read the log file
        $content = File::get($logFile);
        
        // Split content by email boundaries
        $emails = $this->extractEmails($content);
        
        $extractedCount = 0;
        foreach ($emails as $index => $email) {
            if (!empty($email['html'])) {
                $filename = $this->generateFilename($email, $index);
                $filepath = $outputDir . '/' . $filename;
                
                File::put($filepath, $email['html']);
                $extractedCount++;
                
                $this->line("✅ Saved: {$filename}");
                if ($email['subject']) {
                    $this->line("   Subject: {$email['subject']}");
                }
                if ($email['to']) {
                    $this->line("   To: {$email['to']}");
                }
                $this->line('');
            }
        }

        $this->info("🎉 Successfully extracted {$extractedCount} emails!");
        $this->line("📂 Open the files in your browser to view them properly");
        $this->line("🌐 Or run: php artisan serve --port=8001");
        $this->line("   Then visit: http://localhost:8001/storage/mail-logs/");
    }

    private function extractEmails($content)
    {
        $emails = [];
        $currentEmail = [];
        $inEmail = false;
        $inHtml = false;
        $htmlContent = '';
        
        $lines = explode("\n", $content);
        
        foreach ($lines as $line) {
            // Check for email start
            if (preg_match('/^From: (.+)$/', $line, $matches)) {
                if ($inEmail) {
                    $emails[] = $currentEmail;
                }
                $currentEmail = [
                    'from' => trim($matches[1]),
                    'subject' => '',
                    'to' => '',
                    'html' => ''
                ];
                $inEmail = true;
                $inHtml = false;
                $htmlContent = '';
            }
            
            // Extract subject
            elseif (preg_match('/^Subject: (.+)$/', $line, $matches)) {
                $currentEmail['subject'] = trim($matches[1]);
            }
            
            // Extract to
            elseif (preg_match('/^To: (.+)$/', $line, $matches)) {
                $currentEmail['to'] = trim($matches[1]);
            }
            
            // Check for HTML content start
            elseif (strpos($line, 'Content-Type: text/html') !== false) {
                $inHtml = true;
            }
            
            // Collect HTML content
            elseif ($inHtml) {
                if (preg_match('/^--[a-zA-Z0-9]+$/', trim($line))) {
                    // End of email
                    $currentEmail['html'] = $htmlContent;
                    $emails[] = $currentEmail;
                    $inEmail = false;
                    $inHtml = false;
                    $htmlContent = '';
                } else {
                    $htmlContent .= $line . "\n";
                }
            }
        }
        
        // Add the last email if exists
        if ($inEmail) {
            $currentEmail['html'] = $htmlContent;
            $emails[] = $currentEmail;
        }
        
        return $emails;
    }

    private function generateFilename($email, $index)
    {
        $timestamp = date('Y-m-d_H-i-s');
        $subject = $email['subject'] ?: 'no-subject';
        $subject = preg_replace('/[^a-zA-Z0-9\s-]/', '', $subject);
        $subject = preg_replace('/\s+/', '-', trim($subject));
        $subject = substr($subject, 0, 50);
        
        return "email_{$timestamp}_{$index}_{$subject}.html";
    }
} 