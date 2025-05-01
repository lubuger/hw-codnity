<?php

namespace App\Http\Controllers;

use App\Models\News;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('News');
    }

    public function show(Request $request): JsonResponse
    {
        $sort = $request->query('sort');
        $per_page = $request->query('per_page');
        $search = $request->query('search');

        $news = News::orderBy($sort ? $sort[0]['key'] : 'created_at', $sort ? $sort[0]['order'] : 'desc')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->paginate($per_page);

        return response()->json($news);
    }

    public function parse($page = 1): void
    {
        $response = Http::get("https://news.ycombinator.com/?p=$page");
        $dom = new DOMDocument();
        $dom->loadHTML($response->body());
        $xpath = new DOMXPath($dom);
        $newsNodes = $xpath->query('//html/body/center/table/tr[3]/td/table/tr[contains(@class,"athing submission")]')->count();
        $points_counter = $title_counter = $i = 0;
        $has_more = (bool) $xpath->query('//a[contains(@class,"morelink")]')->count();
        $news = [];

        for ($j = 0; $j < $newsNodes; $j++) {
            if ($i === 0) {
                $title_counter = $i + 1;
                $points_counter = $i + 2;
            } else {
                $title_counter = $title_counter + 3;
                $points_counter = $points_counter + 3;
            }

            $id = $xpath->query('//html/body/center/table/tr[3]/td/table/tr['.$title_counter.']/@id');
            $title = $xpath->query('//html/body/center/table/tr[3]/td/table/tr['.$title_counter.']/td[3]/span/a');
            $link = $xpath->query('//html/body/center/table/tr[3]/td/table/tr['.$title_counter.']/td[3]/span/a/@href');
            $points = $xpath->query('//html/body/center/table/tr[3]/td/table/tr['.$points_counter.']/td[2]/span/span');

            if ($points->item(0)) {
                preg_match_all('!\d+!', $points->item(0)->textContent, $matches);
            } else {
                $matches[0][0] = 0;
            }

            $news[$i] = [
                'id' => (int) $id->item(0)->textContent,
                'title' => mb_convert_encoding($title->item(0)->textContent, 'ISO-8859-1', 'UTF-8'),
                'link' => $link->item(0)->textContent,
                'points' => (int) $matches[0][0],
            ];

            $i++;
        }

        foreach ($news as $row) {
            News::updateOrCreate([
                'id' => $row['id'],
            ], [
                'title' => $row['title'],
                'link' => $row['link'],
                'points' => $row['points'],
            ]);
        }

        if ($has_more) {
            $this->parse($page + 1);
        }
    }
}
