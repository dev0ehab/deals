<?php

namespace Tests\Unit;

use App\Services\PageCountExtractorService;
use PHPUnit\Framework\TestCase;

class PageCountExtractorTest extends TestCase
{
    private PageCountExtractorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PageCountExtractorService();
    }

    public function test_get_file_type()
    {
        $this->assertEquals('pdf', $this->service->getFileType('application/pdf'));
        $this->assertEquals('ppt', $this->service->getFileType('application/vnd.ms-powerpoint'));
        $this->assertEquals('pptx', $this->service->getFileType('application/vnd.openxmlformats-officedocument.presentationml.presentation'));
        $this->assertEquals('unknown', $this->service->getFileType('text/plain'));
    }

    public function test_get_page_count_with_invalid_file()
    {
        $result = $this->service->getPageCount('non-existent-file.pdf', 'application/pdf');
        $this->assertEquals(0, $result);
    }

    public function test_get_page_count_with_unsupported_mime_type()
    {
        $result = $this->service->getPageCount('test.txt', 'text/plain');
        $this->assertEquals(0, $result);
    }
}
