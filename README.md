# Feeder Craft Plugin

Give the plugin a remote RSS/Atom feed, or maybe just some XML, and get the data back to use in your templates. 

```
{% set feed = craft.feeder.getFeed('http://feeds.feedburner.com/workingconcept') %}
{% set posts = data.channel.item %}

{% for post in posts %}
<div>
    <h3>{{ post.title }}</h3>
    {{ post.description | raw }}
</div>
{% endfor %}
```

## Installation

Drop the `feeder` folder into `craft/plugins`, then visit the Plugins section of the control panel and install.

## Trouble?

The plugin uses Craft's included Guzzle library to pull the URL you provide, so if things don't go well it's probably because of a bogus feed URL, a poorly-formatted feed, or something Matt overlooked during his five minutes of testing.