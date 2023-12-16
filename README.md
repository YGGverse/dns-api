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

### Socket

Check socket

#### Usage

* `port` - required
* `host` - optional, name, IPv4 or IPv6 `REMOTE_ADDR` by default

```
GET socket.php?port=80&host=php.net
```

##### Response

```
JSON
{
  status: bool
}
```

### Dig

Show host records

#### Usage

* `name` - required host name, IPv4 or IPv6
* `record` - required if `records` not provided
* `records` - required if `record` not provided
  + [x] A
  + [x] AAAA
  + [ ] SRV #1

##### Single record

```
GET dig.php?name=php.net&record=A
```

##### Multiple records

```
GET dig.php?name=php.net&records[]=A&records[]=AAAA
```

##### Response

```
JSON
{
  status: bool
  records: array
}
```