<?php
class HtmlSpecialFunctions {
	public static function onParserSetup($parser) {
		$parser->setFunctionHook('mwCleanHTML', 'HtmlSpecialFunctions::mwCleanHTML');
		$parser->setFunctionHook('mwCategoryLinks', 'HtmlSpecialFunctions::mwCategoryLinks');
                $parser->setFunctionHook('mwIncludeHTML', 'HtmlSpecialFunctions::mwIncludeHTML');
		return true;
	}

	public static function mwCleanHTML($parser, $text='', $max=0) {
	        $output = strip_tags($text);
		if (!empty($max) && is_numeric($max)) {
			$output = trim($output);
			if (mb_strlen($output, "UTF-8")>$max) {
				$output = trim(mb_substr($output, 0, $max, "UTF-8"))."...";
			}
		}
	        return array($output, 'noparse'=>false, 'isHTML'=>true);
	}

	public static function mwIncludeHTML($parser, $file) {
		if (!empty($file) && !preg_match('/[^a-z0-9\.]/i', $file)) {
			$folder = rtrim(dirname(__FILE__), "/")."/html_includes/";
			if (file_exists("$folder/$file")) {
				$html = str_replace("\n", " ", file_get_contents("$folder/$file"));
				return array($html, 'noparse'=>false, 'isHTML'=>'true');
			}
		}
	}

	public static function mwCategoryLinks($parser, $data='', $sep=',', $valuesep=',', $queryForm='', $catarg='', $titlecatshow='', $titleshow='') {
		#$parserOptions = new ParserOptions;
		#$data = $parser->parse($query, $parser->getTitle(), $parserOptions)->getText();
		#return array($query, 'noparse'=>true, 'isHTML'=>true);
		$excludec = array('Seiten mit defekten Dateilinks');

		$listCats = array();
		$cntAll = 0;
		$data = explode($sep, $data);
		if (!empty($data)) {
			foreach($data as $row) {
				$row = preg_replace("/.* \((.*)\)$/i", "$1", $row);
				$fields = explode($valuesep, $row);
				$hasCat = false;
				if (!empty($fields)) {
					foreach($fields as $f) {
						$fc = preg_replace("/^(?:Kategorie|Category):/i", "", $f);
						if (preg_match("/^(?:Kategorie|Category):/i", $f) && !in_array($fc, $excludec)) {
							if (empty($listCats[$f])) {
								$listCats[$f] = 0;
							}
							$listCats[$f]++;
							$hasCat = true;
						}
					}
				}
				if ($hasCat) {$cntAll++;}
			}
		}

		$tree = array();
		if (!empty($listCats)) {
			foreach($listCats as $cat => $cnt) {
				$plist = array();
				$plist[] = $cat;
				$t = Title::newFromText($cat);
				$p = $t->getParentCategoryTree();
				while(!empty($p)) {
					reset($p);
					$pn = key($p);
					$p = $p[$pn];
					$plist[] = $pn;
				};
				$plist = array_reverse($plist);
				self::buildTree($tree, $plist, $cnt);
			}
		}
		//print_r($tree);
		arsort($listCats);

		$args = array_merge($_GET, $_POST);
		//$args = $args[$queryForm];
		//$args[$queryForm] = $args;
		$url = $_SERVER['REQUEST_URI'];
		$url = preg_replace("/^https?:\/\//i", "", $url);
		$url = preg_replace("/^[^\/]+/i", "", $url);
		$url = preg_replace("/\?.*$/i", "", $url);
		//$urlh = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https': 'http';
		$url = "//{{SERVERNAME}}$url";
		//$url = "Special:RunQuery/$queryForm";

		$catsel = (!empty($args[$queryForm][$catarg])) ? $args[$queryForm][$catarg]: '';
		unset($args[$queryForm][$catarg]);
		
		$r = "<div class=\"cats_links_filters\">\n";
                $class = ($catsel=='') ? 'selected': '';
                $urlc = "$url?".http_build_query($args, null, '&');
		$r .= "<ul><li class=\"$class\">\n";
                $r .= "<a href=\"$urlc\">All ($cntAll)</a>\n";
		$r .= "</li></ul>\n";

		$countSel = $cntAll;
		$countCats = 0;
		$r .= self::printTree($tree, $catsel, $countSel, $args, $queryForm, $catarg, $countCats, 2);


		if (!empty($listCats) && 1==2) {
			foreach($listCats as $cat => $cnt) {
				$catc = preg_replace("/^.*:/i", "", $cat);
				$argc = $args;
				$argc[$queryForm][$catarg] = $catc;
				$class = ($catc==$catsel) ? 'selected': '';
				$countSel = ($catc==$catsel) ? $cnt: $countSel;

				$urlc = "$url?".http_build_query($argc, null, '&');
				$r .= "<a href=\"$urlc\" class=\"$class\">$catc ($cnt)</a>\n";
				$countCats++;
			}
		}
		$r .= "</div>\n";

                if (!empty($titlecatshow)) {
                        $r = '<div class="count_cats_results_box">'.str_replace('[x]', $countCats, $titlecatshow).'</div>'.$r;
			$r = '<div class="cats_box">'.$r.'</div>';
                }
		if (!empty($titleshow)) {
                        $titleshow = str_replace('[x]', $countSel, $titleshow);
                        $t = Title::newFromText("Category:$catsel");
                        $catselL = (!empty($catsel)) ? $t->getFullURL(): "";
			$catlinkr = (!empty($catselL)) ? " - <a href=\"$catselL\">see all results in $catsel</a>": "";
	                $titleshow = str_replace('[catlink]', $catlinkr, $titleshow);
			$titleshow = '<div class="count_results_box">'.$titleshow.'</div>';
			$r = $r.$titleshow;
		}

		return array($r, 'noparse'=>false, 'isHTML'=>true);
	}

