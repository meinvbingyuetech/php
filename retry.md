```php
    static $retry = 0;
    retry:
    try {
        echo time(), PHP_EOL;
        throw new \RuntimeException;
    } catch (RuntimeException $e) {
        if (++$retry < 3) goto retry;
    }
    echo 'done';
```
