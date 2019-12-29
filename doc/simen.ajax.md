# Ajax 相關附件

## 基本說明

回傳**固定格式**如下，資料型態為``json``

|   參數    |   型態    |                  說明                  |
| :-------: | :-------: | :------------------------------------: |
| `success` | `boolean` |            ajax 成功或失敗             |
|   `msg`   | `string`  |                拋出訊息                |
|  `data`   |   `mix`   | 包含的資料 以下API回傳值皆為此欄位的值 |

## 快速瀏覽

- 取得商品列表 (/products)
- 取得商品資訊 (/products/details/(:id))
- 加入商品至購物車 (/products/ajax_car)
- 從購物車中刪除商品 (/products/ajax_demitcar)
- 更改購物車商品數量 (/cart/ajax_count)
- 選擇常用地址 (/cart/ajax_common_address)
- 取得鄉鎮城市列表 (/cart/ajax_area_info)

## Ajax 列表

### 取得商品列表 (/products)

- URL: `/products`
- 可用來**載入更多商品**或是**篩選商品**

#### 參數說明

|     參數     |   型態    |                 說明                 |
| :----------: | :-------: | :----------------------------------: |
| `providerId` |   `int`   |               供應商ID               |
|  `keyword`   | `string`  |              搜尋關鍵字              |
|  `maxPrice`  | `decimal` |               最大價錢               |
|  `minPrice`  | `decimal` |               最小價錢               |
|    `msg`     | `string`  |               拋出訊息               |
|  `sortType`  |   `int`   | sortType: 1 為 低至高 1以外為 高至低 |
| `pageNumber` |   `mix`   |                 頁數                 |
|  `pageSize`  |   `mix`   |           單頁筆數 預設12            |

#### 回傳說明

資料庫商品陣列

<hr>

### 取得商品資訊 (/products/details/(:id))

- URL: `/products/details/(:id)`
- 可用在**商品快速瀏覽**視窗

#### 參數說明

商品ID由URL帶入，無參數。

#### 回傳說明

資料庫商品資訊。

<hr>

### 加入商品至購物車 (/products/ajax_car)

- URL: `/products/ajax_car`
  
#### 參數說明

|     參數     |   型態   |  說明  |
| :----------: | :------: | :----: |
| `product_id` |  `int`   | 商品ID |
| `shop_count` |  `int`   |  數量  |
|    `spec`    | `string` |  規格  |

#### 回傳說明

資料庫商品資料。

<hr>

### 從購物車中刪除商品 (/products/ajax_demitcar)

- URL: `/products/ajax_demitcar`

#### 參數說明

|  參數  |   型態   |                    說明                     |
| :----: | :------: | :-----------------------------------------: |
| `uuid` | `string` | 購物車keyid 會放在刪除按扭的tag上(data-key) |

#### 回傳說明

無。

<hr>

### 更改購物車商品數量 (/cart/ajax_count)

- URL: `/cart/ajax_count`

#### 參數說明

| 參數  | 型態  |     說明      |
| :---: | :---: | :-----------: |
| `key` | `int` | 購物車物品key |
| `qty` | `int` |     數量      |

#### 回傳說明

修改後的數量

<hr>

### 計算購物車總金額 (cart/ajax_total)

- URL: `/cart/ajax_total`
- 使用紅利點數、購物金時呼叫

#### 參數說明

|         參數         |   型態    |    說明    |
| :------------------: | :-------: | :--------: |
|    `use_dividend`    | `decimal` |  紅利折抵  |
| `use_shopping_money` | `decimal` | 使用購物金 |

#### 回傳說明

|     參數     |   型態    |    說明    |
| :----------: | :-------: | :--------: |
| `dataTotal`  |   `int`   |   總金額   |
| `only_money` |   `int`   |    現金    |
| `dataBonus`  | `decimal` | 可獲得紅利 |

<hr>

### 選擇常用地址 (/cart/ajax_common_address)

- URL: `/cart/ajax_common_address`

#### 參數說明

|     參數     | 型態  |  說明  |
| :----------: | :---: | :----: |
| `address_id` | `int` | 地址ID |

#### 回傳說明

|    參數    |   型態   |    說明    |
| :--------: | :------: | :--------: |
|   `name`   | `string` | 收件人名稱 |
| `telphone` | `string` |    電話    |
| `country`  |  `int`   |    國家    |
|   `city`   |  `int`   |    城市    |
| `countory` |  `int`   |    鄉鎮    |
| `address`  | `string` |    地址    |
|   `zip`    | `string` |  郵遞區號  |

<hr>

### 取得鄉鎮城市列表 (/cart/ajax_area_info)

- URL: `/cart/ajax_area_info`

#### 參數說明

|   參數    | 型態  |  說明  |
| :-------: | :---: | :----: |
| `area_id` | `int` | 地區ID |

#### 回傳說明

回傳值為陣列，陣列內容包含json物件，物件規格如下

|   參數   |   型態   |   說明   |
| :------: | :------: | :------: |
|  `s_id`  |  `int`   |  地區ID  |
| `s_name` | `string` | 地區名稱 |

<hr>

### 新增/移除追蹤商品 = /cart/ajax_favorite

- URL: `/cart/ajax_favorite`

#### 參數說明

| 參數  | 型態  |  說明  |
| :---: | :---: | :----: |
| `id`  | `int` | 商品id |

#### 回傳說明

|   參數   |   型態   |          說明          |
| :------: | :------: | :--------------------: |
| `action` | `string` | add: 新增<br>del: 刪除 |