<?php /*

**************************************************************************

Plugin Name:  bOingball BBCode
Plugin URI:   http://www.x-3dfx.com/2010/03/18/bbcode-wordpress-plug-in
Description:  Implements nearly all standard <a href="http://en.wikipedia.org/wiki/BBCode">BBCode</a> in posts. Requires WordPress 2.5+ or WPMU 1.5+. (mod of BBCode by Viper)
Version:      1.1.2
Author:       bOingball
Author URI:   http://www.x-3dfx.com/

**************************************************************************

Copyright (C) 2010 bOingball
Based on the original BBCode plugin - Copyright (C) 2008 Viper007Bond

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

**************************************************************************/

class BBCode {

	// Plugin initialization
	function BBCode() {
		// This version only supports WP 2.5+ (learn to upgrade please!)
		if ( !function_exists('add_shortcode') ) return;

		// Register the shortcodes
		add_shortcode( 'b' , array(&$this, 'shortcode_bold') );
		add_shortcode( 'B' , array(&$this, 'shortcode_bold') );
		add_shortcode( 'i' , array(&$this, 'shortcode_italics') );
		add_shortcode( 'I' , array(&$this, 'shortcode_italics') );
		add_shortcode( 'u' , array(&$this, 'shortcode_underline') );
		add_shortcode( 'U' , array(&$this, 'shortcode_underline') );
		add_shortcode( 'url' , array(&$this, 'shortcode_url') );
		add_shortcode( 'URL' , array(&$this, 'shortcode_url') );
		add_shortcode( 'img' , array(&$this, 'shortcode_image') );
		add_shortcode( 'IMG' , array(&$this, 'shortcode_image') );
		add_shortcode( 'quote' , array(&$this, 'shortcode_quote') );
		add_shortcode( 'QUOTE' , array(&$this, 'shortcode_quote') );
		add_shortcode( 'color' , array(&$this, 'shortcode_color') );
		add_shortcode( 'COLOR' , array(&$this, 'shortcode_color') );
		add_shortcode( 's' , array(&$this, 'shortcode_strikethrough') );
		add_shortcode( 'S' , array(&$this, 'shortcode_strikethrough') );
		add_shortcode( 'center' , array(&$this, 'shortcode_center') );
		add_shortcode( 'CENTER' , array(&$this, 'shortcode_center') );
		add_shortcode( 'code' , array(&$this, 'shortcode_code') );
		add_shortcode( 'CODE' , array(&$this, 'shortcode_code') );
		add_shortcode( 'size' , array(&$this, 'shortcode_size') );
		add_shortcode( 'SIZE' , array(&$this, 'shortcode_size') );
		add_shortcode( 'ul' , array(&$this, 'shortcode_unorderedlist') );		
		add_shortcode( 'UL' , array(&$this, 'shortcode_unorderedlist') );
		add_shortcode( 'ol' , array(&$this, 'shortcode_orderedlist') );
		add_shortcode( 'OL' , array(&$this, 'shortcode_orderedlist') );
		add_shortcode( 'li' , array(&$this, 'shortcode_listitem') );
		add_shortcode( 'LI' , array(&$this, 'shortcode_listitem') );
		add_shortcode( 'youtube' , array(&$this, 'shortcode_youtube') );		
		add_shortcode( 'YOUTUBE' , array(&$this, 'shortcode_youtube') );
		add_shortcode( 'gvideo' , array(&$this, 'shortcode_gvideo') );
		add_shortcode( 'GVIDEO' , array(&$this, 'shortcode_gvideo') );
		add_shortcode( 'spoiler' , array(&$this, 'shortcode_spoiler') );
		add_shortcode( 'SPOILER' , array(&$this, 'shortcode_spoiler') );
	}


	// No-name attribute fixing
	function attributefix( $atts = array() ) {
		if ( empty($atts[0]) ) return $atts;

		if ( 0 !== preg_match( '#=("|\')(.*?)("|\')#', $atts[0], $match ) )
			$atts[0] = $match[2];
		return $atts;
	}


	// Bold shortcode
	function shortcode_bold( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
        return '<strong>' .  do_shortcode($content)  . '</strong>';
	}


	// Italics shortcode
	function shortcode_italics( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<em>' . do_shortcode( $content ) . '</em>';
	}


	// Underline shortcode
	function shortcode_underline( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<span style="text-decoration:underline">' . do_shortcode( $content ) . '</span>';
	}


	// URL shortcode - bOingball modded
	function shortcode_url( $atts = array(), $content = NULL ) {
		$atts = $this->attributefix( $atts );
		// [url="http://www.google.com/"]Google[/url]
		if ( isset($atts[0]) ) {
			$url = $atts[0];
		//convert URL by making the array a string so I can work on the content of it.
		$url = implode("",$atts);
		}
		//then take the array and start it at the URL start.
		//If it starts with an = start 1 more along [URL=http://..]
		if ( substr($url,0,1) == '=') {
		$suburl = substr ( $url, 1);
		$text =  $content;
		}
		//If it starts with an " start at 0 [URL="http://..]
		elseif ( substr($url,0,1) !== '"') {
		$suburl = substr ( $url, 0);
		$text =  $content;
		}
		// [url]http://www.google.com/[/url]
		else {
			$url = $text = $content;
		}

		if ( empty($url) ) return '';
		if ( empty($text) ) $text = $url;

		return '<a href="' . $suburl . '">' . do_shortcode( $text ) . '</a>';
	}


