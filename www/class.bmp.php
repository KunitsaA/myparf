<?php

class tools_BmpImage {

	static function bmp2gd(&$BMPdata, $truecolor=true) {
		$ThisFileInfo = array();
		if (self::getid3_bmp($BMPdata, $ThisFileInfo, true, true)) {
			$gd = self::PlotPixelsGD($ThisFileInfo['bmp'], $truecolor);
			return $gd;
		}
		return false;
	}

	static function bmpfile2gd($filename, $truecolor=true) {
		if ($fp = @fopen($filename, 'rb')) {
			$BMPdata = fread($fp, filesize($filename));
			fclose($fp);
			return self::bmp2gd($BMPdata, $truecolor);
		}
		return false;
	}

	static function GD2BMPstring(&$gd_image) {
		$imageX = ImageSX($gd_image);
		$imageY = ImageSY($gd_image);

		$BMP = '';
		for ($y = ($imageY - 1); $y >= 0; $y--) {
			$thisline = '';
			for ($x = 0; $x < $imageX; $x++) {
				$argb = phpthumb_functions::GetPixelColor($gd_image, $x, $y);
				$thisline .= chr($argb['blue']).chr($argb['green']).chr($argb['red']);
			}
			while (strlen($thisline) % 4) {
				$thisline .= "\x00";
			}
			$BMP .= $thisline;
		}

		$bmpSize = strlen($BMP) + 14 + 40;
		$BITMAPFILEHEADER  = 'BM'; 
		$BITMAPFILEHEADER .= phpthumb_functions::LittleEndian2String($bmpSize, 4);
		$BITMAPFILEHEADER .= phpthumb_functions::LittleEndian2String(       0, 2);
		$BITMAPFILEHEADER .= phpthumb_functions::LittleEndian2String(       0, 2);
		$BITMAPFILEHEADER .= phpthumb_functions::LittleEndian2String(      54, 4);
		$BITMAPINFOHEADER  = phpthumb_functions::LittleEndian2String(      40, 4); 
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String( $imageX, 4);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String( $imageY, 4);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(       1, 2);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(      24, 2);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(       0, 4);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(       0, 4); 
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(    2835, 4);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(    2835, 4);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(       0, 4);
		$BITMAPINFOHEADER .= phpthumb_functions::LittleEndian2String(       0, 4);

		return $BITMAPFILEHEADER.$BITMAPINFOHEADER.$BMP;
	}

