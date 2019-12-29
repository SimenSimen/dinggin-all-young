# sql

- lapack_list 插入品牌頁 

```sql
INSERT INTO `lapack_list`(`d_id`, `d_title`, `d_url`, `d_sort`, `d_enable`) VALUES (50, '品牌頁面', '/brands', 50, 'Y');
```


## (member) 經營會員資料表調整 

```sql
ALTER TABLE member ADD COLUMN bank_branch VARCHAR(64) COMMENT '分行名稱';
ALTER TABLE member ADD COLUMN tax_card VARCHAR(64) COMMENT '稅卡號碼';
ALTER TABLE member ADD COLUMN tax_card_free TINYINT NULL COMMENT '稅卡/免稅卡';
ALTER TABLE member ADD COLUMN id_role TINYINT NULL COMMENT '自然人/法人';
```

## (buyer) 一般會員資料表調整
