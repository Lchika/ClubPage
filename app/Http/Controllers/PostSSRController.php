<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostSSRController extends Controller
{
    // Twitter
    // Twitterbot/1.0
    private $twitterBot;
    // Facebook
    // facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)
    private $facebookBot;
    private $line;
    private $discord;
    private $skype;
    private $slack;
    private $plurk;

    public function __construct()
    {
        $this->facebookBot = "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)";
        $this->twitterBot = 'Twitterbot/1.0';
        $this->line = 'facebookexternalhit/1.1;line-poker/1.0';
        $this->discord = "Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)";
        $this->skype = "Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5";
        $this->slack = "Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)";
        $this->plurk = "Mozilla/5.0 (compatible; PlurkBot/1.0; +https://www.plurk.com/) Firefox/61.0";
    }

    public function index()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', 'TOP | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', '電子工作サークル メカトロ同好会エルチカのホームページです。作品紹介や技術コラムを掲載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }
    
    public function posts()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', 'POSTS | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', '作成した記事一覧を掲載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }
    
    public function columns()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', 'COLUMNS | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', 'コラム記事一覧を掲載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }

    public function works()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', 'WORKS | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', 'これまでに作成した、作品一覧を掲載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }

    public function news()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', 'NEWS | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', '電子工作サークル メカトロ同好会エルチカの活動履歴および活動予定を掲載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }

    public function about()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', 'ABOUT | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', '本団体 メカトロ同好会エルチカ についての情報を記載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }
    
    public function detail($id)
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                $post = Post::find($id);
                return view('ogp')->with('title', $post->title . ' | メカトロ同好会エルチカ')
                                    ->with('image_url', $this->domain() . $post->thumbnail)
                                    ->with('description', $post->abstract)
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }
    
    public function tag($tag)
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($this->is_crawler($user_agent)) {
                return view('ogp')->with('title', $tag . ' | メカトロ同好会エルチカ')
                                    ->with('image_url', 'https://home.lchika.club/storage/upload/images/favicon.png')
                                    ->with('description', 'タグに ' . $tag . ' が含まれている記事の一覧を掲載しています。')
                                    ->with('url', $this->url());
            }
        }
        return view('index');
    }

    private function is_crawler(string $user_agent)
    {
        return ($user_agent == $this->twitterBot || $user_agent == $this->facebookBot
                || $user_agent == $this->line || $user_agent == $this->discord
                || $user_agent == $this->skype || $user_agent == $this->slack
                || $user_agent == $this->plurk);
    }

    private function url(): string
    {
        return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    private function domain(): string
    {
        return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
    }
}