	static function getid3_bmp(&$BMPdata, &$ThisFileInfo, $ExtractPalette=false, $ExtractData=false) {

	    $ThisFileInfo['bmp']['header']['raw'] = array();
	    $thisfile_bmp                         = &$ThisFileInfo['bmp'];
	    $thisfile_bmp_header                  = &$thisfile_bmp['header'];
	    $thisfile_bmp_header_raw              = &$thisfile_bmp_header['raw'];

		$offset = 0;
		$overalloffset = 0;
		$BMPheader = substr($BMPdata, $overalloffset, 14 + 40);
		$overalloffset += (14 + 40);

		$thisfile_bmp_header_raw['identifier']  = substr($BMPheader, $offset, 2);
		$offset += 2;

		if ($thisfile_bmp_header_raw['identifier'] != 'BM') {
			$ThisFileInfo['error'][] = 'Expecting "BM" at offset '.intval(@$ThisFileInfo['avdataoffset']).', found "'.$thisfile_bmp_header_raw['identifier'].'"';
			unset($ThisFileInfo['fileformat']);
			unset($ThisFileInfo['bmp']);
			return false;
		}

		$thisfile_bmp_header_raw['filesize']    = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
		$offset += 4;
		$thisfile_bmp_header_raw['reserved1']   = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
		$offset += 2;
		$thisfile_bmp_header_raw['reserved2']   = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
		$offset += 2;
		$thisfile_bmp_header_raw['data_offset'] = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
		$offset += 4;
		$thisfile_bmp_header_raw['header_size'] = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
		$offset += 4;

		$planes22 = self::LittleEndian2Int(substr($BMPheader, 22, 2));
		$planes26 = self::LittleEndian2Int(substr($BMPheader, 26, 2));
		if (($planes22 == 1) && ($planes26 != 1)) {
			$thisfile_bmp['type_os']      = 'OS/2';
			$thisfile_bmp['type_version'] = 1;
		} elseif (($planes26 == 1) && ($planes22 != 1)) {
			$thisfile_bmp['type_os']      = 'Windows';
			$thisfile_bmp['type_version'] = 1;
		} elseif ($thisfile_bmp_header_raw['header_size'] == 12) {
			$thisfile_bmp['type_os']      = 'OS/2';
			$thisfile_bmp['type_version'] = 1;
		} elseif ($thisfile_bmp_header_raw['header_size'] == 40) {
			$thisfile_bmp['type_os']      = 'Windows';
			$thisfile_bmp['type_version'] = 1;
		} elseif ($thisfile_bmp_header_raw['header_size'] == 84) {
			$thisfile_bmp['type_os']      = 'Windows';
			$thisfile_bmp['type_version'] = 4;
		} elseif ($thisfile_bmp_header_raw['header_size'] == 100) {
			$thisfile_bmp['type_os']      = 'Windows';
			$thisfile_bmp['type_version'] = 5;
		} else {
			$ThisFileInfo['error'][] = 'Unknown BMP subtype (or not a BMP file)';
			unset($ThisFileInfo['fileformat']);
			unset($ThisFileInfo['bmp']);
			return false;
		}

		$ThisFileInfo['fileformat']                  = 'bmp';
		$ThisFileInfo['video']['dataformat']         = 'bmp';
		$ThisFileInfo['video']['lossless']           = true;
		$ThisFileInfo['video']['pixel_aspect_ratio'] = (float) 1;

		if ($thisfile_bmp['type_os'] == 'OS/2') {

			$thisfile_bmp_header_raw['width']          = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
			$offset += 2;
			$thisfile_bmp_header_raw['height']         = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
			$offset += 2;
			$thisfile_bmp_header_raw['planes']         = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
			$offset += 2;
			$thisfile_bmp_header_raw['bits_per_pixel'] = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
			$offset += 2;

			$ThisFileInfo['video']['resolution_x']    = $thisfile_bmp_header_raw['width'];
			$ThisFileInfo['video']['resolution_y']    = $thisfile_bmp_header_raw['height'];
			$ThisFileInfo['video']['codec']           = 'BI_RGB '.$thisfile_bmp_header_raw['bits_per_pixel'].'-bit';
			$ThisFileInfo['video']['bits_per_sample'] = $thisfile_bmp_header_raw['bits_per_pixel'];

			if ($thisfile_bmp['type_version'] >= 2) {

				$thisfile_bmp_header_raw['compression']      = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['bmp_data_size']    = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['resolution_h']     = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['resolution_v']     = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['colors_used']      = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['colors_important'] = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['resolution_units'] = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
				$offset += 2;
				$thisfile_bmp_header_raw['reserved1']        = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
				$offset += 2;
				$thisfile_bmp_header_raw['recording']        = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
				$offset += 2;
				$thisfile_bmp_header_raw['rendering']        = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
				$offset += 2;
				$thisfile_bmp_header_raw['size1']            = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['size2']            = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['color_encoding']   = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['identifier']       = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;

				$thisfile_bmp_header['compression']          = self::BMPcompressionOS2Lookup($thisfile_bmp_header_raw['compression']);

				$ThisFileInfo['video']['codec'] = $thisfile_bmp_header['compression'].' '.$thisfile_bmp_header_raw['bits_per_pixel'].'-bit';
			}

		} elseif ($thisfile_bmp['type_os'] == 'Windows') {

			$thisfile_bmp_header_raw['width']            = self::LittleEndian2Int(substr($BMPheader, $offset, 4), true);
			$offset += 4;
			$thisfile_bmp_header_raw['height']           = self::LittleEndian2Int(substr($BMPheader, $offset, 4), true);
			$offset += 4;
			$thisfile_bmp_header_raw['planes']           = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
			$offset += 2;
			$thisfile_bmp_header_raw['bits_per_pixel']   = self::LittleEndian2Int(substr($BMPheader, $offset, 2));
			$offset += 2;
			$thisfile_bmp_header_raw['compression']      = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
			$offset += 4;
			$thisfile_bmp_header_raw['bmp_data_size']    = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
			$offset += 4;
			$thisfile_bmp_header_raw['resolution_h']     = self::LittleEndian2Int(substr($BMPheader, $offset, 4), true);
			$offset += 4;
			$thisfile_bmp_header_raw['resolution_v']     = self::LittleEndian2Int(substr($BMPheader, $offset, 4), true);
			$offset += 4;
			$thisfile_bmp_header_raw['colors_used']      = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
			$offset += 4;
			$thisfile_bmp_header_raw['colors_important'] = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
			$offset += 4;

			$thisfile_bmp_header['compression'] = self::BMPcompressionWindowsLookup($thisfile_bmp_header_raw['compression']);
			$ThisFileInfo['video']['resolution_x']    = $thisfile_bmp_header_raw['width'];
			$ThisFileInfo['video']['resolution_y']    = $thisfile_bmp_header_raw['height'];
			$ThisFileInfo['video']['codec']           = $thisfile_bmp_header['compression'].' '.$thisfile_bmp_header_raw['bits_per_pixel'].'-bit';
			$ThisFileInfo['video']['bits_per_sample'] = $thisfile_bmp_header_raw['bits_per_pixel'];

			if (($thisfile_bmp['type_version'] >= 4) || ($thisfile_bmp_header_raw['compression'] == 3)) {
				$BMPheader .= substr($BMPdata, $overalloffset, 44);
				$overalloffset += 44;

				$thisfile_bmp_header_raw['red_mask']     = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['green_mask']   = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['blue_mask']    = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['alpha_mask']   = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['cs_type']      = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['ciexyz_red']   =                         substr($BMPheader, $offset, 4);
				$offset += 4;
				$thisfile_bmp_header_raw['ciexyz_green'] =                         substr($BMPheader, $offset, 4);
				$offset += 4;
				$thisfile_bmp_header_raw['ciexyz_blue']  =                         substr($BMPheader, $offset, 4);
				$offset += 4;
				$thisfile_bmp_header_raw['gamma_red']    = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['gamma_green']  = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['gamma_blue']   = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;

				$thisfile_bmp_header['ciexyz_red']   = self::FixedPoint2_30(strrev($thisfile_bmp_header_raw['ciexyz_red']));
				$thisfile_bmp_header['ciexyz_green'] = self::FixedPoint2_30(strrev($thisfile_bmp_header_raw['ciexyz_green']));
				$thisfile_bmp_header['ciexyz_blue']  = self::FixedPoint2_30(strrev($thisfile_bmp_header_raw['ciexyz_blue']));
			}

			if ($thisfile_bmp['type_version'] >= 5) {
				$BMPheader .= substr($BMPdata, $overalloffset, 16);
				$overalloffset += 16;

				$thisfile_bmp_header_raw['intent']              = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['profile_data_offset'] = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['profile_data_size']   = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
				$thisfile_bmp_header_raw['reserved3']           = self::LittleEndian2Int(substr($BMPheader, $offset, 4));
				$offset += 4;
			}

		} else {

			$ThisFileInfo['error'][] = 'Unknown BMP format in header.';
			return false;

		}

		if ($ExtractPalette || $ExtractData) {
			$PaletteEntries = 0;
			if ($thisfile_bmp_header_raw['bits_per_pixel'] < 16) {
				$PaletteEntries = pow(2, $thisfile_bmp_header_raw['bits_per_pixel']);
			} elseif (isset($thisfile_bmp_header_raw['colors_used']) && ($thisfile_bmp_header_raw['colors_used'] > 0) && ($thisfile_bmp_header_raw['colors_used'] <= 256)) {
				$PaletteEntries = $thisfile_bmp_header_raw['colors_used'];
			}
			if ($PaletteEntries > 0) {
				$BMPpalette = substr($BMPdata, $overalloffset, 4 * $PaletteEntries);
				$overalloffset += 4 * $PaletteEntries;

				$paletteoffset = 0;
				for ($i = 0; $i < $PaletteEntries; $i++) {
					$blue  = self::LittleEndian2Int(substr($BMPpalette, $paletteoffset++, 1));
					$green = self::LittleEndian2Int(substr($BMPpalette, $paletteoffset++, 1));
					$red   = self::LittleEndian2Int(substr($BMPpalette, $paletteoffset++, 1));
					if (($thisfile_bmp['type_os'] == 'OS/2') && ($thisfile_bmp['type_version'] == 1)) {
					} else {
						$paletteoffset++; 
					}
					$thisfile_bmp['palette'][$i] = (($red << 16) | ($green << 8) | ($blue));
				}
			}
		}

		if ($ExtractData) {
			$RowByteLength = ceil(($thisfile_bmp_header_raw['width'] * ($thisfile_bmp_header_raw['bits_per_pixel'] / 8)) / 4) * 4; // round up to nearest DWORD boundry

			$BMPpixelData = substr($BMPdata, $thisfile_bmp_header_raw['data_offset'], $thisfile_bmp_header_raw['height'] * $RowByteLength);
			$overalloffset = $thisfile_bmp_header_raw['data_offset'] + ($thisfile_bmp_header_raw['height'] * $RowByteLength);

			$pixeldataoffset = 0;
			switch (@$thisfile_bmp_header_raw['compression']) {

				case 0:
					switch ($thisfile_bmp_header_raw['bits_per_pixel']) {
						case 1:
							for ($row = ($thisfile_bmp_header_raw['height'] - 1); $row >= 0; $row--) {
								for ($col = 0; $col < $thisfile_bmp_header_raw['width']; $col = $col) {
									$paletteindexbyte = ord($BMPpixelData{$pixeldataoffset++});
									for ($i = 7; $i >= 0; $i--) {
										$paletteindex = ($paletteindexbyte & (0x01 << $i)) >> $i;
										$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$paletteindex];
										$col++;
									}
								}
								while (($pixeldataoffset % 4) != 0) {
									
									$pixeldataoffset++;
								}
							}
							break;

						case 4:
							for ($row = ($thisfile_bmp_header_raw['height'] - 1); $row >= 0; $row--) {
								for ($col = 0; $col < $thisfile_bmp_header_raw['width']; $col = $col) {
									$paletteindexbyte = ord($BMPpixelData{$pixeldataoffset++});
									for ($i = 1; $i >= 0; $i--) {
										$paletteindex = ($paletteindexbyte & (0x0F << (4 * $i))) >> (4 * $i);
										$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$paletteindex];
										$col++;
									}
								}
								while (($pixeldataoffset % 4) != 0) {

									$pixeldataoffset++;
								}
							}
							break;

						case 8:
							for ($row = ($thisfile_bmp_header_raw['height'] - 1); $row >= 0; $row--) {
								for ($col = 0; $col < $thisfile_bmp_header_raw['width']; $col++) {
									$paletteindex = ord($BMPpixelData{$pixeldataoffset++});
									$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$paletteindex];
								}
								while (($pixeldataoffset % 4) != 0) {

									$pixeldataoffset++;
								}
							}
							break;

						case 24:
							for ($row = ($thisfile_bmp_header_raw['height'] - 1); $row >= 0; $row--) {
								for ($col = 0; $col < $thisfile_bmp_header_raw['width']; $col++) {
									$thisfile_bmp['data'][$row][$col] = (ord($BMPpixelData{$pixeldataoffset+2}) << 16) | (ord($BMPpixelData{$pixeldataoffset+1}) << 8) | ord($BMPpixelData{$pixeldataoffset});
									$pixeldataoffset += 3;
								}
								while (($pixeldataoffset % 4) != 0) {

									$pixeldataoffset++;
								}
							}
							break;

						case 32:
							for ($row = ($thisfile_bmp_header_raw['height'] - 1); $row >= 0; $row--) {
								for ($col = 0; $col < $thisfile_bmp_header_raw['width']; $col++) {
									$thisfile_bmp['data'][$row][$col] = (ord($BMPpixelData{$pixeldataoffset+3}) << 24) | (ord($BMPpixelData{$pixeldataoffset+2}) << 16) | (ord($BMPpixelData{$pixeldataoffset+1}) << 8) | ord($BMPpixelData{$pixeldataoffset});
									$pixeldataoffset += 4;
								}
								while (($pixeldataoffset % 4) != 0) {

									$pixeldataoffset++;
								}
							}
							break;

						case 16:

							break;

						default:
							$ThisFileInfo['error'][] = 'Unknown bits-per-pixel value ('.$thisfile_bmp_header_raw['bits_per_pixel'].') - cannot read pixel data';
							break;
					}
					break;


