# This is an example of Yii2 code according DDD pattern

To run application use
> make dev

Api will be available on:
[OpenApi](https://localhost:8443/doc)

##  Brief explanation

There is a User entity which belong to Shared context.

The User can receive token by corresponding api methods and use it to manage Posts

There is a bounded context named Blog which respond for creating/deleting/updating Blog Posts.

##TODO

- Add tests
- Add logs
- Add metrics
- Add static analysis tools
- Add production ready optimizations: 
```
1) composer
2) preload
3) JIT
```
