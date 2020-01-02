# sql

- lapack_list 插入品牌頁 

```sql
INSERT INTO `lapack_list`(`d_id`, `d_title`, `d_url`, `d_sort`, `d_enable`) VALUES (50, '品牌頁面', '/brands', 50, 'Y');
```


## (member) 經營會員資料表調整 

```sql
ALTER TABLE member ADD COLUMN bank_branch VARCHAR(64) COMMENT '分行名稱';
ALTER TABLE member ADD COLUMN tax_card VARCHAR(64) COMMENT '稅卡號碼';
ALTER TABLE member ADD COLUMN tax_card_free TINYINT NULL COMMENT '1稅卡/2免稅卡';
ALTER TABLE member ADD COLUMN id_role TINYINT NULL COMMENT '1自然人/2法人';
```

## (buyer) 一般會員資料表調整


## (member_appy) 經營會員申請資料表調整 

```sql
ALTER TABLE member_apply ADD COLUMN bank_branch VARCHAR(64) COMMENT '分行名稱';
ALTER TABLE member_apply ADD COLUMN tax_card VARCHAR(64) COMMENT '稅卡號碼';
ALTER TABLE member_apply ADD COLUMN tax_card_free TINYINT NULL COMMENT '1稅卡/2免稅卡';
ALTER TABLE member_apply ADD COLUMN id_role TINYINT NULL COMMENT '1自然人/2法人';
```

## (address) 常用地址資料表調整

```sql
ALTER TABLE address ADD COLUMN email VARCHAR(128) NULL COMMENT 'email';
```

## (order) 調整訂單資料表

```sql
ALTER TABLE `order` ADD COLUMN carrier_type TINYINT NULL COMMENT '載具種類 0: 會員 1: 行動電話 2: 自然人';
ALTER TABLE `order` ADD COLUMN carrier_number VARCHAR(128) NULL COMMENT '載具號碼';
ALTER TABLE `order` ADD COLUMN invoice_type TINYINT NULL COMMENT '發票種類 0: 電子發票 1: 二聯式 2: 三聯式';
```

## (products) 商品資料表調整

```sql
ALTER TABLE products ADD COLUMN prd_bid int(10) NULL COMMENT '品牌編號';
```