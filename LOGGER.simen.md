# 紀錄

## 2019-12-25

My_Controller:78 上方先強制轉印尼語系

|           更動檔案路徑           |            說明            |  備註  |
| :------------------------------: | :------------------------: | :----: |
| application/controllors/gold.php | login, login_set, register | &nbsp; |
|  application/config/routes.php   |         增加router         | &nbsp; |


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

## 頁面

- /index 首頁
- /login (gold/login) 前台登入頁面
- /register (gold/register) 註冊頁面

## 業務邏輯

- /post_member_login (gold/login_set) 處理前台會員登入
- /post_member_login (gold/data_AED) 處理前台會員登入

# 結案前整理

- My_Controller:78 移除強制轉語系
- 前台 view 都放在 index-all-young 資料夾名稱可以改(須改My_controller::indexViewPath)

