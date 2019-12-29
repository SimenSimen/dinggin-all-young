# Config

**Need to turn on the open short tag config for php int**
logger 

#### note
超級管理者後台menu資料表 jur_action
內容:圖文編輯器的需求 從ckeditor資料表產list => 共用 corporate/main 
    新的項目要使用編輯器要調整: 
        dinggin-all-young\app\application\controllers\corporate.php
        dinggin-all-young\app\application\models\corporate_model.php
        table ckeditor 的 type enum

商品系列維護 = 商品分類管理
商品資料維護 = 商品管理


path 
    /admin 後台登入
        使用者auth = 00 進到超級管理者後台


<!-- add 品牌管理 to menu  編號隨資料庫狀況更動-->
INSERT INTO `jur_action` VALUES (null, '0', 'j_brands', '品牌管理', '', '11', 'N', 'N');
INSERT INTO `jur_action` (d_id, d_p_id, d_code, d_name, d_link, sort, is_del, is_super ) SELECT NULL AS col1 , d_id AS col2, 'j_brands' AS col3, '品牌管理' AS col4, '/corporate/main/7' AS col5, '1' AS col6, 'N' AS col7, 'N' AS col8 FROM `jur_action` WHERE d_p_id = 0 AND d_name = '品牌管理';
UPDATE `jurisdicer` set d_action_list = CONCAT ( d_action_list  , ',j_brands') where d_name = '給客戶展示';
ALTER TABLE `ckeditor` MODIFY COLUMN `type` enum('1','2','3','4','5','6','7');
<!-- 增加欄位 for product_brand 關聯 ckeditor -->
alter table product_brand add column ck_id int(10) UNSIGNED default NULL;
<!-- 增加欄位 for 超取店號 -->
ALTER TABLE `order` ADD COLUMN cs_no VARCHAR ( 30 ) DEFAULT NULL COMMENT "超取店號";
<!--for 付款狀態 -->
INSERT INTO `config` VALUES(null, 'paystatus', '授權未成功', '5', NULL, NULL, 'TW');
<!--for 訂單狀態 -->
INSERT INTO `config` VALUES(null, 'orderstatus', '退貨處理中', '9', NULL, NULL, 'TW');
<!--for 會員載具 類型 -->
alter table buyer add column vehicle_type tinyint(4) UNSIGNED default NULL COMMENT "載具類別, 0:手機載具 1:自然人載具";
<!--for 載具號碼 -->
alter table buyer add column vehicle_no VARCHAR(20) default NULL COMMENT "載具號碼";



<!-- file added -->
dinggin-all-young\app\application\controllers\brands.php
dinggin-all-young\app\application\views\brands\
    <!-- list data from product_brand 改成list data from ckeditor,暫不用  -->
    brands_list_for_product_brand.php 


<!-- file modified -->
dinggin-all-young\app\application\controllers\corporate.php
dinggin-all-young\app\application\models\corporate_model.php
dinggin-all-young\app\application\views\admin\system_center\list.php
dinggin-all-young\app\application\models\product_brand_model.php
dinggin-all-young\app\application\controllers\products.php
dinggin-all-young\app\application\views\products\product_class_info.php
dinggin-all-young\app\application\views\products\product_class_list.php
dinggin-all-young\app\application\models\MyModel\mymodel.php
dinggin-all-young\app\application\views\products\product_info.php
dinggin-all-young\app\application\views\products\product_list.php
dinggin-all-young\app/application/controllers/order.php
dinggin-all-young\app/application/models/order_model.php
dinggin-all-young\app/application/views/order/order_info.php
dinggin-all-young\app/application/views/order/order_list.php


