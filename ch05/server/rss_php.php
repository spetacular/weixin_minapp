<?php
/*
	RSS_PHP - the PHP DOM based RSS Parser
	Author: <rssphp.net>
	Published: 200801 :: blacknet :: via rssphp.net
	
	RSS_PHP is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.

	Usage:
		See the documentation at http://rssphp.net/documentation
	Examples:
		Can be found online at http://rssphp.net/examples
*/

class rss_php {
	
	public $document;
	public $channel;
	public $items;

/****************************
	public load methods
***/
	# load RSS by URL
		public function load($url=false, $unblock=true) {
			if($url) {
					$this->loadParser($this->curl_get($url));				
			}
		}
	# load raw RSS data
		public function loadRSS($rawxml=false) {
			if($rawxml) {
				$this->loadParser($rawxml);
			}
		}
		
/****************************
	public load methods
		@param $includeAttributes BOOLEAN
		return array;
***/
	# return full rss array
		public function getRSS($includeAttributes=false) {
			if($includeAttributes) {
				return $this->document;
			}
			return $this->valueReturner();
		}
	# return channel data
		public function getChannel($includeAttributes=false) {
			if($includeAttributes) {
				return $this->channel;
			}
			return $this->valueReturner($this->channel);
		}
	# return rss items
		public function getItems($includeAttributes=false) {
			if($includeAttributes) {
				return $this->items;
			}
			return $this->valueReturner($this->items);
		}

/****************************
	internal methods
***/
	private function loadParser($rss=false) {
		if($rss) {
			$this->document = array();
			$this->channel = array();
			$this->items = array();
			$DOMDocument = new DOMDocument;
			$DOMDocument->strictErrorChecking = false;
			$DOMDocument->loadXML($rss);
			$this->document = $this->extractDOM($DOMDocument->childNodes);
		}
	}
	
	private function valueReturner($valueBlock=false) {
		if(!$valueBlock) {
			$valueBlock = $this->document;
		}
		foreach($valueBlock as $valueName => $values) {
				if(isset($values['value'])) {
					$values = $values['value'];
				}
				if(is_array($values)) {
					$valueBlock[$valueName] = $this->valueReturner($values);
				} else {
					$valueBlock[$valueName] = $values;
				}
		}
		return $valueBlock;
	}
	
	private function extractDOM($nodeList,$parentNodeName=false) {
		$itemCounter = 0;
		foreach($nodeList as $values) {
			if(substr($values->nodeName,0,1) != '#') {
				if($values->nodeName == 'item') {
					$nodeName = $values->nodeName.':'.$itemCounter;
					$itemCounter++;
				} else {
					$nodeName = $values->nodeName;
				}
				$tempNode[$nodeName] = array();				
				if($values->attributes) {
					for($i=0;$values->attributes->item($i);$i++) {
						$tempNode[$nodeName]['properties'][$values->attributes->item($i)->nodeName] = $values->attributes->item($i)->nodeValue;
					}
				}
				if(!$values->firstChild) {
					$tempNode[$nodeName]['value'] = $values->textContent;
				} else {
					$tempNode[$nodeName]['value']  = $this->extractDOM($values->childNodes, $values->nodeName);
				}
				if(in_array($parentNodeName, array('channel','rdf:RDF'))) {
					if($values->nodeName == 'item') {
						$this->items[] = $tempNode[$nodeName]['value'];
					} elseif(!in_array($values->nodeName, array('rss','channel'))) {
						$this->channel[$values->nodeName] = $tempNode[$nodeName];
					}
				}
			} elseif(substr($values->nodeName,1) == 'text') {
				$tempValue = trim(preg_replace('/\s\s+/',' ',str_replace("\n",' ', $values->textContent)));
				if($tempValue) {
					$tempNode = $tempValue;
				}
			} elseif(substr($values->nodeName,1) == 'cdata-section'){
				$tempNode = $values->textContent;
			}
		}
		return $tempNode;
	}
	
	private function curl_get($url){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  return false;
	} else {
	  return $response;
	}
}
	
}

?>