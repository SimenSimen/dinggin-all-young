# 相關說明

- [頁面路由](/doc/simen.router.md)
- [Ajax 附件](/doc/simen.ajax.md)
- [須添加的Sql](/doc/simen.addSql.md)
- [相關備註](/doc/simen.remark.md)

# 紀錄

## 2019-12-28

|            更動檔案路徑            |                       說明                        |     備註     |
| :--------------------------------: | :-----------------------------------------------: | :----------: |
|  application/controllors/cart.php  | total_all,ajax_count,cart_checkout,ajax_area_info |    &nbsp;    |
| application/core/My_Controller.php |                apiResponse,isLogin                | 新增function |
| application/models/gold_model.php  |            pageDividend,dividendExpire            |    &nbsp;    |
|  application/controllors/gold.php  |           member_dividend_fun,dividend            |    &nbsp;    |
| application/controllors/index.php  |                       index                       |    &nbsp;    |

## 2019-12-27

|             更動檔案路徑             |          說明           |    備註    |
| :----------------------------------: | :---------------------: | :--------: |
| application/controllors/products.php | ajax_car ,ajax_demitcar |   &nbsp;   |
|   application/controllors/cart.php   |          index          |   &nbsp;   |
|  application/controllors/webpay.php  |       pay,wait()        |   &nbsp;   |
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

|                   更動檔案路徑                    |        說明         |                備註                |
| :-----------------------------------------------: | :-----------------: | :--------------------------------: |
|                       css/*                       |       &nbsp;        |               &nbsp;               |
|                       js/*                        |       &nbsp;        | icon,video,sound 在js引入 路徑要改 |
|                     images/*                      |       &nbsp;        |               &nbsp;               |
|        application/view/index-all-young/*         |       &nbsp;        |               &nbsp;               |
| application/language/ind/views/index-all-young/\* |       &nbsp;        |               &nbsp;               |
|         application/controllors/index.php         | index, member_login |               &nbsp;               |

# 待辦

- @todo 11020 申請經銷會員必填欄位
- 發票寫入

# 結案前整理

- @todo 10 註解掉 註冊成功 email 發送，因為會報錯。須復原。
- @todo 1001 強制轉語系，須移除。
- @todo 1121 移除開啟錯誤訊息。
- @todo 3329 顯示錯誤訊息 CI loading 語言的時候會報錯 先exit，結案後移除。
- @todo 2200 load 商品 js 有寫好的 記得請對方移過去 ajax(/products)
- @todo 110002 購物車送出先不檢查必填，測試用
 
- 前台 view 都放在 index-all-young 資料夾名稱可以改(須改My_controller::indexViewPath)。

# Remark

- My controller 新增 $indexViewPath 指定前台 view 資料夾，之後有需求修改名稱即可
- 前台所有 view 目前放在 index-all-young 資料夾裡

