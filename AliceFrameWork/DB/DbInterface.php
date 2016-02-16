<?php

/*
 * 数据库实例类接口 
 * @leunico
 */

namespace AliceFrameWork\DB;

Interface DbInterface{
	
	public  function close();
	
	public  function query($sql);
	
	public  function fetchAssoc($resource);
	
	public  function select($sql);	
	
}
