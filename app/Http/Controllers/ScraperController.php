<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DOMDocument;

class ScraperController extends Controller
{
    //
    public function getTagContent(&$fullStr, &$startStr, &$endStr, &$additionalOffset = 0) {
        $startPos = strpos($fullStr, $startStr) + strlen($startStr);
        $endPos = strpos($fullStr, $endStr);
        return substr($fullstr, $startPos, $endPos - $startPos - $additionalOffset);
    }

    public function scraper(){
        
        $links = array(array("https://www.barbora.lv/piena-produkti-un-olas/piens/pasterizets-piens", "Piens"),
                       array("https://www.barbora.lv/piena-produkti-un-olas/sviests-margarins-un-tauki/sviests", "Sviests"),
                       array("https://www.barbora.lv/piena-produkti-un-olas/majoneze", "Majonēze"));
        foreach($links as $link){
            $content = file_get_contents($link[0]); //Ielasa visu lapas saturu iekš $content
            $parts = explode('<div class="b-product--wrap2 b-product--desktop-grid" itemscope itemprop="isRelatedTo" itemtype="http://schema.org/Product">', $content); 
                         //Sadala $content pēc <div class> tag, kurš ir starp (pirms) dažādiem produktiem sarakstā
            array_shift($parts);  //Izdzēš masīva pirmo elementu, jeb mājaslapas daļu, kas ir pirms roduktu saraksta
            $itemCount = count($parts);
            $parts[$itemCount-1] = substr($parts[$itemCount-1], 0, strpos($parts[$itemCount-1], "<script type=\"text/javascript\">")); //Pēdējam elementam nodēš daļu, kas ir pēc produkta
            
            $doc = new DOMDocument();
            $tags = array();
            $hrefs = array();
            foreach ($parts as $part){
                if (!str_contains($part, 'Atvainojiet, šobrīd prece nav pieejama.')){
                    $part = substr($part, 0, strpos($part, "<svg"));  //Noņem daļu stringa, kas ir pēc <svg>, jo DOMDocument tips sūdzējās, ka esot nekorekts
                    $doc->loadhtml($part); //Saglabā kā html failu
                    $tags = $doc->getElementsByTagName('a'); //Atrod visus <a> tagus. Tajos ir iekšā href, jeb links
                    foreach ($tags as $tag){ $hrefs[] =  $tag->getAttribute('href'); } //Nolasa <a> taga href atribūta saturu
                }
            }
            $hrefs = array_unique($hrefs);
            foreach($hrefs as $href){
                $href = "https://www.barbora.lv/".$href;
                $productStr = file_get_contents($href);
                $doc = new DOMDocument();
                $name = '';
                $energy = '';
                $fats = '';
                $carbs = '';
                $sugar = '';
                $protein = '';

                if (str_contains($productStr, 'Uzturvērtība')){
                    #$name = getTagContent($productStr, '<title>', '</title>', 10);
                    $name = substr($productStr, strpos($productStr, '<title>')+7, strpos($productStr, '</title>') - strpos($productStr, '<title>')-17);
                    $nutritionStr = substr($productStr, strpos($productStr, '<tbody>')+7, strpos($productStr, '</tbody>')-strpos($productStr, '<tbody>')-7);
                    $nutritions = explode('</tr>', $nutritionStr);
                    #$tag = $doc->getElementsByTagName('title');
                    foreach ($nutritions as $nutr){
                        $nutrArr = explode('</td>', $nutr);
                        if (str_contains($nutrArr[0], 'Enerģētiskā vērtība')) 
                            $energy = substr($nutrArr[1], 59);
                        if (str_contains($nutrArr[0], 'Tauki')) 
                            $fats = substr($nutrArr[1], 59);
                        if (str_contains($nutrArr[0], 'Ogļhidrāti')) 
                            $carbs = substr($nutrArr[1], 59);
                        if (str_contains($nutrArr[0], 'Cukuri')) 
                            $sugar = substr($nutrArr[1], 59);
                        if (str_contains($nutrArr[0], 'Olbaltumvielas')) 
                            $protein = substr($nutrArr[1], 59);
                        #dd($nutrArr[1]);
                    }
                    #dd($protein);
                    dd($carbs);
                    return $nutritions[5];
                }
                #$name, $amount;
            }
        }
    }
}
