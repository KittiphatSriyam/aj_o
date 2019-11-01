<?php
/*      Y ปีไทยเต็ม          2560
        y ปีไทยย่อ           60
        O ปีเดิมเต็ม          2017
        o ปีเดิมย่อ           17
        M เดือนไทยเต็ม       พฤษภาคม
        m เดือนไทยย่อ        พ.ค.
        u เดือนเดิม           05
        d วันที่เต็ม            06
        j วันที่ย่อ             6
        H ชั่วโมงแบบ 24 ชม.
        h ชั่วโมงเเบบ 12 ชม.
        i นาที
        s วินาที
*/
function FormatThaiDate( $date_str, $format )
{
	if( !$date_str || !$format )
		return "";
	
	$format_len		= strlen( $format );
	
	$components		= explode( " ", $date_str );
	$date			= $components[ 0 ];
	$time			= isset( $components[ 1 ] ) ? $components[ 1 ] : null;
	$component_date	= explode( "-", $date );
	$component_time	= $time ? explode( ":", $time ) : null;
	$ms				= array( "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค." );
	$ml				= array( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
	$formatted		= "";
	
	// Return data as-is if a component is missing
	if( count($component_date) !== 3 )
		return $date_str;
	
	for( $i = 0; $i < $format_len; $i++ )
	{
		$format_ch = $format[ $i ];
		$str = "";
		
		switch( $format_ch )
		{
			case "Y":
			{
				
				$str = sprintf( "%04d", $component_date[ 0 ] + 543 );
				$formatted .= $str;
				break;
			}
			case "O":
			{
				
				$str = sprintf( "%04d", $component_date[ 0 ]);
				$formatted .= $str;
				break;
			}
			case "y":
			{
				$str = sprintf( "%04d", $component_date[ 0 ] + 543 );
				$formatted .= substr( $str, 2, 2 );
				break;
			}
			case "o":
			{
				$str = $component_date[ 0 ];
				$formatted .= substr( $str, 2, 2 );
				break;
			}
			case "M":
			{
				$formatted .= $ml[ $component_date[ 1 ] - 1 ];
				break;
			}
			case "m":
			{
				$formatted .= $ms[ $component_date[ 1 ] - 1 ];
				break;
			}
			case "u":
			{
				$formatted .= $component_date[ 1 ];
				break;
			}
			case "d":
			{
				$formatted .= $component_date[ 2 ];
				break;
			}
			case "j":
			{
				$formatted .= (int)$component_date[ 2 ];
				break;
			}
			case "H":
			{
				if( $component_time )
				{
					$str = sprintf( "%02d", $component_time[ 0 ] );
					$formatted .= $str;
				}
				break;
			}
			case "h":
			{
				if( $component_time )
				{
					$str = sprintf( "%02d", $component_time[ 0 ] );
					$formatted .= $str % 12;
				}
				break;
			}
			case "i":
			{
				if( $component_time )
				{
					$str = sprintf( "%02d", $component_time[ 1 ] );
					$formatted .= $str;
				}
				break;
			}
			case "s":
			{
				if( $component_time )
				{
					$str = sprintf( "%02d", $component_time[ 2 ] );
					$formatted .= $str;
				}
				break;
			}
			default:
			{
				$formatted .= $format_ch;
			}
		}
	}
	
	return $formatted;
}