	private function buildTree(&$tree, $list, $cnt) {
		if (!empty($list)) {
			$pk = array_shift($list);
                        $t = Title::newFromText($pk);
                        $pk = $t->getPrefixedText();
			if (empty($tree[$pk])) {
				$cntL = (!empty($list)) ? 0: $cnt;
				$tree[$pk] = array('cnt'=>$cntL, 'childs'=>array());
			}elseif (empty($list)) {
				$tree[$pk]['cnt'] += $cnt;
			}
			self::buildTree($tree[$pk]['childs'], $list, $cnt);
		}
	}
	private function printTree($tree, $catsel, &$countSel, &$args, $queryForm, $catarg, &$countCats, $startLevel=1, $level=0) {
		$level++;
		$r = '';
		if (!empty($tree)) {
			if ($level < $startLevel) {
				foreach($tree as $cat => $cfg) {
					$r .= self::printTree($cfg['childs'], $catsel, $countSel, $args, $queryForm, $catarg, $countCats, $startLevel, $level);	
				}
			}else{
				$r .= "<ul>\n";
				foreach($tree as $cat => $cfg) {
					$t = Title::newFromText($cat);
					$catc = $t->getText();
					//$catc = preg_replace("/^.*:/i", "", $cat);
					
        	                        $argc = $args;
	                	        $argc[$queryForm][$catarg] = $catc;
        	                	$class = ($catc==$catsel) ? 'selected': '';
                	                $countSel = ($catc==$catsel) ? $cfg['cnt']: $countSel;
					
					$r .= "<li class=\"$class\">\n";
					if (!empty($cfg['cnt'])) {
	                	                $urlc = "$url?".http_build_query($argc, null, '&');
        	                	        $r .= "<a href=\"$urlc\">$catc (".$cfg['cnt'].")</a>\n";
                	                	$countCats++;
					}else{
						$r .= "<span class=\"\">$catc</span>\n";
					}
					$r .= self::printTree($cfg['childs'], $catsel, $countSel, $args, $queryForm, $catarg, $countCats, $startLevel, $level);
					$r .= "</li>\n";
				}
				$r .= "</ul>\n";
			}
		}
		return $r;
	}
}
