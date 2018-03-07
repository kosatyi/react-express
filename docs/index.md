## Table of contents

- [\ReactExpress\Application](#class-reactexpressapplication)
- [\ReactExpress\Core\Route](#class-reactexpresscoreroute)
- [\ReactExpress\Core\Server](#class-reactexpresscoreserver)
- [\ReactExpress\Core\Router](#class-reactexpresscorerouter)
- [\ReactExpress\Core\Routes](#class-reactexpresscoreroutes)
- [\ReactExpress\Core\Model](#class-reactexpresscoremodel)
- [\ReactExpress\Core\Dispatcher](#class-reactexpresscoredispatcher)
- [\ReactExpress\Core\Loader](#class-reactexpresscoreloader)
- [\ReactExpress\Http\Response](#class-reactexpresshttpresponse)
- [\ReactExpress\Http\Request](#class-reactexpresshttprequest)
- [\ReactExpress\Util\PathToRegexp](#class-reactexpressutilpathtoregexp)

<hr />

### Class: \ReactExpress\Application

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$params</strong>)</strong> : <em>void</em> |
| public | <strong>__construct()</strong> : <em>void</em> |
| public static | <strong>instance()</strong> : <em>void</em> |
| public | <strong>listen(</strong><em>mixed</em> <strong>$port</strong>, <em>mixed</em> <strong>$host</strong>, <em>array</em> <strong>$cert=array()</strong>)</strong> : <em>void</em> |
| public | <strong>load(</strong><em>mixed</em> <strong>$name</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>mixed</em> |
| public | <strong>method(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$callback</strong>)</strong> : <em>void</em> |
| public | <strong>middleware(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$class</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>void</em> |
| public | <strong>request(</strong><em>\Psr\Http\Message\ServerRequestInterface</em> <strong>$httpRequest</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Route

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\string</em> <strong>$method</strong>, <em>\string</em> <strong>$path</strong>, <em>mixed</em> <strong>$action</strong>)</strong> : <em>void</em> |
| public | <strong>getCallbacks(</strong><em>\string</em> <strong>$path</strong>, <em>\string</em> <strong>$method</strong>)</strong> : <em>mixed</em> |
| public | <strong>getSubPath(</strong><em>\string</em> <strong>$path=`''`</strong>)</strong> : <em>mixed</em> |
| public | <strong>isRouter()</strong> : <em>bool</em> |
| public | <strong>match(</strong><em>\string</em> <strong>$path</strong>, <em>\string</em> <strong>$method</strong>)</strong> : <em>void</em> |
| public | <strong>params(</strong><em>\string</em> <strong>$path</strong>)</strong> : <em>void</em> |
| public | <strong>parse()</strong> : <em>void</em> |
| public | <strong>run(</strong><em>[\ReactExpress\Application](#class-reactexpressapplication)</em> <strong>$app</strong>, <em>\callable</em> <strong>$next</strong>)</strong> : <em>void</em> |

*This class extends [\ReactExpress\Core\Model](#class-reactexpresscoremodel)*

*This class implements \Serializable, \JsonSerializable*

<hr />

### Class: \ReactExpress\Core\Server

| Visibility | Function |
|:-----------|:---------|
| public | <strong>handler(</strong><em>[\ReactExpress\Application](#class-reactexpressapplication)</em> <strong>$app=null</strong>)</strong> : <em>void</em> |
| public | <strong>listen(</strong><em>mixed</em> <strong>$port</strong>, <em>string</em> <strong>$host=`'127.0.0.1'`</strong>, <em>array</em> <strong>$cert=array()</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Router

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>\string</em> <strong>$method</strong>, <em>array</em> <strong>$arguments</strong>)</strong> : <em>void</em> |
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>addRoute(</strong><em>\string</em> <strong>$method</strong>, <em>\string</em> <strong>$uri</strong>, <em>mixed</em> <strong>$action</strong>)</strong> : <em>void</em> |
| public | <strong>match(</strong><em>\string</em> <strong>$path</strong>, <em>\string</em> <strong>$method</strong>)</strong> : <em>void</em> |
| public | <strong>route(</strong><em>\string</em> <strong>$path</strong>)</strong> : <em>void</em> |
| public | <strong>router()</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Routes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>\string</em> <strong>$method</strong>, <em>array</em> <strong>$arguments=array()</strong>)</strong> : <em>void</em> |
| public | <strong>__construct(</strong><em>[\ReactExpress\Core\Router](#class-reactexpresscorerouter)</em> <strong>$router</strong>, <em>\string</em> <strong>$path</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Model

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__get(</strong><em>mixed</em> <strong>$key</strong>)</strong> : <em>void</em> |
| public | <strong>__set(</strong><em>mixed</em> <strong>$key</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |
| public | <strong>all()</strong> : <em>void</em> |
| public | <strong>attr(</strong><em>mixed</em> <strong>$keys</strong>, <em>mixed</em> <strong>$value=null</strong>)</strong> : <em>void</em> |
| public | <strong>data(</strong><em>array</em> <strong>$data=array()</strong>)</strong> : <em>void</em> |
| public | <strong>jsonSerialize()</strong> : <em>void</em> |
| public | <strong>serialize()</strong> : <em>void</em> |
| public | <strong>unserialize(</strong><em>mixed</em> <strong>$data</strong>)</strong> : <em>void</em> |

*This class implements \JsonSerializable, \Serializable*

<hr />

### Class: \ReactExpress\Core\Dispatcher

| Visibility | Function |
|:-----------|:---------|
| public | <strong>execute(</strong><em>mixed</em> <strong>$callback</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>void</em> |
| public | <strong>get(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>mixed</em> |
| public | <strong>has(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>bool</em> |
| public | <strong>run(</strong><em>mixed</em> <strong>$name</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>void</em> |
| public | <strong>set(</strong><em>mixed</em> <strong>$name</strong>, <em>\callable</em> <strong>$callback</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Loader

| Visibility | Function |
|:-----------|:---------|
| public | <strong>get(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>mixed</em> |
| public | <strong>getInstance(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>mixed</em> |
| public | <strong>load(</strong><em>mixed</em> <strong>$name</strong>, <em>array</em> <strong>$arguments=null</strong>)</strong> : <em>mixed</em> |
| public | <strong>newInstance(</strong><em>mixed</em> <strong>$class</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>void</em> |
| public | <strong>register(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$class</strong>, <em>array</em> <strong>$params=array()</strong>, <em>mixed</em> <strong>$callback=null</strong>)</strong> : <em>void</em> |
| public | <strong>reset()</strong> : <em>void</em> |
| public | <strong>unregister(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Http\Response

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>end()</strong> : <em>void</em> |
| public | <strong>header(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |
| public | <strong>json(</strong><em>mixed</em> <strong>$content</strong>)</strong> : <em>void</em> |
| public | <strong>jsonData()</strong> : <em>void</em> |
| public | <strong>promise()</strong> : <em>void</em> |
| public | <strong>reset()</strong> : <em>void</em> |
| public | <strong>send(</strong><em>mixed</em> <strong>$content</strong>)</strong> : <em>void</em> |
| public | <strong>sendContentLengthHeaders()</strong> : <em>void</em> |
| public | <strong>sendFile()</strong> : <em>void</em> |
| public | <strong>sendHeaders()</strong> : <em>void</em> |
| public | <strong>sendStatus(</strong><em>mixed</em> <strong>$code</strong>, <em>mixed</em> <strong>$content=null</strong>)</strong> : <em>void</em> |
| public | <strong>status(</strong><em>mixed</em> <strong>$code</strong>)</strong> : <em>void</em> |
| public | <strong>write(</strong><em>mixed</em> <strong>$content</strong>)</strong> : <em>void</em> |

*This class extends [\ReactExpress\Core\Model](#class-reactexpresscoremodel)*

*This class implements \Serializable, \JsonSerializable*

<hr />

### Class: \ReactExpress\Http\Request

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Psr\Http\Message\ServerRequestInterface</em> <strong>$request</strong>)</strong> : <em>void</em> |

*This class extends [\ReactExpress\Core\Model](#class-reactexpresscoremodel)*

*This class implements \Serializable, \JsonSerializable*

<hr />

### Class: \ReactExpress\Util\PathToRegexp

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>convert(</strong><em>mixed</em> <strong>$path</strong>, <em>array</em> <strong>$keys=array()</strong>, <em>array</em> <strong>$options=array()</strong>)</strong> : <em>\ReactExpress\Util\{RegExp}</em><br /><em>Normalize the given path string, returning a regular expression. An empty array should be passed in, which will contain the placeholder key names. For example `/user/:id` will then contain `["id"]`.</em> |
| public static | <strong>match(</strong><em>mixed</em> <strong>$regexp</strong>, <em>mixed</em> <strong>$route</strong>)</strong> : <em>void</em> |

