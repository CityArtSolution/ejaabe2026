<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\User;
use App\Models\Category;
use App\Models\Role;
use App\Models\Webinar;
use Illuminate\Support\Facades\DB;


class ScormCourseController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'scorm' => ['required', 'file', 'mimes:zip'],
        ], [
            'title.required' => 'يرجى إدخال عنوان الكورس.',
            'scorm.required' => 'يرجى اختيار ملف SCORM (ZIP).',
            'scorm.mimes' => 'يجب أن يكون الملف بصيغة ZIP.',
        ]);

        $disk = Storage::disk('local');

        $uploadedFile = $request->file('scorm');
        $originalName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd_His');
        $safeBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $archiveName = $safeBaseName . '_' . $timestamp . '.zip';

        // Save archive under private disk
        $storedArchivePath = $disk->putFileAs('scorm_uploads', $uploadedFile, $archiveName);

        // Extract under 'scorm/<folder>' so existing player route can serve it
        $folderName = $safeBaseName . '_' . $timestamp;
        $extractFolder = 'scorm/' . $folderName;
        $absoluteExtractPath = $disk->path($extractFolder);
        if (!is_dir($absoluteExtractPath)) {
            mkdir($absoluteExtractPath, 0755, true);
        }

        $zip = new ZipArchive();
        $absoluteArchivePath = $disk->path($storedArchivePath);
        $realArchivePath = realpath($absoluteArchivePath) ?: $absoluteArchivePath;
        $openResult = $zip->open($realArchivePath);
        if ($openResult !== true) {
            return back()->withErrors(['scorm' => 'تعذّر فتح ملف الـ ZIP. الكود: ' . $openResult])->withInput();
        }
        if (!$zip->extractTo($absoluteExtractPath)) {
            $zip->close();
            return back()->withErrors(['scorm' => 'تعذّر استخراج محتويات الملف.'])->withInput();
        }
        $zip->close();

        $manifestAbsolutePath = $this->findManifest($absoluteExtractPath);

        $launchPath = null;
        $files = $this->listFilesRecursively($absoluteExtractPath, $absoluteExtractPath);
        if ($manifestAbsolutePath && file_exists($manifestAbsolutePath)) {
            $launchPath = $this->determineLaunchPathFromManifest($manifestAbsolutePath, $absoluteExtractPath);
        }
        if ($launchPath === null) {
            $launchPath = $this->findCommonLaunchFile($files);
        }
        if ($launchPath === null) {
            $launchPath = 'index.html';
        }

        // Build play URL using existing route
        $playUrl = route('scorm.asset', ['folder' => $folderName, 'path' => $launchPath]);

        return view('scorm.course_create', [
            'form' => [
                'title' => $request->input('title'),
                'category' => $request->input('category'),
                'price' => $request->input('price'),
            ],
            'folderName' => $folderName,
            'launchPath' => $launchPath,
            'playUrl' => $playUrl,
        ]);
    }

    private function listFilesRecursively(string $basePath, string $rootPath): array
    {
        $results = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir()) {
                continue;
            }
            $absolutePath = $fileInfo->getPathname();
            $relativePath = ltrim(str_replace($rootPath, '', $absolutePath), DIRECTORY_SEPARATOR);
            $results[] = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
        }
        sort($results);
        return $results;
    }

    private function findManifest(string $extractRoot): ?string
    {
        $candidate = $extractRoot . DIRECTORY_SEPARATOR . 'imsmanifest.xml';
        if (file_exists($candidate)) {
            return $candidate;
        }
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($extractRoot, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && strtolower($fileInfo->getFilename()) === 'imsmanifest.xml') {
                return $fileInfo->getPathname();
            }
        }
        return null;
    }

    private function determineLaunchPathFromManifest(string $manifestAbsolutePath, string $absoluteExtractPath): ?string
    {
        try {
            $xml = simplexml_load_file($manifestAbsolutePath);
            if ($xml === false) {
                return null;
            }
            $resourceMap = [];
            if (isset($xml->resources) && isset($xml->resources->resource)) {
                foreach ($xml->resources->resource as $resource) {
                    $rid = (string)($resource['identifier'] ?? '');
                    $href = (string)($resource['href'] ?? '');
                    if ($rid !== '' && $href !== '') {
                        $resourceMap[$rid] = $href;
                    }
                }
            }
            $manifestDir = dirname($manifestAbsolutePath);
            $manifestDirRel = $this->relativePath($absoluteExtractPath, $manifestDir);
            $organizations = $xml->organizations->organization ?? [];
            foreach ($organizations as $organization) {
                foreach ($organization->item as $item) {
                    $href = $this->findFirstHrefFromItems($item, $resourceMap);
                    if ($href) {
                        return ltrim(($manifestDirRel !== '' ? $manifestDirRel . '/' : '') . $href, '/');
                    }
                }
            }
            // fallback next to manifest
            if (file_exists($manifestDir . DIRECTORY_SEPARATOR . 'index.html')) {
                return ltrim(($manifestDirRel !== '' ? $manifestDirRel . '/' : '') . 'index.html', '/');
            }
        } catch (\Throwable $e) {
            return null;
        }
        return null;
    }

    private function findFirstHrefFromItems(\SimpleXMLElement $item, array $resourceMap): ?string
    {
        $ref = (string)($item['identifierref'] ?? '');
        if ($ref !== '' && isset($resourceMap[$ref])) {
            return $resourceMap[$ref];
        }
        foreach ($item->item as $child) {
            $href = $this->findFirstHrefFromItems($child, $resourceMap);
            if ($href) {
                return $href;
            }
        }
        return null;
    }

    private function relativePath(string $fromAbsolute, string $toAbsolute): string
    {
        $from = rtrim(str_replace('\\', '/', realpath($fromAbsolute) ?: $fromAbsolute), '/');
        $to = rtrim(str_replace('\\', '/', realpath($toAbsolute) ?: $toAbsolute), '/');
        if (strpos($to, $from) === 0) {
            return ltrim(substr($to, strlen($from)), '/');
        }
        return '';
    }

    private function findCommonLaunchFile(array $relativeFiles): ?string
    {
        $common = [
            'index_lms.html', 'index_scorm.html', 'story_html5.html', 'story.html',
            'index.html', 'launch.html', 'start.html', 'player.html'
        ];
        $lowerCandidates = array_map('strtolower', $common);
        foreach ($relativeFiles as $relativePath) {
            $lowerBase = strtolower(basename($relativePath));
            if (in_array($lowerBase, $lowerCandidates, true)) {
                return str_replace('\\', '/', $relativePath);
            }
        }
        return null;
    }
    
    
}