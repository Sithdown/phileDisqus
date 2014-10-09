phileDisqus
===========

Embeds Disqus comments to [Phile](http://philecms.github.io/Phile).
Based on [Pico Disqus by Philipp Schmitt](https://github.com/pschmitt/pico_disqus).


## Installation

* Clone this repo to the `plugins/sithdown/disqus`:

```bash
mkdir -p ~http/plugins/sithdown
git clone https://github.com/sithdown/phileDisqus.git ~http/plugins/sithdown/disqus
# You may consider using a submodule for this
git submodule add http://github.com/sithdown/phileDisqus.git /srv/http/plugins/sithdown/disqus
```

* Activate it in `config.php`:

```php
$config['plugins'] = array(
    // [...]
    'sithdown\\disqus' => array('active' => true),
);
```


## Usage

In your theme add `{{ disqus_comments }}` wherever you want to display the comments section.

## Configuration

In `plugins/sithdown/disqus/config.php` you must set:

* `$config['disqus_id' => 'sithdown']` - your disqus ID.

## License

MIT
