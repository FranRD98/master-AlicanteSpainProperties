<?php
/*
Currency conversion using European Central Bank exchange rates
Mick Sear
eCreate, 2005
http://www.ecreate.co.uk

Using feed http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml

methods:
convert() - gets rate of echange between 2 currencies
convertAmount(string amount) - gets value of one quantity in another currency
fromCode(string sourceCurrency) - setter.  Takes 3 character currency code
toCode(string destinationCurrency) - setter.  Takes 3 character currency code
fromTo(string sourceCurrency, string destinationCurrency) - setter.  Takes 2 3-character currency codes
getDebug()
getError()

Usage:
$exch = new CurrencyConverter();
$exch->fromCode("GBP");
$exch->toCode("EUR");
echo $exch->convert();
//or...  echo $exch->convertAmount(12.99);
//or...  echo $exch->convertAmount("12.99");
echo $exch->getDebug(); //etc.

*/

//Look for XPath //gesmes:Envelope/Cube/Cube/

class CurrencyConverter{

    private $feedUrl = "http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml";    //Where the feed comes from
    public $cacheDir = "./modules/property";        //Location for cache file (no trailing slash)
    private $xml;                   //Internal holder for SimpleXML object
    private $from = "GBP";          //Source currency
    private $to = "EUR";            //Dest currency
    private $fromRate;              //Source rate
    private $toRate;                //Dest rate
    private $error;                 //Internal errors  Use getError()
    private $debug;                 //Internal debug.  Use getdebug()
    private $cacheDate;             //Date of cache file.


    /*
    Constructor.  Checks if there's a cached version of the file.
    If yes, loads it and checks the date of the feed.  If that's OK, end
    If no, get a new one
    If the cached feed is old, get a new one if possible, failing over to the
    cache in the event of failure.
    */
    function __construct($url = ""){
        if ($url != ""){
            $this->feedUrl = $url;
        }

        //Is there a cached file?
        if ($this->isValidCached()){
            $today = date("Y-m-d");

            if ($this->cacheDate != $today){
                //It's old - try to load and cache a new one
                $feed = @file_get_contents($this->feedUrl);
                if (!$feed){
                    $this->error .= "Couldn't load the feed from " . $this->feedUrl."\n";

                    //Use the cached feed.
                } else {
                    $this->xml = simplexml_load_string($feed);
                    $this->cache($feed);
                }
            } //Otherwise, we just use the cache file, which is already loaded in $this->xml

        } else {
            //No cached file.  Get a new one.
            $feed = @file_get_contents($this->feedUrl);
            if (!$feed){
                $this->error .= "Couldn't load the feed from " . $this->feedUrl."\n";

                //Use the cached feed.
            } else {
                $this->xml = simplexml_load_string($feed);
                $this->cache($feed);
            }
        }
    }

    /*
    Returns xml if a cached file exists
    */
    function isValidCached(){
        $today = date("Y-m-d");
        if (!is_readable($this->cacheDir."/currencyFeed.xml")){return false;}

        if ($xml = @simplexml_load_file($this->cacheDir."/currencyFeed.xml")){
            $this->cacheDate = $xml->Cube->Cube['time'];
            $this->debug .= "Cache date". $this->cacheDate."\n";
            $this->xml = $xml;
            return true;
        } else {
            return false;
        }
    }

    /*
    Caches feed in cache Dir
    */
    function cache($feed){
        $today = date("Y-m-d");
        if (($fp = fopen($this->cacheDir."/currencyFeed.xml", "w")) !== false){
            if (fwrite($fp, $feed) === FALSE) {
                $this->error .= "Can't write feed to cache!\n";
            }
        } else {
            $this->error .= "Can't write to cache file!\n";
        }
    }

    /*
    Setter for source currency code
    */
    function fromCode($curCode){
        //Need to find the 'cube' element for the currency code to be used as a starting point.
        if (isset($curCode)){
            $this->from = $curCode;
        }
        $this->debug .= "Converting from " . $this->from . "<br />";
    }

    /*
    Setter for destination currency code
    */
    function toCode($curCode){
        //Need to find the cube for the currency code to be used as an end point.
        if (isset($curCode)){
            $this->to = $curCode;
        }
        $this->debug .= "Converting to " . $this->to . "<br />";
    }

    /*
    Setter for source & dest currency codes
    */
    function fromTo($curCodeFrom, $curCodeTo){
        $this->fromCode($curCodeFrom);
        $this->toCode($curCodeTo);
    }

    /*
    Utility function to populate rates by getting them from the XML feed.
    Unfortunately, XPath on Windows doesn't correctly parse

    //Cube/Cube/Cube[@currency = '".$this->from."']/@rate

    - seems to be something to do with namespaces.
    So we have to use a SimpleXML syntax instead, which works :)
    */
    function getRates(){

        if (!is_object($this->xml)){
            $this->error .= "No feed data.\n";
            return false;
        }

        foreach($this->xml->Cube->Cube->Cube as $n){
            if ($n['currency'] == $this->from){
                $this->fromRate = $n['rate'];
            }
            if ($n['currency'] == $this->to){
                $this->toRate = $n['rate'];
            }
        }

        //Since the feed uses EUROs as a base rate, they don't appear in the feed.
        //So if user wants to convert from or to Euros, set that rate to 1.
        if ($this->from == "EUR"){$this->fromRate = 1;}
        if ($this->to == "EUR"){$this->toRate = 1;}
    }

    /*
    Does the business.  Calls getRates() first
    */
    function convert(){

        $this->getRates();

        if (!isset($this->fromRate) || !isset($this->toRate)){
            $this->error .= "Either source or destination rates were null\n";
            return false;
        }

        return (1 / (float) $this->fromRate) * (float) $this->toRate;

    }

    /*
    Converts a specific amount of source currency to dest currency.
    */
    function convertAmount($amount){
        $rate = $this->convert();
        return $rate * (float) $amount;
    }

    function getDebug(){return nl2br($this->debug);}
    function getError(){return nl2br($this->error);}

}
?>