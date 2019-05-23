# wechatapplet-api

微信小程序开发者服务器后端API

## 认证接口 

采用**oauth2**认证流程

### 1.登录
`请求地址` /oauth/login

`请求方式` post 

`请求参数`

|参数名    |必选     |含义
|:---------:|--------|-------|
|code      |true     |wx.login获取的code|

`返回格式`

|参数名    |含义
|:---------:|-------|
|api_token  |前端调用api时的身份凭证|
|open_id    |用户在微信的唯一标识|
|expired_in |api_token过期时间|
|refresh_token |刷新api_token的凭证|

### 2.api_token刷新

`请求地址` /oauth/refresh-token

`请求方式` post 

`请求参数`

|参数名    |必选     |含义
|:---------:|--------|-------|
|api_token   |true     |见登录返回格式|
|open_id     |true     |同上|
|refresh_token   |true     |同上|

`返回格式`

|参数名    |含义
|:---------:|-------|
|api_token  |前端调用api时的身份凭证|
|open_id    |用户在微信的唯一标识|
|expired_in |api_token过期时间|
|refresh_token |刷新api_token的凭证|

## 业务接口

非特殊说明,业务接口需在querystring中携带api_token,即http//xxxxxx:xx/xxxxxxx?api_token=
业务接口均返回json格式的数据，若responsecode为200，一般格式为
```
   {
     'success' => true(false),
     'data' => []({})
    }
```

### 1.map

map为地图信息,携带了它所包含的markpoint,markpoint中携带了它所包含的card
* get /api/map 获取所有map
* get /api/map/{map_id} 获取指定map

### 2.markpoint

地图上的标记点信息

* get /api/markpoint 获取所有markpoint以及包含的card
* get /api/markpoint/{markpoint_id} 获取指定markpoint以及包含的card
* post /api/markpoint/subscription/add/{markpoint_id} 订阅指定的markpoint
* post /api/markpoint/subscription/delete/{markpoint_id} 取消订阅指定的markpoint

### 3.card

卡片信息
* get /api/card 获取所有的card
* get /api/card/{card_id} 获取指定的card
* post /api/card/collection/add/{card_id} 收藏指定的card
* post /api/card/collection/delete/{card_id} 取消收藏指定的card

### 4.article

文章信息
* get /api/article 获取所有的article
* get /api/article/{article_id} 获取指定的article
* post /api/article/collection/add/{article_id} 收藏指定的article
* post /api/article/collection/delete/{article_id} 取消收藏指定的article

### 5.collection

收藏信息
* get /api/collection 获取该用户所有的collection
* get /api/collection/{collection_id} 获取该用户指定的collection

### 5.subscription

订阅信息
* get /api/subscription 获取该用户所有的subscription
* get /api/subscription/{subscription_id} 获取该用户指定的subscription

### 6.alert

提醒信息
* get /api/alert 获取用户所有的alert
* get /api/alert/{alert__id} 获取指定的alert
* post /api/alert/ 添加一条alert, 必选参数为content
* post /api/alert/edit/{alert_id} 编辑指定的alert 必选参数为content
* post /api/alert/delete/{alert_id} 删除指定的alert

### 7. feedback

反馈信息
* post /api/feedback 添加一条反馈信息 必选参数为

### 8.user

用户信息
* get /api/user 获取用户信息
