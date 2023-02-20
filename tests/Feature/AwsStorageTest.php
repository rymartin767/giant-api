<?php

use Illuminate\Support\Facades\Storage;

test('connection to AWS S3 private bucket', function () {
    $path = '/images/events/test-image.webp';
    $this->assertTrue(Storage::disk('s3')->exists($path));
});

test('connection to AWS S3 public bucket', function () {
    $path = '/images/events/test-image.webp';
    $this->assertTrue(Storage::disk('s3-public')->exists($path));
});
