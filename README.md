# Mars Rover

## Setup
```
git clone git@github.com:davidpeach/Rover.git
# or
git clone https://github.com/davidpeach/Rover.git

cd ./Rover

composer install
```

## Running the Test Suite

```

./vendor/bin/phpunit

```


## Running

Below is an example of the questions it will ask you along with example responses you could give.

```

php artisan rover:setup

What is the map size?:
 > # 4 8 (Map grid 4 blocks wide by 8 blocks high - zero indexed)

Please give a mapping.:
> # (2, 3, N) FLLFR

Do you wish to add another mapping? (yes/no) [no]:
> # yes

Please give a mapping.:
> # (1, 0, S) FFRLF

Do you wish to add another mapping? (yes/no) [no]:
> # yes

Please give a mapping.:
> # (2, 2, N) RFLFFFFFF

Do you wish to add another mapping? (yes/no) [no]:
> # no

## You should then receive a response like this:
(2, 3, W)
(1, 0, S) LOST
(3, 7, N) LOST

```