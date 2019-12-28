
# Router

路徑 (controller 路徑)

## 頁面(Direct)

- /index 首頁
- /register (gold/register) 註冊頁面
- /member_sms_code (member_register/sms_code) 輸入簡訊驗證頁面
- /member_register_ok (member_register/register_ok) 註冊成功畫面
- /login (gold/login) 前台登入頁面
- /member (gold/member) 前台會員畫面
- /member/info (gold/member_info) 前台會員基本資料
- /member/upgrade (gold/member_upgrade) 升級經營會員頁面
- /member/change_password (gold/member_password) 修改密碼頁面
- /member/order/{id} (gold/order_info) 訂單詳細資訊
- /member/dividend 紅利查詢
- /member/member_dividend_fun (gold/member_dividend_fun) 購物金查詢
- /products 所有產品列表
- /products/{class_id} 依照產品分類列表
- /brands 品牌頁面
- /cart 購物車頁面
- /cart/checkout (cart/cart_checkout) 結帳頁面
- /cart/finish (/cart/cart_checkout_ok) 結帳完成

### /products 所有產品列表 - 查詢說明

篩選參數

|     參數     |   型態    |                 說明                 |
| :----------: | :-------: | :----------------------------------: |
| `providerId` |   `int`   |               供應商ID               |
|  `maxPrice`  | `decimal` |               最大價錢               |
|  `minPrice`  | `decimal` |               最小價錢               |
|    `msg`     | `string`  |               拋出訊息               |
|  `sortType`  |   `int`   | sortType: 1 為 低至高 1以外為 高至低 |
| `pageNumber` |   `mix`   |                 頁數                 |
|  `pageSize`  |   `mix`   |           單頁筆數 預設12            |

搜尋參數

|   參數    |   型態   |    說明    |
| :-------: | :------: | :--------: |
| `keyword` | `string` | 搜尋關鍵字 |

## 業務邏輯(Form)

- /member_sms_code (member_register/sms_code) 驗證簡訊
- /member/change_password (gold/member_password) 會員修改密碼
- /member/info/update (gold/data_AED) 會員基本資料修改
- /member/logout (gold/logout) 會員登出
- /member/lopin (gold/login_set) 處理前台會員登入
- /member/upgrade/submit (gold/data_AED) 升級經營會員
