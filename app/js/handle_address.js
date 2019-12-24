var cities = null;

/* 處理JavaScript非同步  以axios呼叫API獲取response */
const getCities = async () => {
    // 解構賦值  取得Promise物件之data屬性
    const { data } = await axios.get('/member/get_city_category');
    return data;
}

/* response指定給全域變數 */
getCities()
    .then((response) => {
        cities = response;
    });

/* 參數內容 object:資料過濾條件  element:元素ID */
const handleCollection = (object, element) => {
    // 以lodash過濾集合 並以s_sort欄位排序
    const collection = _.orderBy(_.filter(cities, object), o => o.s_sort)
    $(`#${element} option`).remove();

    // 迭代
    _.forEach(collection,(value, key) => {
        $(`#${element}`).append(
            `<option value=${value.s_id}>${value.s_name}</option>`
        )
    })

    $(`#${element}`).change()
}
$('#country').on('change', () => {
    handleCollection({ 's_city_id': $('#country').val() }, 'city')
})

$('#city').on('change', () => {
    handleCollection({ 's_city_id': $('#city').val() }, 'countory')
})

$('#countory').on('change', () => {
    data = _.filter(cities, { 
        's_city_id': $('#city').val(),
        's_id': $('#countory').val() 
    })

    $('#zip').val(data[0].s_zipcode)
})