<?php
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

require_once "Book.php";

class All
{

    private $conn;
    const DBHOST = 'localhost';
    const DBPORT = '3306';
    const USER = 'jim';
    const PASS = 'livedoor2008';
    const SEPARATOR = '/';

    const EXCLUDE_DIRS = ['page', '.', '..'];
    const EXCLUDE_FILES = [
        'www.allitebooks.com\index.html',
        'web-development\index.html',
        'programming\index.html',
        'datebases\index.html',
        'graphics-design\index.html',
        'operating-systems\index.html',
        'networking-cloud-computing\index.html',
        'administration\index.html',
        'certification\index.html',
        'computers-technology\index.html',
        'enterprise\index.html',
        '..\index.html',
        'hardware\index.html',
        'marketing-seo\index.html',
        'security\index.html',
        'software\index.html'];

    function __construct()
    {
        $dbName = 'ebook';
        $this->conn = mysql_connect(self::DBHOST, self::USER, self::PASS);
        if (!$this->conn) {
            die('can not connect to db.');
        }

        mysql_select_db($dbName, $this->conn) or die('Can not select db.');

    }

    function readHtml($path)
    {
        $directory = new \RecursiveDirectoryIterator($path, \FilesystemIterator::FOLLOW_SYMLINKS);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = array();
        foreach ($iterator as $info) {
            $fileName = $info->getPathname();

            $fileNames = explode('\\', $fileName);
            $fileReverseName = array_reverse($fileNames);

            //skip `page`, `.`, `..` directory
            if ($info->isDir() && in_array($fileReverseName[0], self::EXCLUDE_DIRS)) {
                continue;
            }

            //skip `index.html` in category

            if (in_array($fileReverseName[1] . '/' . $fileReverseName[0], self::EXCLUDE_FILES)) {
                continue;
            }

            //skip not html files
            $pattern = '/.+\.$/i';
            if (preg_match($pattern, $fileName)) {
                continue;
            }

            $files[] = $fileName;;
        }

        //var_dump($files);exit;
        return $files;
    }

    function processHtml($htmlFile)
    {
        try {
            $dom = new Dom;
            $dom->loadFromFile($htmlFile);
            $content = $dom->find('article');

            if (!empty($content) && isset($content)) {
                //get title
                $titleNode = $content->find('.single-title');
                if (!empty($titleNode) && isset($titleNode) && count($titleNode) > 0) {
                    $title = $titleNode[0]->text;
                } else {
                    throw new Exception("no title");
                }


                //thumbnail
                $imgParentNode = $content->find('.entry-body-thumbnail');
                if (!empty($imgParentNode) && isset($imgParentNode) && count($imgParentNode) > 0) {
                    $imgNode = $imgParentNode[0]->find('img');
                    if (!empty($imgNode) && count($imgNode) > 0) {
                        $imgSrc = $imgNode[0]->getAttribute('src');
                        preg_match('/[^\/]+[\.jpg|\.png|\.jpeg]$/', $imgSrc, $img);
                    } else {
                        throw new Exception("no title");
                    }
                } else {
                    throw new Exception("no title");
                }

                //book's detail
                $detailNode = $content->find('.book-detail');
                if (!empty($detailNode) && count($detailNode) > 0) {
                    $detail = $detailNode[0]->find('dd');
                }

                //$detail = $content->find('.book-detail')[0]->find('dd');
                if (!empty($detail) && count($detail) > 0) {
                    $author = trim($detail[0]->find('a')->text);
                    $isbn = trim($detail[1]->text);
                    $year = trim($detail[2]->text);
                    $pages = trim($detail[3]->text);
                    $lang = trim($detail[4]->text);
                    $size = trim($detail[5]->text);
                    $format = trim($detail[6]->text);
                    $category = trim($detail[7]->find('a')->text);
                }

                //desc
                $descriptionNode = $content->find('.entry-content');
                if (!empty($descriptionNode) && count($descriptionNode) > 0) {
                    $description = trim($content->find('.entry-content')[0]->find('p')->text);
                }

                switch ($category) {
                    case 'Web Development':
                        $category = '1';
                        break;
                    case 'Programming':
                        $category = '2';
                        break;
                    case 'Datebases':
                        $category = '3';
                        break;
                    case 'Graphics & Design':
                        $category = '4';
                        break;
                    case 'Operating Systems':
                        $category = '5';
                        break;
                    case 'Networking & Cloud Computing':
                        $category = '6';
                        break;
                    case 'Administration':
                        $category = '7';
                        break;
                    case 'Certification':
                        $category = '8';
                        break;
                    case 'Computers & Technology':
                        $category = '9';
                        break;
                    case 'Enterprise':
                        $category = '10';
                        break;
                    case 'Game Programming':
                        $category = '11';
                        break;
                    case 'Hardware & DIY':
                        $category = '12';
                        break;
                    case 'Marketing & SEO':
                        $category = '13';
                        break;
                    case 'Security':
                        $category = '14';
                        break;
                    case 'Software':
                        $category = '15';
                        break;
                }

                $book = new Book();
                $book->setName($title);
                $book->setDescription($description);
                $book->setCover($img[0]);
                $book->setAuthor($author);
                $book->setIsbn($isbn);
                $book->setYear($year);
                $book->setPages($pages);
                $book->setLanguage($lang);
                $book->setSize($size);
                $book->setFormat($format);
                $book->setCategory($category);

                $this->insertDB($book);
            }
        } catch (Exception $e) {
            throw $e;
        }

        //$this->closeDB();
    }

    function insertDB(Book $book)
    {
        $sql = 'INSERT INTO `books` (`name`, `description`, `cover`, `author`,  `isbn`, `year`, `pages`,  `language`, `size`, `format`,  `category`)  ';
        $sql .= ' VALUES (';
        $sql .= ' "' . $book->getName() . '", ';
        $sql .= ' "' . $book->getDescription() . '", ';
        $sql .= ' "' . $book->getCover() . '", ';
        $sql .= ' "' . $book->getAuthor() . '", ';
        $sql .= ' "' . $book->getIsbn() . '", ';
        $sql .= ' "' . $book->getYear() . '", ';
        $sql .= ' "' . $book->getPages() . '", ';
        $sql .= ' "' . $book->getLanguage() . '", ';
        $sql .= ' "' . $book->getSize() . '", ';
        $sql .= ' "' . $book->getFormat() . '", ';
        $sql .= ' "' . $book->getCategory() . '"';
        $sql .= ' )';

        mysql_query($sql, $this->conn);
    }

    function closeDB()
    {
        mysql_close($this->conn);
    }
}

?>