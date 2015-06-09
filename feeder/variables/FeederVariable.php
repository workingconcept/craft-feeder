<?php

namespace Craft;

class FeederVariable {

	function getFeed($url)
	{
		return craft()->feeder->getFeed($url);
	}

}
