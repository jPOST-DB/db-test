<?php
// 全角のカタカナ、英数字、記号を半角に変換して出力。
function toHankaku( $value = null ) {
    return mb_convert_kana( $value , "aksV" );
}
