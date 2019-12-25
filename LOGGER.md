# Config

**Need to turn on the open short tag config for php int**
logger 





#### note
超級管理者後台menu資料表 jur_action

path 
    /admin 後台登入
        使用者auth = 00 進到超級管理者後台


<!-- add 品牌管理 to menu  編號隨資料庫狀況更動-->
INSERT INTO `jur_action` VALUES (null, '0', 'j_brands', '品牌管理', '', '11', 'N', 'N');
INSERT INTO `jur_action` VALUES (null, '84', 'j_brands', '品牌管理', '/brands/brands_list', '1', 'N', 'N');
UPDATE `jurisdicer` set d_action_list = CONCAT ( d_action_list  , ',j_brands') where d_name = '給客戶展示'


<!-- file added -->
dinggin-all-young\app\application\controllers\brands.php
dinggin-all-young\app\application\views\brands\

<!-- file modified -->