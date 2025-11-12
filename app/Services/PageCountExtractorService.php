<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
// use PhpOffice\PhpPresentation\IOFactory; // Uncomment when package is installed
use ZipArchive;

class PageCountExtractorService
{
    /**
     * Extract page count from various file types
     *
     * @param string $filePath
     * @param string $mimeType
     * @return int
     */
    public function getPageCount(string $filePath, string $mimeType): int
    {
        try {
            switch ($mimeType) {
                case 'application/pdf':
                    return $this->getPdfPageCount($filePath);

                case 'application/vnd.ms-powerpoint':
                    return $this->getPptPageCount($filePath);

                case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                    return $this->getPptxPageCount($filePath);

                default:
                    return 0;
            }
        } catch (Exception $e) {
            Log::error('Error extracting page count: ' . $e->getMessage(), [
                'file_path' => $filePath,
                'mime_type' => $mimeType
            ]);
            return 0;
        }
    }

    /**
     * Extract page count from PDF files
     *
     * @param string $filePath
     * @return int
     */
    private function getPdfPageCount(string $filePath): int
    {
        try {
            // Method 1: Simple regex approach
            $content = file_get_contents($filePath);
            if ($content === false) {
                return 0;
            }

            // Look for /Type/Page pattern
            preg_match_all('/\/Type\s*\/Page[^s]/', $content, $matches);
            $pageCount = count($matches[0]);

            if ($pageCount > 0) {
                return $pageCount;
            }

            // Method 2: Look for /Count pattern in the document
            preg_match('/\/Count\s+(\d+)/', $content, $matches);
            if (isset($matches[1])) {
                return (int) $matches[1];
            }

            // Method 3: Look for /N pattern (number of pages)
            preg_match('/\/N\s+(\d+)/', $content, $matches);
            if (isset($matches[1])) {
                return (int) $matches[1];
            }

            return 0;
        } catch (Exception $e) {
            Log::error('Error extracting PDF page count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count from PPT files (legacy format)
     * Uses multiple methods to improve accuracy
     *
     * @param string $filePath
     * @return int
     */
    private function getPptPageCount(string $filePath): int
    {
        try {
            // Method 1: Try COM object approach (Windows only)
            if (PHP_OS_FAMILY === 'Windows' && class_exists('COM')) {
                $slideCount = $this->extractPptSlideCountUsingCOM($filePath);
                if ($slideCount > 0) {
                    return $slideCount;
                }
            }

            $content = file_get_contents($filePath);
            if ($content === false) {
                return 0;
            }

            // Method 2: Look for slide count in document properties
            $slideCount = $this->extractPptSlideCountFromProperties($content);
            if ($slideCount > 0) {
                return $slideCount;
            }

            // Method 3: Look for slide objects in the binary structure
            $slideCount = $this->extractPptSlideCountFromObjects($content);
            if ($slideCount > 0) {
                return $slideCount;
            }

            // Method 4: Look for slide markers and patterns
            $slideCount = $this->extractPptSlideCountFromPatterns($content);
            if ($slideCount > 0) {
                return $slideCount;
            }

            // Method 5: Look for slide references in the file structure
            $slideCount = $this->extractPptSlideCountFromReferences($content);

            return $slideCount;
        } catch (Exception $e) {
            Log::error('Error extracting PPT slide count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count using COM object (Windows only)
     *
     * @param string $filePath
     * @return int
     */
    private function extractPptSlideCountUsingCOM(string $filePath): int
    {
        try {
            if (!class_exists('COM')) {
                return 0;
            }

            $powerpoint = new \COM("PowerPoint.Application");
            $powerpoint->Visible = 0; // Don't show PowerPoint

            $presentation = $powerpoint->Presentations->Open($filePath);
            $slideCount = $presentation->Slides->Count;

            $presentation->Close();
            $powerpoint->Quit();

            return (int) $slideCount;
        } catch (Exception $e) {
            Log::warning('COM object method failed for PPT: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count from PPT document properties
     *
     * @param string $content
     * @return int
     */
    private function extractPptSlideCountFromProperties(string $content): int
    {
        // Look for slide count in document summary information
        $patterns = [
            '/SlideCount[^\d]*(\d+)/i',
            '/Number of Slides[^\d]*(\d+)/i',
            '/Total Slides[^\d]*(\d+)/i',
            '/Slides[^\d]*(\d+)/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content, $matches)) {
                $count = (int) $matches[1];
                if ($count > 0 && $count < 1000) { // Reasonable slide count range
                    return $count;
                }
            }
        }

        return 0;
    }

    /**
     * Extract slide count from PPT object structure
     *
     * @param string $content
     * @return int
     */
    private function extractPptSlideCountFromObjects(string $content): int
    {
        // Look for slide object references in the binary structure
        $patterns = [
            '/Slide\d+\.ppt/i',
            '/slide\d+\.ppt/i',
            '/SLIDE\d+\.PPT/i',
            '/Slide\d+\.pptx/i',
            '/slide\d+\.pptx/i'
        ];

        $maxSlideNumber = 0;
        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $matches);
            foreach ($matches[0] as $match) {
                if (preg_match('/(\d+)/', $match, $numberMatches)) {
                    $slideNumber = (int) $numberMatches[1];
                    if ($slideNumber > $maxSlideNumber) {
                        $maxSlideNumber = $slideNumber;
                    }
                }
            }
        }

        return $maxSlideNumber;
    }

    /**
     * Extract slide count from PPT patterns
     *
     * @param string $content
     * @return int
     */
    private function extractPptSlideCountFromPatterns(string $content): int
    {
        // Look for slide patterns in the binary content
        $patterns = [
            '/Slide\d+/i',
            '/slide\d+/i',
            '/SLIDE\d+/i',
            '/Slide \d+/i',
            '/slide \d+/i'
        ];

        $maxSlideNumber = 0;
        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $matches);
            foreach ($matches[0] as $match) {
                if (preg_match('/(\d+)/', $match, $numberMatches)) {
                    $slideNumber = (int) $numberMatches[1];
                    if ($slideNumber > $maxSlideNumber) {
                        $maxSlideNumber = $slideNumber;
                    }
                }
            }
        }

        return $maxSlideNumber;
    }

    /**
     * Extract slide count from PPT references
     *
     * @param string $content
     * @return int
     */
    private function extractPptSlideCountFromReferences(string $content): int
    {
        // Look for slide references in the file structure
        $patterns = [
            '/slide\d+\.xml/i',
            '/Slide\d+\.xml/i',
            '/SLIDE\d+\.XML/i',
            '/slide\d+\.bin/i',
            '/Slide\d+\.bin/i'
        ];

        $slideNumbers = [];
        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $matches);
            foreach ($matches[0] as $match) {
                if (preg_match('/(\d+)/', $match, $numberMatches)) {
                    $slideNumbers[] = (int) $numberMatches[1];
                }
            }
        }

        if (empty($slideNumbers)) {
            return 0;
        }

        // Return the highest slide number found
        return max($slideNumbers);
    }

    /**
     * Extract slide count from PPTX files using phpoffice/phppresentation
     *
     * @param string $filePath
     * @return int
     */
    private function getPptxPageCount(string $filePath): int
    {
        try {
            // Method 1: Use phpoffice/phppresentation library (most reliable)
            $slideCount = $this->extractPptxSlideCountUsingPhpOffice($filePath);
            if ($slideCount > 0) {
                return $slideCount;
            }

            // Method 2: Fallback to XML parsing
            $slideCount = $this->extractPptxSlideCountFromXml($filePath);
            if ($slideCount > 0) {
                return $slideCount;
            }

            // Method 3: Count slide files in ZIP
            return $this->extractPptxSlideCountFromZip($filePath);
        } catch (Exception $e) {
            Log::error('Error extracting PPTX slide count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count using phpoffice/phppresentation library
     *
     * @param string $filePath
     * @return int
     */
    private function extractPptxSlideCountUsingPhpOffice(string $filePath): int
    {
        try {
            // Check if the class exists
            if (!class_exists('PhpOffice\PhpPresentation\IOFactory')) {
                Log::warning('PhpOffice\PhpPresentation\IOFactory class not found. Package may not be installed.');
                return 0;
            }

            // Use the fully qualified class name since we commented out the use statement
            $presentation = \PhpOffice\PhpPresentation\IOFactory::load($filePath);
            return $presentation->getSlideCount();
        } catch (Exception $e) {
            Log::warning('PhpOffice method failed for PPTX: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count from PPTX XML structure (fallback method)
     *
     * @param string $filePath
     * @return int
     */
    private function extractPptxSlideCountFromXml(string $filePath): int
    {
        try {
            $zip = new ZipArchive();
            if ($zip->open($filePath) !== TRUE) {
                return 0;
            }

            // Check app.xml for slide count
            $appXml = $zip->getFromName('docProps/app.xml');
            if ($appXml !== false) {
                $slideCount = $this->extractSlideCountFromAppXml($appXml);
                if ($slideCount > 0) {
                    $zip->close();
                    return $slideCount;
                }
            }

            $zip->close();
            return 0;
        } catch (Exception $e) {
            Log::warning('XML method failed for PPTX: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count by counting slide files in ZIP (fallback method)
     *
     * @param string $filePath
     * @return int
     */
    private function extractPptxSlideCountFromZip(string $filePath): int
    {
        try {
            $zip = new ZipArchive();
            if ($zip->open($filePath) !== TRUE) {
                return 0;
            }

            $slideCount = 0;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (preg_match('/^ppt\/slides\/slide\d+\.xml$/', $filename)) {
                    $slideCount++;
                }
            }

            $zip->close();
            return $slideCount;
        } catch (Exception $e) {
            Log::warning('ZIP method failed for PPTX: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Extract slide count from app.xml content
     *
     * @param string $appXml
     * @return int
     */
    private function extractSlideCountFromAppXml(string $appXml): int
    {
        try {
            $dom = new \DOMDocument();
            $dom->loadXML($appXml);

            $xpath = new \DOMXPath($dom);
            $xpath->registerNamespace('app', 'http://schemas.openxmlformats.org/officeDocument/2006/extended-properties');

            // Look for Slides element
            $slidesNodes = $xpath->query('//app:Slides');
            if ($slidesNodes->length > 0) {
                return (int) $slidesNodes->item(0)->nodeValue;
            }

            // Look for Pages element as fallback
            $pagesNodes = $xpath->query('//app:Pages');
            if ($pagesNodes->length > 0) {
                return (int) $pagesNodes->item(0)->nodeValue;
            }

            return 0;
        } catch (Exception $e) {
            Log::error('Error parsing app.xml: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get file type from MIME type
     *
     * @param string $mimeType
     * @return string
     */
    public function getFileType(string $mimeType): string
    {
        switch ($mimeType) {
            case 'application/pdf':
                return 'pdf';
            case 'application/vnd.ms-powerpoint':
                return 'ppt';
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                return 'pptx';
            default:
                return 'unknown';
        }
    }

    /**
     * Debug method to get detailed extraction information
     *
     * @param string $filePath
     * @param string $mimeType
     * @return array
     */
    public function debugPageCountExtraction(string $filePath, string $mimeType): array
    {
        $debug = [
            'file_path' => $filePath,
            'mime_type' => $mimeType,
            'file_type' => $this->getFileType($mimeType),
            'file_exists' => file_exists($filePath),
            'file_size' => file_exists($filePath) ? filesize($filePath) : 0,
            'methods_tried' => [],
            'final_count' => 0
        ];

        if ($mimeType === 'application/vnd.ms-powerpoint') {
            $content = file_get_contents($filePath);
            if ($content !== false) {
                // Test each method
                $debug['methods_tried']['properties'] = $this->extractPptSlideCountFromProperties($content);
                $debug['methods_tried']['objects'] = $this->extractPptSlideCountFromObjects($content);
                $debug['methods_tried']['patterns'] = $this->extractPptSlideCountFromPatterns($content);
                $debug['methods_tried']['references'] = $this->extractPptSlideCountFromReferences($content);

                if (PHP_OS_FAMILY === 'Windows' && class_exists('COM')) {
                    $debug['methods_tried']['com_object'] = $this->extractPptSlideCountUsingCOM($filePath);
                }
            }
        } elseif ($mimeType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
            // Test PPTX methods
            $debug['methods_tried']['phpoffice'] = class_exists('PhpOffice\PhpPresentation\IOFactory')
                ? $this->extractPptxSlideCountUsingPhpOffice($filePath)
                : 'Class not found';
            $debug['methods_tried']['xml_parsing'] = $this->extractPptxSlideCountFromXml($filePath);
            $debug['methods_tried']['zip_counting'] = $this->extractPptxSlideCountFromZip($filePath);
        }

        $debug['final_count'] = $this->getPageCount($filePath, $mimeType);

        return $debug;
    }
}
