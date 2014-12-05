<?php

//namespace salmonmvc\html;

class Htmler {

	public static function buildList($field,
		$data,
		$id,
		$text,
		$value=NULL,
		$opts=NULL,
        $attributes=null) {

		if (is_array($opts)) {

			$o = $opts["multiple"] ? "multiple=\"multiple\" " : NULL;
			$ab = $opts["addBlank"];
		}

        $a = self::buildAttrs($attributes);

		$h = "<select name=\"$field\" $o $a>";

		if ($ab) $h .= "<option />";

		if (is_array($data)) {

			foreach ($data as $option) {

				$v = $option->$id;

				$s = $value != NULL && $value == $v ?
					"selected='selected'" : NULL;

				$h .= "<option $s value=\"$v\" >" .
						$option->$text . "</option>";
			}
		}

		return $h . "</select>";
	}

	public static function buildLink($text,
		$action,
		$id=NULL,
		$attributes = null,
		$controller = NULL,
		$query = NULL) {

		$a = self::buildAttrs($attributes);

		if (is_array($query)) {

			$q = "?";
			foreach ($query as $key => $value) {

				$q .= "$key=$value&";
			}
			$q = rtrim($q, '&');
		}

		return "<a href=\"" . Mvcer::buildUrl($action, $id, $controller) . $q .
				"\" $a>" . $text . "</a>";
	}

    protected static function buildAttrs($attributes) {

        if (is_array($attributes)) {

			foreach ($attributes as $key => $value) {
				$a .= " $key='$value'";
			}
		}

        return $a;
    }
}
?>
