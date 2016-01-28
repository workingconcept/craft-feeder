<?php

namespace Craft;

class FeederService extends BaseApplicationComponent
{

	public function init()
	{
		parent::init();
	}


	/**
	 * Pull a feed from the supplied URL 
	 * 
	 * @param  string $feedUrl An Atom or RSS feed
	 * 
	 * @return mixed              Response or exception from cURL request
	 */
	
	public function getFeed($feedUrl)
	{
		if (empty($feedUrl))
		{
			Craft::log('Missing feed URL.', LogLevel::Warning, false, 'feeder');
			return false;
		}

		$response = $this->_curlRequest($feedUrl);

		if ($data = @simplexml_load_string($response, null, LIBXML_NOCDATA))
		{
			return $data;
		}
		else
		{
			Craft::log('Couldn\'t parse feed at '.$feedUrl.'.', LogLevel::Error, false, 'feeder');
			return false;
		}
	}


	/**
	 * Use Craft's included Guzzle library to make an API request
	 * 
	 * @param  string $url  The URL to query
	 * 
	 * @return void
	 */
	
	private function _curlRequest($url = '')
	{
		try
		{
			$client  = new \Guzzle\Http\Client($url);
			$request = $client->get($url, array(
					'Accept' => 'application/rss+xml',
					'Accept' => 'application/rdf+xml',
					'Accept' => 'application/xml',
					'Accept' => 'text/xml'
				)
			);

			$response = $request->send();

			return $response->getBody(true);
		} 
		catch(\Exception $e)
		{
			FeederPlugin::log($e->getResponse(), LogLevel::Error, true);

			$response = $e->getResponse();

			return $response;
		}
	}

}
