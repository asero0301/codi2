	//플래시메뉴 링크 
	function FLink(val)
	{
	//	if (mainNum == 0 || mainNum == null) { LinkPath = ""; }
	//	else { LinkPath = "../";}
	//	location.href = LinkPath + val;
		location.href = val;
	}
	function MenuLink11()
	{
		//평가해주세요
		LinkNum = "/product/product_list.php";
		FLink(LinkNum);
	}



    function MenuLink21()
	{
		//코디평가순위
		LinkNum = "/product/codi_list.php";
		FLink(LinkNum);
	}



    function MenuLink31()
	{
		//베스트 샵
		LinkNum = "/product/best_shop_list.php";
		FLink(LinkNum);
	}



    function MenuLink41()
	{
		//게시판
		LinkNum = "/board/ucc_list.php";
		FLink(LinkNum);
	}




    function MenuLink51()
	{
		//일반회원가입
		LinkNum = "/member/real_chk.php?mem_kind=U";
		FLink(LinkNum);
	}


    function MenuLink61()
	{
		//샵회원가입
		LinkNum = "/member/real_chk.php?mem_kind=S";
		FLink(LinkNum);
	}