				case 1: 
					switch ($thisfile_bmp_header_raw['bits_per_pixel']) {
						case 8:
							$pixelcounter = 0;
							while ($pixeldataoffset < strlen($BMPpixelData)) {
								$firstbyte  = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
								$secondbyte = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
								if ($firstbyte == 0) {

									switch ($secondbyte) {
										case 0: break;

										case 1:
											$pixeldataoffset = strlen($BMPpixelData);
											break;

										case 2:
											$colincrement = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
											$rowincrement = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
											$col = ($pixelcounter % $thisfile_bmp_header_raw['width']) + $colincrement;
											$row = ($thisfile_bmp_header_raw['height'] - 1 - (($pixelcounter - $col) / $thisfile_bmp_header_raw['width'])) - $rowincrement;
											$pixelcounter = ($row * $thisfile_bmp_header_raw['width']) + $col;
											break;

										default:
											for ($i = 0; $i < $secondbyte; $i++) {
												$paletteindex = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
												$col = $pixelcounter % $thisfile_bmp_header_raw['width'];
												$row = $thisfile_bmp_header_raw['height'] - 1 - (($pixelcounter - $col) / $thisfile_bmp_header_raw['width']);
												$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$paletteindex];
												$pixelcounter++;
											}
											while (($pixeldataoffset % 2) != 0) {
												$pixeldataoffset++;
											}
											break;
									}

								} else {

									for ($i = 0; $i < $firstbyte; $i++) {
										$col = $pixelcounter % $thisfile_bmp_header_raw['width'];
										$row = $thisfile_bmp_header_raw['height'] - 1 - (($pixelcounter - $col) / $thisfile_bmp_header_raw['width']);
										$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$secondbyte];
										$pixelcounter++;
									}

								}
							}
							break;

						default:
							$ThisFileInfo['error'][] = 'Unknown bits-per-pixel value ('.$thisfile_bmp_header_raw['bits_per_pixel'].') - cannot read pixel data';
							break;
					}
					break;



				case 2: 
					switch ($thisfile_bmp_header_raw['bits_per_pixel']) {
						case 4:
							$pixelcounter = 0;
							while ($pixeldataoffset < strlen($BMPpixelData)) {
								$firstbyte  = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
								$secondbyte = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
								if ($firstbyte == 0) {

									switch ($secondbyte) {
										case 0: break;

										case 1:
											$pixeldataoffset = strlen($BMPpixelData);
											break;

										case 2:
											$colincrement = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
											$rowincrement = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
											$col = ($pixelcounter % $thisfile_bmp_header_raw['width']) + $colincrement;
											$row = ($thisfile_bmp_header_raw['height'] - 1 - (($pixelcounter - $col) / $thisfile_bmp_header_raw['width'])) - $rowincrement;
											$pixelcounter = ($row * $thisfile_bmp_header_raw['width']) + $col;
											break;

										default:
											unset($paletteindexes);
											for ($i = 0; $i < ceil($secondbyte / 2); $i++) {
												$paletteindexbyte = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset++, 1));
												$paletteindexes[] = ($paletteindexbyte & 0xF0) >> 4;
												$paletteindexes[] = ($paletteindexbyte & 0x0F);
											}
											while (($pixeldataoffset % 2) != 0) {
												$pixeldataoffset++;
											}

											foreach ($paletteindexes as $dummy => $paletteindex) {
												$col = $pixelcounter % $thisfile_bmp_header_raw['width'];
												$row = $thisfile_bmp_header_raw['height'] - 1 - (($pixelcounter - $col) / $thisfile_bmp_header_raw['width']);
												$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$paletteindex];
												$pixelcounter++;
											}
											break;
									}

								} else {

									$paletteindexes[0] = ($secondbyte & 0xF0) >> 4;
									$paletteindexes[1] = ($secondbyte & 0x0F);
									for ($i = 0; $i < $firstbyte; $i++) {
										$col = $pixelcounter % $thisfile_bmp_header_raw['width'];
										$row = $thisfile_bmp_header_raw['height'] - 1 - (($pixelcounter - $col) / $thisfile_bmp_header_raw['width']);
										$thisfile_bmp['data'][$row][$col] = $thisfile_bmp['palette'][$paletteindexes[($i % 2)]];
										$pixelcounter++;
									}

								}
							}
							break;

						default:
							$ThisFileInfo['error'][] = 'Unknown bits-per-pixel value ('.$thisfile_bmp_header_raw['bits_per_pixel'].') - cannot read pixel data';
							break;
					}
					break;


				case 3: 
					switch ($thisfile_bmp_header_raw['bits_per_pixel']) {
						case 16:
						case 32:
							$redshift   = 0;
							$greenshift = 0;
							$blueshift  = 0;
							if (!$thisfile_bmp_header_raw['red_mask'] || !$thisfile_bmp_header_raw['green_mask'] || !$thisfile_bmp_header_raw['blue_mask']) {
								$ThisFileInfo['error'][] = 'missing $thisfile_bmp_header_raw[(red|green|blue)_mask]';
								return false;
							}
							while ((($thisfile_bmp_header_raw['red_mask'] >> $redshift) & 0x01) == 0) {
								$redshift++;
							}
							while ((($thisfile_bmp_header_raw['green_mask'] >> $greenshift) & 0x01) == 0) {
								$greenshift++;
							}
							while ((($thisfile_bmp_header_raw['blue_mask'] >> $blueshift) & 0x01) == 0) {
								$blueshift++;
							}
							for ($row = ($thisfile_bmp_header_raw['height'] - 1); $row >= 0; $row--) {
								for ($col = 0; $col < $thisfile_bmp_header_raw['width']; $col++) {
									$pixelvalue = self::LittleEndian2Int(substr($BMPpixelData, $pixeldataoffset, $thisfile_bmp_header_raw['bits_per_pixel'] / 8));
									$pixeldataoffset += $thisfile_bmp_header_raw['bits_per_pixel'] / 8;

									$red   = intval(round(((($pixelvalue & $thisfile_bmp_header_raw['red_mask'])   >> $redshift)   / ($thisfile_bmp_header_raw['red_mask']   >> $redshift))   * 255));
									$green = intval(round(((($pixelvalue & $thisfile_bmp_header_raw['green_mask']) >> $greenshift) / ($thisfile_bmp_header_raw['green_mask'] >> $greenshift)) * 255));
									$blue  = intval(round(((($pixelvalue & $thisfile_bmp_header_raw['blue_mask'])  >> $blueshift)  / ($thisfile_bmp_header_raw['blue_mask']  >> $blueshift))  * 255));
									$thisfile_bmp['data'][$row][$col] = (($red << 16) | ($green << 8) | ($blue));
								}
								while (($pixeldataoffset % 4) != 0) {
									$pixeldataoffset++;
								}
							}
							break;

						default:
							$ThisFileInfo['error'][] = 'Unknown bits-per-pixel value ('.$thisfile_bmp_header_raw['bits_per_pixel'].') - cannot read pixel data';
							break;
					}
					break;


				default: 
					$ThisFileInfo['error'][] = 'Unknown/unhandled compression type value ('.$thisfile_bmp_header_raw['compression'].') - cannot decompress pixel data';
					break;
			}
		}

		return true;
	}

	static function IntColor2RGB($color) {
		$red   = ($color & 0x00FF0000) >> 16;
		$green = ($color & 0x0000FF00) >> 8;
		$blue  = ($color & 0x000000FF);
		return array($red, $green, $blue);
	}

	static function PlotPixelsGD(&$BMPdata, $truecolor=true) {
		$imagewidth  = $BMPdata['header']['raw']['width'];
		$imageheight = $BMPdata['header']['raw']['height'];

		if ($truecolor) {

			$gd = @ImageCreateTrueColor($imagewidth, $imageheight);

		} else {

			$gd = @ImageCreate($imagewidth, $imageheight);
			if (!empty($BMPdata['palette'])) {
				foreach ($BMPdata['palette'] as $dummy => $color) {
					list($r, $g, $b) = self::IntColor2RGB($color);
					ImageColorAllocate($gd, $r, $g, $b);
				}
			} else {
				for ($r = 0x00; $r <= 0xFF; $r += 0x33) {
					for ($g = 0x00; $g <= 0xFF; $g += 0x33) {
						for ($b = 0x00; $b <= 0xFF; $b += 0x33) {
							ImageColorAllocate($gd, $r, $g, $b);
						}
					}
				}
			}

		}
		if (!is_resource($gd)) {
			return false;
		}

		foreach ($BMPdata['data'] as $row => $colarray) {
			@set_time_limit(30);
			foreach ($colarray as $col => $color) {
				list($red, $green, $blue) = self::IntColor2RGB($color);
				if ($truecolor) {
					$pixelcolor = ImageColorAllocate($gd, $red, $green, $blue);
				} else {
					$pixelcolor = ImageColorClosest($gd, $red, $green, $blue);
				}
				ImageSetPixel($gd, $col, $row, $pixelcolor);
			}
		}
		return $gd;
	}

	static function PlotBMP(&$BMPinfo) {
		$starttime = time();
		if (!isset($BMPinfo['bmp']['data']) || !is_array($BMPinfo['bmp']['data'])) {
			echo 'ERROR: no pixel data<BR>';
			return false;
		}
		set_time_limit(intval(round($BMPinfo['resolution_x'] * $BMPinfo['resolution_y'] / 10000)));
		$im = self::PlotPixelsGD($BMPinfo['bmp']);
		if (headers_sent()) {
			echo 'plotted '.($BMPinfo['resolution_x'] * $BMPinfo['resolution_y']).' pixels in '.(time() - $starttime).' seconds<BR>';
			ImageDestroy($im);
			exit;
		} else {
			header('Content-Type: image/png');
			ImagePNG($im);
			ImageDestroy($im);
			return true;
		}
		return false;
	}

	static function BMPcompressionWindowsLookup($compressionid) {
		static $BMPcompressionWindowsLookup = array(
			0 => 'BI_RGB',
			1 => 'BI_RLE8',
			2 => 'BI_RLE4',
			3 => 'BI_BITFIELDS',
			4 => 'BI_JPEG',
			5 => 'BI_PNG'
		);
		return (isset($BMPcompressionWindowsLookup[$compressionid]) ? $BMPcompressionWindowsLookup[$compressionid] : 'invalid');
	}

	static function BMPcompressionOS2Lookup($compressionid) {
		static $BMPcompressionOS2Lookup = array(
			0 => 'BI_RGB',
			1 => 'BI_RLE8',
			2 => 'BI_RLE4',
			3 => 'Huffman 1D',
			4 => 'BI_RLE24',
		);
		return (isset($BMPcompressionOS2Lookup[$compressionid]) ? $BMPcompressionOS2Lookup[$compressionid] : 'invalid');
	}

	static function trunc($floatnumber) {
		if ($floatnumber >= 1) {
			$truncatednumber = floor($floatnumber);
		} elseif ($floatnumber <= -1) {
			$truncatednumber = ceil($floatnumber);
		} else {
			$truncatednumber = 0;
		}
		if ($truncatednumber <= 1073741824) { 
			$truncatednumber = (int) $truncatednumber;
		}
		return $truncatednumber;
	}

	static function LittleEndian2Int($byteword) {
		$intvalue = 0;
		$byteword = strrev($byteword);
		$bytewordlen = strlen($byteword);
		for ($i = 0; $i < $bytewordlen; $i++) {
			$intvalue += ord($byteword{$i}) * pow(256, ($bytewordlen - 1 - $i));
		}
		return $intvalue;
	}

	static function BigEndian2Int($byteword) {
		return self::LittleEndian2Int(strrev($byteword));
	}

	static function BigEndian2Bin($byteword) {
		$binvalue = '';
		$bytewordlen = strlen($byteword);
		for ($i = 0; $i < $bytewordlen; $i++) {
			$binvalue .= str_pad(decbin(ord($byteword{$i})), 8, '0', STR_PAD_LEFT);
		}
		return $binvalue;
	}

	static function FixedPoint2_30($rawdata) {
		$binarystring = self::BigEndian2Bin($rawdata);
		return self::Bin2Dec(substr($binarystring, 0, 2)) + (float) (self::Bin2Dec(substr($binarystring, 2, 30)) / 1073741824);
	}

	static function Bin2Dec($binstring, $signed=false) {
		$signmult = 1;
		if ($signed) {
			if ($binstring{0} == '1') {
				$signmult = -1;
			}
			$binstring = substr($binstring, 1);
		}
		$decvalue = 0;
		for ($i = 0; $i < strlen($binstring); $i++) {
			$decvalue += ((int) substr($binstring, strlen($binstring) - $i - 1, 1)) * pow(2, $i);
		}
		return self::CastAsInt($decvalue * $signmult);
	}

	static function CastAsInt($floatnum) {
		$floatnum = (float) $floatnum;

		if (self::trunc($floatnum) == $floatnum) {
			if ($floatnum <= 1073741824) { 
				$floatnum = (int) $floatnum;
			}
		}
		return $floatnum;
	}

}

?>