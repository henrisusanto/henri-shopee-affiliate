<?php
/**
 * @package Henri-Shopee-Affiliate
 */
/*
Plugin Name: Henri Shopee Affiliate
Plugin URI: https://github.com/
Description: Henri Shopee Affiliate
Version: 0.1
Author: Henri
Author URI: https://github.com/henrisusanto/
License: GPLv2 or later
Text Domain: henri-shopee-affiliate
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('HENRI_SHOPEE_AFFILIATE_APP_ID', '');
define('HENRI_SHOPEE_AFFILIATE_APP_SECRET', '');

add_shortcode( 'henri_shopee_affiliate_shortcode', function () {
	return henri_shopee_affiliate_curl();
} );

function henri_shopee_affiliate_curl () {

	$credential = HENRI_SHOPEE_AFFILIATE_APP_ID;
	$timestamp = time();
	$payload = '{"query":"{\n  brandOffer(name: \"demo\") {\n    nodes {\n      offerName\n    }\n  }\n}\n","variables":null,"operationName":null}';
	$secret = HENRI_SHOPEE_AFFILIATE_APP_SECRET;
	$signature = hash('SHA256', $credential.$timestamp.$payload.$secret);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://open-api.affiliate.shopee.co.id/graphql');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Authority: open-api.affiliate.shopee.co.id';
	$headers[] = 'Accept: */*';
	$headers[] = 'Accept-Language: en-US,en;q=0.9';

	$headers[] = "Authorization: SHA256 Credential=$credential, Timestamp=$timestamp, Signature=$signature";

	$headers[] = 'Cache-Control: no-cache';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Cookie: SPC_F=1iXFvTonzwZNlWV8gMFNVNX92a6K4UBW; _fbp=fb.2.1632199856088.1271338441; G_ENABLED_IDPS=google; SPC_CLIENTID=MWlYRnZUb256d1pOuecliffdfqvrhtas; __utmz=156485241.1633058890.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); SC_DFP=GeBnwfagKMKpPCTMzfPS90yGhzYxJNiY; _gcl_au=1.1.1665066065.1648332548; _fbc=fb.2.1650606055397.IwAR1RBI2GNjwZbEQEQ82kHfMM1o6TrmF1lUVEGvWNEdIWQARVdJh4eUyrE4E; __utma=156485241.594314014.1632199859.1643713394.1650749136.5; SPC_U=10162771; SPC_ST=.c0VpbGhPTHBVZ3hQSXlna8Uk4xi5SZMh04+/Xo2f8Uvhx8uKgjxuzRXZvmNYu8tEoMCyPGD4MrdKQgR0RPSDItiAj6eJkfVsf86WNYm0F30T+5nhlcuoWD4gu1pUbatg9xy/s+buVFjzFb0WZlYfNX087eP5rS0uy3Hj7+pT5QHU0RNby+8pOW9mOzURwfb4VQNeMWw2/RRw1Y9NjfZVKA==; cto_bundle=xBm_pl9xOTVUU0hFakRtaHhpJTJCZ2NaMFVGZHdHU2FUdHpjWlZ5aERhTkhCRkdSJTJCd1JPUDhiNGpzdWFSWmNha0xsWFM3R2JwVDY2dEJZSHdJM0tBbUhaclFpUENhcm05VG83alJBSWZOdEkxMWxkdlcwRDFlbmUlMkJvSE0lMkJJV2lDTjlTdCUyQkQ0aFpqWExiOTBleUV4bVElMkZtbU5NaVElM0QlM0Q; _med=refer; SPC_SI=mall.66setiGmzvLTW7H27jRI6eWvaHp4QDDZ; _gid=GA1.3.2072763131.1652565782; _ga=GA1.1.594314014.1632199859; SPC_T_ID=cr+yjYEz4fp4ZojRt2msWgml+hsiQmZmrML4L3yh2Kvr1BXlbPwhH9kwKbzWLgLxfN7T2DsL62d7AH7gHCc5YzX+anwRiltlcXIr3liJS8w=; SPC_T_IV=2nW0sWoW3Q6ZFyMo7wIoyw==; SPC_R_T_ID=cr+yjYEz4fp4ZojRt2msWgml+hsiQmZmrML4L3yh2Kvr1BXlbPwhH9kwKbzWLgLxfN7T2DsL62d7AH7gHCc5YzX+anwRiltlcXIr3liJS8w=; SPC_R_T_IV=2nW0sWoW3Q6ZFyMo7wIoyw==; SPC_EC=ZTNmbnQ5QUI3WFN6MGhaadD7L3bt/jcsZ0GGSs7rCt9M0lfJ/rBx1LjArinMddPRZe6phYPSBTfzGu/ZsdfXtjAxRD3byaL6YZYHLDEZukAN/svQSnTWx0b+lfCHcxxV50W0u/BeUEyfpVgAIr+JJ5MpQ1e+ojS3g03L+wpmh6k=; _ga_SW6D8G0HXK=GS1.1.1652565781.335.1.1652566002.29';
	$headers[] = 'Origin: https://open-api.affiliate.shopee.co.id';
	$headers[] = 'Pragma: no-cache';
	$headers[] = 'Referer: https://open-api.affiliate.shopee.co.id/explorer';
	$headers[] = 'Sec-Ch-Ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"101\", \"Google Chrome\";v=\"101\"';
	$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
	$headers[] = 'Sec-Ch-Ua-Platform: \"macOS\"';
	$headers[] = 'Sec-Fetch-Dest: empty';
	$headers[] = 'Sec-Fetch-Mode: cors';
	$headers[] = 'Sec-Fetch-Site: same-origin';
	$headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	return $result;
}