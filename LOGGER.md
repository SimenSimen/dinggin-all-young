# Config

**Need to turn on the open short tag config for php int**
logger 





#### note
超級管理者後台menu資料表 jur_action

path 
    /admin 後台登入
        使用者auth = 00 進到超級管理者後台


<!-- add 品牌管理 to menu -->
INSERT INTO `jur_action` VALUES (null, '0', 'j_comlist,j_comdata,j_supplier', '品牌管理', '', '11', 'N', 'N');
INSERT INTO `jur_action` VALUES (null), '84', 'j_comdata', '品牌管理', '/products/products_list', '1', 'N', 'N');