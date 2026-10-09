<?php

namespace App\Console\Commands;

use Aws\S3\S3Client;
use Illuminate\Console\Command;
use Throwable;

class InitMinioBuckets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:init-buckets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provision MinIO S3 buckets (lms-public, lms-private, lms-videos) and configure public access';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $endpoint = config('filesystems.disks.s3.endpoint', 'http://minio:9000');
        if (! gethostbynamel('minio') && str_contains($endpoint, 'minio')) {
            $endpoint = str_replace('minio', '127.0.0.1', $endpoint);
        }
        $key = config('filesystems.disks.s3.key', 'learnify_admin');
        $secret = config('filesystems.disks.s3.secret', 'learnify_secret_password');
        $region = config('filesystems.disks.s3.region', 'us-east-1');

        $this->info("Connecting to S3 / MinIO at: {$endpoint}...");

        $client = new S3Client([
            'version' => 'latest',
            'region' => $region,
            'endpoint' => $endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ],
        ]);

        $buckets = [
            'lms-public' => true,   // Public read policy
            'lms-private' => false, // Private
            'lms-videos' => false,  // Private / signed URLs
        ];

        foreach ($buckets as $bucket => $isPublic) {
            try {
                if (! $client->doesBucketExist($bucket)) {
                    $client->createBucket(['Bucket' => $bucket]);
                    $this->info("Created bucket: {$bucket}");
                } else {
                    $this->line("Bucket already exists: {$bucket}");
                }

                if ($isPublic) {
                    $policy = json_encode([
                        'Version' => '2012-10-17',
                        'Statement' => [
                            [
                                'Sid' => 'PublicRead',
                                'Effect' => 'Allow',
                                'Principal' => '*',
                                'Action' => ['s3:GetObject'],
                                'Resource' => ["arn:aws:s3:::{$bucket}/*"],
                            ],
                        ],
                    ]) ?: '';

                    $client->putBucketPolicy([
                        'Bucket' => $bucket,
                        'Policy' => $policy,
                    ]);
                    $this->info("Set public read policy on bucket: {$bucket}");
                }
            } catch (Throwable $e) {
                $this->error("Failed to configure bucket {$bucket}: ".$e->getMessage());
            }
        }

        $this->info('MinIO buckets initialized successfully.');

        return Command::SUCCESS;
    }
}
