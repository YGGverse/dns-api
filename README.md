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

##### Attributes

* `port` - required
* `host` - optional, name, IPv4 or IPv6 `REMOTE_ADDR` by default

##### Request

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

##### Attributes

* `name` - required host name, IPv4 or IPv6
* `record` - required if `records` not provided
* `records` - required if `record` not provided

###### Records support

* [x] A
* [x] AAAA
* [ ] SRV #1

##### Request

###### Single record

```
GET dig.php?name=php.net&record=A
```

###### Multiple records

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