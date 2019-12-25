# 紀錄

## 2019-12-25

My_Controller:78 上方先強制轉印尼語系

|           更動檔案路徑           |            說明            |  備註  |
| :------------------------------: | :------------------------: | :----: |
| application/controllors/gold.php | login, login_set, register | &nbsp; |
|  application/config/routes.php   |         增加router         | &nbsp; |
|          css/style.css           |        修改字形路徑        | &nbsp; |


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

## 業務邏輯

會員
- /post_member_login (gold/login_set) 處理前台會員登入
- /member_sms_code (member_register/sms_code) 驗證簡訊
- /member/logout (gold/logout) 會員登出

# 結案前整理

- @todo 10 註解掉 註冊成功 email 發送，因為會報錯。須復原。
- @todo 1001 強制轉語系，須移除。
- 前台 view 都放在 index-all-young 資料夾名稱可以改(須改My_controller::indexViewPath)

