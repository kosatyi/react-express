## Table of contents

- [\ReactExpress\Application](#class-reactexpressapplication)
- [\ReactExpress\Core\Server](#class-reactexpresscoreserver)
- [\ReactExpress\Core\Model](#class-reactexpresscoremodel)
- [\ReactExpress\Core\Dispatcher](#class-reactexpresscoredispatcher)
- [\ReactExpress\Core\Loader](#class-reactexpresscoreloader)
- [\ReactExpress\Http\Response](#class-reactexpresshttpresponse)
- [\ReactExpress\Http\Request](#class-reactexpresshttprequest)
- [\ReactExpress\Routing\Route](#class-reactexpressroutingroute)
- [\ReactExpress\Routing\Router](#class-reactexpressroutingrouter)
- [\ReactExpress\Routing\Routes](#class-reactexpressroutingroutes)
- [\ReactExpress\Util\PathToRegexp](#class-reactexpressutilpathtoregexp)

<hr />

### Class: \ReactExpress\Application

> Class Application

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$params</strong>)</strong> : <em>mixed/null/object/\ReflectionClass</em> |
| public | <strong>__construct()</strong> : <em>void</em><br /><em>Application constructor.</em> |
| public | <strong>__get(</strong><em>mixed</em> <strong>$key</strong>)</strong> : <em>void</em> |
| public | <strong>__set(</strong><em>mixed</em> <strong>$key</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |
| public static | <strong>instance()</strong> : <em>null/\ReactExpress\static</em> |
| public | <strong>listen(</strong><em>mixed</em> <strong>$port</strong>, <em>mixed</em> <strong>$host</strong>, <em>array</em> <strong>$cert=array()</strong>)</strong> : <em>\ReactExpress\$this</em> |
| public | <strong>load(</strong><em>mixed</em> <strong>$name</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>mixed/null/object/\ReflectionClass</em> |
| public | <strong>method(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$callback</strong>)</strong> : <em>void</em> |
| public | <strong>middleware(</strong><em>mixed</em> <strong>$name</strong>, <em>mixed</em> <strong>$class</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>\ReactExpress\$this</em> |
| public | <strong>request(</strong><em>\Psr\Http\Message\ServerRequestInterface</em> <strong>$httpRequest</strong>)</strong> : <em>\React\Promise\Promise/\React\Promise\PromiseInterface</em> |

<hr />

### Class: \ReactExpress\Core\Server

> Class Server

| Visibility | Function |
|:-----------|:---------|
| public | <strong>handler(</strong><em>\ReactExpress\Core\Application/null/[\ReactExpress\Application](#class-reactexpressapplication)</em> <strong>$app=null</strong>)</strong> : <em>\ReactExpress\Core\$this</em> |
| public | <strong>listen(</strong><em>mixed</em> <strong>$port</strong>, <em>string</em> <strong>$host=`'127.0.0.1'`</strong>, <em>array</em> <strong>$cert=array()</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Model

> Class Model

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__get(</strong><em>mixed</em> <strong>$key</strong>)</strong> : <em>void</em> |
| public | <strong>__set(</strong><em>mixed</em> <strong>$key</strong>, <em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |
| public | <strong>all()</strong> : <em>array</em> |
| public | <strong>attr(</strong><em>mixed</em> <strong>$keys</strong>, <em>null</em> <strong>$value=null</strong>)</strong> : <em>\ReactExpress\Core\$this/array/mixed/null</em> |
| public | <strong>data(</strong><em>array</em> <strong>$data=array()</strong>)</strong> : <em>\ReactExpress\Core\$this</em> |
| public | <strong>jsonSerialize()</strong> : <em>array/mixed</em> |
| public | <strong>serialize()</strong> : <em>string</em> |
| public | <strong>unserialize(</strong><em>string</em> <strong>$data</strong>)</strong> : <em>void</em> |

*This class implements \JsonSerializable, \Serializable*

<hr />

### Class: \ReactExpress\Core\Dispatcher

> Class Dispatcher

| Visibility | Function |
|:-----------|:---------|
| public | <strong>get(</strong><em>\string</em> <strong>$name</strong>)</strong> : <em>mixed/null</em> |
| public | <strong>has(</strong><em>\string</em> <strong>$name</strong>)</strong> : <em>bool</em> |
| public | <strong>run(</strong><em>\string</em> <strong>$name</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>mixed/null</em> |
| public | <strong>set(</strong><em>\string</em> <strong>$name</strong>, <em>\callable</em> <strong>$callback</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Core\Loader

> Class Loader

| Visibility | Function |
|:-----------|:---------|
| public | <strong>get(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>mixed/null</em> |
| public | <strong>getInstance(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>mixed/null</em> |
| public | <strong>load(</strong><em>mixed</em> <strong>$name</strong>, <em>array/null/array</em> <strong>$arguments=null</strong>)</strong> : <em>mixed/null/object/\ReflectionClass</em> |
| public | <strong>newInstance(</strong><em>mixed</em> <strong>$class</strong>, <em>array</em> <strong>$params=array()</strong>)</strong> : <em>mixed/null/object/\ReflectionClass</em> |
| public | <strong>register(</strong><em>\string</em> <strong>$name</strong>, <em>mixed</em> <strong>$class</strong>, <em>array</em> <strong>$params=array()</strong>, <em>\callable</em> <strong>$callback=null</strong>)</strong> : <em>void</em> |
| public | <strong>reset()</strong> : <em>void</em> |
| public | <strong>unregister(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>void</em> |

<hr />

### Class: \ReactExpress\Http\Response

> Class Response

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em><br /><em>Response constructor.</em> |
| public | <strong>end()</strong> : <em>void</em> |
| public | <strong>header(</strong><em>\string</em> <strong>$name</strong>, <em>\string</em> <strong>$value</strong>)</strong> : <em>\ReactExpress\Http\$this</em> |
| public | <strong>json(</strong><em>mixed</em> <strong>$content</strong>)</strong> : <em>\ReactExpress\Http\$this</em> |
| public | <strong>jsonData()</strong> : <em>[\ReactExpress\Http\Response](#class-reactexpresshttpresponse)</em> |
| public | <strong>promise()</strong> : <em>\React\Promise\Promise/\React\Promise\PromiseInterface</em> |
| public | <strong>reset()</strong> : <em>\ReactExpress\Http\$this</em> |
| public | <strong>send(</strong><em>\string</em> <strong>$content=`''`</strong>)</strong> : <em>\ReactExpress\Http\$this</em> |
| public | <strong>sendContentLengthHeaders()</strong> : <em>void</em> |
| public | <strong>sendFile()</strong> : <em>void</em> |
| public | <strong>sendHeaders()</strong> : <em>void</em> |
| public | <strong>sendStatus(</strong><em>mixed</em> <strong>$code</strong>, <em>null</em> <strong>$content=null</strong>)</strong> : <em>\ReactExpress\Http\$this</em> |
| public | <strong>status(</strong><em>mixed</em> <strong>$code</strong>)</strong> : <em>\ReactExpress\Http\$this</em> |
| public | <strong>write(</strong><em>\string</em> <strong>$content=`''`</strong>)</strong> : <em>\ReactExpress\Http\$this</em> |

*This class extends [\ReactExpress\Core\Model](#class-reactexpresscoremodel)*

*This class implements \Serializable, \JsonSerializable*

<hr />

### Class: \ReactExpress\Http\Request

> Class Request

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Psr\Http\Message\ServerRequestInterface</em> <strong>$request</strong>)</strong> : <em>void</em><br /><em>Request constructor.</em> |

*This class extends [\ReactExpress\Core\Model](#class-reactexpresscoremodel)*

*This class implements \Serializable, \JsonSerializable*

<hr />

### Class: \ReactExpress\Routing\Route

> Class Route

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\string</em> <strong>$method</strong>, <em>\string</em> <strong>$path</strong>, <em>mixed</em> <strong>$action</strong>)</strong> : <em>void</em><br /><em>Route constructor.</em> |
| public | <strong>getCallbacks(</strong><em>\string</em> <strong>$path</strong>, <em>\string</em> <strong>$method</strong>)</strong> : <em>[\ReactExpress\Routing\Route](#class-reactexpressroutingroute)</em> |
| public | <strong>getSubPath(</strong><em>\string</em> <strong>$path=`''`</strong>)</strong> : <em>null/string/string[]</em> |
| public | <strong>isRouter()</strong> : <em>bool</em> |
| public | <strong>match(</strong><em>\string</em> <strong>$path</strong>, <em>\string</em> <strong>$method</strong>)</strong> : <em>bool</em> |
| public | <strong>params(</strong><em>\string</em> <strong>$path</strong>)</strong> : <em>void</em> |
| public | <strong>parse()</strong> : <em>void</em> |
| public | <strong>run(</strong><em>[\ReactExpress\Application](#class-reactexpressapplication)</em> <strong>$app</strong>, <em>\callable</em> <strong>$next</strong>)</strong> : <em>void</em> |

*This class extends [\ReactExpress\Core\Model](#class-reactexpresscoremodel)*

*This class implements \Serializable, \JsonSerializable*

<hr />

### Class: \ReactExpress\Routing\Router

> Class Router

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>\string</em> <strong>$method</strong>, <em>array</em> <strong>$arguments</strong>)</strong> : <em>void</em> |
| public | <strong>__construct()</strong> : <em>void</em><br /><em>Router constructor.</em> |
| public | <strong>addRoute(</strong><em>\string</em> <strong>$method</strong>, <em>\string</em> <strong>$uri</strong>, <em>mixed</em> <strong>$action</strong>)</strong> : <em>void</em> |
| public | <strong>match(</strong><em>\string</em> <strong>$path</strong>, <em>\string</em> <strong>$method</strong>)</strong> : <em>array</em> |
| public | <strong>route(</strong><em>\string</em> <strong>$path</strong>)</strong> : <em>[\ReactExpress\Routing\Routes](#class-reactexpressroutingroutes)</em> |
| public | <strong>router()</strong> : <em>\ReactExpress\Routing\static</em> |

<hr />

### Class: \ReactExpress\Routing\Routes

> Class Routes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>\string</em> <strong>$method</strong>, <em>array</em> <strong>$arguments=array()</strong>)</strong> : <em>\ReactExpress\Routing\$this</em> |
| public | <strong>__construct(</strong><em>[\ReactExpress\Routing\Router](#class-reactexpressroutingrouter)</em> <strong>$router</strong>, <em>\string</em> <strong>$path</strong>)</strong> : <em>void</em><br /><em>Routes constructor.</em> |

<hr />

### Class: \ReactExpress\Util\PathToRegexp

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>convert(</strong><em>mixed</em> <strong>$path</strong>, <em>array</em> <strong>$keys=array()</strong>, <em>array</em> <strong>$options=array()</strong>)</strong> : <em>\ReactExpress\Util\{RegExp}</em><br /><em>Normalize the given path string, returning a regular expression. An empty array should be passed in, which will contain the placeholder key names. For example `/user/:id` will then contain `["id"]`.</em> |
| public static | <strong>match(</strong><em>mixed</em> <strong>$regexp</strong>, <em>mixed</em> <strong>$route</strong>)</strong> : <em>void</em> |

