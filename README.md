# web-api

Network API with native Yggdrasil/IPv6 support

## Install

```
git clone https://github.com/YGGverse/web-api.git
cd web-api
composer install
```

## Config

```
nano config.json
```

## Run

```
cd src/public
php -S localhost:8080
```

## Features

### Socket

Check socket (also useful for open ports detection)

#### Usage

##### Attributes

* `port` - required
* `host` - optional, name, IPv4 or IPv6 `REMOTE_ADDR` by default

##### Request

```
GET /net/socket.php?port=80&host=yo.index
```

##### Response

```
JSON
{
  success: bool
}
```

### Dig

Show host records

#### Usage

##### Attributes

* `name` - required host name, IPv4 or IPv6
* `record` - required if `records` not provided
* `records` - required if `record` not provided

###### Records support

* [x] A
* [x] AAAA
* [x] SRV

##### Request

###### Single record

```
GET /net/dig.php?name=yo.index&record=A
```

###### Multiple records

```
GET /net/dig.php?name=yo.index&records[]=A&records[]=AAAA
```

##### Response

```
JSON
{
  success: bool
  records: array
}
```

## Online

### Yggdrasil

 * `http://[201:23b4:991a:634d:8359:4521:5576:15b7]/api/`

### Alfis

 * `http://api.ygg`

### Hybrid

 * `http://api.ygg.at`

### Clearnet

 * `https://yggapi.duckdns.org`