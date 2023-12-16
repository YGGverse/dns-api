# net-api

Simple Network Tools API

## Install

```
git clone https://github.com/YGGverse/net-api.git
cd net-api
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