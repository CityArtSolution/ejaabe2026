<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class ContentsController extends Controller
{
    private function formatContent($content) {
      // Convert double newlines into paragraph tags
    $content = preg_replace("/\n{2,}/u", "</p>\n<p>", $content);
    
    // Ensure each line starts and ends correctly in a paragraph
    $content = "<p>" . trim($content) . "</p>";
    
    // Convert bullet points (- or •) into an unordered list <ul>
    $content = preg_replace('/\n\s*[\-\•]\s*(.+)/u', '<li>$1</li>', $content);

    // Convert numbered lists (1. or 1) into an ordered list <ol>
    $content = preg_replace('/\n\s*\d+\.\s*(.+)/u', '<li>$1</li>', $content);
    $content = preg_replace('/\n\s*\d+\)\s*(.+)/u', '<li>$1</li>', $content);

    // Wrap <li> elements inside <ul> or <ol> where applicable
    if (strpos($content, '<li>') !== false) {
        $content = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $content);
    }

    // Convert headers by detecting lines with important words
    $content = preg_replace('/\n?([^\n]{5,30})\n/u', '<h2>$1</h2>', $content, 1);

    // Ensure proper spacing for readability
    $content = str_replace("<p></p>", "", $content);
    
    return $content;
    }

    public function index($link)
    {
        $firstCharacter = substr($link, 0, 1);
        if ($firstCharacter !== '/') {
            $link = '/' . $link;
        }

        if ($link == '/content_development') {
            $title = app()->getLocale() == 'ar' ? 'تطوير المحتوى' : 'Content Development';

            $data = [
                'pageTitle' => $title,
            ];
            return view('web.default.contents.content_development_' . app()->getLocale(), $data);
        } else {
            $page = Page::where('link', $link)
                ->where('status', 'publish')
                ->first();

            if (!empty($page)) {
                $page->content = $this->formatContent($page->content); // Use $this->formatContent()

                $data = [
                    'pageTitle' => $page->title,
                    'pageDescription' => $page->seo_description,
                    'pageRobot' => $page->robot ? 'index, follow, all' : 'NOODP, nofollow, noindex',
                    'page' => $page
                ];

                return view('web.default.pages.other_pages', $data);
            }
        }

        abort(404);
    }
}
