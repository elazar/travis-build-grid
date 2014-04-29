# elazar/travis-build-grid

Utility for rendering an HTML table of the last [Travis CI](https://travis-ci.org/)
build results for multiple repositories and platform versions.

[Demo](http://phergie.github.io/travis-build-grid.html)

## Installation

Use [Composer](https://getcomposer.org/).

```json
{
    "require": {
        "elazar/travis-build-grid": "1.*"
    }
}
```

## Usage

```
./bin/travis-build-grid php \
    phergie/phergie-irc-bot-react \
    phergie/phergie-irc-client-react \
    ...
```

Above, `php` corresponds to the key in your `.travis.yml` file that references
a list of platform versions. All the arguments that follow reference
repositories on Travis CI. The invocation will send the rendered HTML to stdout.

If you were to store your repository references in a file with one reference
per line, an invocation might look like this:

```
./bin/travis-build-grid php $(< repos.txt) > grid.html
```

## LICENSE

Released under the BSD License. See `LICENSE`.
