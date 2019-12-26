<?
class Comment
{
	static public function ClassExists($class_name, $data = array())
	{ //載入class
		$Ctrl = (object) array();
		if (class_exists($class_name)) {
			$Ctrl = new $class_name($data);
		}
		return $Ctrl;
	}

	//抓取變數
	static public function Set_GET($value)
	{
		$string = "";
		if (isset($_GET[$value])) {
			//環境配置的變量,所有的 ' (單引號), " (雙引號), \ (反斜線) and 空字符會自動轉為含有反斜線的溢出字符
			if (!get_magic_quotes_gpc()) {
				$string = addslashes($_GET[$value]);
			} else {
				$string = trim($_GET[$value]);
			}
		}
		return $string;
	}

	//REQUEST的回傳值
	static function SetValue($value)
	{ //use
		$string = "";
		if (isset($_POST[$value])) {
			//環境配置的變量,所有的 ' (單引號), " (雙引號), \ (反斜線) and 空字符會自動轉為含有反斜線的溢出字符
			if (!get_magic_quotes_gpc() and !is_array($_POST[$value])) {
				$string = addslashes($_POST[$value]);
			} else {
				$string = $_POST[$value];
			}
		}
		if (!is_array($string))
			$string = trim($string);

		return $string;
	}

	/**
	 * Get parmas from request
	 * 
	 * Post data is priority
	 *
	 * @param array|string $key
	 * @return array|string|null
	 */
	public static function params($keys)
	{
		$isArray = is_array($keys);
		$data = [];

		if (!$isArray) {
			$keys = [$keys];
		}

		foreach ($keys as $key) {
			$postData = static::SetValue($key);
			$data[$key] = $postData == '' ? static::Set_GET($key) : $postData;
			$data[$key] = $data[$key] == '' ? null : $data[$key];
		}

		return $isArray ? $data : @$data[$keys[0]];
	}
}
