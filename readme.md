# Lottery 抽奖功能

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]


## Installation

Via Composer

``` bash
$ composer require victtech/lottery
```

## Usage
#### 安装完之后，发布配置文件
``` bash
    php artisan vendor:publish --tag=lottery.config
```

#### 配置文件说明

``` bash
    return [
    'awards'=>[
        //key 是奖项名称
        '一等奖'=>[
            'total'=>5, //奖项总数量
            'probability'=>30  //中奖概率，百分率.所有奖项百分率之外就是不中奖概率
        ],
        '二等奖'=>[
            'total'=>10,
            'probability'=>50
        ]
    ],
];

```

#### 清除以中奖信息

```bash
    php artisan lottery:clearRecord
```
