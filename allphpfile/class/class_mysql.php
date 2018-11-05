<?
/*======================================================================================================
======================================================================================================*/
class MySQL
{
	var $HOST	= "localhost";	##	Host
	var $USER	= "root";		##	DB User
	var $PASS	= "";			##	Password
	var $DB		= "";			##	DB Name
	var $CONN	= "";			##	DB Server 연결 식별자
	var $rowsu	= "";
	var $SQL	= "";
	
/*============================================================================
	함수 이름 :	error($msg)
	함수 인자 :	$msg	-> 표시해줄 에러 메시지

	함수 용도 :	메시지를 출력한다.
	Return 값 : -
==============================================================================*/
	function error($msg)
	{
		$err_no = mysql_errno();
		$err_msg = mysql_error();
		echo "[ $msg ] ( $err_no : $err_msg )<BR>\n";
		exit;
	}

/*============================================================================
	함수 이름 :	connect($host="", $user="", $pass="")
	함수 인자 :	$host	-> DB Server
				$user	-> DB User
				$pass	-> DB Password

	함수 용도 :	DB Server에 연결을 시도한다.
	Return 값 : $this->CONN;
===============================================================================*/
	function connect($host="", $user="", $pass="")
	{
		if(!$host)
			$host = $this->HOST;

		if(!$user)
			$user = $this->USER;

		if(!$pass)
			$pass = $this->PASS;

		$this->CONN = @mysql_connect($host, $user, $pass) or $this->error("DB 서버 연결 실패!");

		return $this->CONN;
	}

/*=============================================================================
	함수 이름 :	select($db="", $conn="")
	함수 인자 :	$db		-> DB Name
				$conn	-> DB Server 연결 식별자

	함수 용도 :	사용할 DB를 선택한다.
	Return 값 : true
==============================================================================*/
	function select($db="", $conn="")
	{
		if(!$db) $db = $this->DB;
		else $this->DB = $db;


		if(!$conn)
			$conn = $this->CONN;

		@mysql_select_db($db, $conn) or $this->error("DB 선택 실패!");

		return true;
	}

/*==============================================================================
	함수 이름 :	search($keywords="")
	함수 인자 :	$keywords	-> 검색하고자 입력한 문자열
				$field		-> 필드
				$where		-> "$where" 조건이 필요할때
				$distat		-> 검색 쿼리 출력
	함수 용도 :	변수의 예문처럼 똑같이 해야한다.
	
	수정일 : 2003-04-11
================================================================================*/
	function search($field,$keywords="",$where="", $distat=0)
	{

		// 필드나 검색어가 없을때 바로 빠져 나간다.
		if((empty($keywords) || !$field) || (empty($field) || !$field)){ return false; }
		// 필드를 검색에 맞게 수정
	
			if(!ereg("-",$field)) $column[0] = $field;			## 필드가 1개일때
			else $column = explode("-",$field);				## 키워드가 복수일때

			$column_num = count($column);

			// 키워드를 검색에 맞는 변수로 알맞게 고친다.
			$keywords = urldecode($keywords);
			$keywords = trim($keywords);
			$keywords = ereg_replace("([ ]+)"," ",$keywords);

			if(!ereg(" ",$keywords)) $keywords = "$keywords";			## 키워드가 1개일때
			else $keywords = explode(" ",$keywords);					## 키워드가 복수일때

			$count = count($keywords);									## 키워드 카운터


			for($cn=0; $cn<$column_num; $cn++){
				if($count==1)
				{
					$sql .= " $column[$cn] LIKE '%$keywords%'";

				}else {
					for($i=0; $i<$count; $i++)
					{
						if($keywords[$i])
						{
							$ir .= " $column[$cn] LIKE '%$keywords[$i]%' OR";
						}
					$val = $ir;
					}
					$sql = substr("$val",0,-2);		## 마지막 'OR'문자를 제거한후 리턴한다.
				}
				if ($column_num>1){
					$sql .= "OR";
				}
			}

			if ($column_num>1){
				$sql = substr("$sql",0,-2);		## 마지막 'OR'문자를 제거한후 리턴한다.
			}		
			/////////////////////////[ WHERE 조건문이 있을때 ]
			if($where) $result .= "$where AND ($sql)";
			
			else $result .= "$sql";
			
			/////////////////////////[ $disat=1일때 result 변수 출력 ]
			if ($distat==1) echo $result;

			return $result;
		}


/*==============================================================================
	함수 이름 :	query($query, $db_name="", $conn="")
	함수 인자 :	$query		-> 실행시킬 SQL 문장
				$db_name	-> 실행시킬 DB 이름
				$conn		-> SQL Query 실행 식별자
				$distat		-> 쿼리 결과 출력
	함수 용도 :	SQL문을 실행 시킨다.
	Return 값 : $result -> SQL문의 실행 결과값
	
	수정일 : 2003-02-16
================================================================================*/
	function query($query, $disat=0, $db_name="", $conn="")
	{
		if(!$conn)
			$conn = $this->CONN;

		if($db_name)
			$result = @mysql_db_query($db_name, $query) or $this->error("$query<br><br>SQL문 에러");
		else
			$result = @mysql_query($query) or $this->error("$query<br><br>SQL문 에러");
			
			////퀄리결과값이 없거나 값이 0이면 메모리를 지운다.
			if((!$result) or (empty($result))){
				@mysql_free_result($result);
				return false;
			}

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($disat==1) echo $query;

		return $result;

	}

/*==============================================================================
	함수 이름 :	queryfs($query, $disat=0, $db_name="", $conn="")
	함수 인자 :	$query		-> 실행시킬 SQL 문장
				$distat		-> 쿼리 결과 출력
				$db_name	-> 실행시킬 DB 이름
				$conn		-> SQL Query 실행 식별자
	함수 용도 :	결과값이 한개의 레코드만 가질 SQL문을 실행시키고 fetch를시킨다.
	Return 값 : $result -> SQL문의 실행 결과값
================================================================================*/
/*
	function queryfs($query, $disat=0, $db_name="", $conn="")
	{
		if(!$conn) $conn = $this->CONN;

		if($db_name) $result = @mysql_db_query($db_name, $query) or $this->error("$query<br><br>SQL문 에러");
		else $result = @mysql_query($query) or $this->error("$query<br><br>SQL문 에러");
			
		////퀄리결과값이 없거나 값이 0이면 메모리를 지운다.
		if((!$result) or (empty($result))){
			@mysql_free_result($result);
			return false;
		}

		

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $result;

		return $result;

	}
*/
/*==============================================================================
	함수 이름 : makeSQL($table, $filed, $where="",$disat=0)
	함수 인자 :	$table		-> 테이블 명
				$filed		-> 테이블 필드명
				$where		-> 조건
				$distat		-> 쿼리 결과 출력
	함수 용도 :	SQL문을 생성 시킨다.
	Return 값 : $result -> SQL 생성 결과값
	
================================================================================*/
	function makeSQL($table, $filed, $where="",$disat=0)
	{
		$result = "SELECT {$filed} FROM {$table} ";
		if($where) $result .= " WHERE $where ";

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $result;

		return $result;

	}

/*=====================================================================================
	함수 이름 :	fetch_row($result)
	
	## 결과 레코드 세트에서 한 행(레코드)의 데이터를 가져온다.
=======================================================================================*/
	function fetch_row($result)
	{
		$list = @mysql_fetch_row($result);
		if((!$list) or (empty($list)))
		{
			mysql_free_result($result);
			$this->error("데이터를 불러들이지 못했습니다. result 값을 확인해 보시기 바랍니다.");
		}
				
		return $list;
	}

/*=====================================================================================
	함수 이름 :	fetch_rows($result)
	함수 인자 :	$result -> SQL문 실행 결과
	함수 용도 :	넘어온 SQL실행 결과에서 한 레코드 단위로 값을 배열로 저장한 뒤 다음 레코드로 위치를 옮긴다.
	Return 값 : $arr -> 현재 게시물 값들을 배열화한 배열
=======================================================================================*/
	function fetch_array($result)
	{
		$list = @mysql_fetch_array($result);
		if((!$list) or (empty($list)))
		{
			mysql_free_result($result);
			$this->error("데이터를 불러들이지 못했습니다. result 값을 확인해 보시기 바랍니다.");
		}
				
		return $list;
	}

/*==================================================================
	함수 이름 :	rows($result="")
	함수 인자 :	$result -> SQL Query 실행 식별자
	함수 용도 :	가장 최근에 불러들인 레코드의 총 갯수를 구한다.
	Return 값 : $total -> 불러들인 레크드의 총 갯수
=====================================================================*/
	function rows($result="")
	{
		$total = $result ? @mysql_num_rows($result) : @mysql_affected_rows();
		
		return ($total > 0 ? $total : 0);
	}

/*==============================================================================
	함수 이름 :	result($result, $num, $field)
	함수 인자 :	$result -> SQL문 실행 결과
				$result -> 값을 불러들일 레크드 번호
				$field	-> 값을 불러들일 필드이름
	함수 용도 :	넘어온 SQL실행 결과에서 레코드 번호에 맞는 필드의 값을 불러온다.
	Return 값 : $value -> 불러들인 필드의 값
================================================================================*/
	function result($result, $row, $field)
	{
		$value = @mysql_result($result, $row, $field);

		return $value;
	}

/*============================================================================
	함수 이름 :	get_count($table, $where)
	함수 인자 :	$table	-> 테이블 이름
				$where	-> 조건
	함수 용도 :	$table 에서 조건($where)에 맞는 모든 갯수를 구한다.
	Return 값 : $this->result($result, 0, "count(*)")	-> 조건에 맞는 총 레코드 수
=============================================================================*/
	function get_count($table, $where="", $distat=0)
	{
		if($where)
			$where = " WHERE $where ";

		$query = "SELECT count(*) FROM $table $where";

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $query;

		$result = $this->query($query);

		return $this->result($result, 0, "count(*)");

		@mysql_free_result($result);
	}

/*============================================================================
	함수 이름 :	get_result($table, $where, $field)
	함수 인자 :	$table	-> 테이블 이름
					$where	-> 조건
					$filed		-> 필드
	함수 용도 :	$table 에서 조건($where)에 맞는 $field의 값을 구한다.
	Return 값 : $this->result($result, 0, $field)	-> 조건에 맞는 총 레코드 수
=============================================================================*/
	function get_result($table, $where, $field="*", $distat=0)
	{
		if($where && $field)
		{
			$query = "SELECT $field FROM $table WHERE $where";

			/////////////////////////[ $disat=1일때 result 변수 출력 ]
			if ($distat==1) echo $query;

			$result = $this->query($query);

			return $this->result($result, 0, $field);
			@mysql_free_result($result);
		}
		else
		{
			return 0;
		}
	}

/*============================================================================
	함수 이름 :	get_query($table, $where, $field)
	함수 인자 :	$table	-> 테이블 이름
					$where	-> 조건
					$filed		-> 필드
	함수 용도 :	$table 에서 조건($where)에 맞는 $field의 값을 구한다.
	Return 값 : $this->result($result, 0, $field)	-> 조건에 맞는 총 레코드 수
=============================================================================*/
	function get_query($table, $where, $field, $distat=0)
	{
		if($where && $field)
		{
			$query = "SELECT $field FROM $table WHERE $where";

			/////////////////////////[ $disat=1일때 result 변수 출력 ]
			if ($distat==1) echo $query;

			$result = $this->query($query);

			return $result;
		}
		else
		{
			return 0;
		}
	}

/*============================================================================
	함수 이름 :	get_record($table, $where, $field)
	함수 인자 :	$table	-> 테이블 이름
				$where	-> 조건
				$field	-> 셀렉트 할 필드들
	함수 용도 :	$table 에서 조건($where)에 맞는 필드들의 값을 구한다.
				query 등 불필요하게 사용하지 않아도 된다.
=============================================================================*/
	function get_record($table, $where="", $field="*", $distat=0)
	{
		if($where)
			$where = " WHERE $where ";

		$query = "SELECT $field FROM $table $where";
		$result = $this->query($query);
		
		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $query;

		$this->rowsu = $this->rows($result);

		if($this->rows())
		{
			return $this->fetch_array($result);
		}
		else
		{
			return 0;
		}
	}
/*==================================================================
	함수 이름 :	sql_insert($table, $arr)
	함수 인자 :	$table	-> 테이블 이름
				$arr	-> 배열의 Key 에는 필드이름, Value 에는 들어갈 값이 있다.
	함수 용도 :	넘어온 $arr의 값을 $table에 Insert 한다.
	Return 값 : true
=====================================================================*/
	function sql_insert($table, $arr, $distat=0)
	{
		if(!$table || !is_array($arr))
			$this->error("테이블 이름과 값을 확인해 주시기 바랍니다.(빈값)");

		$i = 0;
		while(list($key, $value)=each($arr))
		{
			$comma = $i ? "," : "";
			$fields .= $comma."`".$key."`";
			$values .= $comma.$value;

			$i++;
		}

		$query = "INSERT INTO $table ($fields) VALUES ($values)";

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $query;

		$this->query($query);
		
		return true;
	}


/*===================================================================
	함수 이름 :	sql_update($table, $arr, $where)
	함수 인자 :	$table	-> 테이블 이름
				$arr	-> 배열의 Key 에는 필드이름, Value 에는 들어갈 값이 있다.
				$where	-> Update의 조건절
	함수 용도 :	넘어온 $arr의 값을 $table에 $where 조건에 맞게 Update 한다.
	Return 값 : true
====================================================================*/
	function sql_update($table, $arr, $where="", $distat=0)
	{
		
		//$arr = Array( 'login' => 'kok', 'project' => 'autocampko' );  //$project.'ko');
		
		
		if(!$table || !$arr)
			$this->error("테이블 이름과 값을 확인해 주시기 바랍니다.(빈값)");

		if($where)
			$where = " WHERE $where ";

		$i = 0;
		while(list($key, $value)=each($arr))
		{
			$comma = $i ? "," : "";

			$tmp .= $comma."`".$key."`"."=".$value;

			$i++;
		}

		$query = "UPDATE $table SET $tmp $where";

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $query;

		$this->query($query);
		$this->SQL = $query;
		return true;
	}
/*========================================================================
	함수 이름 :	bas_delete($table, $where, $distat=0)
	함수 인자 :	$table	-> 테이블 이름
				$field	-> 필드이름.
	함수 용도 :	넘어온 $arr의 값을 $table에 Insert 한다.
	Return 값 : true
==========================================================================*/
	function bas_delete($table, $where, $distat=0)
	{
		if(!$table || !$where)
			$this->error("테이블 이름 또는 조건 값을 확인해 주시기 바랍니다.(빈값)");

		$where = " WHERE $where ";
		$query = "DELETE FROM $table $where";

		$rt = $this->query($query);
		if($rt) $aa = "ok";
		else $aa = "err";
		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $query;

		return $aa;
	}


/*========================================================================
	함수 이름 :	sql_delete($table, $field, $value, $distat=0)
	함수 인자 :	$table	-> 테이블 이름
				$field	-> 필드이름.
	함수 용도 :	넘어온 $arr의 값을 $table에 Insert 한다.
	Return 값 : true
==========================================================================*/
	function sql_delete($table, $field, $value, $distat=0)
	{
		if(!$table || !$field || !$value)
			$this->error("테이블 이름, 필드 이름, 값을 확인해 주시기 바랍니다.(빈값)");

		$arr_table = explode("-", $table);
		$arr_field = explode("-", $field);
		$arr_value = explode("-", $value);

		$total = count($arr_table);
		for($i=0; $i<$total; $i++)
		{
			$where = " WHERE $arr_field[$i]=$arr_value[$i]";
			$query = "DELETE FROM $arr_table[$i] $where";

			$this->query($query);
		}

		/////////////////////////[ $disat=1일때 result 변수 출력 ]
		if ($distat==1) echo $query;

		return true;
	}

/*========================================================================
	함수 이름 :	sql_num_fields($table, $arr)
	함수 인자 :	$val	-> $this->query 문
	함수 용도 :	필드 총 갯수 알아내기

	## 결과레코드 세트에서 검색된 레코드가 가진 열의 수, ## {즉 필드의 수}를 반환
==========================================================================*/
	function sql_num_fields($val)
	{
		if(!$val) $this->error("query 값을 확인해 주시기 바랍니다.(빈값)");

		$result = mysql_num_fields($val);
	return $result;
	}

/*========================================================================
	함수 이름 :	sql_num_fields($table, $arr)
	
	$val	: $result
	$num	: $i (순서)

	## 결과레코드 세트에서 검색된 레코드가 가진 열의 수, ## {즉 필드의 수}를 반환
==========================================================================*/
	function sql_field_name($val,$num)
	{
		if(!$val) $this->error("query 값을 확인해 주시기 바랍니다.(빈값)");

		$result = mysql_field_name($val,$num);
	return $result;
	}

/*========================================================================
	함수 이름 :	sql_fetch_field($table, $arr)
	
	$val	: $result
	$num	: $i (순서)

	## $list->field == $fieldname
==========================================================================*/
	function sql_fetch_field($val,$num)
	{
		if(!$val) $this->error("query 값을 확인해 주시기 바랍니다.(빈값)");

		$result = mysql_fetch_field($val,$num);
	return $result;
	}

/*========================================================================
	함수 이름 :	is_mysqltable()

	$dbname	: db 명
	$table	: table 명

	## 같은 db 에 같은 이름을 가진 TABLE 이 존재하는지를 체크한다.
	## 같은 테이블이 존재하면 1, 아니면 0
==========================================================================*/
	function is_mysqltable($dbname, $table) 
	{ 
		$result = mysql_list_tables($dbname); 
		$total = mysql_num_rows($result); 
		for($i=0; $i<$total; $i++) 
		{ 
			if($table==mysql_tablename($result, $i)) 
			{ 
				return 1; 
			} 
		} 
		return 0; 
	} 

/*========================================================================
	함수 이름 :	sql_close()
	Return 값 : true
==========================================================================*/
	function sql_close()
	{
		mysql_close($this->CONN);

		return true;
	}

}
?>