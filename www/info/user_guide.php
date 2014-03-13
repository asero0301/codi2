<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/info/user_guide.php
 * date   : 2008.12.22
 * desc   : 사이트안내
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

require_once "../include/_head.php";
?>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top"><!-- 주간 코디 top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? require_once "../include/left_info.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
      
        </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">사이트 이용안내 :</font></b> <font color="#FFFFFF">코디탑텐 사이트 이용안내입니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="1" bgcolor="DD2457">
        <tr>
          <td width="145" rowspan="2" align="center" bgcolor="FFDADA" style="padding:7 5 5 5"><b><font color="CC0000">일반회원 이용안내 </font></b></td>
          <td width="125" align="center" bgcolor="#FFFFFF" class="guide" style="padding:7 5 5 5"><a href="#001">회원가입 </a></td>
          <td width="125" align="center" bgcolor="#FFFFFF" class="guide" style="padding:7 5 5 5"><a href="#002">코디평가</a></td>
          <td width="125" align="center" bgcolor="#FFFFFF" class="guide" style="padding:7 5 5 5"><a href="#003">경품응모 </a></td>
          <td width="125" align="center" bgcolor="#FFFFFF" class="guide" style="padding:7 5 5 5"><a href="#004">경품추첨/당첨 </a></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5" class="guide"><a href="#005">당첨등급/당첨확률</a></td>
          <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5" class="guide"><a href="#006">경품수령</a></td>
          <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5" class="guide"><a href="#007">불량샵 신고</a></td>
          <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5" class="guide"><a href="#008">코디UCC</a></td>
        </tr>
      </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="1" bgcolor="C8C8C8" >
        <tr>
          <td bgcolor="#FFFFFF" style="padding:25 25 25 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="001">회원가입</a></font></b></td>
              </tr>
			    <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. [일반회원 가입] 메뉴를 통해 이용약관, 개인정보보호정책 동의 및 일정양식의 가입항목을 기입함으로써 회원에 가입되며 가입 즉시 서비스를 이용하실 수 있습니다.
                  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
              
2. 가입시 전화번호 및 주소, 이메일 등을 정확히 기재하셔야 합니다. 경품 당첨시 가입하 신 정보로 연락이 취해집니다. (회원정보가 잘못될 경우 당첨이 취소될 수 있습니다.)</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="002">코디평가</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 코디평가방법 : <b><font color="FF5B5C">평가해주세요</font></b>에 등록되어 있는 코디상품에 UP, DOWN, 댓글로 평가를 할 수 있습니다.
                  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
                
2. 평가는 한 개의 코디상품 마다 한번만 할 수 있습니다.
<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

3. 평가를 할 수 있는 코디상품의 수에는 제한이 없습니다.(평가 대기중인 모든 코디상품에 각각 1회씩 평가 가능)
</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="003">경품응모</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 응모방법 : <font color="FF5B5C">코디업, 코디다운, 댓글로 평가하면 자동으로 응모</font>됩니다.
                  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
                 
2. 응모대상 : 평가대기중인 모든 코디상품
</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="004">경품추첨 및 당첨</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 경품추첨 : 평가기간이 마감된 후에 해당 해당 코디상품을 등록한 샵에서 설정한 조건에 따라 추첨<br />
   ① 각 5개 분야의 <b><font color="#333333">TOP10에 선정될 경우</font></b>에만 당첨자 선정<br />
   ② 각 5개 분야의 <b><font color="#333333">TOP10 선정과 상관없이</font></b> 평가가 마감되면 무조건 당첨자 선정
   <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td></td>
     </tr>
   </table>

※ TOP10 선정 기준 : 5개 분야(상의, 하의, 아웃웨어, 언더웨어, 액세서리)별로 지난 일주일동안 마감된 코디상품 중에서, 평가기간동안 받은 점수가 상위 10위에 든 코디상품 각 10개씩 선정. <font color="FF5B5C">매주마다 <b>최소 50개</b>의 경품이 터집니다!</font>
<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

2. 추첨방식 : 평가에 참여한 회원들의 당첨등급을 적용한 추첨 프로그램 자동 선정
<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

3. 당첨발표 : 당첨자확인 게시판 공지 및 이메일 통보
</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="005">당첨등급 및 당첨확률</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 당첨등급 : 응모한 코디상품의 경품 당첨 확률을 높이는 점수(당첨등급이 높다고 해서 무조건 경품에 당첨되지 않으며, 당첨 확률이 높아질 뿐입니다.)
                  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
                
2. 등급구성 : 지난 7일 동안 획득한 활동점수에 따라 1등급 ~ 10등급까지 구성(10점을 획득할 때마다 등급 UP)
<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

