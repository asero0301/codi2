	//�÷��ø޴� ��ũ 
	function FLink(val)
	{
	//	if (mainNum == 0 || mainNum == null) { LinkPath = ""; }
	//	else { LinkPath = "../";}
	//	location.href = LinkPath + val;
		location.href = val;
	}
	function MenuLink11()
	{
		//�����ּ���
		LinkNum = "/product/product_list.php";
		FLink(LinkNum);
	}



    function MenuLink21()
	{
		//�ڵ��򰡼���
		LinkNum = "/product/codi_list.php";
		FLink(LinkNum);
	}



    function MenuLink31()
	{
		//����Ʈ ��
		LinkNum = "/product/best_shop_list.php";
		FLink(LinkNum);
	}



    function MenuLink41()
	{
		//�Խ���
		LinkNum = "/board/ucc_list.php";
		FLink(LinkNum);
	}




    function MenuLink51()
	{
		//�Ϲ�ȸ������
		LinkNum = "/member/real_chk.php?mem_kind=U";
		FLink(LinkNum);
	}


    function MenuLink61()
	{
		//��ȸ������
		LinkNum = "/member/real_chk.php?mem_kind=S";
		FLink(LinkNum);
	}





