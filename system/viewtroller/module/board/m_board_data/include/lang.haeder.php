<?php
	$bd_lang_no = "번호";
	$bd_lang_category = "분류";
	$bd_lang_title = "제목";
	$bd_lang_writer = "작성자";
	$bd_lang_date = "작성일";
	$bd_lang_cnt = "조회";
	$bd_lang_attachments = "첨부";
	$bd_lang_total = "총 게시물";
	$bd_lang_page = "페이지";
	$bd_lang_link = "링크";
	$bd_lang_none ="게시물이 없습니다.";
	$bd_lang_admin = "관리자";
	switch(site_config_path){
		case "/eng":
			$bd_lang_no = "No.";
			$bd_lang_category = "Category";
			$bd_lang_title = "Title";
			$bd_lang_writer = "Writer";
			$bd_lang_date = "Date";
			$bd_lang_cnt = "Search";
			$bd_lang_attachments = "Attachments";
			$bd_lang_total = "Total";
			$bd_lang_page = "page";
			$bd_lang_link = "link";
			$bd_lang_none ="There is no posts.";
			$bd_lang_admin = "Admin";
			break;

		case "/chn":
			$bd_lang_no = "编号";
			//$bd_lang_category = "Category";
			$bd_lang_title = "题目";
			$bd_lang_writer = "作成者";
			$bd_lang_date = "作成日";
			$bd_lang_cnt = "查询";
			$bd_lang_attachments = "Attachments";
			$bd_lang_total = "Total";
			$bd_lang_page = "page";
			$bd_lang_link = "link";
			$bd_lang_admin = "Admin";
			$bd_lang_none ="没有帖子";
			break;
		
		case "/jpn":
			$bd_lang_no = "编号";
			//$bd_lang_category = "Category";
			$bd_lang_title = "题目";
			$bd_lang_writer = "作成者";
			$bd_lang_date = "作成日";
			$bd_lang_cnt = "查询";
			$bd_lang_attachments = "Attachments";
			$bd_lang_total = "Total";
			$bd_lang_page = "page";
			$bd_lang_link = "link";
			$bd_lang_admin = "Admin";
			$bd_lang_none ="没有帖子";
			break;

		default:
			
			break;
    }
?>