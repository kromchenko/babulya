<?php
namespace DynamicContentForElementor;

/**
 * DCE Tokens Class
 *
 * @since 0.1.0
 */
class DCE_Tokens {

    static public function do_tokens($text) {
        return self::replace_all_tokens($text);
    }

    static public function replace_all_tokens($text) {
        $text = self::replace_user_tokens($text);
        $text = self::replace_post_tokens($text);
        //$text = self::replace_var_tokens($text);
        //$text = $this->replace_term__tokens($text); // TODO?!
        $text = self::replace_option_tokens($text);
        return $text;
    }

    static public function replace_user_tokens($text) {
        $current_user = wp_get_current_user();
        $current_user_id = 0;
        if ($current_user) {
            $current_user_id = $current_user->ID;
        }
        // user field
        $pezzi = explode('[user:', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                if ($key) {
                    $metaTmp = explode(']', $avalue);
                    $metaParams = reset($metaTmp);

                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);
                    $altriPezzi = explode('|', $pezzoTmp, 2);
                    if (count($altriPezzi) == 2) {
                        $user_id = end($altriPezzi);
                    } else {
                        $user_id = $current_user_id;
                    }
                    //echo $user_id;
                    $metaName = reset($altriPezzi);
                    $metaKey = explode(':', $metaName);
                    //echo $metaKey[0];
                    $metaValue = '';
                    if ($user_id) {
                        $userTmp = get_user_by('ID', $user_id);
                        if ($userTmp) {
                            //if (property_exists('WP_User', $metaKey[0])) {
                            // campo nativo
                            if (@$userTmp->data->{$metaKey[0]}) {
                                //$userTmp = get_user_by('ID', $user_id);
                                $metaValue = $userTmp->data->{$metaKey[0]};
                            }
                            if (!$metaValue) {
                                if (@$userTmp->data->{'user_' . $metaKey[0]}) {
                                    //if (property_exists('WP_User', 'user_'.$metaKey[0])) {
                                    //$userTmp = get_user_by('ID', $user_id);
                                    $metaValue = $userTmp->data->{'user_' . $metaKey[0]};
                                }
                            }
                            // altri campi nativi
                            if (!$metaValue) {
                                $userInfo = get_userdata($user_id);
                                if (@$userInfo->{$metaKey[0]}) {
                                    $metaValue = $userInfo->{$metaKey[0]};
                                }
                                if (!$metaValue) {
                                    if (@$userInfo->{'user_' . $metaKey[0]}) {
                                        $metaValue = $userInfo->{'user_' . $metaKey[0]};
                                    }
                                }
                            }
                            // campo meta
                            if (!$metaValue) {
                                if (metadata_exists('user', $user_id, $metaKey[0])) {
                                    $metaValue = get_user_meta($user_id, $metaKey[0], true);
                                }
                                if (!$metaValue) {
                                    // meta from module user_registration
                                    if (metadata_exists('user', $user_id, 'user_registration_' . $metaKey[0])) {
                                        $metaValue = get_user_meta($user_id, 'user_registration_' . $metaKey[0], true);
                                    }
                                }
                            }
                        }
                    }
                    $replaceValue = self::check_array_value($metaValue, $metaKey);
                    if ($replaceValue == '') {
                        $replaceValue = $fallback;
                    }
                    $text = str_replace('[user:' . $metaParams . ']', $replaceValue, $text);
                }
            }
        }
        return $text;
    }

    static public function replace_post_tokens($text) {
        global $post;
        $current_post_id = $post_id = 0;
        $current_post = get_post();
        if ($current_post) {
            $current_post_id = $current_post->ID;
        }
        // post field
        $pezzi = explode('[post:', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                $filters = array();
                if ($key) {
                    $metaTmp = explode(']', $avalue);
                    $metaParams = reset($metaTmp);

                    // GET FALLBACK
                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);

                    // GET FILTERS or ID
                    $altriPezzi = explode('|', $pezzoTmp, 2);
                    if (count($altriPezzi) == 2) {
                        $filtesTmp = explode('|', end($altriPezzi));
                        if (is_numeric(end($altriPezzi)) && intval(end($altriPezzi)) > 0 && count($filtesTmp) == 1) {
                            $post_id = end($altriPezzi);
                        } else {
                            foreach ($filtesTmp as $afilter) {
                                $afilterTmp = explode('(', $afilter,2);
                                if (count($afilterTmp) == 2) {
                                    $parameters = explode(',', substr(end($afilterTmp),0,-1));
                                    $kfilter = reset($afilterTmp);
                                    $filters[$kfilter] = $parameters;
                                } else {
                                    $filters[$afilter] = array(); // no params
                                }
                            }
                        }
                    }

                    // SETTING POST ID
                    if (!$post_id) {
                        $post_id = $current_post_id;
                    }
                    $metaName = reset($altriPezzi);

                    // GET SUB ARRAY
                    $metaKey = explode(':', $metaName);
                    $field = reset($metaKey);
                    $metaValue = '';
                    if ($post_id) {
                        $metaValue = DCE_Helper::get_post_value($post_id, $field);
                    }

                    $replaceValue = self::check_array_value($metaValue, $metaKey);
                    if ($replaceValue == '') {
                        // FALLBACK
                        $replaceValue = $fallback;
                    } else {
                        // APPLY FILTERS
                        if (!empty($filters)) {
                            // https://www.w3schools.com/Php/php_ref_string.asp
                            // https://www.php.net/manual/en/ref.strings.php
                            foreach ($filters as $afilter => $parameters) {

                                // THUMB Custom Size
                                if (in_array($field, array('thumbnail','post_thumbnail','thumb','guid'))) {
                                    if (strpos($afilter, 'x') !== false) {
                                        list($h,$w) = explode('x', $afilter, 2);
                                        if (is_numeric($h) && is_numeric($w)) {
                                            //$h = intval($h);
                                            //$w = intval($w);
                                            $post_thumbnail_id = get_post_thumbnail_id( $post_id );
                                            $replaceValueThumb = wp_get_attachment_image_src( $post_thumbnail_id, array($w,$h));
                                            if ($replaceValueThumb) {
                                                $replaceValue = reset($replaceValueThumb);
                                            } else {
                                                $replaceValue = '';
                                            }
                                            continue;
                                        }
                                    }
                                }

                                if ($afilter && is_callable($afilter)) {
                                    if (empty($parameters)) {
                                        $replaceValue = $afilter($replaceValue);
                                    } else {
                                        if (in_array($afilter, array('substr'))) {
                                            array_unshift($parameters, $replaceValue);
                                        }
                                        $replaceValue = call_user_func_array($afilter, $parameters);
                                    }
                                }
                            }
                        }
                    }
                    $text = str_replace('[post:' . $metaParams . ']', $replaceValue, $text);
                }
            }
        }
        $post = $current_post;
        return $text;
    }

    static public function replace_var_tokens($text, $var_name, $var_value) {
        if (is_object($var_value)) {
            $var_value = get_object_vars($var_value);
        }
        //print_r($text);
        //if (trim($text) == '['.$var_name.']') {
            $text = str_replace('['.$var_name.']', DCE_Helper::to_string($var_value), $text); // simple
        //}
        // var field
        $pezzi = explode('['.$var_name.':', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                $filters = array();
                if ($key) {
                    $metaTmp = explode(']', $avalue);
                    $metaParams = reset($metaTmp);

                    // GET FALLBACK
                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);

                    // GET FILTERS or ID
                    $altriPezzi = explode('|', $pezzoTmp, 2);
                    if (count($altriPezzi) == 2) {
                        $filtesTmp = explode('|', end($altriPezzi));
                        if (is_numeric(end($altriPezzi)) && intval(end($altriPezzi)) > 0 && count($filtesTmp) == 1) {
                            $post_id = end($altriPezzi);
                        } else {
                            foreach ($filtesTmp as $afilter) {
                                $afilterTmp = explode('(', $afilter,2);
                                if (count($afilterTmp) == 2) {
                                    $parameters = explode(',', substr(end($afilterTmp),0,-1));
                                    $kfilter = reset($afilterTmp);
                                    $filters[$kfilter] = $parameters;
                                    //var_dump($filters[$kfilter]);
                                } else {
                                    $filters[$afilter] = array(); // no params
                                }
                            }
                        }
                    }

                    $metaName = reset($altriPezzi);

                    // GET SUB ARRAY
                    $metaKey = explode(':', $metaName);
                    $field = reset($metaKey);

                    $replaceValue = self::check_array_value($var_value, $metaKey);
                    if ($replaceValue == '') {
                        // FALLBACK
                        $replaceValue = $fallback;
                    } else {
                        // APPLY FILTERS
                        if (!empty($filters)) {
                            // https://www.w3schools.com/Php/php_ref_string.asp
                            // https://www.php.net/manual/en/ref.strings.php
                            foreach ($filters as $afilter => $parameters) {
                                if ($afilter && is_callable($afilter)) {
                                    if (empty($parameters)) {
                                        $replaceValue = $afilter($replaceValue);
                                    } else {
                                        if (in_array($afilter, array('substr', 'get_the_post_thumbnail'))) {
                                            array_unshift($parameters, $replaceValue);
                                        }
                                        //var_dump($parameters); die();
                                        $replaceValue = call_user_func_array($afilter, $parameters);
                                    }
                                }
                            }
                        }
                    }
                    $text = str_replace('['.$var_name.':' . $metaParams . ']', $replaceValue, $text);
                }
            }
        }
        return $text;
    }

    static public function replace_term_tokens($text) {
        return $text;
    }

    static public function replace_option_tokens($text) {
        // /wp-admin/options.php
        $pezzi = explode('[option:', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                if ($key) {
                    $pezzo = explode(']', $avalue);
                    $metaParams = reset($pezzo);
                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);
                    $optionParams = explode(':', $pezzoTmp);
                    $optionName = $optionParams[0];
                    $optionValue = get_option($optionName);
                    $replaceValue = self::check_array_value($optionValue, $optionParams);
                    if ($replaceValue == '') {
                        $replaceValue = $fallback;
                    }
                    $text = str_replace('[option:' . $metaParams . ']', $replaceValue, $text);
                }
            }
        }
        return $text;
    }

    static public function check_array_value($optionValue = array(), $optionParams = array()) {
        if (is_array($optionValue)) {
            if (count($optionValue) == 1) {
                $tmpValue = reset($optionValue);
                if (!is_array($tmpValue)) {
                    return $tmpValue;
                }
            }
            if (is_array($optionParams)) {
                $val = $optionValue;
                foreach ($optionParams as $key => $value) {
                    if (isset($val[$value])) {
                        $val = $val[$value];
                    }
                }
                if (is_array($val)) {
                    $val = '<pre>'.var_export($val, true).'</pre>';
                }
                return $val;
            }
            if ($optionParams) {
                return $optionValue[$optionParams];
            }
            return '<pre>'.var_export($optionValue, true).'</pre>';
        }
        return $optionValue;
    }

}
