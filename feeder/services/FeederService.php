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
			throw new Exception("Missing feed URL.");
			return;
		}

		$response = $this->_curlRequest($feedUrl);

		if ($data = @simplexml_load_string($response, null, LIBXML_NOCDATA))
		{
			return $data;
		}
		else
		{
			throw new Exception("Couldn't parse feed.");
			return;
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