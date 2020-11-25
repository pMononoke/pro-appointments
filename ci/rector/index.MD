Run rector:
```shell
docker run --rm -v $(pwd):/project rector/rector:latest process --config /project/ci/rector/rector.php --dry-run --ansi
```