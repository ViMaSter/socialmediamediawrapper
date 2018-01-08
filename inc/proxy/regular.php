<?php
	$query = explode("/", $_GET["query"]);

	// Roughly prepare our absolute path
	$absolutePath = sprintf(
		"%s://%s",
		$_SERVER['HTTPS'] ? "https" : "http",
		$_SERVER["SERVER_NAME"] . (dirname($_SERVER["REQUEST_URI"]) == "/" ? "" : dirname($_SERVER["REQUEST_URI"]))
	);

	// Initialize our variables
	$directQuery = false;
	$filename = "";

	if ($query[0] == "direct")
	{
		$directQuery = true;
		$filename = $query[1];
	}

	$blacklist = json_decode( file_get_contents( "blacklist.json" ) );
	$filename = array_pop($query);


	// Gracefully close connection when no file was found
	//  or the filename is listed in the blacklist
	if (!is_file($filename) || in_array($filename, $blacklist))
	{
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		if (file_exists("404.php"))
		{
			require_once("404.php");
			exit();
		}
		else {
			exit("404");
		}
	}

	// Borrowing a modified version of download handling from media-division.com
	/**
	 * Copyright 2012 Armand Niculescu - media-division.com
	 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
	 * 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
	 * 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
	 * THIS SOFTWARE IS PROVIDED BY THE FREEBSD PROJECT "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	 */
	function handleDownload($filepath)
	{
		@ini_set('error_reporting', E_ALL & ~E_NOTICE);
		@ini_set('zlib.output_compression', 'Off');
		 
		if(!isset($filepath) || empty($filepath)) 
		{
			header("HTTP/1.0 400 Bad Request");
			exit;
		}
		 
		$path_parts = pathinfo($filepath);
		$file_name  = $path_parts['basename'];
		$file_ext   = $path_parts['extension'];
		 
		if (is_file($file_name))
		{
			$file_size  = filesize($file_name);
			$file = @fopen($file_name,"rb");
			if ($file)
			{
				header("Pragma: public");
				header("Expires: -1");
				header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
                header('Content-Disposition: inline;');
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$type = finfo_file($finfo, $file_name);
				finfo_close($finfo);
		        header("Content-Type: " . $type);
		 
				if(isset($_SERVER['HTTP_RANGE']))
				{
					list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
					if ($size_unit == 'bytes')
					{
						//multiple ranges could be specified at the same time, but for simplicity only serve the first range
						//http://tools.ietf.org/id/draft-ietf-http-range-retrieval-00.txt
						list($range, $extra_ranges) = explode(',', $range_orig, 2);
					}
					else
					{
						$range = '';
						header('HTTP/1.1 416 Requested Range Not Satisfiable');
						exit;
					}
				}
				else
				{
					$range = '';
				}
		 
				list($seek_start, $seek_end) = explode('-', $range, 2);
				$seek_end   = (empty($seek_end)) ? ($file_size - 1) : min(abs(intval($seek_end)),($file_size - 1));
				$seek_start = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)),0);
		 
				if ($seek_start > 0 || $seek_end < ($file_size - 1))
				{
					header('HTTP/1.1 206 Partial Content');
					header('Content-Range: bytes '.$seek_start.'-'.$seek_end.'/'.$file_size);
					header('Content-Length: '.($seek_end - $seek_start + 1));
				}
				else
				{
					header("Content-Length: $file_size");
				}
		 
				header('Accept-Ranges: bytes');
		 
				set_time_limit(0);
				fseek($file, $seek_start);
		 
				while(!feof($file)) 
				{
					print(@fread($file, 1024*8));
					ob_flush();
					flush();
					if (connection_status()!=0) 
					{
						@fclose($file);
						exit;
					}			
				}
		 
				// file save was a success
				@fclose($file);
				exit;
			}
			else 
			{
				// file couldn't be opened
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		}
		else
		{
			// file does not exist
			header("HTTP/1.0 404 Not Found");
			exit;
		}
	}

	if ($directQuery)
	{
		handleDownload($filename);
	}
	else
	{
		// Gather type info
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$type = finfo_file($finfo, $filename);
		finfo_close($finfo);

		// Use template based on MIME-type we're serving (ignoring subtype)
		$typeArray = explode("/", $type);
		$typeFile = $typeArray[0];

		$responseType = is_file("inc/type/$typeFile.php") ? $typeArray[0] : "other";

		$canonialURL = "$absolutePath/$filename";
		$directURL = "$absolutePath/direct/$filename";
		include "inc/type/" . $responseType . ".php";
	}
?>
