# Primal

Yet another templating engine library

## Documentation

### Installation

```
composer require develhopper/primal
```

### Examples

#### Initialize Primal

```php
<?php
use Primal\Primal;

$primal = Primal::getInstance([
'views_dir' => 'views directory',
'cache_dir' => 'directory path for caching'
]);

$primal->view("viewname.html",[
'arg1' => 'value'
]); // it will print the content of the view file 
```

#### Views Syntax

##### Print a variable
```php
<h1>
{{$variable}}
</h1>
```

##### Execute a Function

```php
{% var_dump($array); %}
```

##### Include another view

```php
@include('viewname.html')
```

##### Place holder
"base.html"
```php
<body>
@yield('content')
</body>
```

##### Extend from another view

```php
@extend('base.html')
```

##### Fill Placeholder in base.html with content by @section
```php
@extend('base.html')

@section('content')
<h1>{{$title}}</h1>
<p>{{$content}}</p>
@endsection
```

##### If Else and elseif Statements

```php
@if($variable == "foo")
<p>foo</p>
@elseif($variable == "bar")
<p>bar</p>
@else
<p>foobar</p>
@endif
```

##### For and Foreach Loops

```php
@for($i=0;$i<100;$i++)
<p>{{$i}}</p>
@endfor

@foreach($list as $item)
<p>{{$item}}</p>
@endforeach
```

