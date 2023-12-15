# dns-api

Simple DNS API

## Install

```
git clone https://github.com/YGGverse/dns-api.git
cd dns-api
composer install
```

## Run

```
cd src/public
php -S localhost:8080
```

## Usage

### Dig

#### Single record

```
dig.php?name=php.net&record=A
```

#### Multiple records

```
dig.php?name=php.net&records[]=A&records[]=AAAA
```