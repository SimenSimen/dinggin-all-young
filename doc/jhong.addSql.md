# sql

- lapack_list 插入品牌頁 

```sql
INSERT INTO `lapack_list`(`d_id`, `d_title`, `d_url`, `d_sort`, `d_enable`) VALUES (50, '品牌頁面', '/brands', 50, 'Y');
```

- add 品牌管理 to menu

```sql
INSERT INTO `jur_action` VALUES (null, '0', 'j_brands', '品牌管理', '', '11', 'N', 'N');
INSERT INTO `jur_action` (d_id, d_p_id, d_code, d_name, d_link, sort, is_del, is_super ) SELECT NULL AS col1 , d_id AS col2, 'j_brands' AS col3, '品牌管理' AS col4, '/corporate/main/7' AS col5, '1' AS col6, 'N' AS col7, 'N' AS col8 FROM `jur_action` WHERE d_p_id = 0 AND d_name = '品牌管理';
UPDATE `jurisdicer` set d_action_list = CONCAT ( d_action_list  , ',j_brands') where d_name = '給客戶展示';
ALTER TABLE `ckeditor` MODIFY COLUMN `type` enum('1','2','3','4','5','6','7');
```

- 增加欄位 for product_brand 關聯 ckeditor

```sql
alter table product_brand add column ck_id int(10) UNSIGNED default NULL;
```

- 增加欄位 for 超取店號 

```sql
ALTER TABLE `order` ADD COLUMN cs_no VARCHAR ( 30 ) DEFAULT NULL COMMENT "超取店號";
```

- for 付款狀態 

```sql
INSERT INTO `config` VALUES(null, 'paystatus', '授權未成功', '5', NULL, NULL, 'TW');
```

- for 訂單狀態 

```sql
INSERT INTO `config` VALUES(null, 'orderstatus', '退貨處理中', '9', NULL, NULL, 'TW');
```

- for 會員載具 類型 

```sql
alter table buyer add column vehicle_type tinyint(4) UNSIGNED default NULL COMMENT "載具類別, 0:手機載具 1:自然人載具";
```

- for 載具號碼 

```sql
alter table buyer add column vehicle_no VARCHAR(20) default NULL COMMENT "載具號碼";
```

- 退款資訊

```sql
alter table `order` add column `tax_card_no` varchar(45) DEFAULT NULL COMMENT '稅卡編號';
alter table `order` add column `back_bank_branch` varchar(45) DEFAULT NULL COMMENT '退款分行';
```


- 會員 分行名稱

```sql
alter table `member` add column `bank_branch_name` varchar(45) DEFAULT NULL COMMENT '分行名稱';
alter table `member` add column `tax_card_no` varchar(45) DEFAULT NULL COMMENT '稅卡編號';
alter table `member` add column `last_login` datetime DEFAULT NULL, COMMENT '最後登入時間';
```