3. 활동점수<br />
① 코디UP, 코디DOWN (1회당 1점) - 평가대기중인 코디상품에 UP 또는 DOWN<br />
② 댓글UP, 댓글DOWN (1회당 2점) - 평가대기중인 코디상품에 댓글UP 또는 댓글DOWN<br />
③ 코디UCC 글등록 (1회당 3점) - 코디 UCC 게시판에 글등록<br />
④ 코디UCC 댓글 (1회당 2점) - 코디UCC 게시판에 등록된 게시물에 댓글 등록<br />
⑤ 코디사러가기 클릭 (1회당 2점) - 코디상품을 보고 해당 샵의 홈페이지로 이동한 경우<br />
⑥ 불량샵 신고 (1회당 3점) - 경품지급 불이행 샵이나, 잘못된 경품정보 등에 관한 신고
<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

4. 당첨확률<br />
① 10등급 : 당첨 확률 0% 추가<br />
② 9등급 : 당첨 확률 5% 추가<br />
③ 8등급 : 당첨 확률 10% 추가<br />
④ 7등급 : 당첨 확률 15% 추가<br />
⑤ 6등급 : 당첨 확률 20% 추가<br />
⑥ 5등급 : 당첨 확률 25% 추가<br />
⑦ 4등급 : 당첨 확률 30% 추가<br />
⑧ 3등급 : 당첨 확률 35% 추가<br />
⑨ 2등급 : 당첨 확률 40% 추가<br />
⑩ 1등급 : 당첨 확률 45% 추가
 </td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="006">경품수령</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 당첨자 발표 후 해당샵에 당첨자의 이름, 아이디, 연락처, 이메일, 주소 정보가 전달됩니다.
                  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
                 
2. 당첨자 정보를 받은 해당샵이 당첨자에게 연락하여 경품을 지급합니다.
 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
3. 경품의 종류에 따라서 붙을 수 있는 제세공과금은 당첨자 본인이 부담합니다. 
 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
4. 당첨자 발표 후 해당샵은 최대 7일 이내에 당첨자에게 경품지급을 완료하는 것을 원칙으로 합니다.
 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
5. 만약 경품지급을 해야 할 의무가 있는 샵이 부당하거나 납득할 수 없는 이유로 경품지급을 거부할 경우, 당첨자는 게시판의 <b><font color="#333333">불량샵 신고하기</font></b>를 통해 그 사실을 공개하고, 해당샵에 사기협의 등 법적인 책임을 물을 수 있습니다.
 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
6. 단, 경품지급 관련하여 모든 책임은 해당 상품을 등록한 샵에 있으며 경품지급과 관련된 해당샵과 당첨자간의 분쟁은 당사자간의 직접 해결을 원칙으로 합니다. 이에 관해서 코디탑텐은 책임을 지지 않습니다.
</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="007">불량샵 신고</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 코디탑텐 [게시판]-[불량샵 신고] 메뉴를 이용합니다.
				 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
2. 샵이 경품 제공을 하지 않을 경우, 샵의 등록상품이 잘못된 정보를 제공할 경우, 기타 불량, 장난 또는 허위로 작성된 샵을 신고할 수 있습니다.
</td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" background="/img/dot00.gif"></td>
              </tr>
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA"><a name="008">코디UCC</a></font></b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1. 코디UCC는 회원님들끼리 코디에 관한 정보를 나누는 공간입니다. 상황에 따라 다음과 같은 성격의 글을 선택하여 글을 등록할 수 있습니다.<br />
① 코디평가 : 자신의 코디에 관한 코디탑텐 회원들의 평가를 원할 때 선택합니다.<br />
② 코디의뢰 : 어울리는 코디에 관한 조언이 필요할 때 선택합니다.<br />
③ 코디제안 : 다양한 코디를 직접 제안하고 싶을 때 선택합니다.
<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

※글을 등록할 경우, <b><font color="#333333">디카나 휴대폰 등으로 직접 찍은 사진 이미지를 첨부하여 등록</font></b>하는 것이 더욱 정확한 정보를 나눌 수 있습니다.
<table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

2. 코디UCC 게시판의 글등록은 일반회원만 가능합니다.(샵회원은 댓글만 가능)
 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                    </tr>
                  </table>
3. 게시판 성격과 다른 글, 도배, 음란, 직접적인 홍보/광고, 기타 게시판 운영기준에 어긋나는 게시물은 별다른 통보없이 삭제 또는 수정될 수 있습니다.</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<? require_once "../include/_foot.php"; ?>