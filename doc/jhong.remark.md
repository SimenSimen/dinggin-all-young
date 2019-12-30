
# 須前端協助

因為js是bundle的，所以ajax以及畫面效果須前端協助處理。

- 立即搜尋結果 /products?keyword ajax
- 搜尋結果 跳 all products (/products?keyword連結即可)
- 商品清單 load more /products?pageNumber 須
- 各種分類篩選條件須 前端組合參數 丟入products/brand
- 加入購物車 (加入購物車後會回傳商品資料供繪製畫面，上放數量需增加，數字tag上有存數據(data-count))
- 移出購物車 (刪除按鍵上有存數據(data-key) 傳入api 即可刪除)
- 上方購物車 icon 數量(.tt-badge-cart .b_green\[data-count\]) 修改
- 加入最愛清單
- 購物車內商品數量修改 uuid 放在最外層 tr 上 有加上類別 tr.cart-item\[data-uuid\]
- 購物車內購物金檢查 (tt-input-counter\[data-amount\])
- 購物車內紅利檢查 (tt-input-counter\[data-amount\])
- 切換二三聯式發票 隱藏欄位
- 選擇地區ajax 

詳情請看 [ajax 相關附件](/doc/simen.ajax.md)