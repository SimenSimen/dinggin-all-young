# 紀錄

## 2019-12-26

|             更動檔案路徑             |  說明  |         備註         |
| :----------------------------------: | :----: | :------------------: |
| application/controllors/products.php | index  |        &nbsp;        |
|   application/library/comment.php    | params | 增加取得數據function |

產品說明

pageNumber 如果有 pageNumber參數，只會畫出商品的content並回傳 (取得更多產品)

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

## 業務邏輯



會員

- /member_sms_code (member_register/sms_code) 驗證簡訊
- /member/change_password (gold/member_password) 會員修改密碼
- /member/info/update (gold/data_AED) 會員基本資料修改
- /member/logout (gold/logout) 會員登出
- /member/lopin (gold/login_set) 處理前台會員登入
- /member/upgrade/submit (gold/data_AED) 升級經營會員

商品



# 待辦

- @todo 11020 申請經銷會員必填欄位

# 結案前整理

- @todo 10 註解掉 註冊成功 email 發送，因為會報錯。須復原。
- @todo 1001 強制轉語系，須移除。
- @todo 1121 移除開啟錯誤訊息。
- @todo 3329 顯示錯誤訊息 CI loading 語言的時候會報錯 先exit，結案後移除。
- 前台 view 都放在 index-all-young 資料夾名稱可以改(須改My_controller::indexViewPath)。
