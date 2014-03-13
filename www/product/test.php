
<script>
function img_resize(wid){
	for ( var i=0; i<document.images.length; i++ ) {
		var obj = document.images[i].id;
		if ( obj.substr(0,7) == "big_pic" ) {
			pic = document.getElementById(obj);
			if ( pic.width > wid ) {
				var ratio;
				ratio = wid / pic.width;
				pic.height = pic.height * ratio;
				pic.width = wid;
			}
		}
	}
}

function GetImageSize(ElemId) {
	with ( TmpImg = document.body.appendChild(document.createElement('img')) ) {
		src = ElemId.src;
		var Width = offsetWidth;
		var Height = offsetHeight;
	}

	document.body.removeChild(TmpImg);
	return { Width : Width, Height : Height };
}


// 비율에 맞춘 이미지 리사이즈
function img_resize_ratio(wid,hei,id) {
	return document.getElementById(id).width;
}
url = "/upload/thumb/200811/200811271407443f63d7vg0d.jpg";
w = 350;
h = 308;




</script>

<p>
<img id="big_img_id" src="" border="0">
</p>

<script>
document.getElementById("big_img_id").src = url;
size = GetImageSize(big_img_id);
document.write("width:"+size.Width+", height:"+size.Height);
</script>