# Tiny Tiny River

A river of news style front-end for [Tiny Tiny RSS](https://tt-rss.org/).

Will display a river of entries for each user-defined category in tt-rss ([demo screenshot](http://i.imgur.com/gzn5sAq.png)).

As of now, Tiny Tiny River doesn’t perform any write operations through the tt-rss API. The front-end is read-only. This means, for example, read items will not disappear from the river view. This is intentional.


## Install

1. Run the following commands:

    ~~~ bash
    git clone https://github.com/mermshaus/TinyTinyRiver.git
    cd TinyTinyRiver
    cp config.dist.php config.php
    ~~~

2. Edit `config.php` to fit your environment.

3. Navigate to the `public` directory with a browser and/or define a symlink to this directory for your web server.


## Requirements

- API access to a Tiny Tiny RSS installation (same or remote server).
- PHP (any more or less recent version should do)
  - curl
  - allow_url_fopen


## Credits

- [Marc Ermshaus](http://www.ermshaus.org/)


## License

This software is licensed under the MIT License.
