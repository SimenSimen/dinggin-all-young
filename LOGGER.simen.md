# 紀錄

## 2019-12-27

|             更動檔案路徑             |          說明           |    備註    |
| :----------------------------------: | :---------------------: | :--------: |
| application/controllors/products.php | ajax_car ,ajax_demitcar |   &nbsp;   |
|   application/library/comment.php    |         params          | 修正非字串 |

## 2019-12-26

|             更動檔案路徑             |     說明      |         備註         |
| :----------------------------------: | :-----------: | :------------------: |
| application/controllors/products.php | index ,detail |        &nbsp;        |
|   application/library/comment.php    |    params     | 增加取得數據function |
|  application/core/My_Controller.php  | debug, isAjax |     新增function     |
|  application/controllors/brands.php  | index ,detail |        &nbsp;        |


## 2019-12-25

|           更動檔案路徑           |                       說明                        |  備註  |
| :------------------------------: | :-----------------------------------------------: | :----: |
| application/controllors/gold.php | login, login_set, register, member_info, data_AED | &nbsp; |
|  application/config/routes.php   |                    增加router                     | &nbsp; |
|          css/style.css           |                   修改字形路徑                    | &nbsp; |

## 2019-12-24

My controller 新增 $indexViewPath 指定前台 view 資料夾
之後有需求修改名稱即可

前台 view 放在 index-all-young 資料夾裡


|                   更動檔案路徑                    |        說明         |                備註                |
| :-----------------------------------------------: | :-----------------: | :--------------------------------: |
|                       css/*                       |       &nbsp;        |               &nbsp;               |
|                       js/*                        |       &nbsp;        | icon,video,sound 在js引入 路徑要改 |
|                     images/*                      |       &nbsp;        |               &nbsp;               |
|        application/view/index-all-young/*         |       &nbsp;        |               &nbsp;               |
| application/language/ind/views/index-all-young/\* |       &nbsp;        |               &nbsp;               |
|         application/controllors/index.php         | index, member_login |               &nbsp;               |

# Ruter

路徑 (controller 路徑)

## 頁面

- /index 首頁

會員

- /register (gold/register) 註冊頁面
- /member_sms_code (member_register/sms_code) 輸入簡訊驗證頁面
- /member_register_ok (member_register/register_ok) 註冊成功畫面
- /login (gold/login) 前台登入頁面
- /member (gold/member) 前台會員畫面
- /member/info (gold/member_info) 前台會員基本資料
- /member/upgrade (gold/member_upgrade) 升級經營會員頁面
- /member/change_password (gold/member_password) 修改密碼頁面


- /products?providerId=供應商&maxPrise="最大價錢"&minPrise="最小價錢"&sortType="排序"&pageNumber="頁數" 所有產品列表
- /products/{class_id}?providerId=供應商&maxPrise="最大價錢"&minPrise="最小價錢"&sortType="排序"&pageNumber="頁數" 依照產品分類列表
- /brands 品牌頁面

## 業務邏輯

會員

- /member_sms_code (member_register/sms_code) 驗證簡訊
- /member/change_password (gold/member_password) 會員修改密碼
- /member/info/update (gold/data_AED) 會員基本資料修改
- /member/logout (gold/logout) 會員登出
- /member/lopin (gold/login_set) 處理前台會員登入
- /member/upgrade/submit (gold/data_AED) 升級經營會員

# 待辦

- @todo 11020 申請經銷會員必填欄位

# ajax 相關附件

### 基本說明

回傳固定格式如下，資料型態為json

|   參數    |   型態    |                  說明                  |
| :-------: | :-------: | :------------------------------------: |
| `success` | `boolean` |            ajax 成功或失敗             |
|   `msg`   | `string`  |                拋出訊息                |
|  `data`   |   `mix`   | 包含的資料 以下API回傳值皆為此欄位的值 |

### load items /products 

** 取得商品資料 用來load more 或是 Filter**

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

資料庫商品資料

### item quick view /products/details/(:id)

### add item to cart /products/ajax_car

#### 參數說明

|     參數     |   型態   |  說明  |
| :----------: | :------: | :----: |
| `product_id` |  `int`   | 商品ID |
| `shop_count` |  `int`   |  數量  |
|    `spec`    | `string` |  規格  |

#### 回傳說明

錯誤的話不會有。
資料庫商品資料。

### del item from cart = /products/ajax_demitcar

#### 參數說明

|  參數  |   型態   |                    說明                     |
| :----: | :------: | :-----------------------------------------: |
| `uuid` | `string` | 購物車keyid 會放在刪除按扭的tag上(data-key) |

#### 回傳說明

空值

### add item to favirate = /products/ajax_favorite

# 結案前整理

- @todo 10 註解掉 註冊成功 email 發送，因為會報錯。須復原。
- @todo 1001 強制轉語系，須移除。
- @todo 1121 移除開啟錯誤訊息。
- @todo 3329 顯示錯誤訊息 CI loading 語言的時候會報錯 先exit，結案後移除。
- @todo 2200 load 商品 js 有寫好的 記得請對方移過去 ajax(/products)
 
- 前台 view 都放在 index-all-young 資料夾名稱可以改(須改My_controller::indexViewPath)。

# sql

- lapack_list 插入品牌頁 

```sql
INSERT INTO `lapack_list`(`d_id`, `d_title`, `d_url`, `d_sort`, `d_enable`) VALUES (50, '品牌頁面', '/brands', 50, 'Y');
```

# 須前端協助

因為js是bundle的，所以ajax須前端協助處理。

- 立即搜尋結果 /products?keyword ajax
- 搜尋結果 跳 all products (/products?keyword連結即可)
- 商品清單 load more /products?pageNumber 須
- 各種分類篩選條件須 前端組合參數 丟入products/brand
- 加入購物車 (加入購物車後會回傳商品資料供繪製畫面，上放數量需增加，數字tag上有存數據(data-count))
- 移出購物車 (刪除按鍵上有存數據(data-key) 傳入api 即可刪除)
- 加入最愛清單
- tt-badge-cart b_green (原始數量放在data-count attr) 購物車數量增加減少

詳情請看 ajax 相關附件