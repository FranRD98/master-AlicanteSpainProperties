<?php
// This class is originally developed by "Bendikt Martin Myklebust" this is updated by "Rakesh Chandel".
//To Secure Global varaible values consisting in array while posting from GET,Session, and POST.


class SecureSqlInjection
{
	function specificData($val,$inmoconn=null)
	{
	    $val = htmlspecialchars(stripslashes(trim($val)));
        $val = str_ireplace("script", "blocked", $val);
        $val = mysqli_escape_string($inmoconn, $val);
        return $val;
	}

	 function secureSuperGlobalGET($value, $key, $inmoconn=null)
    {

		if(!is_array($_GET[$key]))
		{
			$_GET[$key] = htmlspecialchars(stripslashes($_GET[$key]));
			$_GET[$key] = str_ireplace("script", "blocked", $_GET[$key]);
			$_GET[$key] = mysqli_real_escape_string($inmoconn,$_GET[$key]);
		}
		else
		{

		 $c=0;
		 foreach($_GET[$key] as $val)
		 {
		 	 $_GET[$key][$c] = mysqli_real_escape_string($inmoconn,$_GET[$key][$c]);
		 $c++;
		 }
		}
        return $_GET[$key];
    }

    function secureSuperGlobalPOST($value, $key, $inmoconn=null)
    {

		if(!is_array($_POST[$key]))
		{

		$_POST[$key] = htmlspecialchars(stripslashes($_POST[$key]));
		$_POST[$key] = str_ireplace("script", "blocked", $_POST[$key]);
        $_POST[$key] = mysqli_real_escape_string($inmoconn, $_POST[$key]);
        }
		else
		{

		 $c=0;
		 foreach($_POST[$key] as $val)
		 {
		 	 $_POST[$key][$c] = mysqli_real_escape_string($inmoconn, $_POST[$key][$c]);
		 $c++;
		 }
		}
		return $_POST[$key];
    }

    function secureGlobals()
    {

	    array_walk($_GET, array($this, 'secureSuperGlobalGET'));
        array_walk($_POST, array($this, 'secureSuperGlobalPOST'));
    }
}

?>