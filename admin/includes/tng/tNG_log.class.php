<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

class tNG_log {
	function log($className, $methodName=NULL, $message=null) {
		$GLOBALS['KT_logArray'][] = array($className, $methodName, $message);
	}

	function getResult($mode) {
		$ret = '';
		$alt = '';
		$ret .= '<ul id="KT_tngtrace_details">';
		$depth = 2;
		for ($i=0;$i<count($GLOBALS['KT_logArray']);$i++) {
			if (isset($GLOBALS['KT_logArray'][$i+1][0]) && $GLOBALS['KT_logArray'][$i+1][0] == 'KT_ERROR') {
				$alt = ' style="color:red"';
			}
			if ($GLOBALS['KT_logArray'][$i][0] == 'KT_ERROR') {
				$alt = '';
				continue;
			}
			if ($GLOBALS['KT_logArray'][$i][2] == 'begin') {
				$ret .= str_repeat(' ', $depth) . "<li$alt>" . $GLOBALS['KT_logArray'][$i][0] . '.' . $GLOBALS['KT_logArray'][$i][1] . ($alt!=''?'*':'') . '</li>' . "\r\n";
				$ret .= "<ul>";
				$depth+=2;
			} elseif ($GLOBALS['KT_logArray'][$i][2] == 'end') {
				$ret .= "</ul>";
				$depth-=2;
			} else {
				if (!is_null($GLOBALS['KT_logArray'][$i][2])) {
					$ret .= str_repeat(' ', $depth) . "<li$alt>" . $GLOBALS['KT_logArray'][$i][0] . '.' . $GLOBALS['KT_logArray'][$i][1] . ' - ' . $GLOBALS['KT_logArray'][$i][2] . ($alt!=''?'*':'') . '</li>' . "\r\n";
				} else {
					$ret .= str_repeat(' ', $depth) .  "<li$alt>" . $GLOBALS['KT_logArray'][$i][0] . '.' . $GLOBALS['KT_logArray'][$i][1] . ($alt!=''?'*':'') . '</li>' . "\r\n";
				}
			}
		}
		$ret .= "</ul>";
		if ($mode == 'text') {
			$ret = strip_tags($ret);
		}
		return $ret;
	}
}
?>