	// Image shortcode
	function shortcode_image( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<img src="' . $content . '" alt="" />';
	}


	// Quote shortcode -boingball modded
	function shortcode_quote( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		if ( "" === $atts ) {
		return '<blockquote>' . do_shortcode( $content ) . '</blockquote>';
		}
		else {
		//convert Quote attrib by making the array a string
	    $attribs = implode("",$atts);
		//then take the string and start it at Quote name start.
		$subattribs = substr ( $attribs, 1);
		If ( "" !== $subattribs ) return '<strong>' . $subattribs . ' wrote: </strong><blockquote>' . do_shortcode( $content ) . '</blockquote>';
		}
	}
	
	// bOingball - color shortcode
	function shortcode_color( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		if ( "" === $atts ) return '';
		//convert color by making the array a string
		$attribs = implode("",$atts);
		//then take the array and start it at the color start.
		$subattribs = substr ( $attribs, 1);
		return '<font color=' . $subattribs . '>' . do_shortcode($content) . '</font>';
	}
	
	// bOingball - strikethrough shortcode
	function shortcode_strikethrough( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<del>' . do_shortcode($content) . '</del>';
	}
	
	// bOingball - center shortcode
	function shortcode_center( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<center>' . do_shortcode($content) . '</center>';
	}
	
	// bOingball - quote code shortcode
	function shortcode_code( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<code>' . do_shortcode($content) . '</code>';
	}
	
	// bOingball - size code shortcode
	function shortcode_size( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		if ( "" === $atts ) return '';
		//convert size by making the array a string
		$attribs = implode("",$atts);
		//then take the string and start it at the size start.
		$subattribs = substr ( $attribs, 1);
		return '<span style="font-size:' . $subattribs . 'px">' . do_shortcode($content) . '</span>';
		}

	// bOingball - unordered list shortcode
	function shortcode_unorderedlist( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<ul>' . do_shortcode($content) . '</ul>';
	}
	
	// bOingball - ordered list shortcode
	function shortcode_orderedlist( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<ol>' . do_shortcode($content) . '</ol>';
	}
	
	// bOingball - list item shortcode
	function shortcode_listitem( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		return '<li>' . do_shortcode($content) . '</li>';
	}		
	
	// bOingball - youtube shortcode
	function shortcode_youtube( $atts = array(), $content = NULL ) {
		if ( "" === $content ) return 'No YouTube Video ID Set';
		$id = $text = $content;
		return '<object width="400" height="325"><param name="movie" value="http://www.youtube.com/v/' .$id . '"></param><embed src="http://www.youtube.com/v/' . $id . '" type="application/x-shockwave-flash" width="400" height="325"></embed></object>';
	}	
	
	// bOingball - google video shortcode
	function shortcode_gvideo( $atts = array(), $content = NULL ) {
		if ( "" === $content ) return 'No Google Video ID Set';
		$id = $text = $content;
		return '<embed style="width:400px; height:325px;" id="VideoPlayback" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docId=' . $id . '&hl=en"></embed>';
	}	
		
	// bOingball - Spoiler
	function shortcode_spoiler( $atts = array(), $content = NULL ) {
		if ( NULL === $content ) return '';
		// if not spoiler pre text, return just spoiler
		if ( "" === $atts ) return '<div style="margin:20px; margin-top:5px"><div class="smallfont" style="margin-bottom:2px"><b>Spoiler: </b><input type="button" value="Show" style="width:45px;font-size:10px;margin:0px;padding:0px;" onClick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerText = \'\'; this.value = \'Hide\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerText = \'\'; this.value = \'Show\'; }"></div><div class="alt2" style="margin: 0px; padding: 6px; border: 1px inset;"><div style="display: none;">'. do_shortcode($content) .'</div></div></div>';
		//convert spoiler of by making the array a string
		$attribs = implode(" ",$atts);
		//then take the string and start it at the spoiler of start.
		$subattribs = substr ( $attribs, 1);
		return '<div style="margin:20px; margin-top:5px"><div class="smallfont" style="margin-bottom:2px"><b>Spoiler</b> for <i>'. $subattribs .'</i> <input type="button" value="Show" style="width:45px;font-size:10px;margin:0px;padding:0px;" onClick="if (this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display != \'\') { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'\'; this.innerText = \'\'; this.value = \'Hide\'; } else { this.parentNode.parentNode.getElementsByTagName(\'div\')[1].getElementsByTagName(\'div\')[0].style.display = \'none\'; this.innerText = \'\'; this.value = \'Show\'; }"></div><div class="alt2" style="margin: 0px; padding: 6px; border: 1px inset;"><div style="display: none;">'. do_shortcode($content) .'</div></div></div>';
	}		
		
}

// Start this plugin once all other plugins are fully loaded
add_action( 'plugins_loaded', create_function( '', 'global $BBCode; $BBCode = new BBCode();' ) );

?>