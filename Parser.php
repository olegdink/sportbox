<?php

namespace Sportbox\Parser;

class Parser
{

    public $htmlContent;

    protected $url;
    protected $regexpBlock     = "/<div class=\"table-group\">(.*?)<\/div>/is";
    protected $regexpCountries = "/<td>(\d+?)<\/td>.*?<td class=\"table-link\">.*?<img src=\".*?\" width=\"\d+\" height=\"\d+\" title=\"(.*?)\".*?<td>(\d+?)<\/td>.*?<td>(\d+?)<\/td>.*?<td>(\d+?)<\/td>.*?<td>(\d+?)<\/td>/is";

    public function __construct($url)
    {

        if (empty($url)) {
            throw new Exception("Parser::__constructor - 'no url'");
        } else {
            $this->url = $url;
            $this->getContent();
        };

    }

    public function getUrl()
    {

        return $this->url;

    }

    public function setUrl($url)
    {

        if (empty($url)) {
            return false;
        } else {
            $this->url = $url;
            return true;
        };

    }

    public function getContent()
    {

        $this->htmlContent = file_get_contents($this->url);
        return true;

    }

    public function getInfo()
    {

        $rating = [];
        if (preg_match($this->regexpBlock, $this->htmlContent, $tableBlock)) {
            if (preg_match_all($this->regexpCountries, $tableBlock[1], $countries, PREG_SET_ORDER) !== false) {
                foreach ($countries as $country) {
                    array_push($rating, [
                        'rank'   => (int)$country[1],
                        'title'  => $country[2],
                        'gold'   => (int)$country[3],
                        'silver' => (int)$country[4],
                        'bronze' => (int)$country[5],
                        'total'  => (int)$country[6],
                    ]);
                }
            }
        };
        return $rating;

    }

}




