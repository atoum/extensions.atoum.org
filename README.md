This repository is the source files for [http://extensions.atoum.org](http://extensions.atoum.org).

The purpose is to list extensions of atoum and expose it.

## Adding a new extension

Edit the file : `config/extensions.yml`.

## Build & tests

### Build

```
composer install
```

If you made some change in javascript or css, just use the [robo](http://robo.li/) build file:
```
vendor/bin/robo build
```

### Test

```
vendor/bin/atoum
vendor/bin/behat
```

### Run

```
composer web
```

Then use your favorite web browser and go to `http://localhost:8000/`.
