/* http://www.twang.co.kr/ 에 있는 웹소스 차용 */
var stmnGAP1 = 1;
var stmnGAP2 = 1;
var stmnBASE = 1;
var stmnActivateSpeed = 100;
var stmnScrollSpeed = 10;
var stmnTimer;

function InitializeStaticMenu()
{
		floater.style.top = document.body.scrollTop + stmnBASE;
		//alert("aaa"+floater.style.top);
		RefreshStaticMenu();
}
function RefreshStaticMenu()
{
		var stmnStartPoint, stmnEndPoint, stmnRefreshTimer;

		stmnStartPoint = parseInt(floater.style.top, 10);
		stmnEndPoint = document.body.scrollTop + stmnGAP2;
		if (stmnEndPoint < stmnGAP1) stmnEndPoint = stmnGAP1;

		stmnRefreshTimer = stmnActivateSpeed;

		//alert(stmnStartPoint+" : "+stmnEndPoint);

		if ( stmnStartPoint != stmnEndPoint ) {
				stmnScrollAmount = Math.ceil( Math.abs( stmnEndPoint - stmnStartPoint ) / 15 );
				floater.style.top = parseInt(floater.style.top, 10) + ( ( stmnEndPoint<stmnStartPoint ) ? -stmnScrollAmount : stmnScrollAmount );
				stmnRefreshTimer = stmnScrollSpeed;
		}

		stmnTimer = setTimeout ("RefreshStaticMenu();", stmnRefreshTimer);
}

function InitializeStaticKwd()
{
		SearchResultArea.style.top = document.body.scrollTop + stmnBASE;
		//RefreshStaticMenu();
}