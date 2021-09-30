# adventofcode-php

PHP solutions to [Advent of Code](https://adventofcode.com/) tasks.

All tasks are **Advent of Code** ownership. 
This repository represents my solutions to **Advent of Code** algorithmic tasks using PHP.

# Directory structure

- [Puzzles](./src/Puzzle), e.g.
    ```
    src/Puzzle/Year[YEAR]/Day[DAY]_TaskName
        Part1.php           # Part1 solution
        Part2.php           # Part2 solution
    ```
  
- [Tests](./tests/Puzzle), e.g.
    ```
    tests/Puzzle/Year[YEAR]/Day[DAY]_TaskName
        Part1Test.php           # Part1 solution test
        Part2Test.php           # Part2 solution test
    ```
  
- [Docs](./docs)

**adventofcode-php** is completely dockerized.

If you have docker installed:

1. Pull **adventofcode-php** project
2. Open console and change directory to project root
3. Run the following command:
```sh
docker-compose up -d
```
4. If you need to enter a running container:
```sh
docker exec -it adventofcode-php_app_1 /bin/bash
```

# Puzzle adding and testing
1. New puzzle needs to be added in `src/Puzzle/Year2020/Day1DescriptionOptional/Part1.php` directory
2. Puzzle solution method needs to inherit `App\Puzzle\PuzzleInterface` interface
3. Puzzle can be run from project root using CLI command
```sh
puzzle:run <year> <day> <part> <puzzle_input>
```
e.g.
```sh
php bin/console puzzle:run 2020 1 1 '91212129'
```

4. Also you can open puzzle in your favorite browser, e.g.
```
http://localhost/src/Puzzle/Year2020/Day1DescriptionOptional/Part1.php
```

# Multiline input
Multiline input can be pasted to CLI using quotes.
Both single quotes and double quotes work.

```sh
php bin/console puzzle:run 2020 1 1 '5 1 9 5
7 5 3
2 4 6 8'
```

# Tests

PHPUnit is used for testing puzzles also:
- https://phpunit.de/
- https://phpunit.readthedocs.io/

Tests can be run using command:
```sh
./vendor/bin/phpunit tests/
```

# Copyright and License

Copyright (c) 2021 Ivan Georgiev
Licensed under the [MIT License](./docs/LICENSE.md)
