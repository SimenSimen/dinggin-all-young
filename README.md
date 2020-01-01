[前台相關資料](/LOGGER.simen.md)

# Config

## php int

**Need to turn on the open short tag config of php int**

## Docker

```bash
cd project_root/docker
```

```bash
docker-compose up
```

### mysql

- docker internal port: 3306
- localhost port: 13306

### host

host http://all-young.io/

static host http://st.all-young.io/


# Work to do - Simen

|    Title     |           item           | description | remark | check again |
| :----------: | :----------------------: | :---------: | :----: | :---------: |
|     前台     |    首頁-印尼(未登入)     |    done     |        |   &nbsp;    |
|              |   首頁-印尼(一般會員)    |    done     |        |   &nbsp;    |
|              |   首頁-印尼(經銷會員)    |    done     |        |   &nbsp;    |
|              |           登入           |    done     |        |    **V**    |
|              |      註冊-填寫資料       |    done     |        |    **V**    |
|              |      註冊-簡訊驗證       |    done     |        |    **V**    |
|              |      註冊-註冊完成       |    done     |        |    **V**    |
|              |        品牌-商店         |   &nbsp;    |        |   &nbsp;    |
|              |         全部商品         |    done     |        |    **V**    |
|              |       商品頁(有貨)       |    done     |        |    **V**    |
|              |       商品頁(缺貨)       |    done     |        |    **V**    |
|              |          搜尋頁          |    done     |        |    **V**    |
|              | 購物車 - 二聯式發票 印尼 |    done     |        |    **V**    |
|              | 購物車 - 三聯式發票 印尼 |    done     |        |    **V**    |
|              | 購物車 - 二聯式發票確認  |    done     |        |    **V**    |
|              | 購物車 - 三聯式發票確認  |    done     |        |    **V**    |
|              |    購物車 - 訂單完成     |    done     |        |    **V**    |
| 前台會員專區 |       紅利點數查詢       |    done     |        |    **V**    |
|              |        購物金查詢        |    done     |        |    **V**    |
|              |         追蹤清單         |    done     |        |    **V**    |
|              | 基本資料(一般會員)-印尼  |    done     |        |    **V**    |
|              | 基本資料(經營會員)-印尼  |    done     |        |    **V**    |
|              |    升級經營會員-印尼     |    done     |        |    **V**    |
|              |     邀請碼分享-印尼      |    done     |        |    **V**    |

# lang_model

Depends on lapack_list d_id to get language setting

```php
    $this->lmodel->config($pageId, $lang); 
```

# css 

- wokiee font path in css/style.css error
