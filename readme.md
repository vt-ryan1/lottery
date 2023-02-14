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

#### 中奖概率配置文件说明

``` bash
    //配置中奖的概率以及每个奖项的数目
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
#### 1.抽奖使用方法(人固定，奖项随机)
```phpregexp
Lottery::getAward();
```
返回中的奖项名称，也就是配置中的key值

#### 2.抽奖使用方法(奖项固定，人随机)
```phpregexp
PersonLottery::getAward($dataSource,$count);
$dataSource //数据源所有参与抽奖的人员，数组格式，
$count //中奖人数
```
返回长度是$count的包含抽奖人员的数组，代表中奖人员

#### 清除已中奖信息

```bash
    php artisan lottery:clearRecord //清除抽奖的奖项剩余信息
    php artisan lottery:clearPersonRecord //清除已经中奖的人员信息
```
